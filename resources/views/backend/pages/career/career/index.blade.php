<x-Deshboard-layout>
    {{-- @dd($gallery) --}}
    <!-- Table Section -->
    {{-- @dd('hello') --}}
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{route('career.career.index')}}" class="font-bold text-skin-backend-text-base">Career</a> / <span class="text-skin-backend-text-base text-opacity-50">Career</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Manage job listings and details to attract and hire qualified candidates. 
                    </p>
                </div>  
                <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                    href="#" data-hs-overlay="#career-create-model">
                    <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" />
                    </svg>
                    Add Career
                </a>
            </div>
            <!-- End Header -->
            <!-- Table -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto">    
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>
                                <th scope="col" class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-6">Job title</h2> 
                                </th> 
                                <th scope="col" class="py-3 text-start min-w-[100px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Category</h2> 
                                </th> 
                                <th scope="col" class="py-3 text-start min-w-[50px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Work Experience</h2> 
                                </th> 
                                <th scope="col" class="py-3 text-start min-w-[50px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Deadline</h2> 
                                </th> 
                                <th scope="col" class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Short Job Description</h2> 
                                </th> 
                                <th class="py-3 text-center w-[80px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Action</h2>
                                </th> 

                                {{-- <th scope="col" class="px-6 py-3 text-end"></th> --}}
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06]">
                            @forelse ($careers as $career)
                                <tr class="text-xs">
                                    <td class="py-3 px-6">
                                        {{ $career?->job_title }}
                                    </td> 
                                    <td class="py-3">
                                        {{ $career?->category?->name }}
                                    </td> 
                                    <td class="py-3">
                                        {{ $career?->work_exp }}
                                    </td>
                                    <td class="py-3">
                                        {{ $career?->deadline }}
                                    </td>
                                    <td class="py-3">
                                        <span class="line-clamp-1">{{ $career?->short_job_description }}</span> 
                                    </td>
                                    <td class="text-center py-3">
                                        <div class="space-x-2">
                                            <a data="{{ $career }}" id="update"
                                                class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full"
                                                href="#" data-hs-overlay="#career-edit-model">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button career-id="{{$career->id}}" type="button"
                                                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-danger-alert" data-hs-overlay="#hs-danger-alert"
                                                    class="delete-btn gap-x-1 text-xs decoration-2 font-medium inline-flex no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                                                    <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="">
                                    <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="6">No data found</td>
                                </tr>
                            @endforelse

                    </table> 
                </div>
            </div>
            <!-- End Table -->
            <div class="float-right mt-3">
                <x-backend.pagination :paginator="$careers" />
             </div>
        </div>
        <!-- End Card -->
    </div>
    {{-- Delete Modal --}}
    <x-backend.delete-modal/>
    {{-- Delete Modal --}}
    <!-- End Table Section -->
    @include('backend.pages.career.career.model.image-create-model')
    @include('backend.pages.career.career.model.image-edit-model')


    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>

<x-backend.server-error :form_id="'gallery-create'" :request_form="'Gallery\GalleryStoreRequest'" />
<x-backend.server-error :form_id="'gallery-edit'" :request_form="'Gallery\GalleryUpdateRequest'" />
<script>
    $('.delete-btn').click(function(e){
        
        e.preventDefault()
        careerId = $(this).attr('career-id');
        let route = "{{ route('career.career.destroy', ':id') }}".replace(':id', careerId);
        $('#delete').attr('action',route);

    });
</script>
