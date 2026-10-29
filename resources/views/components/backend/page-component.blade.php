@props([
'components' => [],
])

<div class="py-5 border-t border-default border-opacity-50 space-y-4">
    <div id='sortable'
        class="ui space-y-2 h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800">
        @foreach ($components as $value)
        <div id='{{ $value->name . $value->id }}'
            class="flex flex-col bg-skin-backend-secondary component-parent border border-default border-opacity-25 rounded-[10px]">
            <div class="flex justify-between items-center py-3 px-4 md:px-5">
                <h3 class="text-md font-semibold">
                    {{ $value->name }}
                </h3>
                <input type="hidden" name='component_id[]' value='{{ $value->id }}' />
                <input type="hidden" id='limit' name='display[]' value=' {{ $value->limits->limit }}' />

                <div class="flex items-center gap-x-3">
                    <div class="hs-tooltip inline-block">
                        <button type="button" target='{{ $value->name . $value->id }}'
                            class="componet-edit hs-tooltip-toggle size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-blue-200 bg-blue-600 disabled:opacity-50 disabled:pointer-events-none">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <span
                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                role="tooltip">
                                Edit
                            </span>
                        </button>
                    </div>
                    <div class="hs-tooltip inline-block hidden">
                        <span onclick="event.preventDefault()" data-hs-overlay="#styling-model"
                            data="{{ $value->name }}"
                            class="style-component hs-tooltip-toggle size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-500 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                            <i class="fa-solid fa-sliders"></i>
                            <span
                                class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm"
                                role="tooltip">
                                Styling
                            </span>
                        </span>
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
        </div>
        @endforeach
    </div>
    <div>
        <x-backend.button type="button" :value="'Add UI Block'"
            class="px-6 py-2.5 bg-skin-backend-accent rounded-[10px] text-skin-invert hover:bg-opacity-90 transition-opacity"
            data-hs-overlay="#ui-model" :icon="'fa-solid fa-plus'" />
    </div>
</div>


<script>
    $(function() {
    $("#sortable").sortable();
    });
    
    $('input[name="header_component_position"]').on('change', function() {
    $('input[name="header_component_position"]').not(this).prop('checked', false);
    });
    
    $(document).on('click', '.removeComonent', function() {
    $(this).parents('.component-parent').remove();
    })
    $(document).on('click', '.componet-edit', function() {
    let target = $(this).attr('target');
    $('.' + target).trigger('click');
    let val = $(this).parents('#' + target).find('#limit').val();
    $('#display').val(Number(val))
    
    })
</script>