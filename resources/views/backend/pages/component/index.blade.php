<x-Deshboard-layout>

    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{route('dashboard')}}" class="font-bold text-skin-backend-text-base">Dashboard</a> /
                        <span class="text-skin-backend-text-base text-opacity-50">Section</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Manage customizable sections to organize your dashboard content effectively.
                    </p>
                </div>

                <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                    href="#" data-hs-overlay="#create-model">
                    <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 16 16" fill="none">
                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    Add Section
                </a>
            </div>
            <!-- End Header -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto">


                    <!-- Table -->
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th scope="col" class="py-3 text-center min-w-[50px]">
                                    <h2 class="px-2">#</h2>
                                </th>
                                <th scope="col" class="py-3 text-start min-w-[200px] border-l border-default border-opacity-[6%]">
                                    <h2 class="px-6">Component</h2>
                                </th>
                                <th scope="col" class="py-3 text-center min-w-[100px] border-l border-default border-opacity-[6%]">
                                    <h2 class="px-2">Order</h2>
                                </th>
                                <th scope="col" class="py-3 text-center min-w-[190px] border-l border-default border-opacity-[6%]">
                                    <h2 class="px-4">Action</h2>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06] space-y-2">

                            @forelse ($components as $index => $component)
                            @php
                                $childFields = $component->componentFiled->where('group', 1);
                                $tableColumns = $childFields->filter(fn($f) => ($f->show_in_table ?? 1));
                                $isManageable = $childFields->isNotEmpty() || ($component->set_from === 'database' && $component->database);
                                $orderNum = $index + 1;
                            @endphp
                            <tr class="text-xs component-row" data-id="{{ $component->id }}">
                                <td class="py-3 px-2 text-center font-medium text-skin-backend-text-base opacity-70">
                                    {{ $orderNum }}
                                </td>
                                <td class="py-3 px-6 border-l border-default border-opacity-[6%]">
                                    {{ ucfirst(str_replace('-', ' ', $component->name)) }}
                                </td>
                                <td class="py-3 px-2 text-center border-l border-default border-opacity-[6%]">
                                    <div class="flex items-center justify-center gap-0.5">
                                        <button type="button" class="order-up inline-flex items-center justify-center w-7 h-7 rounded bg-[#323232] hover:bg-skin-backend-accent text-skin-backend-text-base disabled:opacity-40 disabled:cursor-not-allowed" data-id="{{ $component->id }}" title="Move up">
                                            <i class="fa-solid fa-chevron-up text-[10px]"></i>
                                        </button>
                                        <button type="button" class="order-down inline-flex items-center justify-center w-7 h-7 rounded bg-[#323232] hover:bg-skin-backend-accent text-skin-backend-text-base disabled:opacity-40 disabled:cursor-not-allowed" data-id="{{ $component->id }}" title="Move down">
                                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="text-center py-3 border-l border-default border-opacity-[6%]">
                                    <div class="flex items-center justify-center gap-x-2">
                                        @if($isManageable)
                                            <a href="{{ route('dynamic-component.index', $component->name) }}"
                                                class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#10B981] rounded-full hover:bg-opacity-90"
                                                title="Manage Data">
                                                <i class="fa-solid fa-database"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('component.export-sql-view', $component->id) }}"
                                            target="_blank"
                                            class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#4B5563] rounded-full hover:bg-opacity-90"
                                            title="View SQL">
                                            <i class="fa-solid fa-code"></i>
                                        </a>
                                        <a href="{{ route('component.export-sql', $component->id) }}"
                                            class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#6B7280] rounded-full hover:bg-opacity-90"
                                            title="Download SQL">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a data-json="{{ base64_encode($component->load('componentFiled')->toJson()) }}" id="update"
                                            class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full"
                                            href="#" data-hs-overlay="#edit-model">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button component-id="{{$component->id}}" type="button" aria-haspopup="dialog"
                                            aria-expanded="false" aria-controls="hs-danger-alert"
                                            data-hs-overlay="#hs-danger-alert"
                                            class="delete-btn gap-x-1 text-xs decoration-2 font-medium inline-flex no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @if($childFields->isNotEmpty())
                            <tr class="text-xs bg-[#ffffff04]">
                                <td colspan="4" class="py-2 px-6 text-skin-backend-text-base text-opacity-70">
                                    <span class="text-opacity-50">Columns ({{ $tableColumns->count() }} in table):</span>
                                    {{ $tableColumns->pluck('name')->map(fn($n) => ucfirst(str_replace('_', ' ', $n)))->join(', ') ?: '—' }}
                                </td>
                            </tr>
                            @elseif($component->set_from === 'database' && $component->database)
                            <tr class="text-xs bg-[#ffffff04]">
                                <td colspan="4" class="py-2 px-6 text-skin-backend-text-base text-opacity-70">
                                    <span class="text-opacity-50">Database table:</span> {{ $component->database }}
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr class="">
                                <td class="px-4 py-2 w-full text-gray-500 text-center" colspan="4">No data found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- End Table -->
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>


    {{-- Model --}}
    @include('backend.pages.component.model.create-model')
    @include('backend.pages.component.model.edit-model')
    {{-- Message --}}
    @if ($message = Session::get('success'))
    <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>
{{-- servier error --}}
<x-backend.server-error :form_id="'component-create'" :request_form="'Component\ComponentCreateRequest'" />
{{--
<x-backend.server-error :form_id="'component-edit'" :request_form="'component\componentRequest'" /> --}}
{{-- Delete Modal --}}
<x-backend.delete-modal />
{{-- Delete Modal --}}
{{-- Delete Element Confermation --}}
<script>
    $('.delete-btn').click(function(e){
        e.preventDefault()
        componentId = $(this).attr('component-id');
        let route = "{{ route('component.destroy', ':id') }}".replace(':id', componentId);
        $('#delete').attr('action',route);
    });

    $(document).on('click', '.order-up, .order-down', function(e) {
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        var dir = btn.hasClass('order-up') ? 'up' : 'down';
        btn.prop('disabled', true);
        $.ajax({
            url: "{{ route('component.reorder') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                direction: dir
            },
            success: function() {
                location.reload();
            },
            error: function() {
                btn.prop('disabled', false);
            }
        });
    });
</script>