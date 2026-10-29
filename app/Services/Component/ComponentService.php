<?php

namespace App\Services\Component;

use App\Models\ComponentField;
use App\Models\ComponentMaster;

class ComponentService
{
    /**
     * Parse static options from "value:Label" per line format to associative array
     */
    protected static function parseStaticOptions(string $input): ?array
    {
        $lines = array_filter(array_map('trim', explode("\n", $input)));
        $options = [];
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                [$val, $label] = explode(':', $line, 2);
                $options[trim($val)] = trim($label);
            } else {
                $options[$line] = $line;
            }
        }
        return empty($options) ? null : $options;
    }

    public static function  ComponentCreate(array $data)
    {
        $prepared = collect($data);

        $maxPosition = ComponentMaster::max('position') ?? 0;
        $position = isset($prepared['position']) && (int) $prepared['position'] > 0 ? (int) $prepared['position'] : ($maxPosition + 1);
        $subGroupSettings = $prepared['sub_group_settings'] ?? [];
        $schemaGroupSettings = [];
        if (is_array($subGroupSettings)) {
            foreach ($subGroupSettings as $gid => $s) {
                if (is_array($s)) {
                    $schemaGroupSettings[$gid] = [
                        'name' => $s['name'] ?? 'Group ' . $gid,
                        'is_multiple' => isset($s['is_multiple']) && $s['is_multiple'] ? true : false,
                    ];
                }
            }
        }

        // Build related_data config from form
        $relatedData = [];
        $labels  = $prepared['related_data_label']  ?? [];
        $sources = $prepared['related_data_source'] ?? [];
        $limits  = $prepared['related_data_limit']  ?? [];

        foreach ($labels as $i => $label) {
            $label  = is_string($label) ? trim($label) : $label;
            $source = $sources[$i] ?? null;
            $source = is_string($source) ? trim($source) : $source;
            $limit  = isset($limits[$i]) ? (int) $limits[$i] : 0;

            if ($label === '' && ($source === null || $source === '')) {
                continue;
            }

            $relatedData[] = [
                'label'  => $label,
                'source' => $source,
                'limit'  => $limit,
            ];
        }

        $master =  ComponentMaster::create([
            'name' => $prepared['name'],
            'schema_group_settings' => !empty($schemaGroupSettings) ? $schemaGroupSettings : null,
            'set_from' => isset($prepared['set_from']) ? $prepared['set_from'] : null,
            'database' => isset($prepared['database']) ? $prepared['database'] : null,
            'relational_table' => isset($prepared['relational_table']) ? $prepared['relational_table'] : null,
            'related_data' => !empty($relatedData) ? $relatedData : null,
            'limit' =>  isset($prepared['limit']) ?  $prepared['limit'] : null,
            'position' => $position,
            'is_single' => isset($prepared['is_single']) && $prepared['is_single'] ? true : false,
            'is_connected' => isset($prepared['is_connected']) && $prepared['is_connected'] ? true : false,
            'data_source_component_id' => isset($prepared['data_source_component_id']) && $prepared['data_source_component_id'] !== '' ? (int) $prepared['data_source_component_id'] : null,
        ]);
        $fields = isset($prepared['field_name']) ? $prepared['field_name'] : [];
        $parentPosition = 1;
        $sub_fields = isset($prepared['sub_field_name']) ? $prepared['sub_field_name'] : [];

        foreach ($fields as $key => $field) {
            ComponentField::create([
                'component_id' => $master->id,
                'name' =>  $field,
                'type' =>  $prepared['field_type'][$key],
                'position' => $parentPosition,
            ]);
            $parentPosition++;
        }

        $sub_show_in_table = $prepared['sub_field_show_in_table'] ?? [];
        $sub_is_required = $prepared['sub_field_is_required'] ?? [];
        $sub_colspan = $prepared['sub_field_colspan'] ?? [];
        $sub_schema_group = $prepared['sub_field_schema_group'] ?? [];
        $sub_related_component = $prepared['sub_field_related_component'] ?? [];
        $sub_display_column = $prepared['sub_field_display_column'] ?? [];
        $sub_static_options = $prepared['sub_field_static_options'] ?? [];
        $sub_help_text = $prepared['sub_field_help_text'] ?? [];
        foreach ($sub_fields as $key => $sub_field) {
            $colspan = isset($sub_colspan[$key]) ? max(1, min(12, (int) $sub_colspan[$key])) : 6;
            $schemaGroup = isset($sub_schema_group[$key]) ? max(1, (int) $sub_schema_group[$key]) : 1;
            $type = $prepared['sub_field_type'][$key];
            $relationshipType = in_array($type, ['belongsTo', 'hasOne', 'hasMany']) ? $type : null;
            $relatedComponent = $relationshipType && isset($sub_related_component[$key]) ? $sub_related_component[$key] : null;
            $displayColumn = $relationshipType && isset($sub_display_column[$key]) ? $sub_display_column[$key] : null;
            $isRequired = isset($sub_is_required[$key]) && $sub_is_required[$key] ? 1 : 0;
            $staticOptions = null;
            if ($type === 'select' && !empty($sub_static_options[$key])) {
                $staticOptions = self::parseStaticOptions($sub_static_options[$key]);
            }
            ComponentField::create([
                'component_id' => $master->id,
                'name' =>  $sub_field,
                'type' =>  $type,
                'relationship_type' => $relationshipType,
                'related_component' => $relatedComponent,
                'display_column' => $displayColumn,
                'static_options' => $staticOptions,
                'is_required' => $isRequired,
                'group' => 1,
                'schema_group' => $schemaGroup,
                'position' => $key,
                'show_in_table' => isset($sub_show_in_table[$key]) && $sub_show_in_table[$key] ? 1 : 0,
                'colspan' => $colspan,
            ]);
        }
        return true;
    }
    public static function  ComponentUpdate(array $data, $id)
    {

        $prepared = collect($data);

        $master = ComponentMaster::where('id', $id)->first();
        $position = isset($prepared['position']) && (int) $prepared['position'] > 0 ? (int) $prepared['position'] : $master->position;
        $subGroupSettings = $prepared['sub_group_settings'] ?? [];
        $schemaGroupSettings = [];
        if (is_array($subGroupSettings)) {
            foreach ($subGroupSettings as $gid => $s) {
                if (is_array($s)) {
                    $schemaGroupSettings[$gid] = [
                        'name' => $s['name'] ?? 'Group ' . $gid,
                        'is_multiple' => isset($s['is_multiple']) && $s['is_multiple'] ? true : false,
                    ];
                }
            }
        }

        // Build related_data config from form (update)
        $relatedData = [];
        $labels  = $prepared['related_data_label']  ?? [];
        $sources = $prepared['related_data_source'] ?? [];
        $limits  = $prepared['related_data_limit']  ?? [];

        foreach ($labels as $i => $label) {
            $label  = is_string($label) ? trim($label) : $label;
            $source = $sources[$i] ?? null;
            $source = is_string($source) ? trim($source) : $source;
            $limit  = isset($limits[$i]) ? (int) $limits[$i] : 0;

            if ($label === '' && ($source === null || $source === '')) {
                continue;
            }

            $relatedData[] = [
                'label'  => $label,
                'source' => $source,
                'limit'  => $limit,
            ];
        }

        $master->update([
            'name' => $prepared['name'],
            'schema_group_settings' => !empty($schemaGroupSettings) ? $schemaGroupSettings : null,
            'set_from' => isset($prepared['set_from']) ? $prepared['set_from'] : null,
            'database' => isset($prepared['database']) ? $prepared['database'] : null,
            'relational_table' => isset($prepared['relational_table']) ? $prepared['relational_table'] : null,
            'related_data' => !empty($relatedData) ? $relatedData : null,
            'limit' =>  isset($prepared['limit']) ?  $prepared['limit'] : null,
            'position' => $position,
            'is_single' => isset($prepared['is_single']) && $prepared['is_single'] ? true : false,
            'is_connected' => isset($prepared['is_connected']) && $prepared['is_connected'] ? true : false,
            'data_source_component_id' => isset($prepared['data_source_component_id']) && $prepared['data_source_component_id'] !== '' ? (int) $prepared['data_source_component_id'] : null,
        ]);

        // Delete full groups that were removed from the form (component definition uses custom/schema groups)
        if ($master->set_from === 'custom' && !empty($schemaGroupSettings)) {
            $submittedSchemaGroups = array_map('intval', array_keys($schemaGroupSettings));
            ComponentField::where('component_id', $master->id)
                ->whereNotNull('group')
                ->whereNotNull('schema_group')
                ->whereNotIn('schema_group', $submittedSchemaGroups)
                ->delete();
        }

        $lastFieldDefault = ComponentField::where('component_id', $master->id)
            ->whereNull('page_id')
            ->orderBy('position', 'desc')
            ->first();
        $lastField = ComponentField::where('component_id', $master->id)

            ->orderBy('position', 'desc')
            ->whereNotNull('page_id')
            ->first();



        $fields = isset($prepared['field_name']) ? $prepared['field_name'] : [];
        $sub_fields = isset($prepared['sub_field_name']) ? $prepared['sub_field_name'] : [];

        // Reorder parent (non-grouped) fields based on submitted order
        $parentPosition = 1;
        foreach ($fields as $key => $field) {
            $component =  ComponentField::where('id', isset($prepared['field_id'][$key]) ?  $prepared['field_id'][$key] : false)->first();
            if ($component) {
                // Update all instances (default + page-wise) of this field name and set new position
                ComponentField::whereNull('group')
                    ->where('component_id', $component->component_id)
                    ->where('name', $component->name)
                    ->update([
                        'name' =>  $field,
                        'position' => $parentPosition,
                    ]);
            } else {
                // New parent field – create in the correct position for default and page-wise records
                $parentType = $prepared['field_type'][$key];
                ComponentField::create([
                    'component_id' => $master->id,
                    'name' =>  $field,
                    'type' => $parentType,
                    'position' => $parentPosition,
                ]);

                $pageIds = ComponentField::where('component_id', $master->id)
                    ->whereNotNull('page_id')
                    ->select('page_id')
                    ->groupBy('page_id')
                    ->pluck('page_id');

                foreach ($pageIds as $value) {
                    ComponentField::create([
                        'component_id' => $master->id,
                        'name' =>  $field,
                        'type' => $parentType,
                        'position' => $parentPosition,
                        'page_id' => $value,
                    ]);
                }
            }
            $parentPosition++;
        }
        $moreDefault = ComponentField::where('component_id', $master->id)
            ->whereNotNull('group')
            ->where('group', '!=', '1')
            ->whereNull('page_id')
            ->groupBy('group',)
            ->select('group')
            ->orderBy('group', 'ASC')
            ->get();
        $more = ComponentField::where('component_id', $master->id)
            ->whereNotNull('group')
            ->where('group', '!=', '1')
            ->whereNotNull('page_id')
            ->groupBy('group',)
            ->select('group')
            ->orderBy('group', 'ASC')
            ->get();


        $sub_field_count = 0;
        foreach ($sub_fields as $key => $sub_field) {
            $component_sub =  ComponentField::where('id', isset($prepared['sub_field_id'][$key]) ?  $prepared['sub_field_id'][$key] : false)->first();
            $sub_field_count = $key;
            if ($component_sub) {
                $showInTable = isset($prepared['sub_field_show_in_table'][$key]) && $prepared['sub_field_show_in_table'][$key] ? 1 : 0;
                $isRequired = isset($prepared['sub_field_is_required'][$key]) && $prepared['sub_field_is_required'][$key] ? 1 : 0;
                $colspan = isset($prepared['sub_field_colspan'][$key]) ? max(1, min(12, (int) $prepared['sub_field_colspan'][$key])) : 6;
                $schemaGroup = isset($prepared['sub_field_schema_group'][$key]) ? max(1, (int) $prepared['sub_field_schema_group'][$key]) : 1;
                $type = $prepared['sub_field_type'][$key];
                $relationshipType = in_array($type, ['belongsTo', 'hasOne', 'hasMany']) ? $type : null;
                $relatedComponent = $relationshipType && isset($prepared['sub_field_related_component'][$key]) ? $prepared['sub_field_related_component'][$key] : null;
                $displayColumn = $relationshipType && isset($prepared['sub_field_display_column'][$key]) ? $prepared['sub_field_display_column'][$key] : null;
                $staticOptions = (($type === 'select' || $type === 'text') && isset($prepared['sub_field_static_options'][$key]) && !empty(trim($prepared['sub_field_static_options'][$key] ?? '')))
                    ? self::parseStaticOptions($prepared['sub_field_static_options'][$key]) : null;
                $helpText = isset($prepared['sub_field_help_text'][$key]) ? trim($prepared['sub_field_help_text'][$key]) : null;
                $helpText = $helpText !== '' ? $helpText : null;
                $component_sub->update([
                    'name' => $sub_field,
                    'type' => $type,
                    'position' => $key,
                    'show_in_table' => $showInTable,
                    'is_required' => $isRequired,
                    'colspan' => $colspan,
                    'schema_group' => $schemaGroup,
                    'relationship_type' => $relationshipType,
                    'related_component' => $relatedComponent,
                    'display_column' => $displayColumn,
                    'static_options' => $staticOptions,
                    'help_text' => $helpText,
                ]);
            } else {
                $type = $prepared['sub_field_type'][$key];
                $position = $key;
                $showInTable = isset($prepared['sub_field_show_in_table'][$key]) && $prepared['sub_field_show_in_table'][$key] ? 1 : 0;
                $colspan = isset($prepared['sub_field_colspan'][$key]) ? max(1, min(12, (int) $prepared['sub_field_colspan'][$key])) : 6;
                $schemaGroup = isset($prepared['sub_field_schema_group'][$key]) ? max(1, (int) $prepared['sub_field_schema_group'][$key]) : 1;
                $relationshipType = in_array($type, ['belongsTo', 'hasOne', 'hasMany']) ? $type : null;
                $relatedComponent = $relationshipType && isset($prepared['sub_field_related_component'][$key]) ? $prepared['sub_field_related_component'][$key] : null;
                $displayColumn = $relationshipType && isset($prepared['sub_field_display_column'][$key]) ? $prepared['sub_field_display_column'][$key] : null;
                $isRequired = isset($prepared['sub_field_is_required'][$key]) && $prepared['sub_field_is_required'][$key] ? 1 : 0;
                $staticOptions = null;
                if (($type === 'select' || $type === 'text') && isset($prepared['sub_field_static_options'][$key]) && !empty(trim($prepared['sub_field_static_options'][$key] ?? ''))) {
                    $staticOptions = self::parseStaticOptions($prepared['sub_field_static_options'][$key]);
                }
                $helpText = isset($prepared['sub_field_help_text'][$key]) ? trim($prepared['sub_field_help_text'][$key]) : null;
                $helpText = $helpText !== '' ? $helpText : null;
                ComponentField::create([
                    'component_id' => $master->id,
                    'name' =>  $sub_field,
                    'type' =>  $type,
                    'relationship_type' => $relationshipType,
                    'related_component' => $relatedComponent,
                    'display_column' => $displayColumn,
                    'static_options' => $staticOptions,
                    'help_text' => $helpText,
                    'is_required' => $isRequired,
                    'group' => 1,
                    'schema_group' => $schemaGroup,
                    'position' => $position,
                    'show_in_table' => $showInTable,
                    'colspan' => $colspan,
                ]);
                $pageIds = ComponentField::whereNotNull('group')->whereNotNull('page_id')
                    ->select('page_id')
                    ->groupBy('page_id')
                    ->pluck('page_id');
                $pages_id = [];

                foreach ($pageIds as $key => $value) {
                    $pages_id[$sub_field] = $value;

                    ComponentField::create([
                        'component_id' => $master->id,
                        'name' =>  $sub_field,
                        'type' => $type,
                        'group' => 1,
                        'schema_group' => $schemaGroup,
                        'position' => $position,
                        'page_id' => $value,
                        'show_in_table' => $showInTable,
                        'colspan' => $colspan,
                    ]);
                }



                // If there are no existing default fields, start from position 1
                $nextPositionDefault = $lastFieldDefault?->position ?? 1;
                if (!empty($moreDefault)) {
                    foreach ($moreDefault as $index => $value) {
                        ComponentField::create([
                            'component_id' => $master->id,
                            'name' =>  $sub_field,
                            'type' =>  $prepared['sub_field_type'][$sub_field_count],
                            'group' => $value->group,
                            'schema_group' => $schemaGroup,
                            'position' => $nextPositionDefault,
                            'page_id' =>  null,
                            'show_in_table' => $showInTable,
                            'colspan' => $colspan,
                        ]);
                        $nextPositionDefault++;
                    }
                }
                $nextPosition = $lastField?->position ?? -0;
                if (!empty($more)) {
                    foreach ($more as $index => $value) {
                        ComponentField::create([
                            'component_id' => $master->id,
                            'name' =>  $sub_field,
                            'type' =>  $prepared['sub_field_type'][$sub_field_count],
                            'group' => $value->group,
                            'schema_group' => $schemaGroup,
                            'position' => $nextPosition,
                            'page_id' => isset($pages_id[$sub_field]) ? $pages_id[$sub_field] : null,
                            'show_in_table' => $showInTable,
                            'colspan' => $colspan,
                        ]);
                        $nextPosition++;
                    }
                }
            }
        }


        // $Upload_all_sub_filed = ComponentField::where('component_id', $master->id)
        //     ->whereNotNull('group')
        //     ->where('group', '1')
        //     ->get();

        // $sub_fild_update_count = 0;
        // foreach ($Upload_all_sub_filed as $key => $value) {
        //     ComponentField::where('component_id', $value->component_id)->where('name', $value->)
        //         ->update([
        //             'name' => $sub_fields[$sub_fild_update_count],
        //         ]);
        //     $sub_fild_update_count++;
        //     if ($sub_fild_update_count == count($sub_fields)) {

        //         $sub_fild_update_count = 0;
        //     }
        // }
    }
}
