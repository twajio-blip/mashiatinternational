<x-Deshboard-layout>

    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Content --> 
            <div class="space-y-4">
                <!-- Header -->
                <div class="grid gap-3 md:flex md:justify-between md:items-center">
                    <div class="space-y-2 max-w-[304px]">
                        <h2 class="text-[24px] font-bold text-skin-backend-text-base">
                            Pages
                        </h2>
                        <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                            Manage the content of individual web pages, including home, about, services, and more.
                        </p>
                    </div>

                    <div>
                        <div class="inline-flex gap-x-2">
                            <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                                href="{{ route('pages.create') }}">
                                <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" />
                                </svg>
                                Add Pages
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Header -->

                <!-- Table -->
                <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                    <div class="w-full overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                            <thead class="bg-[#323232] font-bold">
                                <tr>
                                    <th scope="col" class="py-3 text-start min-w-[150px]">
                                        <h2 class="px-6">Pages</h2>
                                    </th>
                                    <th class="py-3 text-start min-w-[120px]">
                                        <h2 class="px-4 border-l border-default border-opacity-[6%]">Created at
                                        </h2>
                                    </th>
                                    <th class="py-3 text-center min-w-[100px]">
                                        <h2 class="px-4 border-l border-default border-opacity-[6%]">Status</h2>
                                    </th>
                                    <th class="py-3 text-center min-w-[100px]">
                                        <h2 class="px-4 border-l border-default border-opacity-[6%]">Action</h2>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#ffffff06]">

                                @forelse ($pages as $page)
                                    <tr>
                                        <td>
                                            <div class="px-6 py-3">{{ $page->name }}</div>
                                        </td>
                                        <td>
                                            <div class=" py-3">{{ $page->created_at->diffForHumans() }}</div>
                                        </td>
                                        <td class="text-center">
                                            @if ($page->status == 1)
                                                <span
                                                    class="inline-flex items-center justify-center gap-x-1.5 py-1.5 px-2 rounded-full text-xs bg-[#99FFFF4D] text-[#99FFFF] font-[600] min-w-[82px]">Published</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-[600] bg-[#FFDE004D] text-[#FFDE00] min-w-[82px] text-center justify-center">Draft</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="space-x-2">
                                                <a data="{{ $page }}" id="update"
                                                    class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full"
                                                    href="{{ route('pages.edit', $page->id) }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <button page-id="{{ $page->id }}" type="button"
                                                    aria-haspopup="dialog" aria-expanded="false"
                                                    aria-controls="hs-danger-alert"
                                                    data-hs-overlay="#hs-danger-alert"
                                                    class="delete-btn gap-x-1 text-xs decoration-2 font-medium inline-flex no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                                                    <i class=" fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="4">
                                            No data found</td>
                                    </tr>
                                @endforelse

                        </table>
                    </div>
                </div>
                <!-- End Table -->

            </div>  
        <!-- End Content -->
    </div>
    <!-- End Table Section -->

    {{-- Delete Modal --}}
    <x-backend.delete-modal />
    {{-- Delete Modal --}}

    {{-- Message --}}
    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>
{{-- servier error --}}
{{-- <x-backend.server-error :form_id="'pages-create'" :request_form="'pages\pagesRequest'" />
<x-backend.server-error :form_id="'pages-edit'" :request_form="'pages\pagesRequest'" /> --}}

{{-- Delete Element Confermation  --}}
<script>
    $('.delete-btn').click(function(e) {

        e.preventDefault()
        pageId = $(this).attr('page-id');
        let route = "{{ route('pages.destroy', ':id') }}".replace(':id', pageId);
        $('#delete').attr('action', route);

    });
</script>
