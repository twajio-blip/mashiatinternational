<x-backend.model :id="'category-edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'category-edit'" :action="route('gallery.categories.store')" :title="'Edit Category'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Category Name')" for="category_name" />
        <x-backend.input-field type="text" name="category_name" id='category_name' :value="old('category_name')"
            placeholder="Enter category name" />
            <x-backend.input-label :value="__('Thumbnail')" for="upload_image" />
            <x-backend.input-field type="file" name="image" id='upload_image' 
                class="block w-full text-sm text-gray-500
    file:me-4 file:py-2 file:px-4
    file:rounded-[4px] file:border-0
    file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
    file:disabled:opacity-50 file:disabled:pointer-events-none
      " />
    </div>
</x-backend.model>



<script>
    $(document).on('click', '#update', function() {
        let data = $(this).attr('data');

        data = JSON.parse(data);
        $('#category-edit-model').find('#category_name').val(data.category_name);
        // Set the content of the editor
        let route = "{{ route('gallery.categories.update', ':id') }}".replace(':id', data.id);
        $('#category-edit').attr('action', route);
    })
</script>
