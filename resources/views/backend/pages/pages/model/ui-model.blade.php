<x-backend.model :id="'ui-model'" class="lg:max-w-4xl" :button="false" :form_id="'pages-create'" :action="''"
    :method="__('get')" :title="'Add Ui Elements'">
    @csrf
    <div class="p-6 space-y-4">
        <div class="w-full md:w-1/2 relative text-skin-backend-text-base">
            <span class="absolute top-1/2 -translate-y-1/2 left-4"><i
                class="fa-solid fa-magnifying-glass"></i></span>
            <input id="searchInput"
                class="w-full bg-skin-backend-secondary border border-default border-opacity-25 rounded-[10px] focus:outline-none focus:ring-0 focus:border-highlight pl-10 py-3 text-sm"
                type="text" role="combobox" aria-expanded="false" placeholder="Search Component"
                value="" data-hs-combo-box-input="">
        </div>  
        <div class="addComponent h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800 grid grid-cols-12 gap-4">  
    
            @foreach ($components as $component)
                <div class="col-span-12 sm:col-span-6 flex flex-col gap-2 sm:flex-row items-center justify-between  w-full border border-default border-opacity-25 rounded-[10px] p-4 sm:px-2 sm:py-1">
                    <div class="shrink-0 h-30 sm:h-[60px] w-full sm:w-[120px] text-center flex items-center justify-center bg-[#323232] rounded-[10px]">
                        <i class="fa-solid fa-code text-6xl sm:text-2xl text-gray-400"></i>
                    </div>
                    <div class="">
                        <h3 class="">
                            {{ $component->name }}
                        </h3>
                    </div>
                    <span class="cursor-pointer float-right">
                        <span data="{{ $component }}" dataBase="" type='button'
                            class="{{ $component->name . $component->id }} add-field-value px-4 py-2 bg-skin-backend-accent text-skin-invert rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Use
                        </span>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    
</x-backend.model>


<script>
    function highlightText(searchText) {
            if (searchText) {
                let firstMatch = null;
                // Only find and highlight matches within the #ui-model element
                $("#ui-model h3").each(function () {
                    let content = $(this).html();
                    const regex = new RegExp(searchText, 'gi');
                    const highlightedText = content.replace(regex, (match) =>
                        `<span class="highlight">${match}</span>`
                    );
                    $(this).html(highlightedText);

                    // Auto-scroll to the first match
                    if (!firstMatch && $(this).find('.highlight').length > 0) {
                        firstMatch = $(this).find('.highlight')[0];
                    }
                });

                if (firstMatch) {
                    firstMatch.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }
        }

        function removeHighlights() {
            // Only remove highlights within the #ui-model element
            $("#ui-model span.highlight").each(function () {
                const parent = $(this).parent();
                $(this).replaceWith($(this).text());
                parent.contents().filter(function() {
                    return this.nodeType === 3; // Node type 3 is a text node
                }).each(function() {
                    this.textContent = this.textContent; // Merge text nodes
                });
            });
        }

        $(document).ready(function () {
            $("#searchInput").on("keyup", function () {
                const searchText = $(this).val();
                removeHighlights(); // Clear previous highlights
                if (searchText.trim() !== '') {
                    highlightText(searchText); // Highlight new search text
                }
            });
        });
</script>
