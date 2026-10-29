<x-backend.model :id="'slide-create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'slide-create'" :action="route('slider.store')" :title="'Create Sliders'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Content')" for="create" />
        <x-backend.textEditor :id="'create'" name='content' :form_id="'slide-create'" />
        <x-backend.input-label :value="__('Button Name')" for="button_name" />
        <x-backend.input-field type="text" name="btn_name" id='button_name' :value="old('button_name')"
            placeholder="Enter button name" />

        <x-backend.input-label :value="__('Button URL')" for="button_url" />
        <x-backend.input-field type="text" name="btn_url" id='button_url' placeholder="Enter button url"
            :value="old('button_url')" />
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
