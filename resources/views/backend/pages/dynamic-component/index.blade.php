<x-Deshboard-layout>
    <div class="py-10">
        <div class="space-y-4">
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[400px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{ route('dashboard') }}" class="font-bold text-skin-backend-text-base">Dashboard</a> /
                        <a href="{{ route('component.index') }}" class="font-bold text-skin-backend-text-base">Section</a> /
                        <span class="text-skin-backend-text-base text-opacity-50">{{ ucfirst(str_replace('-', ' ', $dynamicComponent->name)) }}</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Manage {{ ucfirst(str_replace('-', ' ', $dynamicComponent->name)) }} data - view, add, edit, and delete records.
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-skin-backend-accent bg-opacity-20 text-skin-backend-accent ml-1">{{ count($columns) }} columns</span>
                    </p>
                </div>
                <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                    href="{{ route('dynamic-component.create', $dynamicComponent->name) }}">
                    <i class="fa-solid fa-plus"></i>
                    Add {{ ucfirst(str_replace('-', ' ', $dynamicComponent->name)) }}
                </a>
            </div>

            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <form id="dynamic-component-search-form" method="get" action="{{ route('dynamic-component.index', $dynamicComponent->name) }}" class="mb-4">
                    <div class="flex flex-wrap items-center gap-2 w-full sm:max-w-xl">
                        <div class="relative flex-1 min-w-[200px]">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-skin-backend-text-base text-opacity-40 pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-sm"></i>
                            </span>
                            <input type="search" name="search" id="dynamic-component-search-input" value="{{ request('search') }}"
                                placeholder="Search (updates as you type)…"
                                autocomplete="off"
                                class="w-full pl-9 pr-3 py-2 text-sm rounded-[10px] bg-skin-backend-secondary border border-default border-opacity-[25%] text-skin-backend-text-base placeholder:text-skin-backend-text-base placeholder:text-opacity-40 focus:outline-none focus:border-highlight" />
                        </div>
                        <span class="text-xs text-skin-backend-text-base text-opacity-50 js-dynamic-search-status hidden whitespace-nowrap" aria-live="polite">Searching…</span>
                        <button type="button" id="dynamic-search-clear-btn"
                            class="py-2 px-3 text-xs text-skin-backend-accent hover:underline whitespace-nowrap {{ request()->filled('search') ? '' : 'hidden' }}">
                            Clear
                        </button>
                    </div>
                </form>
                <div id="dynamic-component-list" class="transition-opacity duration-200">
                    @include('backend.pages.dynamic-component.partials.list')
                </div>
            </div>
        </div>
    </div>

    <x-backend.delete-modal />
    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif
    @if ($message = Session::get('error'))
        <x-backend.flash-error :message="$message" :type="'error'" />
    @endif
</x-Deshboard-layout>

<script>
    (function() {
        const DEBOUNCE_MS = 350;
        const $form = $('#dynamic-component-search-form');
        const $input = $('#dynamic-component-search-input');
        const $list = $('#dynamic-component-list');
        const $status = $('.js-dynamic-search-status');
        const $clearBtn = $('#dynamic-search-clear-btn');
        let timer = null;

        function toggleClearVisibility() {
            if ($input.val().trim()) {
                $clearBtn.removeClass('hidden');
            } else {
                $clearBtn.addClass('hidden');
            }
        }

        function syncUrlFromForm() {
            const base = $form.attr('action');
            const q = $input.val().trim();
            const url = q ? (base + '?search=' + encodeURIComponent(q)) : base;
            history.replaceState(null, '', url);
        }

        function runListFetch() {
            clearTimeout(timer);
            $status.removeClass('hidden');
            $list.addClass('opacity-50 pointer-events-none');
            $.ajax({
                url: $form.attr('action'),
                method: 'GET',
                data: $form.serialize(),
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                dataType: 'html',
                success: function(html) {
                    $list.html(html);
                    syncUrlFromForm();
                    toggleClearVisibility();
                },
                complete: function() {
                    $status.addClass('hidden');
                    $list.removeClass('opacity-50 pointer-events-none');
                }
            });
        }

        $input.on('input', function() {
            clearTimeout(timer);
            timer = setTimeout(runListFetch, DEBOUNCE_MS);
        });

        $form.on('submit', function(e) {
            e.preventDefault();
            clearTimeout(timer);
            runListFetch();
        });

        $clearBtn.on('click', function() {
            $input.val('');
            clearTimeout(timer);
            runListFetch();
        });
    })();

    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id');
        const route = "{{ route('dynamic-component.destroy', [$dynamicComponent->name, ':id']) }}".replace(':id', id);
        $('#delete').attr('action', route);
    });
</script>
