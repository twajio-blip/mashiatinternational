<?php

namespace App\Http\Controllers\Backend\Pages;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\ComponentMaster;
use App\Models\ComponentField;
use App\Services\Pages\PagesService;

class DynamicComponentController extends Controller
{
    /**
     * Get components that have child fields or database tables (manageable dynamically)
     * Rule 1: Only show if has at least one non-empty row (all empty = cannot show)
     */
    public static function getManageableComponents()
    {
        $components = ComponentMaster::with('componentFiled')
            ->where(function ($q) {
                $q->whereHas('componentFiled', fn($sq) => $sq->where('group', 1))
                    ->orWhere('set_from', 'database');
            })
            ->orderBy('position', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return $components->filter(function ($comp) {
            if ($comp->set_from === 'database' && $comp->database) {
                return Schema::hasTable($comp->database) && DB::table($comp->database)->exists();
            }
            return ComponentField::where('component_id', $comp->id)
                ->whereNotNull('group')
                // ->where(function ($q) {
                //     $q->whereNotNull('value')->where('value', '!=', '');
                // })
                ->exists();
        })->values();
    }

    /**
     * Display table listing for a dynamic component
     */
    public function index(string $slug)
    {
        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)->orderBy('position')])
            ->firstOrFail();

        // If component is marked as single entry, skip listing table
        if ($component->is_single) {
            if ($component->set_from === 'database' && $component->database) {
                $tableName = $component->database;
                if (!Schema::hasTable($tableName)) {
                    return redirect()->route('pages.index')
                        ->with('error', "Table {$tableName} does not exist.");
                }
                $orderCol = Schema::hasColumn($tableName, 'created_at') ? 'created_at' : 'id';
                $row = DB::table($tableName)->orderByDesc($orderCol)->first();
                if (!$row) {
                    return redirect()->route('dynamic-component.create', $slug);
                }
                return redirect()->route('dynamic-component.edit', [$slug, $row->id]);
            } else {
                // Find first NON-EMPTY data group; if none, go to create
                $groups = ComponentField::where('component_id', $component->id)
                    ->whereNotNull('group')
                    ->whereNull('page_id')
                    ->pluck('group')
                    ->unique()
                    ->sortDesc()
                    ->values();
                $selectedGroup = null;
                foreach ($groups as $groupId) {
                    $isEmpty = true;
                    foreach ($component->componentFiled->where('group', 1) as $field) {
                        $q = ComponentField::where('component_id', $component->id)
                            ->where('group', $groupId)
                            ->where('name', $field->name)
                            ->whereNull('page_id');
                        if (Schema::hasColumn('component_fields', 'schema_group')) {
                            $q->where('schema_group', $field->schema_group ?? 1);
                        }
                        if (Schema::hasColumn('component_fields', 'schema_instance')) {
                            $q->orderBy('schema_instance');
                        }
                        $val = $q->value('value');
                        if ($val !== null && trim((string) $val) !== '') {
                            $isEmpty = false;
                            break;
                        }
                    }
                    if (!$isEmpty) {
                        $selectedGroup = $groupId;
                        break;
                    }
                }

                if ($selectedGroup === null) {
                    return redirect()->route('dynamic-component.create', $slug);
                }
                return redirect()->route('dynamic-component.edit', [$slug, $selectedGroup]);
            }
        }

        $childFields = $component->componentFiled->where('group', 1);
        $tableFields = $childFields->filter(fn($f) => ($f->show_in_table ?? 1));
        $columns = $tableFields->pluck('name')->unique()->values();
        $search = trim((string) request('search', ''));
        $perPage = 10;

        if ($component->set_from === 'database' && $component->database) {
            // Data from external table
            $tableName = $component->database;
            if (!Schema::hasTable($tableName)) {
                return redirect()->route('pages.index')
                    ->with('error', "Table {$tableName} does not exist.");
            }
            if ($columns->isEmpty()) {
                $columns = collect(Schema::getColumnListing($tableName))
                    ->diff(['id', 'created_at', 'updated_at']);
            }
            $orderCol = Schema::hasColumn($tableName, 'created_at') ? 'created_at' : 'id';
            $allDbRows = DB::table($tableName)->orderByDesc($orderCol)->get();
            $relationshipFields = $tableFields->filter(fn($f) => $f->relationship_type && $f->related_component && $f->display_column)->keyBy('name');
            $filteredRows = $allDbRows->filter(function ($row) use ($columns) {
                foreach ($columns as $col) {
                    $val = $row->{$col} ?? '';
                    if ($val !== null && trim((string) $val) !== '') {
                        return true;
                    }
                }
                return false;
            })->map(function ($row) use ($relationshipFields) {
                $row = (object) (array) $row;
                foreach ($relationshipFields as $col => $field) {
                    if (isset($row->{$col})) {
                        $row->{$col} = self::getRelationshipDisplayValue($field->related_component, $field->display_column, $row->{$col});
                    }
                }
                return $row;
            })->values();
            $filteredRows = $this->filterDynamicRowsBySearch($filteredRows, $columns, $search);
            $rows = $this->paginateDynamicRows($filteredRows, $perPage, $search);
        } else {
            // Data from component_fields
            $groups = ComponentField::where('component_id', $component->id)
                ->whereNotNull('group')
                ->whereNull('page_id')
                ->pluck('group')
                ->unique()
                ->sortDesc()
                ->values();

            $allRows = collect();
            foreach ($groups as $group) {
                $row = (object)['id' => $group, '_group' => $group];
                $isEmpty = true;
                foreach ($component->componentFiled->where('group', 1) as $field) {
                    $q = ComponentField::where('component_id', $component->id)
                        ->where('group', $group)
                        ->where('name', $field->name)
                        ->where('schema_group', $field->schema_group ?? 1)
                        ->whereNull('page_id');
                    if (Schema::hasColumn('component_fields', 'schema_instance')) {
                        $q->orderBy('schema_instance');
                    }
                    $val = $q->value('value');
                    if ($field->relationship_type && $field->related_component && $field->display_column) {
                        $val = self::getRelationshipDisplayValue($field->related_component, $field->display_column, $val);
                    }
                    $row->{$field->name} = $val;
                    if ($val !== null && trim((string) $val) !== '') {
                        $isEmpty = false;
                    }
                }
                if (!$isEmpty) {
                    $allRows->push($row);
                }
            }
            $allRows = $this->filterDynamicRowsBySearch($allRows, $columns, $search);
            $rows = $this->paginateDynamicRows($allRows, $perPage, $search);
        }

        $viewData = [
            'dynamicComponent' => $component,
            'columns' => $columns,
            'rows' => $rows,
        ];

        if (request()->ajax()) {
            return view('backend.pages.dynamic-component.partials.list', $viewData);
        }

        return view('backend.pages.dynamic-component.index', $viewData);
    }

    /**
     * @param  Collection<int, object>  $rows
     * @param  Collection<int, string>  $columns
     * @return Collection<int, object>
     */
    protected function filterDynamicRowsBySearch(Collection $rows, Collection $columns, string $search): Collection
    {
        if ($search === '') {
            return $rows;
        }
        $needle = Str::lower($search);
        return $rows->filter(function ($row) use ($columns, $needle) {
            $rowArray = (array) $row;
            $cols = $columns->isNotEmpty()
                ? $columns
                : collect(array_keys($rowArray))->reject(fn ($k) => $k === '_group');
            foreach ($cols as $col) {
                $val = $row->{$col} ?? ($rowArray[$col] ?? null);
                if ($val === null || $val === '') {
                    continue;
                }
                $haystack = Str::lower(strip_tags((string) $val));
                if ($haystack !== '' && Str::contains($haystack, $needle)) {
                    return true;
                }
            }
            $idVal = isset($row->id) ? (string) $row->id : '';
            if ($idVal !== '' && Str::contains(Str::lower($idVal), $needle)) {
                return true;
            }
            return false;
        })->values();
    }

    /**
     * @param  Collection<int, object>  $items
     */
    protected function paginateDynamicRows(Collection $items, int $perPage, string $search): LengthAwarePaginator
    {
        $total = $items->count();
        $lastPage = max(1, (int) ceil($total / $perPage));
        $page = max(1, (int) request('page', 1));
        $page = min($page, $lastPage);
        $paginator = new LengthAwarePaginator(
            $items->forPage($page, $perPage)->values(),
            $total,
            $perPage,
            $page,
            ['path' => request()->url()]
        );
        if ($search !== '') {
            $paginator->appends(['search' => $search]);
        }
        return $paginator;
    }

    /**
     * Resolve relationship value (ID or JSON array) to display label(s)
     */
    public static function getRelationshipDisplayValue(?string $relatedComponent, ?string $displayColumn, $value): string
    {
        if (!$relatedComponent || !$displayColumn || $value === null || $value === '') {
            return '';
        }
        $options = self::getRelationshipOptions($relatedComponent, $displayColumn);
        if (empty($options)) {
            return (string) $value;
        }
        $ids = is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{')) ? json_decode($value, true) : $value;
        if (is_array($ids)) {
            $labels = [];
            foreach ($ids as $id) {
                $labels[] = $options[$id] ?? $id;
            }
            return implode(', ', $labels);
        }
        return (string) ($options[$value] ?? $value);
    }

    /**
     * Get options for relationship dropdowns (id => display_value)
     */
    public static function getRelationshipOptions(string $relatedComponentSlug, string $displayColumn): array
    {
        $related = ComponentMaster::where('name', $relatedComponentSlug)->first();
        if (!$related) {
            return [];
        }
        if ($related->set_from === 'database' && $related->database) {
            if (!Schema::hasTable($related->database)) {
                return [];
            }
            $cols = Schema::getColumnListing($related->database);
            if (!in_array($displayColumn, $cols)) {
                return [];
            }
            $rows = DB::table($related->database)->orderByDesc('id')->get();
            return $rows->mapWithKeys(function ($row) use ($displayColumn) {
                $label = $row->{$displayColumn} ?? $row->id ?? '';
                return [$row->id => (string) $label];
            })->all();
        }
        $groups = ComponentField::where('component_id', $related->id)
            ->whereNotNull('group')
            ->where('group', '!=', 1)
            ->whereNull('page_id')
            ->pluck('group')
            ->unique()
            ->sort()
            ->values();
        $options = [];
        foreach ($groups as $group) {
            $val = ComponentField::where('component_id', $related->id)
                ->where('group', $group)
                ->where('name', $displayColumn)
                ->whereNull('page_id')
                ->value('value');
            $options[$group] = (string) ($val ?? $group);
        }
        return $options;
    }

    /**
     * Show create form for dynamic component
     */
    public function create(string $slug)
    {
        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)->orderBy('position')])
            ->firstOrFail();

        if ($component->set_from === 'database' && $component->database && $component->componentFiled->where('group', 1)->isEmpty()) {
            $tableName = $component->database;
            if (Schema::hasTable($tableName)) {
                $cols = array_diff(Schema::getColumnListing($tableName), ['id', 'created_at', 'updated_at']);
                $component->schemaColumns = collect($cols)->map(function ($col) {
                    $type = (str_contains(strtolower($col), 'image') || str_contains(strtolower($col), 'img')) ? 'file' : 'text';
                    return (object)['name' => $col, 'type' => $type];
                })->values();
            }
        }

        $relationshipOptions = [];
        foreach ($component->componentFiled->where('group', 1) as $field) {
            if ($field->relationship_type && $field->related_component && $field->display_column) {
                $relationshipOptions[$field->name] = self::getRelationshipOptions($field->related_component, $field->display_column);
            }
        }

        return view('backend.pages.dynamic-component.create', [
            'dynamicComponent' => $component,
            'relationshipOptions' => $relationshipOptions,
        ]);
    }

    /**
     * Store new row for dynamic component
     */
    public function store(Request $request, string $slug)
    {

        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)->orderBy('position')])
            ->firstOrFail();

        $createdGroupId = null;
        $createdRowId = null;

        if ($component->set_from === 'database' && $component->database) {
            $tableName = $component->database;
            if (!Schema::hasTable($tableName)) {
                return redirect()->back()->with('error', "Table {$tableName} does not exist.");
            }
            $columns = array_diff(Schema::getColumnListing($tableName), ['id', 'created_at', 'updated_at']);
            $data = $request->only($columns);
            foreach ($request->allFiles() as $key => $file) {
                if (in_array($key, $columns)) {
                    $data[$key] = $this->processImage($file);
                }
            }
            $createdRowId = DB::table($tableName)->insertGetId($data);
        } else {
            $childFields = $component->componentFiled->where('group', 1);
            // Use numeric MAX: if `group` is a string column, SQL MAX() is lexicographic ('9' > '10'),
            // so every new row would incorrectly reuse group 10.
            $maxGroup = (int) (DB::table('component_fields')
                ->where('component_id', $component->id)
                ->whereNotNull('group')
                ->whereNull('page_id')
                ->max(DB::raw('CAST(`group` AS UNSIGNED)')) ?? 0);

            $subfield = $request->input('subfield', []);
            if (!is_array($subfield)) {
                $subfield = [];
            }

            // Ensure pure file-only schema groups/instances are present in $subfield
            // so they are processed and saved (e.g. Hero Media group with only a background_image file)
            $fileSubfield = $request->file('subfield', []);
            if (is_array($fileSubfield)) {
                foreach ($fileSubfield as $sg => $instances) {
                    if (!isset($subfield[$sg]) || !is_array($subfield[$sg])) {
                        $subfield[$sg] = [];
                    }
                    if (!is_array($instances)) {
                        continue;
                    }
                    foreach ($instances as $instId => $fields) {
                        if (!isset($subfield[$sg][$instId]) || !is_array($subfield[$sg][$instId])) {
                            $subfield[$sg][$instId] = [];
                        }
                        if (!is_array($fields)) {
                            continue;
                        }
                        foreach ($fields as $fieldName => $file) {
                            if (!array_key_exists($fieldName, $subfield[$sg][$instId])) {
                                // placeholder so group/instance is not skipped; real file value handled later by hasFile/processImage
                                $subfield[$sg][$instId][$fieldName] = null;
                            }
                        }
                    }
                }
            }

            // Detect format: per-group multiple (subfield[schemaGroup][instanceId][field]) vs legacy (subfield[instanceKey][field])
            $isPerGroupFormat = false;
            foreach ($subfield as $k => $v) {
                if (is_array($v) && !empty($v)) {
                    $first = reset($v);
                    if (is_array($first) && is_numeric(key($v))) {
                        $isPerGroupFormat = true;
                        break;
                    }
                }
            }

            if ($isPerGroupFormat) {
                // Per-group multiple: subfield[schemaGroup][instanceId][fieldName], one record = one group ID
                $newGroup = $maxGroup + 1;
                $createdGroupId = $newGroup;
                $childFieldsBySchema = $childFields->groupBy(fn($f) => $f->schema_group ?? 1);

                foreach ($subfield as $schemaGroup => $instances) {
                    if (!is_array($instances)) continue;
                    $fieldsForGroup = $childFieldsBySchema->get($schemaGroup) ?? $childFieldsBySchema->get((string)$schemaGroup) ?? collect();
                    foreach ($instances as $instanceId => $instanceData) {
                        if (!is_array($instanceData)) continue;
                        foreach ($fieldsForGroup->where('is_required', 1) as $reqField) {
                            $val = $instanceData[$reqField->name] ?? null;
                            $isEmpty = $val === null || $val === '' || (is_array($val) && empty($val));

                            // For file/upload fields: skip required check if a new file is being uploaded.
                            if ($isEmpty && in_array($reqField->type, ['file', 'upload', 'upload_multi'], true)) {
                                if ($request->hasFile("subfield.{$schemaGroup}.{$instanceId}.{$reqField->name}")) {
                                    $isEmpty = false;
                                }
                            }

                            if ($isEmpty) {
                                return redirect()->back()->withInput()->withErrors([
                                    "subfield.{$schemaGroup}.{$instanceId}.{$reqField->name}" => ucfirst(str_replace('_', ' ', $reqField->name)) . ' is required.',
                                ]);
                            }
                        }
                    }
                }

                $position = 0;
                foreach ($subfield as $schemaGroup => $instances) {
                    if (!is_array($instances)) continue;
                    $fieldsForGroup = $childFieldsBySchema->get($schemaGroup) ?? $childFieldsBySchema->get((string)$schemaGroup) ?? collect();
                    foreach ($instances as $instanceId => $instanceData) {
                        if (!is_array($instanceData)) continue;
                        foreach ($fieldsForGroup as $field) {
                            $value = $instanceData[$field->name] ?? null;
                            if (in_array($field->type, ['file', 'upload', 'upload_multi'], true) && $request->hasFile("subfield.{$schemaGroup}.{$instanceId}.{$field->name}")) {
                                if ($field->type === 'upload_multi') {
                                    $files = $request->file("subfield.{$schemaGroup}.{$instanceId}.{$field->name}");
                                    $stored = [];
                                    if (is_array($files)) {
                                        foreach ($files as $file) {
                                            $stored[] = $this->processImage($file);
                                        }
                                    } else {
                                        $stored[] = $this->processImage($files);
                                    }
                                    $value = json_encode($stored);
                                } else {
                                    $value = $this->processImage($request->file("subfield.{$schemaGroup}.{$instanceId}.{$field->name}"));
                                }
                            }
                            if ($field->relationship_type === 'hasMany' && is_array($value)) {
                                $value = json_encode($value);
                            }
                            $createData = [
                                'component_id' => $component->id,
                                'name' => $field->name,
                                'type' => $field->type,
                                'value' => $value,
                                'group' => $newGroup,
                                'position' => $position++,
                                'page_id' => null,
                            ];
                            if (Schema::hasColumn('component_fields', 'schema_group')) {
                                $createData['schema_group'] = $schemaGroup;
                            }
                            if (Schema::hasColumn('component_fields', 'schema_instance')) {
                                $createData['schema_instance'] = (int) $instanceId;
                            }
                            ComponentField::create($createData);
                        }
                    }
                }
            } else {
                // Legacy: subfield[instanceKey][fieldName], one instanceKey = one full record
                foreach ($subfield as $instanceKey => $subfieldData) {
                    if (!is_array($subfieldData)) continue;
                    foreach ($childFields->where('is_required', 1) as $reqField) {
                        $val = $subfieldData[$reqField->name] ?? null;
                        $isEmpty = $val === null || $val === '' || (is_array($val) && empty($val));

                        // For file/upload fields: skip required check if a new file is being uploaded.
                        if ($isEmpty && in_array($reqField->type, ['file', 'upload', 'upload_multi'], true)) {
                            if ($request->hasFile("subfield.{$instanceKey}.{$reqField->name}")) {
                                $isEmpty = false;
                            }
                        }

                        if ($isEmpty) {
                            return redirect()->back()->withInput()->withErrors([
                                "subfield.{$instanceKey}.{$reqField->name}" => ucfirst(str_replace('_', ' ', $reqField->name)) . ' is required.',
                            ]);
                        }
                    }
                }

                foreach ($subfield as $instanceKey => $subfieldData) {
                    if (!is_array($subfieldData)) continue;
                    $newGroup = $maxGroup + 1;
                    $maxGroup = $newGroup;
                    $createdGroupId = $newGroup;
                    $position = 0;
                    foreach ($childFields as $field) {
                        $value = $subfieldData[$field->name] ?? null;
                        if (in_array($field->type, ['file', 'upload', 'upload_multi'], true) && $request->hasFile("subfield.{$instanceKey}.{$field->name}")) {
                            if ($field->type === 'upload_multi') {
                                $files = $request->file("subfield.{$instanceKey}.{$field->name}");
                                $stored = [];
                                if (is_array($files)) {
                                    foreach ($files as $file) {
                                        $stored[] = $this->processImage($file);
                                    }
                                } else {
                                    $stored[] = $this->processImage($files);
                                }
                                $value = json_encode($stored);
                            } else {
                                $value = $this->processImage($request->file("subfield.{$instanceKey}.{$field->name}"));
                            }
                        }
                        if ($field->relationship_type === 'hasMany' && is_array($value)) {
                            $value = json_encode($value);
                        }
                        $createData = [
                            'component_id' => $component->id,
                            'name' => $field->name,
                            'type' => $field->type,
                            'value' => $value,
                            'group' => $newGroup,
                            'position' => $position++,
                            'page_id' => null,
                        ];
                        if (Schema::hasColumn('component_fields', 'schema_group')) {
                            $createData['schema_group'] = $field->schema_group ?? 1;
                        }
                        if (Schema::hasColumn('component_fields', 'schema_instance')) {
                            $createData['schema_instance'] = 1;
                        }
                        ComponentField::create($createData);
                    }
                }
            }
        }

        $successMessage = ucfirst(str_replace('-', ' ', $component->name)) . ' created successfully.';

        // Single entry = true: after create, auto redirect to edit page
        if ($component->is_single) {
            $editId = $createdRowId ?? $createdGroupId;
            if ($editId !== null) {
                $editUrl = route('dynamic-component.edit', [$slug, $editId]);
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'message' => $successMessage,
                        'redirect_url' => $editUrl,
                    ]);
                }
                return redirect()->to($editUrl)->with('success', $successMessage);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => $successMessage]);
        }
        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Show edit form for dynamic component row
     */
    public function edit(string $slug, string $id)
    {
        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)->orderBy('position')])
            ->firstOrFail();

        if ($component->set_from === 'database' && $component->database) {
            $row = DB::table($component->database)->where('id', $id)->first();
            if (!$row) {
                return redirect()->route('dynamic-component.index', $slug)->with('error', 'Record not found.');
            }
        } else {
            $group = (int) $id;
            $fieldsQuery = ComponentField::where('component_id', $component->id)
                ->where('group', $group)
                ->whereNull('page_id');
            if (Schema::hasColumn('component_fields', 'schema_instance')) {
                $fieldsQuery->orderBy('schema_group')->orderBy('schema_instance');
            }
            $allFields = $fieldsQuery->get();
            $fields = collect();
            $schemaGroupSettings = is_array($component->schema_group_settings ?? null) ? $component->schema_group_settings : [];
            foreach ($component->componentFiled->where('group', 1) as $template) {
                $sg = $template->schema_group ?? 1;
                $groupSettings = $schemaGroupSettings[$sg] ?? $schemaGroupSettings[(string)$sg] ?? [];
                $groupIsMultiple = !empty($groupSettings['is_multiple']);
                $matches = $allFields->filter(fn($f) => $f->name === $template->name && ($f->schema_group ?? 1) == $sg);
                foreach ($matches as $match) {
                    $si = Schema::hasColumn('component_fields', 'schema_instance') ? ($match->schema_instance ?? 1) : 1;
                    if (!isset($fields[$sg])) {
                        $fields[$sg] = collect();
                    }
                    if (!isset($fields[$sg][$si])) {
                        $fields[$sg][$si] = collect();
                    }
                    $fields[$sg][$si][$template->name] = $match;
                }
            }
            $row = (object)['id' => $group, '_group' => $group, '_fields' => $fields];
        }

        $relationshipOptions = [];
        foreach ($component->componentFiled->where('group', 1) as $field) {
            if ($field->relationship_type && $field->related_component && $field->display_column) {
                $relationshipOptions[$field->name] = self::getRelationshipOptions($field->related_component, $field->display_column);
            }
        }

        return view('backend.pages.dynamic-component.edit', [
            'dynamicComponent' => $component,
            'row' => $row,
            'relationshipOptions' => $relationshipOptions,
        ]);
    }

    /**
     * Update row for dynamic component
     */
    public function update(Request $request, string $slug, string $id)
    {
        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)->orderBy('position')])
            ->firstOrFail();

        if ($component->set_from === 'database' && $component->database) {
            $tableName = $component->database;
            if (!Schema::hasTable($tableName)) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => "Table {$tableName} does not exist."], 422);
                }
                return redirect()->back()->with('error', "Table {$tableName} does not exist.");
            }
            $columns = Schema::getColumnListing($tableName);
            $data = $request->only(array_diff($columns, ['id', 'created_at', 'updated_at']));

            // Handle _remove markers for database columns
            foreach ($columns as $col) {
                if ($request->input($col . '_remove')) {
                    $oldVal = DB::table($tableName)->where('id', $id)->value($col);
                    if ($oldVal) {
                        $this->deleteStoredFileValue($oldVal);
                    }
                    $data[$col] = null;
                }
            }

            foreach ($request->allFiles() as $key => $file) {
                if (in_array($key, $columns)) {
                    // Delete old file before saving new one
                    $oldVal = DB::table($tableName)->where('id', $id)->value($key);
                    if ($oldVal) {
                        $this->deleteStoredFileValue($oldVal);
                    }
                    $data[$key] = $this->processImage($file);
                }
            }
            DB::table($tableName)->where('id', $id)->update($data);
        } else {
            $group = (int) $id;
            $childFields = $component->componentFiled->where('group', 1)->sortBy('schema_group');
            // Use subfield_json from JS - collects ALL instances (including appended 3,4,5) - bypasses PHP multipart parsing
            $subfield = [];
            $subfieldJson = $request->input('subfield_json');
            if ($subfieldJson && is_string($subfieldJson)) {
                $decoded = json_decode($subfieldJson, true);
                if (is_array($decoded)) {
                    $subfield = $decoded;
                }
            }
            if (empty($subfield)) {
                $subfield = $request->input('subfield', []);
            }
            if (!is_array($subfield)) {
                $subfield = [];
            }
            // Register file-upload entries as placeholders so the per-field loop
            // picks them up.  Do NOT process the file here — that happens once
            // inside the per-field loop below (avoids the double-move bug).
            foreach ($request->allFiles() as $dotKey => $file) {
                if (preg_match('/^subfield\.(\d+)\.(\d+)\.(.+)$/', $dotKey, $m)) {
                    $sg = $m[1];
                    $inst = $m[2];
                    $fieldName = $m[3];
                    if (!isset($subfield[$sg])) $subfield[$sg] = [];
                    if (!isset($subfield[$sg][$inst])) $subfield[$sg][$inst] = [];
                    if (!array_key_exists($fieldName, $subfield[$sg][$inst])) {
                        $subfield[$sg][$inst][$fieldName] = null;
                    }
                }
            }

            $schemaGroupSettings = is_array($component->schema_group_settings ?? null) ? $component->schema_group_settings : [];
            $hasAppendableGroup = collect($schemaGroupSettings)->contains(fn($s) => !empty($s['is_multiple']));

            $isPerGroupFormat = $hasAppendableGroup;
            if (!$isPerGroupFormat && !empty($subfield)) {
                foreach ($subfield as $k => $v) {
                    if (is_array($v)) {
                        $innerKey = array_key_first($v);
                        if ($innerKey !== null && (is_numeric($innerKey) || is_numeric((string) $innerKey))) {
                            $isPerGroupFormat = true;
                            break;
                        }
                    }
                }
            }

            if ($isPerGroupFormat) {
                foreach ($subfield as $schemaGroup => $instances) {
                    if (!is_array($instances)) continue;
                    $fieldsForGroup = $childFields->filter(fn($f) => ($f->schema_group ?? 1) == (int) $schemaGroup);
                    foreach ($instances as $instanceId => $instanceData) {
                        if (!is_array($instanceData)) continue;
                        foreach ($fieldsForGroup->where('is_required', 1) as $reqField) {
                            $val = $instanceData[$reqField->name] ?? null;
                            $isEmpty = $val === null || $val === '' || (is_array($val) && empty($val));

                            // For file/upload fields: skip required check if a new file is being
                            // uploaded OR if there is already a stored value in the database.
                            if ($isEmpty && in_array($reqField->type, ['file', 'upload', 'upload_multi'], true)) {
                                if ($request->hasFile("subfield.{$schemaGroup}.{$instanceId}.{$reqField->name}")) {
                                    $isEmpty = false;
                                } else {
                                    // Check existing stored value
                                    $existingQ = ComponentField::where('component_id', $component->id)
                                        ->where('group', $group)
                                        ->where('name', $reqField->name)
                                        ->whereNull('page_id');
                                    if (Schema::hasColumn('component_fields', 'schema_group')) {
                                        $existingQ->where('schema_group', (int) $schemaGroup);
                                    }
                                    if (Schema::hasColumn('component_fields', 'schema_instance')) {
                                        $existingQ->where('schema_instance', (int) $instanceId);
                                    }
                                    $existingValue = $existingQ->value('value');
                                    if ($existingValue !== null && $existingValue !== '') {
                                        $isEmpty = false;
                                    }
                                }
                            }

                            if ($isEmpty) {
                                $errorKey = "subfield.{$schemaGroup}.{$instanceId}.{$reqField->name}";
                                $errorMsg = ucfirst(str_replace('_', ' ', $reqField->name)) . ' is required.';
                                if ($request->ajax()) {
                                    return response()->json(['success' => false, 'message' => $errorMsg, 'errors' => [$errorKey => [$errorMsg]]], 422);
                                }
                                return redirect()->back()->withInput()->withErrors([$errorKey => $errorMsg]);
                            }
                        }
                    }
                }

                // Delete instances that were removed from the form
                if (Schema::hasColumn('component_fields', 'schema_group') && Schema::hasColumn('component_fields', 'schema_instance')) {
                    $schemaGroupsInComponent = $childFields->pluck('schema_group')->map(fn($sg) => $sg ?? 1)->unique()->filter()->values();
                    foreach ($schemaGroupsInComponent as $schemaGroup) {
                        $sg = (int) $schemaGroup;
                        $instances = $subfield[$sg] ?? $subfield[$schemaGroup] ?? $subfield[(string)$schemaGroup] ?? [];
                        $submittedInstanceIds = is_array($instances) ? array_map('intval', array_keys($instances)) : [];
                        $query = ComponentField::where('component_id', $component->id)
                            ->where('group', $group)
                            ->where('schema_group', $sg)
                            ->whereNull('page_id');
                        if (!empty($submittedInstanceIds)) {
                            $query->whereNotIn('schema_instance', $submittedInstanceIds);
                        }
                        $query->delete();
                    }
                }

                $position = 0;
                foreach ($subfield as $schemaGroup => $instances) {
                    if (!is_array($instances)) continue;
                    $fieldsForGroup = $childFields->filter(fn($f) => ($f->schema_group ?? 1) == (int) $schemaGroup);
                    foreach ($instances as $instanceId => $instanceData) {
                        if (!is_array($instanceData)) continue;
                        foreach ($fieldsForGroup as $field) {
                            $value = $instanceData[$field->name] ?? null;
                            $hasUpload = in_array($field->type, ['file', 'upload', 'upload_multi'], true) && $request->hasFile("subfield.{$schemaGroup}.{$instanceId}.{$field->name}");

                            // Clear marker from form: subfield_remove[schemaGroup][instanceId][fieldName]
                            $shouldRemove = (bool) data_get(
                                $request->input('subfield_remove', []),
                                "{$schemaGroup}.{$instanceId}.{$field->name}"
                            );

                            $existingQuery = ComponentField::where('component_id', $component->id)
                                ->where('group', $group)
                                ->where('name', $field->name)
                                ->whereNull('page_id');
                            if (Schema::hasColumn('component_fields', 'schema_group')) {
                                $existingQuery->where('schema_group', (int) $schemaGroup);
                            }
                            if (Schema::hasColumn('component_fields', 'schema_instance')) {
                                $existingQuery->where('schema_instance', (int) $instanceId);
                            }
                            $existingValue = $existingQuery->value('value');

                            if ($field->type === 'upload_multi') {
                                $multiRemove = $this->inputSubfieldMultiRemoveList($request, [(string) $schemaGroup, (string) $instanceId, $field->name]);
                                $currentFiles = $this->parseUploadMultiStoredFilenames($existingValue);

                                if ($shouldRemove) {
                                    if ($existingValue !== null && $existingValue !== '') {
                                        $this->deleteStoredFileValue($existingValue);
                                    }
                                    $value = null;
                                } else {
                                    foreach ($multiRemove as $rm) {
                                        if (in_array($rm, $currentFiles, true)) {
                                            $this->deleteStoredFileValue($rm);
                                        }
                                    }
                                    $currentFiles = array_values(array_diff($currentFiles, $multiRemove));

                                    if ($hasUpload) {
                                        $files = $request->file("subfield.{$schemaGroup}.{$instanceId}.{$field->name}");
                                        $stored = [];
                                        if (is_array($files)) {
                                            foreach ($files as $file) {
                                                $stored[] = $this->processImage($file);
                                            }
                                        } else {
                                            $stored[] = $this->processImage($files);
                                        }
                                        $value = $this->mergeUploadMultiValue(
                                            $currentFiles === [] ? null : json_encode($currentFiles),
                                            $stored
                                        );
                                    } else {
                                        $value = $currentFiles === [] ? null : json_encode($currentFiles);
                                    }
                                }
                            } elseif ($hasUpload) {
                                if ($existingValue !== null && $existingValue !== '') {
                                    $this->deleteStoredFileValue($existingValue);
                                }
                                $value = $this->processImage($request->file("subfield.{$schemaGroup}.{$instanceId}.{$field->name}"));
                            } elseif ($shouldRemove && in_array($field->type, ['file', 'upload', 'upload_multi'], true)) {
                                if ($existingValue !== null && $existingValue !== '') {
                                    $this->deleteStoredFileValue($existingValue);
                                }
                                $value = null;
                            } elseif (in_array($field->type, ['file', 'upload', 'upload_multi'], true)) {
                                if ($existingValue !== null && $existingValue !== '') {
                                    $value = $existingValue;
                                }
                            }
                            if ($field->relationship_type === 'hasMany' && is_array($value)) {
                                $value = json_encode($value);
                            }
                            $match = [
                                'component_id' => $component->id,
                                'group' => $group,
                                'name' => $field->name,
                                'page_id' => null,
                            ];
                            if (Schema::hasColumn('component_fields', 'schema_group')) {
                                $match['schema_group'] = (int) $schemaGroup;
                            }
                            if (Schema::hasColumn('component_fields', 'schema_instance')) {
                                $match['schema_instance'] = (int) $instanceId;
                            }
                            ComponentField::updateOrCreate($match, [
                                'value' => $value,
                                'type' => $field->type,
                                'position' => $position++,
                            ]);
                        }
                    }
                }
            } else {
                foreach ($childFields->where('is_required', 1) as $reqField) {
                    $val = $request->input("subfield.{$group}.{$reqField->name}");
                    $isEmpty = $val === null || $val === '' || (is_array($val) && empty($val));

                    // For file/upload fields: skip required check if a new file is being
                    // uploaded OR if there is already a stored value in the database.
                    if ($isEmpty && in_array($reqField->type, ['file', 'upload', 'upload_multi'], true)) {
                        if ($request->hasFile("subfield.{$group}.{$reqField->name}")) {
                            $isEmpty = false;
                        } else {
                            $existingQ = ComponentField::where('component_id', $component->id)
                                ->where('group', $group)
                                ->where('name', $reqField->name)
                                ->whereNull('page_id');
                            if (Schema::hasColumn('component_fields', 'schema_group')) {
                                $existingQ->where('schema_group', $reqField->schema_group ?? 1);
                            }
                            if (Schema::hasColumn('component_fields', 'schema_instance')) {
                                $existingQ->where('schema_instance', 1);
                            }
                            $existingValue = $existingQ->value('value');
                            if ($existingValue !== null && $existingValue !== '') {
                                $isEmpty = false;
                            }
                        }
                    }

                    if ($isEmpty) {
                        $errorKey = "subfield.{$group}.{$reqField->name}";
                        $errorMsg = ucfirst(str_replace('_', ' ', $reqField->name)) . ' is required.';
                        if ($request->ajax()) {
                            return response()->json(['success' => false, 'message' => $errorMsg, 'errors' => [$errorKey => [$errorMsg]]], 422);
                        }
                        return redirect()->back()->withInput()->withErrors([$errorKey => $errorMsg]);
                    }
                }
                $position = 0;
                foreach ($childFields as $field) {
                    $value = $request->input("subfield.{$group}.{$field->name}");
                    $hasUpload = in_array($field->type, ['file', 'upload', 'upload_multi'], true) && $request->hasFile("subfield.{$group}.{$field->name}");

                    // Clear marker from form: subfield_remove[group][fieldName]
                    $shouldRemove = (bool) data_get(
                        $request->input('subfield_remove', []),
                        "{$group}.{$field->name}"
                    );

                    $existingQuery = ComponentField::where('component_id', $component->id)
                        ->where('group', $group)
                        ->where('name', $field->name)
                        ->whereNull('page_id');
                    if (Schema::hasColumn('component_fields', 'schema_group')) {
                        $existingQuery->where('schema_group', $field->schema_group ?? 1);
                    }
                    if (Schema::hasColumn('component_fields', 'schema_instance')) {
                        $existingQuery->where('schema_instance', 1);
                    }
                    $existingValue = $existingQuery->value('value');

                    if ($field->type === 'upload_multi') {
                        $multiRemove = $this->inputSubfieldMultiRemoveList($request, [(string) $group, $field->name]);
                        $currentFiles = $this->parseUploadMultiStoredFilenames($existingValue);

                        if ($shouldRemove) {
                            if ($existingValue !== null && $existingValue !== '') {
                                $this->deleteStoredFileValue($existingValue);
                            }
                            $value = null;
                        } else {
                            foreach ($multiRemove as $rm) {
                                if (in_array($rm, $currentFiles, true)) {
                                    $this->deleteStoredFileValue($rm);
                                }
                            }
                            $currentFiles = array_values(array_diff($currentFiles, $multiRemove));

                            if ($hasUpload) {
                                $files = $request->file("subfield.{$group}.{$field->name}");
                                $stored = [];
                                if (is_array($files)) {
                                    foreach ($files as $file) {
                                        $stored[] = $this->processImage($file);
                                    }
                                } else {
                                    $stored[] = $this->processImage($files);
                                }
                                $value = $this->mergeUploadMultiValue(
                                    $currentFiles === [] ? null : json_encode($currentFiles),
                                    $stored
                                );
                            } else {
                                $value = $currentFiles === [] ? null : json_encode($currentFiles);
                            }
                        }
                    } elseif ($hasUpload) {
                        if ($existingValue !== null && $existingValue !== '') {
                            $this->deleteStoredFileValue($existingValue);
                        }
                        $value = $this->processImage($request->file("subfield.{$group}.{$field->name}"));
                    } elseif ($shouldRemove && in_array($field->type, ['file', 'upload', 'upload_multi'], true)) {
                        if ($existingValue !== null && $existingValue !== '') {
                            $this->deleteStoredFileValue($existingValue);
                        }
                        $value = null;
                    } elseif (in_array($field->type, ['file', 'upload', 'upload_multi'], true)) {
                        if ($existingValue !== null && $existingValue !== '') {
                            $value = $existingValue;
                        }
                    }
                    if ($field->relationship_type === 'hasMany' && is_array($value)) {
                        $value = json_encode($value);
                    }
                    $match = [
                        'component_id' => $component->id,
                        'group' => $group,
                        'name' => $field->name,
                        'page_id' => null,
                    ];
                    if (Schema::hasColumn('component_fields', 'schema_group')) {
                        $match['schema_group'] = $field->schema_group ?? 1;
                    }
                    if (Schema::hasColumn('component_fields', 'schema_instance')) {
                        $match['schema_instance'] = 1;
                    }
                    ComponentField::updateOrCreate($match, [
                        'value' => $value,
                        'type' => $field->type,
                        'position' => $position++,
                    ]);
                }
            }
        }

        $successMessage = ucfirst(str_replace('-', ' ', $component->name)) . ' updated successfully.';

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $successMessage]);
        }

        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Delete row for dynamic component
     * Rule 2: If last row - don't delete, clear all fields instead (keep one empty section)
     */
    public function destroy(string $slug, string $id)
    {
        $component = ComponentMaster::where('name', $slug)
            ->with(['componentFiled' => fn($q) => $q->where('group', 1)])
            ->firstOrFail();

        if ($component->set_from === 'database' && $component->database) {
            $tableName = $component->database;
            if (Schema::hasTable($tableName)) {
                $totalRows = DB::table($tableName)->count();

                // Always delete stored files for this row before clearing/deleting
                $row = DB::table($tableName)->where('id', $id)->first();
                if ($row) {
                    foreach ((array) $row as $col => $value) {
                        if (in_array($col, ['id', 'created_at', 'updated_at'], true)) {
                            continue;
                        }
                        $colLower = strtolower($col);
                        $looksLikeFile = str_contains($colLower, 'image')
                            || str_contains($colLower, 'img')
                            || str_contains($colLower, 'photo')
                            || str_contains($colLower, 'logo')
                            || str_contains($colLower, 'banner')
                            || str_contains($colLower, 'thumb')
                            || str_contains($colLower, 'file')
                            || str_contains($colLower, 'attachment')
                            || str_contains($colLower, 'document');
                        if ($looksLikeFile) {
                            $this->deleteStoredFileValue($value);
                        }
                    }
                }

                if ($totalRows <= 1) {
                    $columns = array_diff(Schema::getColumnListing($tableName), ['id', 'created_at', 'updated_at']);
                    $clearData = array_fill_keys($columns, null);
                    DB::table($tableName)->where('id', $id)->update($clearData);
                    return redirect()->route('dynamic-component.index', $slug)
                        ->with('success', 'Last section cleared. At least one section is kept.');
                }

                DB::table($tableName)->where('id', $id)->delete();
            }
        } else {
            // Delete all stored files for this component group (all schema groups/instances)
            $fieldsForGroup = ComponentField::where('component_id', $component->id)
                ->where('group', (int) $id)
                ->whereNull('page_id')
                ->get();

            foreach ($fieldsForGroup as $f) {
                if (in_array($f->type, ['file', 'upload', 'upload_multi'], true)) {
                    $this->deleteStoredFileValue($f->value);
                }
            }

            $groupCount = ComponentField::where('component_id', $component->id)
                ->whereNotNull('group')
                ->whereNull('page_id')
                ->pluck('group')
                ->unique()
                ->count();

            if ($groupCount <= 1) {
                ComponentField::where('component_id', $component->id)
                    ->where('group', (int) $id)
                    ->whereNull('page_id')
                    ->update(['value' => null]);
                return redirect()->route('dynamic-component.index', $slug)
                    ->with('success', 'Last section cleared. At least one section is kept.');
            }

            ComponentField::where('component_id', $component->id)
                ->where('group', (int) $id)
                ->whereNull('page_id')
                ->delete();
        }

        return redirect()->route('dynamic-component.index', $slug)
            ->with('success', ucfirst(str_replace('-', ' ', $component->name)) . ' deleted successfully.');
    }

    /**
     * Parse stored component value into a flat list of filenames for upload_multi (JSON array or single string).
     *
     * @return list<string>
     */
    protected function parseUploadMultiStoredFilenames(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }
        if (is_array($value)) {
            return array_values(array_filter($value, fn ($v) => is_string($v) && $v !== ''));
        }
        if (is_string($value)) {
            $trim = trim($value);
            if ($trim !== '' && (str_starts_with($trim, '[') || str_starts_with($trim, '{'))) {
                $decoded = json_decode($value, true);
                if (is_array($decoded)) {
                    return array_values(array_filter($decoded, fn ($v) => is_string($v) && $v !== ''));
                }
            }

            return [$value];
        }

        return [];
    }

    /**
     * Append newly processed uploads to existing upload_multi filenames (do not remove previous files).
     *
     * @param  list<string|null>  $newProcessedFilenames
     */
    protected function mergeUploadMultiValue(?string $existingJson, array $newProcessedFilenames): string
    {
        $existing = $this->parseUploadMultiStoredFilenames($existingJson);
        $newClean = [];
        foreach ($newProcessedFilenames as $f) {
            if (is_string($f) && $f !== '') {
                $newClean[] = $f;
            }
        }
        $merged = array_values(array_unique(array_merge($existing, $newClean)));

        return json_encode($merged);
    }

    /**
     * Filenames the user removed from an upload_multi field (subfield_multi_remove[..][..][..][]).
     *
     * @param  array<int, int|string>  $pathSegments e.g. [schemaGroup, instanceId, field] or [group, field] (legacy)
     * @return list<string>
     */
    protected function inputSubfieldMultiRemoveList(Request $request, array $pathSegments): array
    {
        $key = implode('.', array_map(static fn ($s) => (string) $s, $pathSegments));
        $raw = data_get($request->input('subfield_multi_remove', []), $key);
        if ($raw === null || $raw === '') {
            return [];
        }
        $list = is_array($raw) ? $raw : [$raw];

        return array_values(array_filter($list, static fn ($r) => is_string($r) && $r !== ''));
    }

    /**
     * Remove one or many stored filenames from public/images.
     *
     * @param mixed $value
     */
    protected function deleteStoredFileValue($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $filenames = [];
        if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                foreach ($decoded as $v) {
                    if (is_string($v) && $v !== '') {
                        $filenames[] = $v;
                    }
                }
            }
        } elseif (is_array($value)) {
            foreach ($value as $v) {
                if (is_string($v) && $v !== '') {
                    $filenames[] = $v;
                }
            }
        } elseif (is_string($value)) {
            $filenames[] = $value;
        }

        foreach ($filenames as $name) {
            if (str_starts_with($name, 'http://') || str_starts_with($name, 'https://') || str_starts_with($name, '/')) {
                continue;
            }
            $path = public_path('images/' . $name);
            if (file_exists($path)) {
                @unlink($path);
            }
        }
    }

    protected function processImage($file)
    {
        if (!$file || !$file->isValid()) {
            return null;
        }
        // If it's an image, run through imageComprese (webp optimize)
        $mime = $file->getMimeType();
        if (is_string($mime) && str_starts_with($mime, 'image/')) {
            return imageComprese($file->getRealPath());
        }

        // Non-image: store as-is with a safe unique filename
        $originalName = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        if (!$ext) {
            $ext = pathinfo($originalName, PATHINFO_EXTENSION) ?: '';
        }
        $base = pathinfo($originalName, PATHINFO_FILENAME);
        $slug = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base) ?: 'file';
        $filename = $slug . '_' . uniqid('', true) . ($ext ? '.' . $ext : '');

        // Reuse the same "images" directory so existing asset() paths work
        $file->move(public_path('images'), $filename);

        return $filename;
    }
}
