<x-backend.model :id="'edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'service-edit'" :action="route('service.store')" :title="'Edit Service'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Title'" for="title" />
        <x-backend.input-field type="text" name="title" id='title' :value="old('title')" placeholder="Enter title" />
        <x-backend.input-label :value="'Short Description'" for="short-des" />
        <x-backend.input-textarea name="short_des" rows="4" id='short-des' :text="old('short-des')"
            placeholder="Enter description" />

        <x-backend.input-label :value="'Button Name'" for="button_name" />
        <x-backend.input-field type="text" name="button_name" id='button_name' :value="old('button_name')" placeholder="Enter Button Name" /> 

        <x-backend.input-label :value="'Long Description'" for="des" />
        <x-backend.textEditor :id="'des-edit'" name='content' :form_id="'service-edit'" />
       
        <x-backend.input-label :value="__('Upload Image')" for="upload_image" />
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
        $('#service-edit').find('#title').val(data.title);
        $('#service-edit').find('#icone').val(data.icone);
        $('#service-edit').find('#button_name').val(data.button_name);
        $('#service-edit').find('#short-des').val(data.short_des);
        editTextEditor.setContents(data.content);
        let route = "{{ route('service.update', ':id') }}".replace(':id', data.id);
        $('#service-edit').attr('action', route)
    })
</script>
