<x-backend.model :id="'create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'service-create'" :action="route('service.store')" :title="'Create Service'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Title'" for="title" />
        <x-backend.input-field type="text" name="title" id='title' :value="old('title')" placeholder="Enter title" />
        <x-backend.input-label :value="'Short Description'" for="short-des" />
        <x-backend.input-textarea name="short_des" rows="4" id='short-des' :text="old('short-des')"
            placeholder="Enter description" />

        <x-backend.input-label :value="'Button Name'" for="button_name" />
        <x-backend.input-field type="text" name="button_name" id='button_name' :value="old('button_name')" placeholder="Enter Button Name" /> 

        <x-backend.input-label :value="'Long Description'" for="description" />
        <x-backend.textEditor :id="'create'" name='content' :form_id="'service-create'" />

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
