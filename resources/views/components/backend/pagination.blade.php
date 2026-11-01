@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="flex items-center gap-2" aria-label="Pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button type="button"
                class=" min-h-[32px] min-w-[32px] py-1.5 px-3 inline-flex justify-center items-center gap-x-1.5 text-sm border border-default border-opacity-25 bg-skin-backend-secondary text-skin-backend-text-base focus:outline-none disabled:opacity-50 disabled:pointer-events-none "
                aria-label="Previous" disabled> 
                <span class="hidden sm:block"><i class="fa-solid fa-angle-left"></i></span>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                class="min-h-[32px] min-w-[32px] py-1.5 px-3 inline-flex justify-center items-center gap-x-1.5 text-sm border border-default border-opacity-25 bg-skin-backend-secondary text-skin-backend-text-base hover:text-skin-hover hover:border-highlight focus:outline-none focus:text-skin-hover focus:border-highlight transition-colors"
                aria-label="Previous">
                <span class="hidden sm:block"><i class="fa-solid fa-angle-left"></i></span>
            </a>
        @endif

        {{-- Pagination Links --}}
        @foreach ($paginator->links()->elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span
                    class="min-h-[32px] min-w-[32px] flex justify-center items-center border border-default border-opacity-25 text-skin-backedn-text-base py-1.5 px-3 text-sm">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="cursor-pointer min-h-[32px] min-w-[32px] flex justify-center items-center bg-skin-backend-secondary text-skin-hover border border-highlight py-1.5 px-3 text-sm"
                            aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            class="min-h-[32px] min-w-[32px] flex justify-center items-center border py-1.5 bg-skin-backend-secondary text-skin-backend-text-base border-default border-opacity-25 hover:text-skin-hover hover:border-highlight focus:text-skin-hover focus:border-highlight px-3 text-sm transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                class="min-h-[32px] min-w-[32px] py-1.5 px-3 inline-flex justify-center items-center gap-x-1.5 text-sm border border-default border-opacity-25 bg-skin-backend-secondary text-skin-backend-text-base hover:text-skin-hover hover:border-highlight focus:outline-none focus:text-skin-hover focus:border-highlight transition-colors"
                aria-label="Next">
                <span class="hidden sm:block"><i class="fa-solid fa-angle-right"></i></span> 
            </a>
        @else
            <button type="button"
                class="min-h-[32px] min-w-[32px] py-1.5 px-3 inline-flex justify-center items-center gap-x-1.5 text-sm border border-default border-opacity-25 bg-skin-backend-secondary text-skin-backend-text-base focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                aria-label="Next" disabled>
                <span class="hidden sm:block"><i class="fa-solid fa-angle-right"></i></span> 
            </button>
        @endif
    </nav>
@endif
