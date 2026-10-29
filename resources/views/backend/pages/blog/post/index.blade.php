<x-Deshboard-layout>
    <!-- Table Section -->
    <div class=" py-10 ">
        <!-- Card -->
        <div class="space-y-4">
            <!-- Header -->
            <div class="md:flex md:justify-between md:items-center space-y-4 md:space-y-0">

                <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
                    <h2 class="text-[24px]">
                        <a href="{{ route('blog.posts.index') }}" class="font-bold text-skin-backend-text-base">Blog</a> /
                        <span class="text-skin-backend-text-base text-opacity-50">Posts</span>
                    </h2>
                    <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                        Create, edit, and manage your blog posts to share updates and stories.
                    </p>
                </div>


                <a class="py-2.5 px-4 inline-flex items-center gap-x-2 text-xs  font-[600] rounded-[10px] bg-skin-backend-accent hover:bg-opacity-90 transition-opacity duration-300 text-skin-invert disabled:opacity-50 disabled:pointer-events-none"
                    href="#" data-hs-overlay="#post-create-model">
                    <svg class="flex-shrink-0 w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 16 16" fill="none">
                        <path d="M2.63452 7.50001L13.6345 7.5M8.13452 13V2" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                    </svg>
                    Add Post
                </a>
            </div>
            <!-- End Header -->
            <!-- Table -->
            <div class="bg-skin-backend-secondary text-skin-backend-text-base p-6 rounded-[10px]">
                <div class="w-full overflow-x-auto"> 
                    <table class="min-w-full divide-y divide-[#ffffff06] text-[14px]">
                        <thead class="bg-[#323232] font-bold">
                            <tr>

                                <th class="py-3 text-start min-w-[200px]">
                                    <h2 class="px-6">Images</h2> 
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Title</h2> 
                                </th>
                                <th class="py-3 text-start min-w-[150px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Category</h2> 
                                </th>
                                <th class="py-3 text-center w-[100px]">
                                    <h2 class="px-4 border-l border-default border-opacity-[6%]">Action</h2>
                                </th>  
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#ffffff06]">
                            @forelse ($blogs as $post)
                                <tr class="text-xs">
                                    <td class="py-3 px-6">
                                        <div>
                                            <img class="w-[141px] h-[70px] object-cover object-center rounded-[10px]" src="{{ asset('images/' . $post->image) }}"
                                                alt="blog-image">
                                        </div>
                                    </td>  
                                    <td class="py-3">
                                        {{ $post->title }}
                                    </td> 
                                    <td class="py-3">
                                        {{ $post->category->category_name }}
                                    </td>  
                                    <td class="text-center py-3">
                                        <div class="space-x-2">
                                            <a data="{{ $post }}" id="update"
                                                class="inline-flex items-center justify-center gap-x-1 text-xs decoration-2 font-medium w-[26px] h-[26px] bg-[#3762ED] rounded-full"
                                                href="#" data-hs-overlay="#post-edit-model">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button post-id="{{ $post->id }}" type="button" aria-haspopup="dialog"
                                                aria-expanded="false" aria-controls="hs-danger-alert"
                                                data-hs-overlay="#hs-danger-alert"
                                                class="delete-btn gap-x-1 text-xs decoration-2 font-medium inline-flex no-underline items-center justify-center w-[26px] h-[26px] rounded-full bg-[#E61714]">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="">
                                    <td class=" px-4 py-2 w-full text-gray-500 text-center" colspan="4">No data found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> 
            </div>
            <!-- End Table -->
            <div class="float-right mt-3">
                <x-backend.pagination :paginator="$blogs" />
            </div>
        </div>
        <!-- End Card -->
    </div>
    {{-- Delete Modal --}}
    <x-backend.delete-modal />
    {{-- Delete Modal --}}
    <!-- End Table Section -->
    @include('backend.pages.blog.post.model.post-create-model')
    @include('backend.pages.blog.post.model.post-edit-model')

    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>

<script>
    $('.delete-btn').click(function(e) {

        e.preventDefault()
        postId = $(this).attr('post-id');
        let route = "{{ route('blog.posts.destroy', ':id') }}".replace(':id', postId);
        $('#delete').attr('action', route);

    });
</script>
