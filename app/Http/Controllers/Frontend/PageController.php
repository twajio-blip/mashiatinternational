<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Backend\Pages\DynamicComponentController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\ContactRequest;
use App\Models\BlogPost;
use App\Models\Career;
use App\Models\ComponentField;
use App\Models\ComponentMaster;
use App\Models\Contact;
use App\Models\GalleryImage;
use App\Models\Page;
use App\Models\Services;
use App\Models\Subscriber;
use App\Services\Notifications\Notifications;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Build component data group-wise (schema_group, schema_instance) with relationship resolution.
     * Supports appendable groups (multiple instances per schema_group).
     */
    protected function buildGroupWiseComponentData(Collection $fields, ComponentMaster $component, int $pageId): array
    {
        $templateFields = $component->componentFiled()->where('group', 1)->orderBy('schema_group')->orderBy('position')->get();
        $relationshipFields = $templateFields->filter(fn($f) => $f->relationship_type && $f->related_component && $f->display_column)->keyBy('name');
        $schemaGroupSettings = is_array($component->schema_group_settings ?? null) ? $component->schema_group_settings : [];

        $byRecord = [];
        foreach ($fields as $field) {
            $recordGroup = $field->group ?: 0;
            $schemaGroup = Schema::hasColumn('component_fields', 'schema_group') ? ($field->schema_group ?? 1) : 1;
            $schemaInstance = Schema::hasColumn('component_fields', 'schema_instance') ? ($field->schema_instance ?? 1) : 1;

            $value = $field->value;
            if (isset($relationshipFields[$field->name])) {
                $def = $relationshipFields[$field->name];
                $value = DynamicComponentController::getRelationshipDisplayValue($def->related_component, $def->display_column, $value);
            }

            $byRecord[$recordGroup][$schemaGroup][$schemaInstance][$field->name] = $value;
        }

        $getGroupName = function ($sg) use ($schemaGroupSettings) {
            $settings = $schemaGroupSettings[$sg] ?? $schemaGroupSettings[(string) $sg] ?? [];

            return $settings['name'] ?? 'Group ' . $sg;
        };

        $result = [];
        foreach ($byRecord as $recordGroup => $schemaGroups) {
            $flat = ['component_id' => null, 'group' => $recordGroup, 'page_id' => null, 'current_page_id' => $pageId];
            $blocks = [];
            ksort($schemaGroups);
            $firstSchemaGroup = null;
            foreach ($schemaGroups as $sg => $instances) {
                ksort($instances);
                $groupName = $getGroupName($sg);
                $firstSchemaGroup ??= $sg;
                foreach ($instances as $si => $fieldsMap) {
                    $blocks[] = array_merge($fieldsMap, ['group_name' => $groupName, 'schema_group' => $sg]);
                    foreach ($fieldsMap as $name => $val) {
                        $flat[$name] = $val;
                    }
                }
            }
            if (count($blocks) <= 1) {
                $flat['group_name'] = $getGroupName($firstSchemaGroup ?? 1);
                $flat['schema_group'] = $firstSchemaGroup ?? 1;
            }
            $first = $fields->first(fn($f) => ($f->group ?: 0) == $recordGroup);
            if ($first) {
                $flat['component_id'] = $first->component_id;
                $flat['page_id'] = $first->page_id;
            }
            $result[$recordGroup] = count($blocks) > 1 ? $blocks : $flat;
        }

        return $result;
    }

    /**
     * Convert buildGroupWiseComponentData output to frontend format.
     * One record (one post) = one item: each item has all its group data.
     * - If group is NOT multiple: fields are flattened (group_name + field keys, no instances array).
     * - If group IS multiple: group has group_name + instances array.
     */
    protected function toFrontendComponentFormat(array $groupWiseData, int $componentId, int $pageId, int $totalPage, array $schemaGroupSettings = []): array
    {
        $out = [];
        ksort($groupWiseData);
        $recordIndex = 0;
        foreach ($groupWiseData as $recordGroup => $data) {
            $meta = ['component_id' => $componentId, 'group' => $recordGroup, 'page_id' => null, 'current_page_id' => $pageId];
            $blocks = [];
            if (is_array($data) && array_is_list($data) && !empty($data) && is_array($data[0])) {
                foreach ($data as $block) {
                    $blocks[] = array_merge($meta, $block);
                }
            } else {
                $blocks = [is_array($data) ? array_merge($meta, $data) : $meta];
            }

            // Within this record, group blocks by schema_group
            $bySchemaGroup = [];
            $instanceIndex = [];
            foreach ($blocks as $item) {
                $sg = $item['schema_group'] ?? 1;
                if (!isset($bySchemaGroup[$sg])) {
                    $bySchemaGroup[$sg] = [
                        'group_name' => $item['group_name'] ?? 'Group ' . $sg,
                        'instances' => [],
                    ];
                    $instanceIndex[$sg] = 0;
                }
                $instanceData = array_diff_key($item, array_flip(['component_id', 'group', 'page_id', 'current_page_id', 'group_name', 'schema_group', 'pagination']));
                // Remove null and empty string values; skip totally empty instances
                $instanceData = array_filter($instanceData, fn($v) => $v !== null && $v !== '');
                if ($instanceData === []) {
                    continue;
                }
                $instanceIndex[$sg]++;
                $bySchemaGroup[$sg]['instances'][$instanceIndex[$sg]] = $instanceData;
            }

            // For non-multiple groups: flatten single instance (no instances array)
            foreach ($bySchemaGroup as $sg => $groupData) {
                $settings = $schemaGroupSettings[$sg] ?? $schemaGroupSettings[(string) $sg] ?? [];
                $isMultiple = !empty($settings['is_multiple']);
                $instances = $groupData['instances'] ?? [];
                if (!$isMultiple && count($instances) === 1) {
                    $single = reset($instances);
                    $bySchemaGroup[$sg] = array_merge(['group_name' => $groupData['group_name']], $single);
                } elseif (!$isMultiple && count($instances) === 0) {
                    $bySchemaGroup[$sg] = ['group_name' => $groupData['group_name']];
                }
                // else: keep group_name + instances array for multiple
            }

            $record = array_merge($meta, $bySchemaGroup);
            // Skip record if it has no meaningful data:
            // - For multiple groups: require at least one non-empty instance.
            // - For non-multiple groups: require at least one field key besides group_name that is non-empty.
            $hasData = false;
            foreach ($record as $k => $v) {
                if (!is_int($k) || !is_array($v)) {
                    continue;
                }

                // Multiple group: must have at least one non-empty instance
                if (isset($v['instances'])) {
                    if (!empty($v['instances'])) {
                        $hasData = true;
                        break;
                    }

                    continue;
                }

                // Non-multiple group: must have some non-empty field besides group_name
                if (isset($v['group_name'])) {
                    $fieldsOnly = array_diff_key($v, ['group_name' => true]);
                    $fieldsOnly = array_filter($fieldsOnly, fn($val) => $val !== null && $val !== '');
                    if (!empty($fieldsOnly)) {
                        $hasData = true;
                        break;
                    }
                }
            }
            if ($hasData) {
                $out[$recordIndex] = $record;
                $recordIndex++;
            }
        }
        // Reindex to first position (0, 1, 2, ...) so no gaps
        $out = array_values($out);
        $out['pagination'] = $totalPage;
        $out['component_id'] = $componentId;

        return $out;
    }

    public function index()
    {

        $totalPage = 0;
        $defaultPage = 0;
        $customPage = 0;
        $page = Page::where('permalink', request()->path())
            ->where('status', 1)
            ->with([
                'component',
                'pageStatus',
            ])
            ->first();

        $calculatePaginationCount = function ($subQuery, $page_id, $status, $show) use (&$defaultPage, &$customPage) {
            if ($status) {
                $parentCount = (clone $subQuery)->whereNull('group')->count();
                $childCount = (clone $subQuery)->where('group', 1)->count();
                $totalChildCount = (clone $subQuery)->whereNotNull('group')->count();
                $customPage = (int) ceil($totalChildCount / (($childCount * $show) != 0 ? ($childCount * $show) : 1));
            } else {
                $parentCount = (clone $subQuery)->where('page_id', $page_id)->whereNull('group')->count();
                $childCount = (clone $subQuery)->where('page_id', $page_id)->where('group', 1)->count();
                $totalChildCount = (clone $subQuery)->where('page_id', $page_id)->whereNotNull('group')->count();
                $defaultPage = (int) ceil($totalChildCount / (($childCount * $show) != 0 ? ($childCount * $show) : 1));
            }
            $child = $childCount * $show;
            if ($child == 0) {
                return 0;
            }

            return $parentCount + $child;
        };
        $paginationCount = function ($subQuery, $page_id, $status, $show) use (&$defaultPage, &$customPage) {
            if ($status) {
                $parentCount = (clone $subQuery)->whereNull('group')->count();
            } else {
                $parentCount = (clone $subQuery)->where('page_id', $page_id)->whereNull('group')->count();
            }

            return $parentCount;
        };

        $componentsWithPaginatedFields = $page->component->map(function ($component) use ($page, $calculatePaginationCount, $paginationCount) {
            $componentId = $component->id;

            $queryParams = [];
            parse_str(Str::after(request()->fullUrl(), '?'), $queryParams);

            // Get the current page and component_id from the query parameters
            $currentPage = $queryParams['page' . $componentId] ?? 1; // Default to page 1
            $currentComponentId = $queryParams['component_id'] ?? null;

            $howManyDataShow = collect($page->pageStatus)
                ->where('component_id', $componentId)
                ->first()
                ->data_view_no ?? 1;

            $howManyDataShowDefault = $calculatePaginationCount(
                $component->componentFiled(),
                $page->id,
                true,
                $howManyDataShow
            );

            $howManyParentShowDefault = $paginationCount(
                $component->componentFiled(),
                $page->id,
                true,
                $howManyDataShow
            );
            $howManyDataShowCustom = $calculatePaginationCount(
                $component->componentFiledPageWise(),
                $page->id,
                false,
                $howManyDataShow
            );

            $howManyParentShowCustom = $paginationCount(
                $component->componentFiledPageWise(),
                $page->id,
                false,
                $howManyDataShow
            );

            // Set Laravel's pagination page resolver
            Paginator::currentPageResolver(function () use ($currentPage, $currentComponentId, $componentId, $howManyParentShowDefault, $howManyParentShowCustom) {
                // Apply pagination only if the current component matches the component_id
                return $howManyParentShowDefault || $howManyParentShowCustom ? 1 : ($currentComponentId && $currentComponentId != $componentId ? 1 : $currentPage);
            });

            if ($howManyDataShowDefault != 0) {
                $component->componentFiled = collect($component->componentFiled()->Paginate($howManyDataShowDefault)->items());
            } elseif ($howManyParentShowDefault != 0) {
                $component->componentFiled = collect($component->componentFiled()->Paginate($howManyParentShowDefault)->items());
            } else {
                $component->componentFiled = collect([]);
            }

            if ($howManyDataShowCustom != 0) {
                $component->componentFiledPageWise = collect($component->componentFiledPageWise()->where('page_id', $page->id)->Paginate($howManyDataShowCustom)->items());
            } elseif ($howManyParentShowCustom != 0) {
                $component->componentFiledPageWise = collect($component->componentFiledPageWise()->where('page_id', $page->id)->Paginate($howManyParentShowCustom)->items());
            } else {
                $component->componentFiledPageWise = collect([]);
            }

            return $component;
        });
        $page->setRelation('component', $componentsWithPaginatedFields);

        if ($page) {
            $limit = 1;
            $components = [];

            foreach ($page->component as $component) {
                $limit = $component->limits->limit ?? $limit;
                $matchData = collect($page->pageStatus)->firstWhere('component_id', $component->id);
                if (!$matchData) {
                    continue;
                }

                if ($component->set_from === 'database' && $component->database) {
                    continue;
                }

                $totalPage = 0;
                $fields = collect();
                // If connected, use data source component for child records
                $source = ($component->is_connected ?? false) && ($component->data_source_component_id ?? null)
                    ? ComponentMaster::find($component->data_source_component_id)
                    : $component;

                if ($matchData->status == 1) {
                    // Custom (page-wise) + fallback to default groups that are not overridden
                    $totalPage = $defaultPage;
                    $pageWise = $source->componentFiledPageWise;
                    $global = $source->componentFiled;
                    if (count($pageWise) == 0 && count($global) == 0) {
                        $totalPage = 0;
                    }
                    $overriddenGroups = $pageWise->pluck('group')->unique();
                    $fields = $global->filter(function ($f) use ($overriddenGroups) {
                        return !$overriddenGroups->contains($f->group);
                    })->concat($pageWise);
                } else {
                    // Default/global only
                    $totalPage = $customPage;
                    $fields = $source->componentFiled;
                    if (count($fields) == 0) {
                        $totalPage = 0;
                    }
                }

                // When connected, use source component's template for relationship resolution (so category/brand show names, not IDs)
                $templateComponent = ($component->is_connected ?? false) && ($component->data_source_component_id ?? null) ? $source : $component;
                $groupWiseData = $this->buildGroupWiseComponentData($fields, $templateComponent, $page->id);

                // Pass schema_group_settings so we know which groups are multiple.
                // - If is_multiple = true  => always expose "instances" array (even single item).
                // - If is_multiple = false => flatten to a single group (no "instances" key).
                $schemaGroupSettings = is_array($component->schema_group_settings ?? null)
                    ? $component->schema_group_settings
                    : [];

                $components[$component->name] = $this->toFrontendComponentFormat(
                    $groupWiseData,
                    $component->id,
                    $page->id,
                    $totalPage,
                    $schemaGroupSettings
                );

                // Build related data blocks for index view (same logic as dataView)
                $relatedBlocks = [];
                $relatedConfigs = is_array($component->related_data ?? null) ? $component->related_data : [];
                $relatedKeyCounts = [];
                foreach ($relatedConfigs as $cfg) {
                    $label = $cfg['label'] ?? null;
                    $source = $cfg['source'] ?? null;
                    $limit = (int) ($cfg['limit'] ?? 0); // currently unused
                    if (!$source) {
                        continue;
                    }

                    // Treat source as a component name -> we format its fields just like main $data
                    $srcComponent = ComponentMaster::where('name', $source)->first();
                    if (!$srcComponent) {
                        continue;
                    }

                    // Use default (global) field definition of the source component (page_id is null)
                    $srcFields = $srcComponent->componentFiled()->get();

                    $srcGroupWise = $this->buildGroupWiseComponentData($srcFields, $srcComponent, $page->id);
                    $srcSchemaGroupSettings = is_array($srcComponent->schema_group_settings ?? null)
                        ? $srcComponent->schema_group_settings
                        : [];

                    $srcData = $this->toFrontendComponentFormat(
                        $srcGroupWise,
                        $srcComponent->id,
                        $page->id,
                        1,
                        $srcSchemaGroupSettings
                    );

                    $blockLabel = $label ?: $srcComponent->name;
                    $key = (string) $blockLabel;
                    if ($key === '') {
                        $key = (string) $srcComponent->name;
                    }

                    // Ensure unique keys if same label repeats
                    if (isset($relatedKeyCounts[$key])) {
                        $relatedKeyCounts[$key]++;
                        $key = $key . '-' . $relatedKeyCounts[$key];
                    } else {
                        $relatedKeyCounts[$key] = 1;
                    }

                    $relatedBlocks[$key] = [
                        'label' => $blockLabel,
                        'data' => $srcData,
                        'component' => $srcComponent,
                    ];
                }

                if (!empty($relatedBlocks)) {
                    $components[$component->name]['relatedBlocks'] = $relatedBlocks;
                }
            }

            foreach ($page->component as $data) {

                $db_name = $data->database;
                $db_relation = $data->relational_table;

                if ($db_name && $data->set_from == 'database') {
                    if (!isset($components[$data->name]) || count($components[$data->name]) == 0) {
                        $components[$data->name] = [0 => []];
                    }

                    parse_str(Str::after(request()->fullUrl(), '?'), $queryParams);

                    // Get the current page and component_id from the query parameters
                    $currentPage = $queryParams['page' . $data->id] ?? 1; // Default to page 1
                    $currentComponentId = $queryParams['component_id'] ?? null;
                    // Set Laravel's pagination page resolver
                    Paginator::currentPageResolver(function () use ($currentPage, $currentComponentId, $data) {
                        // Apply pagination only if the current component matches the component_id
                        return $currentComponentId && $currentComponentId != $data->id ? 1 : $currentPage;
                    });

                    $matchData = collect($page->pageStatus)->firstWhere('component_id', $data->id)->data_view_no ?? 1;

                    if ($matchData == 0) {
                        $items = new Collection;
                        $paginator = new LengthAwarePaginator($items, $items->count(), 1);
                        $components[$data->name][1] = $paginator; // Paginate an empty collection
                    } else {
                        $components[$data->name][1] = DB::table($db_name)->orderByDesc('id')->when(count(request()->all()) != 0, function ($quarry) use ($data) {
                            $allDataFilter = request()->all();
                            $keysToRemove = ['component'];
                            $afterRemoveComponent = array_diff_key(request()->all(), array_flip($keysToRemove));
                            foreach ($afterRemoveComponent as $key => $value) {
                                $containsSearch = str_contains($key, 'search');
                                if (isset($allDataFilter['component']) && $allDataFilter['component'] == $data->name) {
                                    if ($containsSearch) {
                                        $searchKey = explode('-', $key);
                                        $quarry->where($searchKey[1], 'LIKE', '%' . $value . '%');
                                    } else {
                                        if ($key != 'page') {
                                            $quarry->where($key, $value);
                                        }
                                    }
                                }
                            }
                        })->paginate($matchData)->toArray();
                    }

                    if ($db_relation) {
                        $components[$data->name][$data->relational_table] = DB::table($db_relation)->orderByDesc('id')->get()->toArray();
                    }
                    $components[$data->name]['component'] = $data->name;
                    $components[$data->name]['current_page_id'] = $page->id;
                    $components[$data->name]['component_id'] = $data->id;
                }
            }
        }

        if ($page) {

            return view('pages', compact('components', 'page'));
        } else {
            return view('default-page');
        }
    }

    public function dataView($id, $current_page_id)
    {

        $page = Page::where('id', $current_page_id)
            ->where('status', 1)
            ->with(['component', 'pageStatus'])
            ->firstOrFail();

        // Find the component on this page by its id
        $component = $page->component->firstWhere('id', (int) $id);
        if (!$component) {

            abort(404);
        }

        // Decide whether to use page-wise fields or global fields
        // Follows the same idea as index(): pageStatus.status == 1 => page-wise data
        $matchStatus = collect($page->pageStatus)->firstWhere('component_id', $component->id);
        $usePageWise = $matchStatus && (int) $matchStatus->status === 1;

        // If this component is connected, use its data source for field records; keep display component for output
        $displayComponent = $component;
        if (($component->is_connected ?? false) && ($component->data_source_component_id ?? null)) {
            $component = ComponentMaster::find($component->data_source_component_id) ?? $component;
        }

        // Build fields collection, supporting custom (page-wise) override + default fallback
        $globalFields = ComponentField::where('component_id', $component->id)
            ->whereNull('page_id')
            ->get();
        if ($usePageWise) {
            $pageFields = ComponentField::where('component_id', $component->id)
                ->where('page_id', $page->id)
                ->get();
            $overriddenGroups = $pageFields->pluck('group')->unique();
            $fields = $globalFields->filter(function ($f) use ($overriddenGroups) {
                return !$overriddenGroups->contains($f->group);
            })->concat($pageFields);
        } else {
            $fields = $globalFields;
        }

        // Build the same frontend-friendly structure as index() does (use $component = source for relationship resolution)
        $groupWiseData = $this->buildGroupWiseComponentData($fields, $component, $page->id);

        // When ?group=X is present, show only that record so each service/project has its own detail page
        $requestedGroup = request()->query('group');
        if ($requestedGroup !== null && $requestedGroup !== '') {
            $groupKey = is_numeric($requestedGroup) ? (int) $requestedGroup : $requestedGroup;
            if (!array_key_exists($groupKey, $groupWiseData)) {
                abort(404);
            }
            $groupWiseData = [$groupKey => $groupWiseData[$groupKey]];
        }

        // Use display component for output id/settings (so frontend gets the page's component id)
        $schemaGroupSettings = is_array($displayComponent->schema_group_settings ?? null)
            ? $displayComponent->schema_group_settings
            : [];

        // We don't paginate detail view; treat as single page
        $data = $this->toFrontendComponentFormat(
            $groupWiseData,
            $displayComponent->id,
            $page->id,
            1,
            $schemaGroupSettings
        );

        // Resolve related_data blocks configured on this component (for details page)
        // Each related block is formatted using the SAME helpers as $data (buildGroupWiseComponentData + toFrontendComponentFormat)
        $relatedBlocks = [];
        $relatedConfigs = is_array($displayComponent->related_data ?? null) ? $displayComponent->related_data : [];
        $relatedKeyCounts = [];
        foreach ($relatedConfigs as $cfg) {
            $label = $cfg['label'] ?? null;
            $source = $cfg['source'] ?? null;
            $limit = (int) ($cfg['limit'] ?? 0); // currently unused but kept for future paging/filtering
            if (!$source) {
                continue;
            }

            // Treat source as a component name -> we format its fields just like main $data
            $srcComponent = ComponentMaster::where('name', $source)->first();
            if (!$srcComponent) {
                continue;
            }

            // For now we always use the default (global) field definition of the source component (page_id is null),
            // so related blocks are independent of which page they are shown on.
            $srcFields = $srcComponent->componentFiled()->get();

            // Build group-wise data & frontend format exactly like index()/dataView
            $srcGroupWise = $this->buildGroupWiseComponentData($srcFields, $srcComponent, $page->id);
            $srcSchemaGroupSettings = is_array($srcComponent->schema_group_settings ?? null)
                ? $srcComponent->schema_group_settings
                : [];

            $srcData = $this->toFrontendComponentFormat(
                $srcGroupWise,
                $srcComponent->id,
                $page->id,
                1,
                $srcSchemaGroupSettings
            );

            $blockLabel = $label ?: $srcComponent->name;
            $key = (string) $blockLabel;
            if ($key === '') {
                $key = (string) $srcComponent->name;
            }

            // Ensure unique keys if same label repeats
            if (isset($relatedKeyCounts[$key])) {
                $relatedKeyCounts[$key]++;
                $key = $key . '-' . $relatedKeyCounts[$key];
            } else {
                $relatedKeyCounts[$key] = 1;
            }

            $relatedBlocks[$key] = [
                'label' => $blockLabel,
                'data' => $srcData,
                'component' => $srcComponent,
            ];
        }

        // Render component-name-wise view.
        // If connected, use the connected (data source) component's view; otherwise use this component's own view.
        $viewName = $component->name . '-view';
        return view($viewName, [
            'data' => $data,
            'page' => $page,
            'component' => $component,
            'relatedBlocks' => $relatedBlocks,
        ]);
    }

    public function serviceView($id)
    {
        $page = Page::where('name', 'Services')->where('status', 1)->first();
        $services = Services::where('id', $id)->first();
        $allService = Services::orderBy('id', 'desc')->limit(8)->get(['id', 'title']);

        return view('service-view', compact('services', 'allService', 'page'));
    }

    public function blogView($id, $current_page_id)
    {
        $page = Page::where('id', $current_page_id)->where('status', 1)->first();
        $blog = BlogPost::where('id', $id)->with('category')->first();
        $blogs = BlogPost::inRandomOrder()->limit(5)->get();
        $relatedBlogs = BlogPost::where('category_id', ($blog->category_id))->with('category')->limit(5)->get();

        return view('blog-view', compact('blog', 'blogs', 'page', 'relatedBlogs'));
    }

    public function listView($id, $current_page_id)
    {
        // Same data as blogView, but renders dedicated test-list details view
        $page = Page::where('id', $current_page_id)->where('status', 1)->first();
        $blog = BlogPost::where('id', $id)->with('category')->first();
        $blogs = BlogPost::inRandomOrder()->limit(5)->get();
        $relatedBlogs = BlogPost::where('category_id', $blog->category_id)->with('category')->limit(5)->get();

        return view('test-list-view', compact('blog', 'blogs', 'page', 'relatedBlogs'));
    }

    public function jobView($id, $current_page_id)
    {
        $page = Page::where('id', $current_page_id)->where('status', 1)->first();
        $career = Career::where('id', $id)->with('category')->first();

        return view('jobView', compact('career', 'page'));
    }

    public function contactStore(ContactRequest $request)
    {
        $filter_request = filterRequest(['g-recaptcha-response']);
        $filter_request['subscribe'] = $request->boolean('subscribe');
        $filter_request['status'] = 0;

        $contact = Contact::create($filter_request);
        $send = [
            'type' => 'contact',
            'title' => "New Inquiry from ({$contact->email})",
            'message' => $contact->description,
            'type_id' => $contact->id,
            'redirect_url' => url('/admin/contact/' . $contact->id),

        ];
        Notifications::sendNotification($send);

        return redirect()->back()->with('success', 'Your message has been sent. We will get back to you within 24 hours.');
    }

    public function subscriberStore()
    {
        $filter_request = filterRequest();
        $subscribers = Subscriber::create($filter_request);
        $send = [
            'type' => 'subscriber',
            'title' => "New Subscriber ({$subscribers->email})",
            'message' => 'A new subscriber has subscribed.',
            'type_id' => $subscribers->id,
            'redirect_url' => url('/admin/subscriber/' . $subscribers->id),

        ];
        Notifications::sendNotification($send);

        return redirect()->back()->with('success', 'You have successfully subscribed to our newsletter.');
    }

    public function galleryView($id)
    {
        $gallery = GalleryImage::where('category_id', $id)->get();

        return view('gallery-view', compact('gallery'));
    }

    public function defaultPage()
    {
        return view('default-page');
    }

    public function pageDetails($page_id, $group, $component_id, $current_page_id, $view_page_name)
    {

        $page_id = $page_id != 'null' ? $page_id : null;
        $group = $group != 'null' ? $group : null;
        $component_id = $component_id != 'null' ? $component_id : null;
        $current_page_id = $current_page_id != 'null' ? $current_page_id : null;
        $page = Page::find($current_page_id);
        $component = ComponentMaster::find($component_id);
        $componentDetails = ComponentField::where('page_id', $page_id)->where('component_id', $component_id)->where('group', $group)->get();
        $singleComponentDetails = [];
        foreach ($componentDetails as $key => $value) {
            $singleComponentDetails[$value['name']] = $value['value'];
        }

        return view($view_page_name, compact('component', 'singleComponentDetails', 'page'));
    }
}
