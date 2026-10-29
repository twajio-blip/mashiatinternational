<x-backend.model :id="'post-edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'post-edit'" :action="route('work.posts.store')" :title="'Edit Works'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Work Title')" for="work_title" />
        <x-backend.input-field type="text" name="title" id='work_title' :value="old('work_title')"
            placeholder="Enter work title"  required/>

        <x-backend.input-label :value="__('Work Subtitle')" for="work_subtitle" />
        <x-backend.input-field type="text" name="subtitle" id='work_subtitle' :value="old('work_subtitle')"
            placeholder="Enter work subtitle" required/>

        <x-backend.input-label :value="__('Work Slug')" for="work_slug" />
        <x-backend.input-field type="text" name="slug" id='work_slug' :value="old('work_slug')"
            placeholder="Enter work slug"  required/>
        <x-backend.input-label :value="__('Category')" for="category" />
        <x-backend.input-dropdown id="category" name="category_id" class="field" :values="$categories" :label_name="'category_name'"
            :label_id="'id'" :placeholder="'Select one'" selected='' required />
        <x-backend.input-label :value="__('Description')" for="description" />
        <x-backend.textEditor :id="'work_edit'" name='description' :form_id="'post-edit'"  :value='""' />

        <x-backend.input-label :value="__('Upload Image')" for="upload_image" accept=".png, .jpg, .jpeg" />
        <x-backend.input-field type="file" name="image" id='upload_image'
            class="block w-full text-sm text-gray-500
    file:me-4 file:py-2 file:px-4
    file:rounded-[4px] file:border-0
    file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
    file:disabled:opacity-50 file:disabled:pointer-events-none
  "  />


    </div>
</x-backend.model>



<script>
    $(document).on('click', '#update', function() {
        let data = $(this).attr('data');

        data = JSON.parse(data);
        $('#post-edit-model').find('#work_title').val(data.title);
        $('#post-edit-model').find('#work_subtitle').val(data.subtitle);
        $('#post-edit-model').find('#work_slug').val(data.slug);
        $('#post-edit-model').find('#category').val(data.category_id);
            
        editTextEditor.setContents(data.description);
        // Set the content of the editor
        let route = "{{ route('work.posts.update', ':id') }}".replace(':id', data.id);
        $('#post-edit').attr('action', route);
    })
</script>
