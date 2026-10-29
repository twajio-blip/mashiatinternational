<x-Deshboard-layout>

    <!-- Table Section -->
    <div class="py-10 space-y-4">
        <!-- Header -->
        <div class="space-y-2 max-w-[304px]">
            <h2 class="text-[24px] font-bold text-skin-backend-text-base">
                <a href="{{ route('theme-option.index') }}" class="font-bold text-skin-backend-text-base">Settings</a> /
                <span class="text-skin-backend-text-base text-opacity-50">Navigation</span>
            </h2>
            <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                Manage your website’s menu structure and navigation links for easy user access.
            </p>
        </div>
        <!-- End Header -->
        <form action="{{ route('widget.store') }}" method="post">
            @csrf
            <div class="grid grid-cols-12 gap-4 text-skin-backend-text-base">
                <div class="col-span-12 md:col-span-7 lg:col-span-4 w-full space-y-4">
                    <p class="text-[18px] font-bold text-center">Pages</p>

                    <div class="dd border border-default border-opacity-25  bg-skin-backend-secondary p-4 rounded-[4px]"
                        id="nestable-left">
                        <ol class="dd-list space-y-4">

                            @foreach ($pages as $page)
                            <li class="dd-item space-y-3" data-id="{{ $page->id }}" data-name="{{$page->name  }}"
                                data-type="page" data-link="{{ $page->permalink }}">
                                <div class="relative  cursor-move">
                                    <div
                                        class="dd-handle bg-skin-backend-primary text-skin-hover rounded-[10px] p-4  border border-default border-opacity-25 text-sm flex-1">
                                        <span> {{ $page->name }}</span>
                                    </div>
                                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">



                                        {{-- Add Child --}}
                                        <button title="Add Child"
                                            class="add-child-btn w-6 h-6 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white flex items-center justify-center transition">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>



                                    </div>
                                </div>
                            </li>
                            @endforeach


                        </ol>
                    </div>

                </div>
                <div class="col-span-12 md:col-span-12 lg:col-span-4 w-full space-y-4">
                    <p class="text-[18px] font-bold text-center">Header</p>
                    <div class="dd border border-default border-opacity-25  bg-skin-backend-secondary p-4 rounded-[4px]"
                        id="nestable-right">
                        @php
                        function renderWidgets($widgets) {
                        if (count($widgets) ==0) return;


                        echo '<ol class="dd-list space-y-4">';

                            foreach ($widgets as $widget) {
                            echo '<li class="dd-item space-y-3" data-id="' . $widget['ref_id'] . '"
                                data-name="' . $widget['name'] . '" data-type="' . $widget['type'] . '"
                                data-link="' . $widget['link'] . '">';

                                echo '<div class="relative cursor-move">
                                    <div
                                        class="dd-handle bg-skin-backend-primary text-skin-hover rounded-[10px] p-4 border border-default border-opacity-25 text-sm flex-1">
                                        <span>' . htmlspecialchars($widget['name']) . '</span>
                                    </div>
                                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">';

                                        if ($widget['ref_id'] == null) {
                                        echo '<button title="Edit"
                                            class="edit-btn w-6 h-6 rounded-full bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </button>';
                                        }

                                        echo '<button title="Add Child"
                                            class="add-child-btn w-6 h-6 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white flex items-center justify-center transition">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>';

                                        if ($widget['ref_id'] == null) {
                                        echo '<button title="Delete"
                                            class="delete-btn w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                        </button>';
                                        }

                                        echo '</div>
                                </div>';

                                if (!empty($widget['children'])) {
                                renderWidgets($widget['children']); // recursive
                                }

                                echo '</li>';
                            }

                            echo '</ol>';
                        }
                        @endphp

                        {{-- ✅ Render widget tree --}}
                        {!! renderWidgets($widgets) !!}

                    </div>

                </div>

                <div class="col-span-12 md:col-span-4 lg:col-span-4 w-full space-y-4">
                    <p class="text-[18px] font-bold text-center">Action</p>
                    <button type="submit" id="update-widget"
                        class="bg-skin-backend-accent hover:bg-opacity-90 text-skin-invert font-bold text-sm py-2 px-4 w-full rounded-[10px]">
                        Update
                    </button>
                </div>
            </div>
        </form>
        <!-- End Card -->
        <div id="hs-basic-modal"
            class="hs-overlay hs-overlay-open:opacity-100 hs-overlay-open:duration-500 hidden size-full fixed top-0 start-0 z-[80] opacity-0 overflow-x-hidden transition-all overflow-y-auto pointer-events-none"
            role="dialog" tabindex="-1" aria-labelledby="hs-basic-modal-label">
            <div class="sm:max-w-lg sm:w-full m-3 sm:mx-auto">
                <div
                    class="flex flex-col bg-skin-backend-secondary text-skin-backend-text-base rounded-[10px] pointer-events-auto">
                    <div class="flex justify-between items-center py-3 px-4 h-[73px] bg-[#323232] rounded-t-[10px]">
                        <h3 id="hs-basic-modal-label" class="text-[18px] font-bold">
                            Add Child
                        </h3>
                        <button type="button"
                            class="flex justify-center items-center p-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-skin-backend-secondary disabled:opacity-50 disabled:pointer-events-none"
                            aria-label="Close" data-hs-overlay="#hs-basic-modal">
                            <span class="sr-only">Close</span>
                            <svg class="shrink-0 size-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                <path d="m6 6 12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form action="" method="get" id='addChild'>
                        <div class="p-4 overflow-y-auto space-y-4">
                            <div>
                                <x-backend.input-label :value="'Name'" for="name-child" />
                                <x-backend.input-field type="text" name="name" id='name-child' :value="''"
                                    placeholder="Enter Name" required />
                            </div>
                            <div>
                                <x-backend.input-label :value="'Url'" for="url-child" />
                                <x-backend.input-field type="text" name="url" id='url-child' :value="''"
                                    placeholder="Enter url" required />
                            </div>
                        </div>
                        <div class="flex justify-end items-center gap-x-2 pt-3 pb-10 px-4">
                            <button type="button"
                                class="close-model px-12 py-3 text-skin-hover border border-highlight rounded-[10px] hover:bg-skin-backend-accent hover:text-skin-invert transition-colors font-semibold text-xs disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-overlay="#hs-basic-modal">
                                Close
                            </button>
                            <button type="submit"
                                class="parent-info addChild px-12 py-3 bg-skin-backend-accent text-skin-invert rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="flex gap-10 w-full max-w-6xl mx-auto">
        <!-- LEFT SIDE -->
        {{-- <div class="w-1/2">
            <button id="add-left-item"
                class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Add New Item
            </button>
            <div class="dd" id="nestable-left">
                <ol class="dd-list">



                    <li class="dd-item" data-id="7" data-type="url" data-link="/preview">
                        <div class="relative  cursor-move">
                            <div class="dd-handle flex-1"><span>Contact preview</span></div>
                            <div class="space-x-2  absolute right-2 top-1/2 -translate-y-1/2">
                                <button class="text-blue-600 edit-btn hover:underline">Edit</button>
                                <button class="text-red-600 delete-btn hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>


                    <li class="dd-item" data-id="9" data-type="url" data-link="/other">
                        <div class="relative  cursor-move">
                            <div class="dd-handle flex-1"><span>Other</span></div>
                            <div class="space-x-2  absolute right-2 top-1/2 -translate-y-1/2">
                                <button class="text-blue-600 edit-btn hover:underline">Edit</button>
                                <button class="text-red-600 delete-btn hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </div> --}}

        <!-- RIGHT SIDE -->
        {{-- <div class="w-1/2 bg-gray-100 p-4 rounded">
            <div class="dd" id="nestable-right">
                <ol class="dd-list">
                    <li class="dd-item " data-id="1" data-type="page" data-link="">
                        <div class="relative  cursor-move">
                            <div class="dd-handle flex-1"><span>Home</span></div>
                            <div class="space-x-2  absolute right-2 top-1/2 -translate-y-1/2">
                                <button class="text-blue-600 edit-btn hover:underline">Edit</button>
                                <button class="text-red-600 delete-btn hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>
                    <li class="dd-item" data-id="2" data-type="url" data-link="/contact">
                        <div class="relative  cursor-move">
                            <div class="dd-handle flex-1"><span>Contact</span></div>
                            <div class="space-x-2  absolute right-2 top-1/2 -translate-y-1/2">
                                <button class="text-blue-600 edit-btn hover:underline">Edit</button>
                                <button class="text-red-600 delete-btn hover:underline">Delete</button>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </div> --}}
        @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
        @endif

</x-Deshboard-layout>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<!-- Nestable2 -->

<link rel="stylesheet" href="{{ asset('css/nasted-manu.css') }}">
<script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>


{{-- Delete Element Confermation --}}
<script>
    $(document).ready(function() {
        // Initialize nestable with group and maxDepth 4 for both sides
        $('#nestable-left').nestable({
            group: 1,
            maxDepth: 1
        });

        $('#nestable-right').nestable({
            group: 1,
            maxDepth: 4
        });

     let nextId = 9999;
        const MAX_DEPTH = 4;
        
        $(document).on('click', '.add-child-btn', function (e) {
        e.preventDefault();
        
        const parentItem = $(this).closest('.dd-item');
        
        // 🧠 Calculate current depth (level)
        const currentLevel = parentItem.parents('.dd-item').length + 1;
        const remainingLevels = MAX_DEPTH - currentLevel;
        
        if (remainingLevels <= 0) { alert(`⚠️ Maximum depth of ${MAX_DEPTH} reached.\nYou can't add more children.`); return; }
            // ✅ Show user how many levels are available console.log(`You are at level ${currentLevel}. You can add up to

        
            // ✅ Create or get the child list
            let childList = parentItem.children('ol.dd-list');
            if (!childList.length) {
            childList = $('<ol class="dd-list space-y-3 mt-2"></ol>');
            parentItem.append(childList);
            }
        
            // ✅ Create new child item
            const newItem = $(`<li class="dd-item space-y-3" data-id="null" data-type="url" data-link="#" data-name="New Item ${nextId}">
                <div class="relative cursor-move">
                    <div
                        class="dd-handle bg-skin-backend-primary text-skin-hover rounded-[10px] p-3 border border-default border-opacity-25 text-sm flex-1">
                        <span>New Item ${nextId}</span>
                    </div>
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-1">
                        <button title="Edit"
                            class="edit-btn w-6 h-6 rounded-full bg-blue-500 hover:bg-blue-600 text-white flex items-center justify-center transition">
                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        </button>
                        <button title="Add Child"
                            class="add-child-btn w-6 h-6 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white flex items-center justify-center transition">
                            <i class="fa-solid fa-plus text-[10px]"></i>
                        </button>
                        <button title="Delete"
                            class="delete-btn w-6 h-6 rounded-full bg-red-500 hover:bg-red-600 text-white flex items-center justify-center transition">
                            <i class="fa-solid fa-trash text-[10px]"></i>
                        </button>
                    </div>
                </div>
            </li>`);
        
            // ✅ Append to child list
            childList.append(newItem);
            nextId++;
            });


        let currentRightItems = '';

        // Log current serialized data on any change
        $('#nestable-left, #nestable-right').on('change', function() {
            const leftData = $('#nestable-left').nestable('serialize');
            const rightData = $('#nestable-right').nestable('serialize');
            console.clear();
            // console.log('Left Menu Data:', JSON.stringify(leftData, null, 2));
            // console.log('Right Menu Data:', JSON.stringify(rightData, null, 2));
            currentRightItems = JSON.stringify(rightData, null, 2);

        });

        // Edit button click
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();
            const container = $(this).closest('.dd-item');
            const handle = container.find('.dd-handle');
            const currentTitle = handle.find('span').first().text().trim();
            const currentType = container.data('type') || 'page';
            const currentLink = container.data('link') || '';

            // Prevent multiple forms open
            if (container.find('.edit-form').length) return;

            const form = `
    <div class="edit-form  border border-gray-700 rounded p-3 bg-skin-backend-primary mt-2 space-y-2">
        <input type="text" class="edit-title bg-skin-backend-secondary w-full border px-2 py-1 rounded" value="${currentTitle}" placeholder="Title" />
        <select class="edit-type bg-skin-backend-secondary w-full border px-2 py-1 rounded">
            <option value="page" ${currentType==='page' ? 'selected' : '' }>Page</option>
            <option value="url" ${currentType==='url' ? 'selected' : '' }>URL</option>
        </select>
        <input type="text" class="edit-link bg-skin-backend-secondary w-full border px-2 py-1 rounded" value="${currentLink}"
            placeholder="Enter URL or slug" />
        <div class="flex justify-end gap-2">
            <button class="save-edit bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Save</button>
            <button class="cancel-edit bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Cancel</button>
        </div>
    </div>
    `;

            handle.hide();
            $(this).closest('div').siblings('.edit-form').remove(); // remove any other open edit form
            $(this).closest('div').after(form);
            // Hide edit/delete buttons while editing
            container.find('.edit-btn, .delete-btn, .add-child-btn').hide();
        });

        // Save edit button click
        $(document).on('click', '.save-edit', function() {
            const form = $(this).closest('.edit-form');
            const container = form.closest('.dd-item');
            const newTitle = form.find('.edit-title').val().trim();
            const newType = form.find('.edit-type').val();
            const newLink = form.find('.edit-link').val().trim();

            if (newTitle === '') {
                alert('Title cannot be empty');
                return;
            }

            container.data('type', newType);
            container.data('link', newLink);
            container.data('name', newTitle);
            container.find('.dd-handle span').first().text(newTitle);

            form.remove();
            container.find('.dd-handle').show();
            container.find('.edit-btn, .delete-btn').show();
        });

        // Cancel edit button click
        $(document).on('click', '.cancel-edit', function() {
            const form = $(this).closest('.edit-form');
            const container = form.closest('.dd-item');
            form.remove();
            container.find('.dd-handle').show();
            container.find('.edit-btn, .delete-btn').show();
        });

        // Delete button click
        $(document).on('click', '.delete-btn', function() {
            if (confirm('Are you sure you want to delete this item?')) {
                $(this).closest('.dd-item').remove();
            }
        });



        $(document).on('click', '#update-widget', function(e) {
            e.preventDefault();
            $('#nestable-right').trigger('change');
            


            $.ajax({
                type: 'POST',
                url: '{{ route('widget.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    items: currentRightItems
                },
                success: function(response) {
            
                 const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                    icon: "success",
                    title: "Widget update successfully"
                    });
                    // Optionally, you can redirect or update the UI
                    // window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                
                }
            });


        });


    });
</script>