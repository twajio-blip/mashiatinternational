<x-backend.model :id="'create-model'" class="lg:max-w-6xl" :button="'Submit'" :form_id="'component-create'" :action="route('component.store')"
    :method="__('post')">
    @csrf
    <div class="p-4 sm:p-10 overflow-y-auto  space-y-2">
        <x-backend.input-label :value="'Section Name'" for="component-name" />
        <x-backend.input-field type="text" name="name" id='component-name' :value="old('name')"
            placeholder="Enter Section name" required />
        @php $nextOrder = (\App\Models\ComponentMaster::max('position') ?? 0) + 1; @endphp
        <x-backend.input-label :value="'Order No'" for="component-order" />
        <x-backend.input-field type="number" name="position" id='component-order' :value="old('position', $nextOrder)"
            placeholder="Enter order number (1, 2, 3...)" min="1" class="w-32" />
        <p class="text-xs text-skin-backend-text-base opacity-60">Lower number appears first in list and sidebar</p>
        <div class="mt-3 flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <x-backend.input-switch id="component-single" name="is_single" value="1" />
                <x-backend.input-label :value="'Single entry (no listing table)'" class="ms-1" for="component-single" />
            </div>
            <div class="flex items-center gap-2">
                <x-backend.input-switch id="component-connect" name="is_connected" value="1" />
                <x-backend.input-label :value="'Connect to another component data'" class="ms-1" for="component-connect" />
            </div>
        </div>

        {{-- When "Connect" is ON, hide normal section fields and show this dropdown + related data --}}
        <div class="mt-3 connect-component hidden">
            <x-backend.input-label :value="'Data source component'" for="data_source_component_id" />
            <x-backend.input-select
                id="data_source_component_id"
                name="data_source_component_id"
                :values="$allComponents ?? $components->pluck('name','id')"
                :placeholder="'Select component to use its records'"
                selected=""
            />
            <p class="text-xs text-skin-backend-text-base opacity-60 mt-1">
                When enabled, this section will reuse records from the selected component but can have its own layout.
            </p>
            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <x-backend.input-label :value="'Related Data (optional)'" />
                    <button type="button" class="btn-add-related-data py-1 px-3 text-xs font-semibold rounded bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent hover:bg-opacity-30">
                        <i class="fa-solid fa-plus mr-1"></i> Add
                    </button>
                </div>
                <div class="related-data-container space-y-2">
                    {{-- rows will be added dynamically; default empty --}}
                </div>
            </div>
        </div>

        <div class="component-field">
            <x-backend.input-label :value="'Section field'" for="component" />
            <x-backend.input-select id="component" class="field" :values="input()" :placeholder="'Select one'" selected=''
                required />
            <div class="field-list mt-2">


            </div>
        </div>

        <div class="database-field">
            <div class="flex items-center mt-4">
                <x-backend.input-switch id="database" name='set_from' value='database' />
                <x-backend.input-label :value="'From database'" class=" ms-3" for="database" />
                <x-backend.input-switch id="custom" class="ml-10" name='set_from' value='custom' />
                <x-backend.input-label :value="'Custom'" class=" ms-3 " name='set_custom' for="custom" />
            </div>
            <div class="add-database mt-4 space-y-2">

            </div>
        </div>


    </div>
</x-backend.model>

<script>
    // Toggle between own fields and connected component
    $(document).on('change', '#component-connect', function() {
        const checked = $(this).is(':checked');
        const root = $(this).closest('.overflow-y-auto');
        root.find('.component-field, .database-field').toggle(!checked);
        root.find('.connect-component').toggle(checked);
    });

    $(document).on('change', '#database', function() {
        let status = $(this).parents('.database-field').find('#database').is(':checked');
        $(this).parents('.database-field').find('#custom').prop('checked', false);
        if (status) {
            let element = `
            <x-backend.input-label :value="'Database name'" for="database-name" />
            <x-backend.input-field type="text" name="database" id='database-name' :value="old('database')"
                placeholder="Enter Database name" required />

            <x-backend.input-label :value="'Relational Table (optional)'" for="relational-table" />
            <x-backend.input-field type="text" name="relational_table" id='relational-table' :value="old('relational_table')"
                placeholder="Enter relational table name if needed"  />

            <x-backend.input-label :value="'Detail Limit (optional)'" for="component-limit" />
            <x-backend.input-field type="number" name="limit" id='component-limit' :value="old('limit')"
                placeholder="How many related items to show in details page" min="1" class="w-40" />
            <p class="text-xs text-skin-backend-text-base opacity-60">
                Used when showing related data on the detail page for this component.
            </p>

            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <x-backend.input-label :value="'Related Data (optional)'" />
                    <button type="button" class="btn-add-related-data py-1 px-3 text-xs font-semibold rounded bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent hover:bg-opacity-30">
                        <i class="fa-solid fa-plus mr-1"></i> Add
                    </button>
                </div>
                <div class="related-data-container space-y-2">
                    {{-- rows will be added dynamically; default empty --}}
                </div>
            </div>
            `;

            $(this).parents('.database-field').find('.add-database').html(element);
        } else {
            $(this).parents('.database-field').find('.add-database').empty();

        }
    });
    $(document).on('change', '#custom', function() {
        let status = $(this).parents('.database-field').find('#custom').is(':checked');
        $(this).parents('.database-field').find('#database').prop('checked', false);
        if (status) {
            window.schemaGroupCounter = 1;
            let element = `
            <div class="custom-groups-container space-y-4">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-skin-backend-text-base">Field Groups</span>
                    <button type="button" class="add-group-btn py-2 px-4 text-xs font-semibold rounded-lg bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent hover:bg-opacity-30 transition-colors">
                        <i class="fa-solid fa-plus mr-1"></i> Add Group
                    </button>
                </div>
                <div class="group-blocks">${renderGroupBlock(1)}</div>
            </div>

            <div class="mt-4 space-y-2">
                <div class="flex items-center justify-between">
                    <x-backend.input-label :value="'Related Data (optional)'" />
                    <button type="button" class="btn-add-related-data py-1 px-3 text-xs font-semibold rounded bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent hover:bg-opacity-30">
                        <i class="fa-solid fa-plus mr-1"></i> Add
                    </button>
                </div>
                <div class="related-data-container space-y-2">
                    {{-- rows will be added dynamically; default empty --}}
                </div>
            </div>
            `;
            $(this).parents('.database-field').find('.add-database').html(element);
        } else {
            $(this).parents('.database-field').find('.add-database').empty();

        }
    });
    function renderGroupBlock(schemaGroup) {
        return `
        <div class="group-block border border-default border-opacity-25 rounded-lg p-4 mb-4" data-schema-group="${schemaGroup}">
            <div class="flex items-center justify-between mb-3 gap-3 flex-wrap">
                <div class="flex-1 min-w-[180px]">
                    <label class="block text-xs text-skin-backend-text-base opacity-75 mb-1">Group Name</label>
                    <input type="text" name="sub_group_settings[${schemaGroup}][name]" class="group-name-input w-full px-3 py-2 text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-md text-skin-backend-text-base" placeholder="e.g. Hero, Features, Footer" />
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <input type="checkbox" name="sub_group_settings[${schemaGroup}][is_multiple]" value="1" class="group-multiple-cb checkbox bg-[#eaeaea] border-gray-200 rounded text-skin-hover focus:ring-0" />
                    <label class="text-xs text-skin-backend-text-base opacity-75 whitespace-nowrap">Multiple (allow appending)</label>
                </div>
                <button type="button" class="remove-group inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 bg-opacity-20 text-red-500 hover:bg-opacity-30 text-sm flex-shrink-0" ${schemaGroup === 1 ? 'style="display:none"' : ''}>
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </div>
            <x-backend.input-label :value="'Component field'" for="component" />
            <x-backend.input-select :values="input()" class='sub-component' data-schema-group="${schemaGroup}" :placeholder="'Select one'" selected='' />
            <div class="mt-3 rounded-lg border border-default border-opacity-10 overflow-x-auto">
                <table class="min-w-full text-sm table-fixed" style="table-layout: fixed;">
                    <colgroup>
                        <col style="width: 22%;" />
                        <col style="width: 7%;" />
                        <col style="width: 10%;" />
                        <col style="width: 7%;" />
                        <col style="width: 18%;" />
                        <col style="width: 30%;" />
                        <col style="width: 6%;" />
                    </colgroup>
                    <thead class="bg-[#323232] bg-opacity-50">
                        <tr>
                            <th class="py-2 px-3 text-left font-medium text-skin-backend-text-base">Field</th>
                            <th class="py-2 px-2 text-center font-medium text-skin-backend-text-base">Required</th>
                            <th class="py-2 px-2 text-center font-medium text-skin-backend-text-base">Show in table</th>
                            <th class="py-2 px-2 text-center font-medium text-skin-backend-text-base">Colspan</th>
                            <th class="py-2 px-3 text-left font-medium text-skin-backend-text-base">Help text</th>
                            <th class="py-2 px-3 text-left font-medium text-skin-backend-text-base">Relationship</th>
                            <th class="py-2 px-2 text-center font-medium text-skin-backend-text-base w-14"></th>
                        </tr>
                    </thead>
                    <tbody class="custom-fields-tbody align-top" data-schema-group="${schemaGroup}"></tbody>
                </table>
            </div>
        </div>`;
    }
    $(document).on('click', '#create-model .add-group-btn', function() {
        window.schemaGroupCounter = (window.schemaGroupCounter || 1) + 1;
        $(this).closest('.custom-groups-container').find('.group-blocks').append(renderGroupBlock(window.schemaGroupCounter));
    });
    $(document).on('click', '#create-model .remove-group', function() {
        $(this).closest('.group-block').remove();
    });
    const RELATIONSHIP_TYPES = ['belongsTo', 'hasOne', 'hasMany'];
    const SELECT_TYPE = 'select';
    const manageableComponents = @json($manageableComponents ?? []);
    const manageableOptions = manageableComponents.map(c => `<option value="${c.name}">${c.name.replace(/-/g, ' ')}</option>`).join('');
    $(document).on('change', '#create-model .sub-component', function() {
        let schemaGroup = $(this).data('schema-group');
        let value = $(this).find('option:selected').val();
        let text = $(this).find('option:selected').text();
        if (!value) return;
        $(this).find('option:first').prop('selected', true);
        const isRelationship = RELATIONSHIP_TYPES.includes(value);
        const isSelect = value === SELECT_TYPE;
        const relationshipCell = isSelect ? `
            <td class="py-3 px-3 align-top relationship-cell">
                <div class="space-y-2 text-xs">
                    <label class="block mb-1 text-skin-backend-text-base opacity-75">Static Options (value:Label per line)</label>
                    <textarea name="sub_field_static_options[]" rows="3" class="w-full min-h-[72px] px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base" placeholder="active:Active&#10;inactive:Inactive&#10;draft:Draft"></textarea>
                    <input type="hidden" name="sub_field_related_component[]" value="" />
                    <input type="hidden" name="sub_field_display_column[]" value="" />
                </div>
            </td>
        ` : isRelationship ? `
            <td class="py-3 px-3 align-top relationship-cell">
                <div class="space-y-2 text-xs">
                    <div>
                        <label class="block mb-1 text-skin-backend-text-base opacity-75">Related Component</label>
                        <select name="sub_field_related_component[]" class="w-full px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base">
                            <option value="">Select component</option>
                            ${manageableOptions}
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-skin-backend-text-base opacity-75">Display Column</label>
                        <input type="text" name="sub_field_display_column[]" class="w-full px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary" placeholder="e.g. title, name" />
                    </div>
                    <input type="hidden" name="sub_field_static_options[]" value="" />
                </div>
            </td>
        ` : `
            <td class="py-3 px-3 align-top relationship-cell">
                <div class="min-h-[38px] flex items-center">
                    <span class="text-xs text-skin-backend-text-base opacity-50">—</span>
                </div>
                <input type="hidden" name="sub_field_related_component[]" value="" />
                <input type="hidden" name="sub_field_display_column[]" value="" />
                <input type="hidden" name="sub_field_static_options[]" value="" />
            </td>
        `;
        let row = `
            <tr class="list hover:bg-[#ffffff04]" draggable="true">
                <td class="py-3 px-3 align-top">
                    <x-backend.input-label :value="'${text}'" for="${value}" />
                    <x-backend.input-field type="text" name="sub_field_name[]" class="w-full"
                        placeholder="Enter ${value} field name" required />
                    <x-backend.input-field type="hidden" name="sub_field_type[]" value='${value}' />
                    <input type="hidden" name="sub_field_show_in_table[]" class="show-in-table-val" value="1" />
                    <input type="hidden" name="sub_field_is_required[]" class="is-required-val" value="0" />
                    <input type="hidden" name="sub_field_schema_group[]" value="${schemaGroup}" />
                </td>
                <td class="py-3 px-2 text-center align-middle">
                    <input type="checkbox" class="is-required-cb checkbox bg-[#eaeaea] border-gray-200 rounded text-skin-hover focus:ring-0" />
                </td>
                <td class="py-3 px-2 text-center align-middle">
                    <input type="checkbox" class="show-in-table-cb checkbox bg-[#eaeaea] border-gray-200 rounded text-skin-hover focus:ring-0" checked />
                </td>
                <td class="py-3 px-2 text-center align-top">
                    <select name="sub_field_colspan[]" class="colspan-select w-full max-w-[60px] mx-auto block px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base focus:outline-none focus:border-highlight">
                        ${[1,2,3,4,5,6,7,8,9,10,11,12].map(n => '<option value="'+n+'"'+(n===6?' selected':'')+'>'+n+'</option>').join('')}
                    </select>
                </td>
                <td class="py-3 px-3 align-top">
                    <input type="text" name="sub_field_help_text[]" class="w-full min-h-[38px] px-2 py-1.5 text-xs border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base focus:outline-none focus:border-highlight" placeholder="Hint or link below input" />
                </td>
                ${relationshipCell}
                <td class="py-3 px-2 text-center align-middle">
                    <button type="button" class="remove inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-500 bg-opacity-20 text-red-500 hover:bg-opacity-30 transition-colors">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                </td>
            </tr>
        `;
        $(this).closest('.group-block').find('.custom-fields-tbody[data-schema-group="' + schemaGroup + '"]').append(row);
    });
    $(document).on('change', '.show-in-table-cb', function() {
        var val = $(this).is(':checked') ? '1' : '0';
        $(this).closest('tr.list').find('.show-in-table-val').val(val);
    });
    $(document).on('change', '.is-required-cb', function() {
        var val = $(this).is(':checked') ? '1' : '0';
        $(this).closest('tr.list').find('.is-required-val').val(val);
    });
    $(document).on('change', '#create-model .field', function() {
        let value = $(this).find('option:selected').val();
        let text = $(this).find('option:selected').text();
        if (!value) return;
        $(this).find('option:first').prop('selected', true);
        let element = `
            <div class='list' draggable="true">
                    <x-backend.input-label :value="'${text}'" for="${value}" />
                    <x-backend.input-field type="text" name="field_name[]" class="!w-[90%] inline-block"
                        placeholder="Enter ${value} field name" required />
                    <x-backend.input-field type="hidden" name="field_type[]"
                        value='${value}'  />
                    <span class=" float-end">
                        <button class=" remove text-red-600  text-2xl mt-2"><i class="fa-solid fa-circle-xmark"></i></button>
                    </span>

                </div>
                `;


        $(this).parents('.component-field').find('.field-list').append(element);

    })

    // Related data add/remove (database + custom)
    $(document).on('click', '.btn-add-related-data', function() {
        const container = $(this).closest('.mt-4').find('.related-data-container');
        const rowHtml = `
            <div class="flex gap-2 items-end related-data-row">
                <div class="flex-1">
                    <label class="block text-xs text-skin-backend-text-base opacity-75 mb-1">Label</label>
                    <input type="text" name="related_data_label[]" class="w-full px-3 py-2 text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-md text-skin-backend-text-base" placeholder="e.g. Categories" />
                </div>
                <div class="flex-1">
                    <label class="block text-xs text-skin-backend-text-base opacity-75 mb-1">Source (component)</label>
                    <select name="related_data_source[]" class="w-full px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base">
                        <option value="">Select component</option>
                        ${manageableOptions}
                    </select>
                </div>
                <div class="w-24">
                    <label class="block text-xs text-skin-backend-text-base opacity-75 mb-1">Limit</label>
                    <input type="number" name="related_data_limit[]" min="1" class="w-full px-2 py-1.5 text-sm border border-default border-opacity-25 rounded-md bg-skin-backend-secondary text-skin-backend-text-base" />
                </div>
                <button type="button" class="btn-remove-related-data inline-flex items-center justify-center w-8 h-8 rounded bg-red-500 bg-opacity-20 text-red-500 hover:bg-opacity-30">
                    <i class="fa-solid fa-trash-can text-sm"></i>
                </button>
            </div>
        `;
        container.append(rowHtml);
    });

    $(document).on('click', '.btn-remove-related-data', function() {
        $(this).closest('.related-data-row').remove();
    });

    $(document).on('click', '.remove', function() {
        $(this).closest('.list').remove();
    });

    // Enable drag-and-drop reordering for component fields and custom fields
    (function() {
        let dragSrcEl = null;

        const draggableSelector = '.component-field .field-list .list, #create-model .custom-fields-tbody .list';

        // Start dragging
        $(document).on('dragstart', draggableSelector, function(e) {
            dragSrcEl = this;
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            e.originalEvent.dataTransfer.setData('text/plain', 'drag'); // required for Firefox
            $(this).addClass('opacity-60');
        });

        // Allow dropping
        $(document).on('dragover', draggableSelector, function(e) {
            e.preventDefault();
            if (e.originalEvent.dataTransfer) {
                e.originalEvent.dataTransfer.dropEffect = 'move';
            }
        });

        // Handle drop
        $(document).on('drop', draggableSelector, function(e) {
            e.preventDefault();
            if (!dragSrcEl || dragSrcEl === this) return;

            const $drag = $(dragSrcEl);
            const $target = $(this);

            // Only reorder within the same container
            if ($drag.parent()[0] !== $target.parent()[0]) return;

            if ($drag.index() < $target.index()) {
                $target.after($drag);
            } else {
                $target.before($drag);
            }
        });

        // Cleanup after drag ends
        $(document).on('dragend', draggableSelector, function() {
            $(this).removeClass('opacity-60');
            dragSrcEl = null;
        });
    })();
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("component-create").addEventListener("submit", function(event) {
            // Check if the form is valid
            if (this.checkValidity() === false) {
                // Prevent form submission if validation fails
                event.preventDefault();
                event.stopPropagation();
            } else {

            }
        });
    });
</script>
