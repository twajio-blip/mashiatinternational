<x-backend.model :id="'category-edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'category-edit'" :action="route('work.categories.store')" :title="'Edit Category'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Category Name')" for="category_name" />
        <x-backend.input-field type="text" name="category_name" id='category_name' :value="old('category_name')"
            placeholder="Enter category name" /> 
    </div>
</x-backend.model>
 
<script>
    $(document).on('click', '#update', function() {
        let data = $(this).attr('data');
  
        data = JSON.parse(data);
        $('#category-edit-model').find('#category_name').val(data.category_name);
        // Set the content of the editor
        let route = "{{ route('work.categories.update', ':id') }}".replace(':id', data.id);
        $('#category-edit').attr('action', route);
    })
</script>
