<x-Deshboard-layout>

    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[350px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{route('dashboard')}}" class="font-bold text-skin-backend-text-base">Dashboard</a> / <span class="text-skin-backend-text-base text-opacity-50">Manage Services</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Manage and display the services your business offers with titles, icons, and descriptions. 
                    </p> 
                </div>

                <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                    href="#" data-hs-overlay="#create-model">
                    <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Add Service
                </a>
            </div>
            <!-- End Header -->

            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <!-- Table -->
                <div class="w-full overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th class="py-3 text-start min-w-[200px]">
                                    <h2 class="px-6">Image</h2> 
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">title</h2> 
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Short Description</h2> 
                                </th>
                                <th class="py-3 text-center w-[100px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Action</h2>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06] space-y-2">
                            @forelse ($services as $service)
                                <tr>
                                    <td class="py-3 px-6">
                                        <div>
                                            <img class="w-[141px] h-[70px] object-cover object-center rounded-[10px]" src="{{ asset('images/' . $service->image) }}"
                                                alt="Image Description">
                                        </div>
                                    </td>
                                    <td class="py-3"> 
                                            {{ $service->title }}
                                    </td>
                                    <td class="py-3">
                                            {{ $service->short_des }}
                                    </td>

                                    <td class="text-center py-3">
                                        <div class="space-x-2">
                                            <a data="{{ $service }}" id="update"
                                                class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full"
                                                href="#" data-hs-overlay="#edit-model">
                                                <i class="fa-solid fa-pen-to-square  "></i>
                                            </a>
                                            <button service-id="{{ $service->id }}" type="button"
                                                aria-haspopup="dialog" aria-expanded="false"
                                                aria-controls="hs-danger-alert"
                                                data-hs-overlay="#hs-danger-alert"
                                                class="delete-btn gap-x-1 text-xs decoration-2 font-medium inline-flex no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="">
                                    <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="4">No data found</td>
                                </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div> 
                <!-- End Table -->
            </div>
            <div class="float-right mt-3">
                <x-backend.pagination :paginator="$services" />
            </div>


        </div>
        <!-- End Card -->
    </div>
    <!-- End Table Section -->
    {{-- Delete Modal --}}
    <x-backend.delete-modal />
    {{-- Delete Modal --}}
    {{-- Model --}}
    @include('backend.pages.services.model.create-model')
    @include('backend.pages.services.model.edit-model')
    {{-- Message --}}
    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>
{{-- servier error --}}
<x-backend.server-error :form_id="'service-create'" :request_form="'Services\ServiceStoreRequest'" />
<x-backend.server-error :form_id="'service-edit'" :request_form="'Services\ServicesUpdateRequest'" />
{{-- Delete Element Confermation  --}}
<script>
    $('.delete-btn').click(function(e) {

        e.preventDefault()
        serviceId = $(this).attr('service-id');
        let route = "{{ route('service.destroy', ':id') }}".replace(':id', serviceId);
        $('#delete').attr('action', route);

    });
</script>
