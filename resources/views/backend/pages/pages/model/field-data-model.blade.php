<x-backend.model :id="'field-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'pages-ui'"
    :action="route('pages.store')" :method="__('post')" :title="'Edit Section'">
    @csrf
    <div class="p-6 space-y-4">
        <div class="field space-y-2"></div>
        <div class="static space-y-2">
            <x-backend.input-label :value="'Number of displays'" for="dispaly" />
            <x-backend.input-field type="number" name="display" id="display" class="w-full"
                placeholder="Enter number" />
        </div>
        <div class="relationship-section hidden space-y-3 border border-default border-opacity-25 rounded-[10px] p-4">
            <div>
                <h4 class="text-sm font-semibold">Component Relationships</h4>
                <p class="text-xs text-skin-backend-text-base/70">
                    Select related components and configure relationship type.
                </p>
            </div>
            <div class="relationship-list space-y-3"></div>
            <input type="hidden" name="relationship_config" id="relationship_config" value="">
        </div>
        <div class="advanced-toggle-section hidden border border-default border-opacity-25 rounded-[10px] p-4">
            <label class="flex items-center justify-between gap-3 cursor-pointer">
                <div>
                    <h4 class="text-sm font-semibold">Advanced Mode</h4>
                    <p class="text-xs text-skin-backend-text-base/70">Enable field mapping and selected-field display controls.</p>
                </div>
                <input id="advanced_mode_toggle" type="checkbox"
                    class="checkbox bg-[#eaeaea] shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0">
            </label>
        </div>
        <div class="advanced-section hidden space-y-3 border border-default border-opacity-25 rounded-[10px] p-4">
            <div>
                <h4 class="text-sm font-semibold">Advanced Mode</h4>
                <p class="text-xs text-skin-backend-text-base/70">
                    Choose selected fields and map related component fields.
                </p>
            </div>
            <div class="selected-component-fields space-y-2"></div>
            <div class="advanced-mapping-list space-y-3"></div>
            <input type="hidden" name="advanced_relationship_config" id="advanced_relationship_config" value="">
        </div>
    </div>


</x-backend.model>
<script>
    $(document).ready(function() {
        function parseComponentPayload(raw) {
            if (!raw) return null;
            if (typeof raw === 'object') return raw;
            try {
                return JSON.parse(raw);
            } catch (e) {
                return null;
            }
        }

        function uniqueFieldsFromComponent(component) {
            const fields = component?.component_filed || [];
            const names = [];
            fields.forEach((field) => {
                if (!field || !field.name) return;
                if (!names.includes(field.name)) {
                    names.push(field.name);
                }
            });
            return names;
        }

        function getAllComponentPayloads() {
            const list = [];
            $('.add-field-value').each(function() {
                const parsed = parseComponentPayload($(this).attr('data'));
                if (parsed && parsed.id && !list.some((item) => Number(item.id) === Number(parsed.id))) {
                    list.push(parsed);
                }
            });
            return list;
        }

        function detectRelatedComponents(currentComponent, allComponents) {
            const relatedIds = new Set();
            const nameToId = {};

            allComponents.forEach((component) => {
                nameToId[String(component.name || '').toLowerCase()] = Number(component.id);
            });

            if (currentComponent?.data_source_component_id) {
                relatedIds.add(Number(currentComponent.data_source_component_id));
            }

            (currentComponent?.component_filed || []).forEach((field) => {
                if (field?.related_component) {
                    const id = nameToId[String(field.related_component).toLowerCase()];
                    if (id) relatedIds.add(id);
                }
            });

            allComponents.forEach((component) => {
                if (Number(component.id) === Number(currentComponent.id)) return;
                if (Number(component?.data_source_component_id) === Number(currentComponent.id)) {
                    relatedIds.add(Number(component.id));
                }
                (component?.component_filed || []).forEach((field) => {
                    if (String(field?.related_component || '').toLowerCase() === String(currentComponent?.name || '').toLowerCase()) {
                        relatedIds.add(Number(component.id));
                    }
                });
            });

            return allComponents.filter((component) =>
                Number(component.id) !== Number(currentComponent.id) && relatedIds.has(Number(component.id))
            );
        }

        function getRelationshipTypeLabel(type) {
            if (type === 'one_to_one') return 'One-to-One';
            if (type === 'one_to_many') return 'One-to-Many';
            if (type === 'many_to_one') return 'Many-to-One';
            return 'One-to-One';
        }

        function getScopedConfigSource(component) {
            const mode = window._pagesUiContext?.mode || 'default';
            if (mode === 'custom' && component?.page_status) {
                return {
                    relationship_config: Array.isArray(component.page_status.relationship_config) ? component.page_status.relationship_config : null,
                    advanced_relationship_config: Array.isArray(component.page_status.advanced_relationship_config) ? component.page_status.advanced_relationship_config : null
                };
            }

            return {
                relationship_config: Array.isArray(component?.default_relationship_config) ? component.default_relationship_config : null,
                advanced_relationship_config: Array.isArray(component?.default_advanced_relationship_config) ? component.default_advanced_relationship_config : null
            };
        }

        function buildRelationshipList(currentComponent, allComponents, advancedMode) {
            const autoDetected = detectRelatedComponents(currentComponent, allComponents);
            const autoDetectedIds = new Set(autoDetected.map((item) => Number(item.id)));
            const scopedConfig = getScopedConfigSource(currentComponent);
            const savedRelationshipConfig = scopedConfig.relationship_config;
            const hasSavedRelationshipConfig = savedRelationshipConfig !== null;
            const savedRelationshipMap = new Map(
                (savedRelationshipConfig || []).map((cfg) => [Number(cfg.related_component_id), cfg])
            );
            const availableComponents = autoDetected;

            if (!availableComponents.length) {
                return `<p class="text-xs text-skin-backend-text-base/70">No related components detected for this component.</p>`;
            }

            return availableComponents.map((component) => {
                const componentId = Number(component.id);
                const savedConfig = savedRelationshipMap.get(componentId);
                const checked = hasSavedRelationshipConfig
                    ? savedRelationshipMap.has(componentId)
                    : autoDetectedIds.has(componentId);
                const selectedType = savedConfig?.relationship_type || 'one_to_one';
                const badge = `<span class="text-[10px] px-2 py-1 rounded bg-[#3762ED] text-white">Auto detected</span>`;

                return `
                    <div class="border border-default border-opacity-25 rounded-[10px] p-3 space-y-2 relationship-row" data-related-id="${component.id}">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 text-sm">
                                <input type="checkbox" class="relationship-select checkbox bg-[#eaeaea] shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0"
                                    value="${component.id}" ${checked ? 'checked' : ''}>
                                <span>${component.name}</span>
                            </div>
                            ${badge}
                        </div>
                        <div class="relationship-config ${checked ? '' : 'hidden'}">
                            <label class="text-xs block mb-1">Relationship Type</label>
                            <select class="relationship-type w-full bg-skin-backend-secondary border border-default border-opacity-25 rounded-[6px] px-2 py-2">
                                <option value="one_to_one" ${selectedType === 'one_to_one' ? 'selected' : ''}>One to One</option>
                                <option value="one_to_many" ${selectedType === 'one_to_many' ? 'selected' : ''}>One to Many</option>
                                <option value="many_to_one" ${selectedType === 'many_to_one' ? 'selected' : ''}>Many to One</option>
                            </select>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function buildAdvancedMappings(currentComponent, selectedRelatedComponents) {
            const currentFields = uniqueFieldsFromComponent(currentComponent);
            const scopedConfig = getScopedConfigSource(currentComponent);
            const savedAdvancedConfig = Array.isArray(scopedConfig.advanced_relationship_config)
                ? scopedConfig.advanced_relationship_config
                : [];
            const selectedCurrentFields = Array.from(new Set(savedAdvancedConfig.flatMap((cfg) =>
                Array.isArray(cfg?.selected_component_fields) ? cfg.selected_component_fields : []
            )));
            const hasSavedCurrentFieldSelection = selectedCurrentFields.length > 0;

            const selectedComponentFieldList = currentFields.length
                ? currentFields.map((field) => `
                    <label class="inline-flex items-center gap-2 text-xs mr-3 mb-2">
                        <input type="checkbox" class="current-display-field checkbox bg-[#eaeaea] shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0" value="${field}" ${hasSavedCurrentFieldSelection ? (selectedCurrentFields.includes(field) ? 'checked' : '') : 'checked'}>
                        <span>${field}</span>
                    </label>
                `).join('')
                : `<span class="text-xs text-skin-backend-text-base/70">No fields found for the selected component.</span>`;

            $('#field-model .selected-component-fields').html(`
                <div>
                    <p class="text-xs mb-2">Select Current Component Fields (Only selected fields will be shown on get data time)</p>
                    <div class="flex flex-wrap gap-1">${selectedComponentFieldList}</div>
                </div>
            `);

            if (!selectedRelatedComponents.length) {
                return `<p class="text-xs text-skin-backend-text-base/70">No related components found. You can still select current component fields.</p>`;
            }

            return selectedRelatedComponents.map((component) => {
                const filteredRelatedFields = uniqueFieldsFromComponent(component);
                const savedForRelated = savedAdvancedConfig.find((cfg) => Number(cfg?.related_component_id) === Number(component.id));
                const savedDisplayFields = Array.isArray(savedForRelated?.display_fields) ? savedForRelated.display_fields : [];
                const hasSavedDisplaySelection = savedDisplayFields.length > 0;
                const relatedCheckboxes = filteredRelatedFields.map((field) => `
                    <label class="inline-flex items-center gap-2 text-xs mr-3 mb-2">
                        <input type="checkbox" class="relationship-display-field checkbox bg-black shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0"
                            value="${field}" ${hasSavedDisplaySelection ? (savedDisplayFields.includes(field) ? 'checked' : '') : 'checked'}>
                        <span>${field}</span>
                    </label>
                `).join('');

                return `
                    <div class="border border-default border-opacity-25 rounded-[10px] p-3 space-y-3 advanced-map-card" data-related-id="${component.id}">
                        <div class="flex items-center justify-between">
                            <h5 class="text-sm font-medium">${component.name}</h5>
                        </div>
                        <div>
                            <p class="text-xs mb-2">Related Component Fields to Display</p>
                            <div class="flex flex-wrap">${relatedCheckboxes || '<span class="text-xs text-skin-backend-text-base/70">No fields available.</span>'}</div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function refreshAdvancedMappings(currentComponent, allComponents) {
            const selectedIds = $('#field-model .relationship-select:checked').map(function() {
                return Number($(this).val());
            }).get();

            const selectedRelatedComponents = allComponents.filter((component) => selectedIds.includes(Number(component.id)));
            const html = buildAdvancedMappings(currentComponent, selectedRelatedComponents);
            $('#field-model .advanced-mapping-list').html(html);
        }

        function collectRelationshipConfig() {
            const config = [];
            $('#field-model .relationship-row').each(function() {
                const row = $(this);
                const isSelected = row.find('.relationship-select').is(':checked');
                if (!isSelected) return;
                config.push({
                    related_component_id: Number(row.attr('data-related-id')),
                    relationship_type: row.find('.relationship-type').val() || 'one_to_one',
                    data_view: 'list'
                });
            });

            $('#field-model #relationship_config').val(JSON.stringify(config));
            return config;
        }

        function collectAdvancedRelationshipConfig() {
            const advanced = [];
            const selectedCurrentFields = $('#field-model .current-display-field:checked').map(function() {
                return $(this).val();
            }).get();

            $('#field-model .advanced-map-card').each(function() {
                const card = $(this);
                const relatedId = Number(card.attr('data-related-id'));

                const displayFields = card.find('.relationship-display-field:checked').map(function() {
                    return $(this).val();
                }).get();

                advanced.push({
                    related_component_id: relatedId,
                    field_mapping: [],
                    display_fields: displayFields,
                    selected_component_fields: selectedCurrentFields
                });
            });
            $('#field-model #advanced_relationship_config').val(JSON.stringify(advanced));
            return advanced;
        }

        $(document).on('click', '.add-field-value', function() {
            let data = $(this).attr('data');
            let dataBaseData = $(this).attr('dataBase');

            data = JSON.parse(data);
            let fileds = [];
            let sub_fileds = '';
            let group_fileds = [];
            let arraySet = [];
            let group = 1;
            let count = 0;

            // Detect page context:
            // - Edit page: #pages-edit exists and has a real page-id
            // - Create page: no #pages-edit -> treat as null (no page yet)
            let page_id = $('#pages-edit').length ? $('#pages-edit').attr('page-id') : null;


            Swal.fire({
                title: "Choose Your Design Option",
                text: "Select a mode to configure your component fields and relationships.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#FA9B0D",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Custom",
                cancelButtonText: "Default",
                background: "#1e1e1e", // dark background
                color: "#ffffff"       // light text color
            }).then((result) => {
                let value = data.component_filed;
                const isCustomMode = result.isConfirmed;
                const isDefaultMode = result.dismiss === Swal.DismissReason.cancel;

                if (isCustomMode) {
                    if (data.component_filed_page_wise.length != 0) {
                        value = data.component_filed_page_wise;

                    } else {
                        value = data.component_filed;

                    }

                    fileds.push(`<input type="hidden" name='status' value="1" >`)
                    if (page_id) {
                        fileds.push(`<input type="hidden" name='page_id' value="${page_id}" >`)
                    }
                    HSOverlay.open('#field-model');
                } else if (isDefaultMode) {
                    value = data.component_filed;
                    // Default mode = use GLOBAL data (no page_id for fields)
                    fileds.push(`<input type="hidden" name='status' value="0" >`)
                    HSOverlay.open('#field-model');
                } else {
                    return;
                }
                fileds.push(`<input type="hidden" name='component_id' value="${data.id}" >`)
                if (page_id) {
                    fileds.push(
                        `<input type="hidden" name='page_id_for_status' value="${page_id}" >`
                    );
                }
                // Use component template (component_filed) to decide if "Number of displays" applies,
                // so it shows for both Default and Custom even when page-wise data is empty.
                const templateFields = data.component_filed || [];
                const countfield = templateFields.filter((element) => {
                    return element.group == 1;
                });

                const hasChild =
                    countfield.length > 0 ||
                    (data.set_from === 'database' && data.database) ||
                    !!data.is_connected; // always allow number of displays for connected components

                if (hasChild) {
                    $('#field-model .static').removeClass('hidden');
                } else {
                    $('#field-model .static').addClass('hidden');
                    $('#field-model #display').val(0);
                }

                fileds.push(`<input type="hidden" name='id' value='${data.id}'>`)
                // Store so submit can send id even if form inputs are in wrong/cloned form
                // CRITICAL: Only send page_id when Custom mode (status=1), not Default mode
                window._pagesUiContext = {
                    id: data.id,
                    component_id: data.id,
                    page_id: isCustomMode && page_id ? page_id : null,
                    page_id_for_status: page_id || null,
                    status: isCustomMode ? 1 : 0,
                    mode: isCustomMode ? 'custom' : 'default',
                    currentComponent: data,
                    allComponents: getAllComponentPayloads()
                };
                textarea = '';
                value.forEach(element => {
                    let result = element.name.replace('_', ' ');
                    let elementName = result.charAt(0).toUpperCase() + result.slice(1);
                    let elementId = element.id;

                    if (element.group == null) {
                        if (element.type == "textarea") {
                            fileds.push(` <div class='list'>
                    <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                    <x-backend.input-textarea name="field_name[]"   :text="'${element.value ?? textarea}'" placeholder='Enter ${elementName}' />
                    <x-backend.input-field value='${element.id}' type="hidden" name="field_id[]"  
                        placeholder="''"   />
                        </div>`);
                        } else if (element.type == "textEditor") {
                            fileds.push(`
                            <div class='list'>
                                <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                                <textarea 
                                    id="editor-${element.id}" 
                                    name="field_name[]" 
                                    class='w-full abcd'
                                    placeholder="Enter ${elementName}" 
                                    >${element.value ?? textarea}</textarea>
                                <x-backend.input-field 
                                    value='${element.id}' 
                                    type="hidden" 
                                    name="field_id[]" 
                                    placeholder="''" 
                                />
                            </div>
                        `);


                            // Initialize the text editor after the content is added
                            setTimeout(() => {
                                applyTextEditor(`editor-${element.id}`)
                            }, 100); // Delay to ensure the DOM is updated

                        } else if (element.type == "file") {
                            fileds.push(`
                        
                        
                        <div class='list'>
                            <x-backend.input-label :value="'${elementName}'" for="${element.name}" /> 
                        </div>

                        <div class="flex items-center relative">
                            <p 
                                id="lfm" 
                                data="${element.id}"
                                data-input="label${element.id}"  
                                data-preview="holder${element.id}" 
                                class="absolute left-[1px] btn bg-[#323232] text-skin-backend-text-base px-4 py-2 rounded-l-[4px] flex items-center space-x-2 custom${element.id}">
                                <i class="fa fa-picture-o"></i>
                                <span>Choose</span>
                            </p>
                            <x-backend.input-field value='${element.id}' type="hidden" name="field_image_id[] "  />
                            <input 
                            name="field_image[]"'
                                id="label${element.id}" readonly
                                value="${element.value ? element.value : '' }" 
                                class="w-full pl-24 form-control bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] px-3 py-2 flex-1" 
                                type="text focus:outline-none focus:border-highlight focus:ring-0 transition-colors" 
                                >
                        </div>
                        
                        <div 
                        id="holder${element.id}" 
                        class="mt-4 max-h-24 overflow-hidden">
                    
                        ${element.value ? `<img src="${element.value}" height="40" width="50" >` : '' }
                        </div>
                        `);
                        } else if (element.type == 'checkBox') {
                            fileds.push(` <div class='list '>
                   
                     <div class="flex items-center mt-3 w-fit">
                        <input type="checkbox" class="checkbox bg-[#eaeaea] shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0 disabled:opacity-50 disabled:pointer-events-none" id="${element.name}"  value='1'   ${element?.value == '1' ? 'checked' : ''}>
                        <label for="${element.name}" class="ms-3">${elementName}</label>
                        <input value="${element.value ? element.value : '' }" class='checkbox_value' type='hidden' name="field_name[]"  />
                        </div>
                        <x-backend.input-field  value='${element.id}' type="hidden" name="field_id[]"  
                        placeholder="''"   />
                        </div>`);

                        } 
                        else {
                            fileds.push(` <div class='list'>
                    <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                    <x-backend.input-field type="${element.type}" name="field_name[]" value="${element.value ? element.value : '' }"   class="w-full"
                        placeholder="Enter ${elementName}" />
                        <x-backend.input-field value='${element.id}' type="hidden" name="field_id[]"  
                        placeholder="''"   />
                        </div>`);
                        }
                    }

                    if (element.group != null) {
                        count++
                        arraySet.push(element)
                        group = element.group;
                        textarea = '';
                        if (element.type == "textarea") {
                            sub_fileds = sub_fileds + ` <div class='list'>
                    <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                    <x-backend.input-textarea   name="subfield[${element.group}][${element.name}]" :text="'${element.value ?? textarea}'" placeholder='Enter ${element.name}' />
                    <x-backend.input-field value='${element.id}' type="hidden" name="sub_field_id[]"  
                        placeholder="''"   />
                        </div>`;
                        } else if (element.type == "textEditor") {

                            sub_fileds += `
                                <div class='list'>
                                    <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                                    <textarea 
                                        id="editor-${elementId}" 
                                        name="subfield[${element.group}][${element.name}]" 
                                        placeholder="Enter ${element.name}" 
                                        >${element.value ?? textarea}</textarea>
                                    <x-backend.input-field 
                                        value="${element.id}" 
                                        type="hidden" 
                                        name="sub_field_id[]" 
                                        placeholder="''" 
                                    />
                                </div>
                            `;



                            setTimeout(() => {
                                applyTextEditor(`editor-${elementId}`)
                            }, 100);



                        } else if (element.type == "file") {
                            let randomNumber = generateRendomNumber()

                            sub_fileds = sub_fileds + `
                        <div class='list'>
                            <x-backend.input-label :value="'${elementName}'" for="${element.name}" /> 
                        </div>
                        <div class="flex items-center relative">
                                <p 
                                    id="lfm" 
                                    data="${randomNumber}"
                                    data-input="label${randomNumber}"  
                                    data-preview="holder${randomNumber}" 
                                    class="absolute left-[1px] btn bg-[#323232] text-skin-backend-text-base px-4 py-2 rounded-l-[4px] flex items-center space-x-2 custom${randomNumber}">
                                    <i class="fa fa-picture-o"></i>
                                    <span>Choose</span>
                                </p>
                            <x-backend.input-field value='${element.id}' type="hidden" name="sub_field_id[]"  
                             />
                                <input 
                                name="subfield[${element.group}][${element.name}]"'
                                    id="label${randomNumber}" readonly
                                    value="${element.value ? element.value : '' }" 
                                    class="w-full pl-24 form-control bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] px-3 py-2 flex-1" 
                                type="text focus:outline-none focus:border-highlight focus:ring-0 transition-colors" 
                                    type="text" 
                                  >
                        </div>
                                <div 
                                id="holder${randomNumber}" 
                                class="mt-4 max-h-24 overflow-hidden">
                          
                                ${element.value ? `<img src="${element.value}"" height="40" width="50" >` : '' }
                                </div>



                                `
                        } 
                        else if(element.type == "checkBox"){
                            sub_fileds = sub_fileds + ` <div class='list'>
                                                        <div class="flex items-center mt-3 w-fit">
                                                        <input name="subfield[${element.group}][${element.name}]" type="checkbox" class="checkbox bg-[#eaeaea] shrink-0 border-gray-200 rounded text-skin-hover focus:ring-0 focus:ring-offset-0 disabled:opacity-50 disabled:pointer-events-none" id="subfield[${element.group}][${element.name}]"  value='1'   ${element?.value == '1' ? 'checked' : ''} required/>
                                                        <label for="subfield[${element.group}][${element.name}]" class="ms-3">${elementName}</label>
                                                        <input value="${element.value ? element.value : '' }" class='checkbox_value' type='hidden' name="sub_field_id[]"  /> 
                                                        </div>
                                                        </div>`;
                        }
                        else {
                            sub_fileds = sub_fileds + ` <div class='list'>
                                                        <x-backend.input-label :value="'${elementName}'" for="${element.name}" />
                                                        <x-backend.input-field type="${element.type}" name="subfield[${element.group}][${element.name}]"  class="w-full"
                                                        placeholder="Enter ${elementName}" value="${element.value ? element.value : '' }" />
                                                        <x-backend.input-field value='${element.id}' type="hidden" name="sub_field_id[]"  
                                                        placeholder="''"   />
                                                        </div>`;
                        }

                        if (group != element.group || count == countfield.length) {
                            element = `
                <div class="border border-default border-opacity-25 rounded-[10px] clone space-y-2 overflow-hidden">
                      <div class="bg-[#323232] p-3">
                         <button type='button' class="relative toggole  outline-none w-full  text-left  ">${arraySet['0'].value}
                    <span class="absolute right-9 top-0 bottom-0 icone flex items-center items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="absolute right-0 top-0 bottom-0 remove-group flex items-center z-50 gap-x-1 text-xs decoration-2 font-medium no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                        <i class="fa-solid fa-remove remove-group"></i>
                    </span>
                </button>
                       </div>
                       <div class="content hidden p-3 space-y-3">
                       ${sub_fileds}
                           </div>

                     </div>
                        `
                            sub_fileds = [];
                            count = 0;
                            arraySet = [];
                            group_fileds.push(element);
                        }
                        group = element.group;

                    }

                });

                // Decide initial "Number of displays":
                // 1) Use existing page_status.data_view_no if present
                // 2) Else use component default limit (data.limits.limit) if available
                // 3) Else fallback to 1 so frontend shows something
                let initDisplay;
                if (data.page_status && data.page_status.data_view_no != null && data.page_status.data_view_no !== 'null') {
                    initDisplay = data.page_status.data_view_no;
                } else if (data.limits && typeof data.limits.limit !== 'undefined' && data.limits.limit !== null) {
                    initDisplay = data.limits.limit;
                } else {
                    initDisplay = 1;
                }
                $('#field-model .static').find('#display').val(initDisplay);
                $('#field-model .field').html(fileds);

                const componentList = window._pagesUiContext?.allComponents || [];
                const detectedRelationships = detectRelatedComponents(data, componentList);
                const relationshipHtml = buildRelationshipList(data, componentList, false);

                $('#field-model .relationship-section').removeClass('hidden');
                $('#field-model .relationship-list').html(relationshipHtml);
                collectRelationshipConfig();

                $('#field-model #advanced_mode_toggle').prop('checked', false);
                $('#field-model .advanced-toggle-section').removeClass('hidden');

                if ($('#field-model #advanced_mode_toggle').is(':checked')) {
                    $('#field-model .advanced-section').removeClass('hidden');
                } else {
                    $('#field-model .advanced-section').addClass('hidden');
                    $('#field-model .advanced-mapping-list').html('');
                    $('#field-model .selected-component-fields').html('');
                }

                refreshAdvancedMappings(data, componentList);
                collectAdvancedRelationshipConfig();
            });




        })

        $(document).on('change', '#field-model .relationship-select', function() {
            const row = $(this).closest('.relationship-row');
            if ($(this).is(':checked')) {
                row.find('.relationship-config').removeClass('hidden');
            } else {
                row.find('.relationship-config').addClass('hidden');
            }
            const ctx = window._pagesUiContext || {};
            collectRelationshipConfig();
            refreshAdvancedMappings(ctx.currentComponent || {}, ctx.allComponents || []);
            collectAdvancedRelationshipConfig();
        });

        $(document).on('change',
            '#field-model .relationship-display-field, #field-model .current-display-field, #field-model .relationship-type',
            function() {
                collectRelationshipConfig();
                collectAdvancedRelationshipConfig();
            }
        );

        $(document).on('change', '#field-model #advanced_mode_toggle', function() {
            const ctx = window._pagesUiContext || {};
            const enabled = $(this).is(':checked');
            if (enabled) {
                $('#field-model .advanced-section').removeClass('hidden');
                refreshAdvancedMappings(ctx.currentComponent || {}, ctx.allComponents || []);
            } else {
                $('#field-model .advanced-section').addClass('hidden');
                $('#field-model .advanced-mapping-list').html('');
                $('#field-model .selected-component-fields').html('');
            }
            collectAdvancedRelationshipConfig();
        });

        $(document).on('click', '.remove-group', function() {
            $(this).closest('.border').remove();
        })
        //   Group Toggole 
        $(document).on('click', '.toggole', function() {
            let parentBorder = $(this).closest('.border');
            let content = parentBorder.find('.content');
            let icone = parentBorder.find('.icone');

            icone.html(content.css('display') == 'block' ? '<i class="fa-solid fa-plus"></i>' :
                '<i class="fa-solid fa-minus"></i>');
            content.slideToggle(200);
        });

        // Ui Element Store 
        $(document).on('submit', '#pages-ui', function(e) {
            e.preventDefault()
            let page_id = $('#pages-edit').attr('page-id');

            
            $('.loader').removeClass('hidden');
            $('.submit').addClass('hidden');
            
            let form = new FormData(this);

            // Always send id/component_id from stored context (form inputs may be in cloned modal)
            var ctx = window._pagesUiContext;
            if (ctx && (ctx.id != null && ctx.id !== '')) {
                form.set('id', ctx.id);
                form.set('component_id', ctx.component_id);
                // CRITICAL: Only send page_id if it's actually set (Custom mode)
                // If null/empty (Default mode), don't send it so backend uses global fields
                if (ctx.page_id && ctx.page_id !== '' && ctx.page_id !== 'null') {
                    form.set('page_id', ctx.page_id);
                }
                if (ctx.page_id_for_status && ctx.page_id_for_status !== '' && ctx.page_id_for_status !== 'null') {
                    form.set('page_id_for_status', ctx.page_id_for_status);
                }
                form.set('status', String(ctx.status));
            }

            let thisElement = $(this)
            form.append('_token', $('input[name="_token"]').val());

            const relationshipConfig = collectRelationshipConfig();
            const advancedRelationshipConfig = collectAdvancedRelationshipConfig();
            const isAdvancedEnabled = $('#field-model #advanced_mode_toggle').is(':checked');
            form.set('relationship_config', JSON.stringify(relationshipConfig));
            form.set('advanced_relationship_config', JSON.stringify(advancedRelationshipConfig));
            form.set('ui_mode', isAdvancedEnabled ? 'advanced' : ((window._pagesUiContext && window._pagesUiContext.mode) ? window._pagesUiContext.mode : 'default'));

            // Normalize empty field values so backend gets a consistent \"null\" string.
            // This helps distinguish between \"not sent\" and \"sent but empty\".
            for (let [key, value] of form.entries()) {
                if (typeof value === 'string' && value.trim() === '') {
                    form.set(key, 'null');
                }
            }
            fetch('{{ route('add-ui') }}', {
                method: "post",
                credentials: "same-origin",
                body: form,
            }).then(function(response) {
                return response.json().then(function(json) {
                    if (!response.ok) {
                        return Promise.reject({ response: response, json: json });
                    }
                    return json;
                });
            }).then(function(json) {
                if (!json.component || !json.item) {
                    console.error('Add UI: invalid response', json);
                    $('.loader').addClass('hidden');
                    $('.submit').removeClass('hidden');
                    return;
                }
                thisElement.find('.cancle').trigger('click')

                let data = [];
                // Field 
                json.component.forEach(element => {
                    data = data + ` <div class="col-span-12 sm:col-span-6 flex flex-col gap-2 sm:flex-row items-center justify-between  w-full border border-default border-opacity-25 rounded-[10px] p-4 sm:px-2 sm:py-1">
                <div class="shrink-0 h-30 sm:h-[60px] w-full sm:w-[120px] text-center flex items-center justify-center bg-[#323232] rounded-[10px]">
                    <i class="fa-solid fa-code text-6xl sm:text-2xl text-gray-400"></i>
                </div>
                <div class="">
                    <h3 class="">
                        ${element.name}
                    </h3>
             </div>
                    <span class="cursor-pointer float-right">
                        <a href="#" data='${JSON.stringify(element)}' type='button' 
                            class="${element.name+element.id} add-field-value px-4 py-2 bg-skin-backend-accent text-skin-invert rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Use
                        </a>
                    </span>


            </div>`

                });
                ui = `<div id='${json.item.name + json.item.id}'
                          class="flex flex-col bg-skin-backend-secondary component-parent border border-default border-opacity-25 rounded-[10px]">
                                    <div
                                        class="flex justify-between items-center py-3 px-4 md:px-5">
                                        <h3 class="text-md font-semibold">
                                       ${json.item.name} 
                                        </h3>
                                        <input type="hidden" name='component_id[]' value='${json.item.id}' />
                                        <input type="hidden" id='limit' name='display[]' value='${json.item.display}' />

                                        <div class="flex items-center gap-x-3">
                                            <div class="hs-tooltip inline-block">
                                                <button type="button" target='${json.item.name+json.item.id}'
                                                    class="componet-edit hs-tooltip-toggle size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-blue-200 bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <span
                                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                        role="tooltip">
                                                        Edit
                                                    </span>
                                                </button>
                                            </div>
                                
                                            <div class="hs-tooltip inline-block">
                                                <button type="button"
                                                    class="hs-tooltip-toggle removeComonent size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none">
                                                    <i class="fa-solid fa-xmark"></i>
                                                    <span
                                                        class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                                        role="tooltip">
                                                        Delete
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </div>`;
                var $sortable = $('#sortable');
                if ($sortable.length && $sortable.find("#" + json.item.name + json.item.id).length === 0) {
                    $sortable.append(ui);
                } else if ($sortable.length) {
                    $sortable.find("#" + json.item.name + json.item.id).replaceWith(ui);
                }

                $('.addComponent').html(data);
                $('.loader').addClass('hidden');
                $('.submit').removeClass('hidden');
            }).catch(function(err) {
                $('.loader').addClass('hidden');
                $('.submit').removeClass('hidden');
                var msg = (err && err.json && err.json.error) ? err.json.error : (err && err.message) ? err.message : 'Could not add component.';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                } else {
                    alert(msg);
                }
            })


        })


    });
    // File manager
    $(document).on('click', '#lfm', function() {
        if (!$(this).data('initialized')) {
            let attr = $(this).attr('data');
            $('.custom' + attr).filemanager('file');
            $(this).data('initialized', true);
        }
    });
    // Checkbox 
    $(document).on('change', '.checkbox', function() {
        var checkboxValue = $(this).prop('checked') ? 1 : 0;
        $(this).parent().find('.checkbox_value').val(checkboxValue);
    });
</script>