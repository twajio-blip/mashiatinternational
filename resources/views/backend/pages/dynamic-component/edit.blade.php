<x-Deshboard-layout>
    <div class="py-10">
        <div class="space-y-4">
            <div class="space-y-2 max-w-[400px] text-skin-backend-text-base">
                <h2 class="text-[24px]">
                    <a href="{{ route('dashboard') }}" class="font-bold">Dashboard</a> /
                    <a href="{{ route('dynamic-component.index', $dynamicComponent->name) }}" class="font-bold">{{ ucfirst(str_replace('-', ' ', $dynamicComponent->name)) }}</a> /
                    <span class="text-opacity-50">Edit</span>
                </h2>
                <p class="text-[14px] text-opacity-50">
                    Edit {{ ucfirst(str_replace('-', ' ', $dynamicComponent->name)) }} record.
                </p>
            </div>

            @php
                $rowId = $row->id ?? $row->_group ?? '';
                $useDatabase = $dynamicComponent->set_from === 'database' && $dynamicComponent->database;
            @endphp

            <form id="dynamic-component-form" action="{{ route('dynamic-component.update', [$dynamicComponent->name, $rowId]) }}" method="post" enctype="multipart/form-data"
                class="bg-skin-backend-secondary p-6 rounded-[10px]">
                @csrf
                @method('put')
                @php
                    $fields = $dynamicComponent->componentFiled->where('group', 1)->sortBy('schema_group');
                    if ($fields->isEmpty() && $useDatabase && $dynamicComponent->database) {
                        $cols = array_diff(\Illuminate\Support\Facades\Schema::getColumnListing($dynamicComponent->database), ['id', 'created_at', 'updated_at']);
                        $fields = collect($cols)->map(fn($col) => (object)['name' => $col, 'type' => 'text', 'colspan' => 1]);
                    }
                    $fieldsByGroup = $fields->groupBy(fn($f) => is_object($f) ? ($f->schema_group ?? 1) : 1);
                    $relationshipOptions = $relationshipOptions ?? [];
                    $schemaGroupSettings = is_array($dynamicComponent->schema_group_settings ?? null) ? $dynamicComponent->schema_group_settings : [];
                    if (empty($schemaGroupSettings) && is_array($dynamicComponent->schema_group_names ?? null)) {
                        foreach ($dynamicComponent->schema_group_names ?? [] as $gid => $name) {
                            $schemaGroupSettings[$gid] = ['name' => $name];
                        }
                    }
                @endphp
                @foreach($fieldsByGroup as $schemaGroup => $groupFields)
                @php
                    $groupSettings = $schemaGroupSettings[$schemaGroup] ?? $schemaGroupSettings[(string)$schemaGroup] ?? [];
                    $groupName = $groupSettings['name'] ?? 'Group ' . $schemaGroup;
                    $groupIsMultiple = !empty($groupSettings['is_multiple']);
                    $instances = isset($row->_fields[$schemaGroup]) ? $row->_fields[$schemaGroup] : (isset($row->_fields[(string)$schemaGroup]) ? $row->_fields[(string)$schemaGroup] : collect());
                    if ($instances instanceof \Illuminate\Support\Collection && $instances->isEmpty()) {
                        $instances = collect([1 => collect()]);
                    } elseif (!($instances instanceof \Illuminate\Support\Collection) && !is_array($instances)) {
                        $instances = collect([1 => $instances]);
                    }
                    if (is_array($instances)) {
                        $instances = collect($instances);
                    }
                    $instanceIds = $instances->keys()->sort()->values();
                    if ($instanceIds->isEmpty()) {
                        $instanceIds = collect([1]);
                    }
                @endphp
                <div class="group-section mb-6 flex flex-col" data-schema-group="{{ $schemaGroup }}">
                    <div class="group-instances space-y-4">
                @foreach($instanceIds as $instanceId)
                    <div class="group-instance rounded-[10px] border border-default border-opacity-25 p-6 bg-[#ffffff04]" data-schema-group="{{ $schemaGroup }}" data-instance="{{ $instanceId }}">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-skin-backend-text-base">{{ $groupName }}@if($instanceIds->count() > 1) ({{ $instanceId }})@endif</h3>
                        @if($groupIsMultiple)
                        <button type="button" class="remove-group-instance inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-500 bg-opacity-20 text-red-500 hover:bg-opacity-30 text-sm" title="Remove">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @endif
                    </div>
                    <div class="grid grid-cols-12 gap-6">
                @foreach($groupFields as $field)
                    @php
                        $fieldName = is_object($field) ? $field->name : $field;
                        $fieldType = is_object($field) ? ($field->type ?? 'text') : 'text';
                        $label = ucfirst(str_replace('_', ' ', $fieldName));
                        $inputName = $useDatabase ? $fieldName : "subfield[{$schemaGroup}][{$instanceId}][{$fieldName}]";
                        $instanceFields = isset($row->_fields[$schemaGroup][$instanceId]) ? $row->_fields[$schemaGroup][$instanceId] : (isset($row->_fields[(string)$schemaGroup][$instanceId]) ? $row->_fields[(string)$schemaGroup][$instanceId] : collect());
                        $fieldData = isset($instanceFields[$fieldName]) ? $instanceFields[$fieldName] : (is_object($instanceFields) && isset($instanceFields[$fieldName]) ? $instanceFields[$fieldName] : null);
                        $value = $useDatabase ? ($row->{$fieldName} ?? old($fieldName)) : ($fieldData && is_object($fieldData) ? $fieldData->value : old($inputName));
                        $displayValue = old($inputName, $value);
                        $colspan = is_object($field) ? min(12, max(1, (int)($field->colspan ?? 1))) : 1;
                        $isRequired = is_object($field) && ($field->is_required ?? 0);
                        $isRelationship = in_array($fieldType, ['belongsTo', 'hasOne', 'hasMany']);
                        $relOptions = $relationshipOptions[$fieldName] ?? [];
                        $isHasMany = $fieldType === 'hasMany';
                        $selectedValues = $isHasMany && $displayValue ? (is_string($displayValue) ? json_decode($displayValue, true) : (array)$displayValue) : [];
                        if (!is_array($selectedValues)) $selectedValues = [];
                    @endphp
                    <div class="space-y-2 @switch($colspan) @case(2) col-span-2 @break @case(3) col-span-3 @break @case(4) col-span-4 @break @case(5) col-span-5 @break @case(6) col-span-6 @break @case(7) col-span-7 @break @case(8) col-span-8 @break @case(9) col-span-9 @break @case(10) col-span-10 @break @case(11) col-span-11 @break @case(12) col-span-12 @break @default col-span-1 @endswitch">
                        <x-backend.input-label :value="$label" :for="$fieldName" />
                        @if($isRelationship)
                            @if(empty($relOptions))
                                <p class="text-xs text-amber-500 py-2">Add data to the related component first.</p>
                            @else
                                @if($isHasMany)
                                    <div class="multiselect-dropdown relative" data-field="{{ $fieldName }}" data-required="{{ $isRequired ? '1' : '0' }}">
                                        <div class="multiselect-trigger flex items-center justify-between gap-2 min-h-[42px] px-3 py-2 text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] text-skin-backend-text-base cursor-pointer hover:border-opacity-40 transition-colors"
                                            tabindex="0">
                                            <div class="multiselect-tags flex flex-wrap gap-1.5 flex-1 min-w-0">
                                                @foreach($relOptions as $optVal => $optLabel)
                                                    @php $isSelected = in_array((string)$optVal, array_map('strval', $selectedValues)); @endphp
                                                    @if($isSelected)
                                                    <span class="multiselect-tag inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent" data-value="{{ $optVal }}">
                                                        {{ $optLabel }} <i class="fa fa-times text-[10px] cursor-pointer hover:opacity-80 multiselect-tag-remove"></i>
                                                    </span>
                                                    @endif
                                                @endforeach
                                                <span class="multiselect-placeholder text-skin-backend-text-base opacity-50 {{ !empty($selectedValues) ? 'hidden' : '' }}">Select {{ $label }}...</span>
                                            </div>
                                            <i class="fa fa-chevron-down text-xs opacity-60 flex-shrink-0 multiselect-chevron transition-transform"></i>
                                        </div>
                                        <div class="multiselect-panel absolute left-0 right-0 top-full mt-1 z-50 hidden py-2 bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] shadow-lg max-h-56 overflow-hidden flex flex-col">
                                            <div class="flex items-center justify-between px-3 pb-2 border-b border-default border-opacity-10 flex-shrink-0">
                                                <div class="flex gap-2 text-xs">
                                                    <button type="button" class="multiselect-select-all text-skin-backend-accent hover:underline">Select all</button>
                                                    <span class="text-default opacity-40">|</span>
                                                    <button type="button" class="multiselect-clear text-skin-backend-text-base opacity-70 hover:underline">Clear</button>
                                                </div>
                                                @if(count($relOptions) > 6)
                                                <input type="text" class="multiselect-search w-28 px-2 py-1 text-xs bg-skin-backend-secondary border border-default border-opacity-25 rounded text-skin-backend-text-base focus:outline-none focus:border-highlight" placeholder="Search..." />
                                                @endif
                                            </div>
                                            <div class="overflow-y-auto p-2 space-y-0.5 flex-1 min-h-0">
                                                @foreach($relOptions as $optVal => $optLabel)
                                                    @php $isSelected = in_array((string)$optVal, array_map('strval', $selectedValues)); @endphp
                                                <label class="multiselect-option flex items-center gap-2 px-2 py-1.5 rounded hover:bg-[#ffffff08] cursor-pointer text-sm" data-value="{{ $optVal }}" data-label="{{ strtolower($optLabel) }}" data-display="{{ $optLabel }}">
                                                    <input type="checkbox" name="{{ $inputName }}[]" value="{{ $optVal }}" {{ $isSelected ? 'checked' : '' }} class="multiselect-cb rounded border-default border-opacity-25 text-skin-backend-accent focus:ring-0" />
                                                    {{ $optLabel }}
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <select name="{{ $inputName }}" id="{{ $fieldName }}" {{ $isRequired ? 'required' : '' }}
                                        class="py-2 px-3 block w-full text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] text-skin-backend-text-base focus:outline-none focus:border-highlight focus:ring-0">
                                        <option value="" {{ empty($displayValue) ? 'selected' : '' }}>— Select {{ $label }} —</option>
                                        @foreach($relOptions as $optVal => $optLabel)
                                            <option value="{{ $optVal }}" {{ (string)$displayValue === (string)$optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endif
                        @elseif($fieldType === 'textarea')
                            <x-backend.input-textarea :name="$inputName" :id="$fieldName" :text="$value" :placeholder="'Enter ' . $label" :required="$isRequired" />
                        @elseif($fieldType === 'textEditor')
                            @php $textEditorId = 'texteditor-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName; @endphp
                            <x-backend.textEditor
                                :id="$textEditorId"
                                name="{{ $inputName }}"
                                :form_id="'dynamic-component-form'"
                                :value="$value"
                                class="w-full" />
                        @elseif($fieldType === 'file')
                            @php $fileInputId = 'label-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName; $fileHolderId = 'holder-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName; @endphp
                            <div class="relative">
                                <p data-input="{{ $fileInputId }}" data-preview="{{ $fileHolderId }}"
                                    class="lfm-btn absolute left-[1px] btn bg-[#323232] text-skin-backend-text-base px-4 py-2 rounded-l-[4px] flex items-center space-x-2 cursor-pointer"
                                    data="{{ $fieldName }}">
                                    <i class="fa fa-picture-o"></i><span>Choose</span>
                                </p>
                                <input type="text" name="{{ $inputName }}" id="{{ $fileInputId }}" readonly
                                    value="{{ $value }}"
                                    class="w-full pl-24 bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] px-3 py-2" />
                            </div>
                            <div id="{{ $fileHolderId }}" class="mt-2 max-h-24 overflow-hidden">
                                @if($value)
                                    <img src="{{ Str::startsWith($value, ['http://', 'https://', '/']) ? $value : asset('images/' . $value) }}" height="40" width="50" alt="">
                                @endif
                            </div>
                        @elseif($fieldType === 'upload')
                            @php
                                $uploadInputId = 'upload-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName;
                                $uploadPreviewId = 'upload-preview-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName;
                            @endphp
                            <div class="space-y-2">
                                <input
                                    type="file"
                                    name="{{ $inputName }}"
                                    id="{{ $uploadInputId }}"
                                    class="normal-upload-input w-full text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] text-skin-backend-text-base focus:outline-none focus:border-highlight focus:ring-0"
                                    data-preview="#{{ $uploadPreviewId }}"
                                />
                                <div id="{{ $uploadPreviewId }}" class="normal-upload-preview mt-2 flex flex-wrap gap-2">
                                    @if($value)
                                        @php
                                            $uploadUrl = Str::startsWith($value, ['http://', 'https://', '/']) ? $value : asset('images/' . $value);
                                            $lower = strtolower($value);
                                            $isImage = Str::endsWith($lower, ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.bmp', '.svg']);
                                        @endphp
                                        @if($isImage)
                                            <div class="inline-flex items-center gap-2 border border-default border-opacity-25 rounded p-1 bg-[#0000000d]">
                                                <img src="{{ $uploadUrl }}" alt="" class="h-14 w-auto object-cover rounded">
                                            </div>
                                        @else
                                            <a href="{{ $uploadUrl }}" target="_blank" class="inline-flex items-center gap-2 text-[11px] text-skin-backend-accent underline break-all">
                                                <i class="fa-regular fa-file text-xs"></i>
                                                <span class="break-all max-w-[200px]">{{ $value }}</span>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <button
                                    type="button"
                                    class="normal-upload-clear mt-1 text-xs text-red-400 hover:text-red-500 {{ $value ? '' : 'hidden' }}"
                                    data-target="#{{ $uploadInputId }}"
                                >
                                    Clear file
                                </button>
                            </div>
                        @elseif($fieldType === 'upload_multi')
                            @php
                                $uploadInputId = 'upload-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName;
                                $uploadPreviewId = 'upload-preview-' . $schemaGroup . '-' . $instanceId . '-' . $fieldName;
                                $storedFiles = [];
                                if (!empty($value)) {
                                    $decoded = json_decode($value, true);
                                    $storedFiles = is_array($decoded) ? $decoded : [$value];
                                }
                            @endphp
                            <div class="space-y-2">
                                <input
                                    type="file"
                                    name="{{ $inputName }}[]"
                                    id="{{ $uploadInputId }}"
                                    class="normal-upload-input w-full text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] text-skin-backend-text-base focus:outline-none focus:border-highlight focus:ring-0"
                                    data-preview="#{{ $uploadPreviewId }}"
                                    multiple
                                />
                                <div id="{{ $uploadPreviewId }}" class="normal-upload-preview mt-2 flex flex-wrap gap-2">
                                    @foreach($storedFiles as $fileName)
                                        @php
                                            $uploadUrl = Str::startsWith($fileName, ['http://', 'https://', '/']) ? $fileName : asset('images/' . $fileName);
                                            $lower = strtolower($fileName);
                                            $isImage = Str::endsWith($lower, ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.bmp', '.svg']);
                                        @endphp
                                        @if($isImage)
                                            <div class="upload-multi-stored-item relative inline-flex items-center gap-2 border border-default border-opacity-25 rounded p-1 bg-[#0000000d]" data-filename="{{ e($fileName) }}">
                                                <img src="{{ $uploadUrl }}" alt="" class="h-14 w-auto object-cover rounded">
                                                <button type="button" class="upload-multi-remove-stored absolute -top-1 -right-1 w-5 h-5 rounded-full bg-red-500 text-[10px] text-white leading-none flex items-center justify-center shadow hover:bg-red-600 z-10"
                                                    title="Remove this file"
                                                    data-sg="{{ $schemaGroup }}" data-inst="{{ $instanceId }}" data-field="{{ $fieldName }}">&times;</button>
                                            </div>
                                        @else
                                            <div class="upload-multi-stored-item relative inline-flex items-center gap-2 border border-default border-opacity-25 rounded p-1 bg-[#0000000d]" data-filename="{{ e($fileName) }}">
                                                <a href="{{ $uploadUrl }}" target="_blank" class="inline-flex items-center gap-2 text-[11px] text-skin-backend-accent underline break-all">
                                                    <i class="fa-regular fa-file text-xs"></i>
                                                    <span class="break-all max-w-[200px]">{{ $fileName }}</span>
                                                </a>
                                                <button type="button" class="upload-multi-remove-stored absolute -top-1 -right-1 w-5 h-5 rounded-full bg-red-500 text-[10px] text-white leading-none flex items-center justify-center shadow hover:bg-red-600 z-10"
                                                    title="Remove this file"
                                                    data-sg="{{ $schemaGroup }}" data-inst="{{ $instanceId }}" data-field="{{ $fieldName }}">&times;</button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button
                                    type="button"
                                    class="normal-upload-clear mt-1 text-xs text-red-400 hover:text-red-500 {{ empty($storedFiles) ? 'hidden' : '' }}"
                                    data-target="#{{ $uploadInputId }}"
                                >
                                    Clear files
                                </button>
                            </div>
                        @elseif($fieldType === 'checkBox')
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="{{ $inputName }}" id="{{ $fieldName }}" value="1" {{ $value == '1' ? 'checked' : '' }}
                                    class="checkbox bg-[#eaeaea] border-gray-200 rounded text-skin-hover focus:ring-0" />
                                <label for="{{ $fieldName }}">{{ $label }}</label>
                            </div>
                        @elseif($fieldType === 'select')
                            @php
                                $staticOpts = is_object($field) && ($field->static_options ?? null) ? (is_array($field->static_options) ? $field->static_options : json_decode($field->static_options, true)) : [];
                                if (!is_array($staticOpts)) $staticOpts = [];
                            @endphp
                            <select name="{{ $inputName }}" id="{{ $fieldName }}" {{ $isRequired ? 'required' : '' }}
                                class="py-2 px-3 block w-full text-sm bg-skin-backend-secondary border border-default border-opacity-25 rounded-[4px] text-skin-backend-text-base focus:outline-none focus:border-highlight focus:ring-0">
                                <option value="" {{ empty($displayValue) ? 'selected' : '' }}>— Select {{ $label }} —</option>
                                @foreach($staticOpts as $optVal => $optLabel)
                                    <option value="{{ $optVal }}" {{ (string)$displayValue === (string)$optVal ? 'selected' : '' }}>{{ $optLabel }}</option>
                                @endforeach
                            </select>
                        @else
                            <x-backend.input-field type="{{ $fieldType }}" :name="$inputName" :id="$fieldName"
                                :value="$value" :placeholder="'Enter ' . $label" class="w-full" :required="$isRequired" />
                        @endif
                        @if(is_object($field) && !empty($field->help_text))
                            <p class="text-xs text-skin-backend-text-base opacity-70 mt-1 [&_a]:text-skin-backend-accent [&_a]:underline [&_a]:decoration-skin-backend-accent [&_a:hover]:opacity-90">{!! $field->help_text !!}</p>
                        @endif
                        @error($inputName)
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
                    </div>
                </div>
                @endforeach
                </div>
                @if($groupIsMultiple)
                <div class="mt-3 order-last add-more-wrapper">
                    <button type="button" class="add-more-group-instance py-2.5 px-5 text-sm font-semibold rounded-xl bg-skin-backend-accent bg-opacity-20 text-black hover:bg-opacity-30" data-schema-group="{{ $schemaGroup }}" data-row-id="{{ $rowId }}">
                        <i class="fa-solid fa-plus mr-1"></i> Add more {{ $groupName }}
                    </button>
                </div>
                @endif
                </div>
                </div>
                @endforeach

                <div class="flex gap-3 pt-6">
                    <button type="submit" id="update-btn" class="py-2.5 px-5 text-sm font-semibold rounded-xl bg-skin-backend-accent hover:bg-opacity-90 text-skin-invert inline-flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white hidden" id="update-spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="update-btn-text">Update</span>
                    </button>
                    <a href="{{ route('dynamic-component.index', $dynamicComponent->name) }}"
                        class="py-2.5 px-5 text-sm font-semibold rounded-xl bg-[#323232] hover:bg-opacity-90 text-white">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif
    @if ($message = Session::get('error'))
        <x-backend.flash-error :message="$message" :type="'error'" />
    @endif
</x-Deshboard-layout>
<script>
function showFlashMessage(message, type) {
    type = type || 'success';
    var bgColor = type === 'success' ? '#10b981' : '#ef4444';
    var icon = type === 'success' ? '<i class="fa-solid fa-check-circle mr-2"></i>' : '<i class="fa-solid fa-exclamation-circle mr-2"></i>';

    var $toast = $('<div class="fixed top-5 right-5 z-[9999] max-w-sm px-5 py-3 rounded-lg shadow-lg text-white text-sm font-medium flex items-center" style="background:' + bgColor + '; opacity:0; transform: translateX(100%);">' + icon + '<span>' + $('<span>').text(message).html() + '</span></div>');
    $('body').append($toast);
    $toast.animate({ opacity: 1, right: 0 }, 300).css('transform', 'translateX(0)');
    setTimeout(function() {
        $toast.animate({ opacity: 0 }, 400, function() { $toast.remove(); });
    }, 4000);
}
$(function() {
    // Check for flash message stored by AJAX success
    var flashMsg = sessionStorage.getItem('_flash_success');
    if (flashMsg) {
        sessionStorage.removeItem('_flash_success');
        showFlashMessage(flashMsg, 'success');
    }
    var flashErr = sessionStorage.getItem('_flash_error');
    if (flashErr) {
        sessionStorage.removeItem('_flash_error');
        showFlashMessage(flashErr, 'error');
    }
});
</script>
@php $hasAddMore = collect($schemaGroupSettings ?? [])->contains(fn($s) => !empty($s['is_multiple'])); @endphp
@if($hasAddMore)
<script>
$(function() {
    var instanceCounters = {};
    function toggleRemoveButtons() {
        $('.group-section').each(function() {
            var instances = $(this).find('.group-instance');
            $(this).find('.remove-group-instance').toggle(instances.length > 1);
        });
    }
    toggleRemoveButtons();
    $('.group-section').each(function() {
        var sg = $(this).data('schema-group');
        var maxInst = 0;
        $(this).find('.group-instance').each(function() {
            var inst = parseInt($(this).data('instance'), 10) || 1;
            if (inst > maxInst) maxInst = inst;
        });
        instanceCounters[sg] = maxInst;
    });
    $(document).on('click', '.add-more-group-instance', function() {
        var schemaGroup = $(this).data('schema-group');
        var groupSection = $(this).closest('.group-section');
        var firstInstance = groupSection.find('.group-instance').first();
        var clone = firstInstance.clone();

        instanceCounters[schemaGroup] = (instanceCounters[schemaGroup] || 0) + 1;
        var newInstance = instanceCounters[schemaGroup];

        clone.attr('data-instance', newInstance);
        clone.find('h3').first().text(function(i, text) {
            var t = (text || '').trim();
            return /\(\d+\)\s*$/.test(t) ? t.replace(/\(\d+\)\s*$/, '(' + newInstance + ')') : t + ' (' + newInstance + ')';
        });

        // Update names, IDs and reset values
        clone.find('input, select, textarea').each(function() {
            var $el = $(this);
            $el.prop('disabled', false).removeAttr('disabled');

            var name = $el.attr('name');
            if (name && name.match(/^subfield\[\d+\]\[\d+\]/)) {
                name = name.replace(/^subfield\[(\d+)\]\[\d+\]/, 'subfield[$1][' + newInstance + ']');
                $el.attr('name', name);
            }

            var id = $el.attr('id');
            if (id && id.match(/^label-\d+-\d+-/)) {
                // file-manager text input
                $el.attr('id', id.replace(/^label-(\d+)-\d+-/, 'label-$1-' + newInstance + '-'));
            } else if (id && id.match(/^upload-\d+-\d+-/)) {
                // normal upload (single/multi) input
                $el.attr('id', id.replace(/^upload-(\d+)-\d+-/, 'upload-$1-' + newInstance + '-'));
            } else if (id && id.match(/^texteditor-(\d+)-\d+-(.+)$/)) {
                // textEditor: unique id per instance so SunEditor can be re-initialized
                $el.attr('id', id.replace(/^texteditor-(\d+)-\d+-(.+)$/, function(m, g1, g2) { return 'texteditor-' + g1 + '-' + newInstance + '-' + g2; }));
            }

            $el.val('');
            if ($el.is(':checkbox')) $el.prop('checked', false);
        });

        // Update LFM button bindings
        clone.find('.lfm-btn').each(function() {
            var $btn = $(this);
            var inputId = $btn.attr('data-input');
            var previewId = $btn.attr('data-preview');
            if (inputId && inputId.match(/^label-\d+-\d+-/)) {
                var newInputId = inputId.replace(/^label-(\d+)-\d+-/, 'label-$1-' + newInstance + '-');
                var newPreviewId = previewId.replace(/^holder-(\d+)-\d+-/, 'holder-$1-' + newInstance + '-');
                $btn.attr('data-input', newInputId).attr('data-preview', newPreviewId);
            }
        });

        // Update and clear file-manager preview holders
        clone.find('[id^="holder-"]').each(function() {
            var $holder = $(this);
            var id = $holder.attr('id');
            if (id && id.match(/^holder-\d+-\d+-/)) {
                $holder
                    .attr('id', id.replace(/^holder-(\d+)-\d+-/, 'holder-$1-' + newInstance + '-'))
                    .empty();
            }
        });

        // Update normal upload preview IDs and clear them
        clone.find('[id^="upload-preview-"]').each(function() {
            var $preview = $(this);
            var id = $preview.attr('id');
            if (id && id.match(/^upload-preview-\d+-\d+-/)) {
                var newId = id.replace(/^upload-preview-(\d+)-\d+-/, 'upload-preview-$1-' + newInstance + '-');
                $preview.attr('id', newId).empty();
            }
        });

        // Sync normal upload input data-preview attributes
        clone.find('.normal-upload-input').each(function() {
            var $input = $(this);
            var previewSelector = $input.data('preview');
            if (previewSelector && typeof previewSelector === 'string' && previewSelector.match(/^#upload-preview-\d+-\d+-/)) {
                var newSelector = previewSelector.replace(/^#upload-preview-(\d+)-\d+-/, '#upload-preview-$1-' + newInstance + '-');
                // Update both the attribute and jQuery's cached data so renderNormalUploadPreview sees the new selector
                $input.attr('data-preview', newSelector).data('preview', newSelector);
            }
        });

        // Fix and hide clear buttons for this instance
        clone.find('.normal-upload-clear').each(function() {
            var $btn = $(this);
            var target = $btn.data('target') || '';
            if (typeof target === 'string' && target.match(/^#?upload-\d+-\d+-/)) {
                var prefix = target.charAt(0) === '#' ? '#' : '';
                var newTarget = target.replace(/^#?upload-(\d+)-\d+-/, prefix + 'upload-$1-' + newInstance + '-');
                $btn.attr('data-target', newTarget);
            }
            $btn.addClass('hidden');
        });

        // Ensure any cloned previews are cleared
        clone.find('.normal-upload-preview').each(function() {
            $(this).empty();
        });

        clone.find('.multiselect-tag').remove();
        clone.find('.multiselect-placeholder').removeClass('hidden');
        clone.find('.multiselect-cb').each(function() { $(this).prop('checked', false); });
        clone.find('.lfm-btn').data('lfm-initialized', false);

        // Remove cloned SunEditor UI (toolbar/iframe) so only the textarea remains; SunEditor puts UI as sibling of textarea
        clone.find('.sun-editor').remove();
        // If the textarea was wrapped inside a SunEditor container, unwrap it to get a plain textarea
        clone.find('textarea[id^="texteditor-"]').each(function() {
            var $ta = $(this);
            var $wrap = $ta.closest('.se-container, .sun-editor-container, [class*="sun-editor"]');
            if ($wrap.length) {
                $ta.detach();
                $wrap.replaceWith($ta);
            }
        });

        var groupInstances = groupSection.find('.group-instances');
        if (groupInstances.length) {
            groupInstances.append(clone);
        } else {
            var addMoreWrapper = groupSection.find('.add-more-wrapper');
            addMoreWrapper.length ? addMoreWrapper.before(clone) : groupSection.append(clone);
        }

        // Re-initialize SunEditor on newly appended textareas
        if (typeof SUNEDITOR !== 'undefined') {
            var sunEditorOptions = {
                defaultStyle: 'font-family: Arial, sans-serif; font-size: 14px;',
                buttonList: [
                    ['undo', 'redo', 'font', 'fontSize', 'formatBlock'],
                    ['bold', 'underline', 'italic', 'strike', 'subscript', 'superscript', 'removeFormat'],
                    ['fontColor', 'hiliteColor', 'textStyle', 'removeFormat'],
                    ['align', 'list', 'lineHeight', 'table', 'link', 'image'],
                    ['fullScreen', 'showBlocks', 'codeView'],
                    ['horizontalRule', 'template', 'blockquote', 'indent', 'outdent']
                ],
                table: { maxWidth: '100%', maxHeight: '300px', resize: true },
                imageUploadSizeLimit: 2 * 1024 * 1024,
                font: ['Arial', 'Comic Sans MS', 'Courier New', 'Georgia', 'Tahoma', 'Trebuchet MS', 'Verdana'],
                fontSize: ['8', '10', '12', '14', '16', '18', '20', '24', '28', '32', '36', '40', '46', '52', '58', '64', '70', '76', '82', '88', '94', '100', '106', '112', '118', '120'],
                mode: 'classic',
                height: '200px',
                colorList: null
            };
            clone.find('textarea[id^="texteditor-"]').each(function() {
                var el = this;
                var editor = SUNEDITOR.create(el, sunEditorOptions);
                if (editor) el._sunEditor = editor;
            });
        }

        toggleRemoveButtons();
        $(document).trigger('lfm-reinit');
    });
    $(document).on('click', '.remove-group-instance', function() {
        var groupSection = $(this).closest('.group-section');
        var instances = groupSection.find('.group-instance');
        if (instances.length > 1) {
            $(this).closest('.group-instance').remove();
            toggleRemoveButtons();
        }
    });
});
</script>
@endif
<script>
$(function() {
    function collectSubfieldData() {
        var subfield = {};
        $('.group-instance').each(function() {
            var $inst = $(this);
            var sg = String($inst.data('schema-group') || $inst.attr('data-schema-group') || '1');
            var instId = String($inst.data('instance') || $inst.attr('data-instance') || '1');
            if (!subfield[sg]) subfield[sg] = {};
            if (!subfield[sg][instId]) subfield[sg][instId] = {};
            $inst.find('input, select, textarea').each(function() {
                var $el = $(this);
                if ($el.attr('type') === 'file') return;
                var name = $el.attr('name');
                if (!name || name.indexOf('subfield[') !== 0) return;
                var m = name.match(/^subfield\[(\d+)\]\[(\d+)\]\[([^\]]*)\]/);
                if (!m || String(m[1]) !== sg || String(m[2]) !== instId) return;
                var fieldName = m[3];
                if ($el.is(':checkbox') && name.indexOf('[]') === -1) {
                    subfield[sg][instId][fieldName] = $el.is(':checked') ? '1' : '';
                } else if (name.indexOf('[]') !== -1) {
                    if (!subfield[sg][instId][fieldName]) subfield[sg][instId][fieldName] = [];
                    if ($el.is(':checked')) subfield[sg][instId][fieldName].push($el.val());
                } else {
                    // For textareas with SunEditor: get content directly from editor so appended content is always saved
                    var rawEl = this;
                    var val = '';
                    if ($el.is('textarea') && rawEl._sunEditor && typeof rawEl._sunEditor.getContents === 'function') {
                        val = rawEl._sunEditor.getContents() || '';
                    } else {
                        val = $el.val() || '';
                    }
                    subfield[sg][instId][fieldName] = val;
                }
            });
        });
        return subfield;
    }

    // Track files selected on any upload input (including appended ones)
    var pendingFiles = {};
    $(document).on('change', '.normal-upload-input', function() {
        var name = $(this).attr('name');
        if (name && this.files && this.files.length > 0) {
            pendingFiles[name] = this.files;
        } else if (name) {
            delete pendingFiles[name];
        }
    });

    // Sync all SunEditor instances into their textareas (used before collecting form data)
    function syncAllSunEditorsToTextareas() {
        $('#dynamic-component-form').find('textarea[id^="texteditor-"]').each(function() {
            var ed = this._sunEditor;
            if (ed && typeof ed.getContents === 'function') {
                this.value = ed.getContents();
            }
        });
    }

    // AJAX form submission with loading state
    $('#dynamic-component-form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var $form = $(form);

        // Sync editors immediately so content is in textareas
        syncAllSunEditorsToTextareas();

        // Defer build/submit one tick so editor internals flush (fixes first-save not persisting appended content)
        var doSubmit = function() {
            // Sync again right before reading (ensures appended editor content is included on first save)
            syncAllSunEditorsToTextareas();

            // Validate required multiselect fields
            var invalid = [];
            $form.find('.multiselect-dropdown[data-required="1"]').each(function() {
                if ($(this).find('.multiselect-cb:checked').length === 0) {
                    var label = $(this).closest('.space-y-2').find('.input-label, label').first().text().replace(/\s*\*\s*$/, '');
                    invalid.push(label || 'This field');
                }
            });
            if (invalid.length) {
                showFlashMessage('Please select at least one option for: ' + invalid.join(', '), 'error');
                return;
            }

            // Show loading
            $('#update-btn').css('pointer-events', 'none').addClass('opacity-70');
            $('#update-spinner').removeClass('hidden');
            $('#update-btn-text').text('Updating...');

            // Build FormData manually
            var fd = new FormData();

            // Add all non-file form fields
            $form.find('input:not([type="file"]), select, textarea').each(function() {
                var $el = $(this);
                var name = $el.attr('name');
                if (!name) return;
                if ($el.attr('type') === 'checkbox' || $el.attr('type') === 'radio') {
                    if ($el.is(':checked')) fd.append(name, $el.val());
                } else if ($el.is('select[multiple]')) {
                    $el.find('option:selected').each(function() {
                        fd.append(name, $(this).val());
                    });
                } else {
                    fd.append(name, $el.val() || '');
                }
            });

            // Add subfield_json with all text data (includes synced editor content)
            fd.append('subfield_json', JSON.stringify(collectSubfieldData()));

            // Add files: first from actual file inputs in the DOM
            $form.find('input[type="file"]').each(function() {
                var name = $(this).attr('name');
                if (!name || !this.files || !this.files.length) return;
                for (var i = 0; i < this.files.length; i++) {
                    fd.append(name, this.files[i]);
                }
            });

            // Also add any tracked pending files (covers appended inputs)
            for (var fname in pendingFiles) {
                if (!pendingFiles[fname] || !pendingFiles[fname].length) continue;
                var alreadyAdded = false;
                $form.find('input[type="file"][name="' + fname + '"]').each(function() {
                    if (this.files && this.files.length > 0) alreadyAdded = true;
                });
                if (!alreadyAdded) {
                    for (var i = 0; i < pendingFiles[fname].length; i++) {
                        fd.append(fname, pendingFiles[fname][i]);
                    }
                }
            }

            // Submit via AJAX
            $.ajax({
                url: form.action,
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(data) {
                    var msg = (data && data.message) ? data.message : 'Updated successfully.';
                    sessionStorage.setItem('_flash_success', msg);
                    window.location.reload();
                },
                error: function(xhr) {
                    $('#update-btn').css('pointer-events', '').removeClass('opacity-70');
                    $('#update-spinner').addClass('hidden');
                    $('#update-btn-text').text('Update');
                    if (xhr.status === 422) {
                        try {
                            var data = JSON.parse(xhr.responseText);
                            var msgs = [];
                            if (data.errors) {
                                for (var key in data.errors) {
                                    msgs.push(data.errors[key].join(', '));
                                }
                            }
                            if (msgs.length) {
                                showFlashMessage(msgs.join('\n'), 'error');
                            } else if (data.message) {
                                showFlashMessage(data.message, 'error');
                            } else {
                                showFlashMessage('Validation failed. Please check your input.', 'error');
                            }
                        } catch(e) {
                            showFlashMessage('Validation failed. Please check your input.', 'error');
                        }
                    } else {
                        showFlashMessage('An error occurred while saving. Please try again.', 'error');
                    }
                }
            });
        };
        setTimeout(doSubmit, 0);
    });
});
</script>
@php $hasMultiselect = $fields->contains(fn($f) => is_object($f) && ($f->type ?? '') === 'hasMany'); @endphp
@if($hasMultiselect)
<script>
$(function() {
    function updateMultiselectTags(dropdown) {
        var tags = dropdown.find('.multiselect-tags');
        var placeholder = tags.find('.multiselect-placeholder');
        var checked = dropdown.find('.multiselect-cb:checked');
        tags.find('.multiselect-tag').remove();
        if (checked.length) {
            placeholder.addClass('hidden');
            checked.each(function() {
                var opt = $(this).closest('.multiselect-option');
                var val = opt.data('value');
                var label = opt.data('display') || opt.text().trim();
                tags.append('<span class="multiselect-tag inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent" data-value="'+val+'">'+label+' <i class="fa fa-times text-[10px] cursor-pointer hover:opacity-80 multiselect-tag-remove"></i></span>');
            });
        } else {
            placeholder.removeClass('hidden');
        }
    }
    $(document).on('click', '.multiselect-trigger', function(e) {
        e.stopPropagation();
        var dd = $(this).closest('.multiselect-dropdown');
        var open = dd.hasClass('open');
        $('.multiselect-dropdown').removeClass('open').find('.multiselect-panel').addClass('hidden').siblings('.multiselect-trigger').find('.multiselect-chevron').removeClass('rotate-180');
        if (!open) {
            dd.addClass('open');
            dd.find('.multiselect-panel').removeClass('hidden');
            dd.find('.multiselect-chevron').addClass('rotate-180');
        }
    });
    $(document).on('click', function() {
        $('.multiselect-dropdown').removeClass('open').find('.multiselect-panel').addClass('hidden');
        $('.multiselect-chevron').removeClass('rotate-180');
    });
    $(document).on('click', '.multiselect-panel, .multiselect-option, .multiselect-select-all, .multiselect-clear', function(e) { e.stopPropagation(); });
    $(document).on('change', '.multiselect-cb', function() {
        updateMultiselectTags($(this).closest('.multiselect-dropdown'));
    });
    $(document).on('click', '.multiselect-tag-remove', function(e) {
        e.stopPropagation();
        var val = $(this).closest('.multiselect-tag').data('value');
        var dd = $(this).closest('.multiselect-dropdown');
        dd.find('.multiselect-cb[value="'+val+'"]').prop('checked', false);
        $(this).closest('.multiselect-tag').remove();
        if (!dd.find('.multiselect-tag').length) dd.find('.multiselect-placeholder').removeClass('hidden');
    });
    $(document).on('click', '.multiselect-select-all', function(e) {
        e.preventDefault();
        $(this).closest('.multiselect-dropdown').find('.multiselect-cb').prop('checked', true);
        updateMultiselectTags($(this).closest('.multiselect-dropdown'));
    });
    $(document).on('click', '.multiselect-clear', function(e) {
        e.preventDefault();
        $(this).closest('.multiselect-dropdown').find('.multiselect-cb').prop('checked', false);
        updateMultiselectTags($(this).closest('.multiselect-dropdown'));
    });
    $(document).on('input', '.multiselect-search', function() {
        var q = $(this).val().toLowerCase();
        $(this).closest('.multiselect-dropdown').find('.multiselect-option').each(function() {
            var label = $(this).data('label') || '';
            $(this).toggle(q === '' || label.indexOf(q) !== -1);
        });
    });
    $('.multiselect-dropdown').each(function() { updateMultiselectTags($(this)); });
});
</script>
@endif
@php $hasFile = $fields->contains(fn($f) => is_object($f) && ($f->type ?? '') === 'file'); @endphp
@if($hasFile)
<script>
    $(document).on('click', '.lfm-btn', function() {
        const el = $(this);
        if (!el.data('initialized')) {
            el.filemanager('file');
            el.data('initialized', true);
        }
    });
</script>
@endif
<script>
    $(function() {
        function renderNormalUploadPreview(input) {
            var $input = $(input);
            var files = input.files || [];
            var previewSelector = $input.data('preview');
            var $preview = previewSelector ? $(previewSelector) : $input.siblings('.normal-upload-preview');
            var $clearBtn = $('.normal-upload-clear[data-target="#' + input.id + '"], .normal-upload-clear[data-target="' + input.id + '"]').first();

            if (!$preview || !$preview.length) {
                return;
            }

            $preview.empty();

            if (!files.length) {
                if ($clearBtn.length) $clearBtn.addClass('hidden');
                return;
            }

            Array.from(files).forEach(function(file, index) {
                var isImage = file.type && file.type.indexOf('image/') === 0;
                var $wrapper = $('<div class="normal-upload-item relative inline-flex items-center justify-center border border-default border-opacity-25 rounded-md bg-[#00000012] w-20 h-20 overflow-hidden" data-file-index="' + index + '"></div>');

                if (isImage) {
                    var img = document.createElement('img');
                    img.className = 'w-full h-full object-cover';
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    $wrapper.append(img);
                } else {
                    var $iconWrap = $('<div class="flex flex-col items-center justify-center text-center px-1"></div>');
                    $iconWrap.append('<i class="fa-regular fa-file text-xs mb-1"></i>');
                    var shortName = file.name.length > 12 ? file.name.substring(0, 9) + "..." : file.name;
                    var $info = $('<span class="text-[10px] opacity-70 break-all"></span>').text(shortName);
                    $iconWrap.append($info);
                    $wrapper.append($iconWrap);
                }

                var $remove = $('<button type="button" class="normal-upload-remove absolute -top-1 -right-1 w-5 h-5 rounded-full bg-red-500 text-[10px] text-white flex items-center justify-center shadow">&times;</button>');
                $wrapper.append($remove);

                $preview.append($wrapper);
            });

            if ($clearBtn.length) {
                $clearBtn.removeClass('hidden');
            }
            updateUploadMultiClearBtn($preview);
        }

        function updateUploadMultiClearBtn($preview) {
            if (!$preview || !$preview.length) return;
            var $clear = $preview.siblings('.normal-upload-clear').first();
            if (!$clear.length) return;
            var hasStored = $preview.find('.upload-multi-stored-item').length > 0;
            var hasNewItems = $preview.find('.normal-upload-item').length > 0;
            var $inp = $preview.siblings('.normal-upload-input').first();
            var hasFiles = $inp.length && $inp[0].files && $inp[0].files.length > 0;
            $clear.toggleClass('hidden', !hasStored && !hasNewItems && !hasFiles);
        }

        $(document).on('change', '.normal-upload-input', function() {
            renderNormalUploadPreview(this);
            var previewSelector = $(this).data('preview');
            if (previewSelector) updateUploadMultiClearBtn($(previewSelector));
        });

        $(document).on('click', '.upload-multi-remove-stored', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $btn = $(this);
            var sg = String($btn.data('sg'));
            var inst = String($btn.data('inst'));
            var field = String($btn.data('field'));
            var $item = $btn.closest('.upload-multi-stored-item');
            var fn = $item.attr('data-filename');
            if (!fn) return;
            var inputName = 'subfield_multi_remove[' + sg + '][' + inst + '][' + field + '][]';
            $('#dynamic-component-form').append(
                $('<input>', { type: 'hidden', name: inputName, value: fn, class: 'upload-multi-remove-marker' })
            );
            var $preview = $item.closest('.normal-upload-preview');
            $item.remove();
            updateUploadMultiClearBtn($preview);
        });

        $(document).on('click', '.normal-upload-remove', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.normal-upload-item');
            var index = parseInt($item.data('fileIndex'), 10);
            if (isNaN(index)) index = 0;
            var $preview = $item.closest('.normal-upload-preview');
            var $input = $preview.prevAll('.normal-upload-input').first();
            if (!$input.length || !$input[0].files) {
                $item.remove();
                return;
            }
            var dt = new DataTransfer();
            var files = $input[0].files;
            for (var i = 0; i < files.length; i++) {
                if (i === index) continue;
                dt.items.add(files[i]);
            }
            $input[0].files = dt.files;
            renderNormalUploadPreview($input[0]);
        });

        $(document).on('click', '.normal-upload-clear', function() {
            var target = $(this).data('target') || '';
            var $input = target ? $(target) : $();
            if ($input.length === 0 && target.charAt(0) !== '#') {
                $input = $('#' + target);
            }
            if ($input.length) {
                var inputName = $input.attr('name');
                $input.val('');
                var previewSelector = $input.data('preview');
                var $preview = previewSelector ? $(previewSelector) : $input.siblings('.normal-upload-preview');
                if ($preview && $preview.length) {
                    $preview.find('.upload-multi-stored-item').remove();
                    $preview.find('.normal-upload-item').remove();
                }
                // Drop pending individual-remove markers for this multi field (full clear supersedes)
                if (inputName && inputName.indexOf('[]') !== -1) {
                    var m = inputName.match(/^subfield\[(\d+)\]\[(\d+)\]\[([^\]]+)\]\[\]$/);
                    if (m) {
                        $('#dynamic-component-form').find('.upload-multi-remove-marker[name^="subfield_multi_remove[' + m[1] + '][' + m[2] + '][' + m[3] + ']"]').remove();
                    }
                }
                updateUploadMultiClearBtn($preview);

                // Mark field for removal on update by adding hidden input
                if (inputName) {
                    var baseName = inputName.replace(/\[\]$/, '');
                    var removeInputName;

                    // For dynamic component subfields, send remove markers under subfield_remove[…]
                    if (baseName.indexOf('subfield[') === 0) {
                        removeInputName = 'subfield_remove' + baseName.substring('subfield'.length);
                    } else {
                        // For normal/database columns, just append _remove
                        removeInputName = baseName + '_remove';
                    }

                    // Remove any existing remove marker for this field
                    $('#dynamic-component-form').find('input[name=\"' + removeInputName + '\"]').remove();
                    // Add new remove marker
                    $('#dynamic-component-form').append('<input type=\"hidden\" name=\"' + removeInputName + '\" value=\"1\">');
                }
            }
            $(this).addClass('hidden');
        });
    });
</script>
