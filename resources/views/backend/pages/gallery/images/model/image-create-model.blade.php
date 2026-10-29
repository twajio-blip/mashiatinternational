<x-backend.model :id="'gallery-create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'gallery-create'" :action="route('gallery.images.store')" :title="'Add Image'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Component field'" for="component" />
        <x-backend.input-dropdown id="component" name="category_id" class="field" :values="$categories" :label_name="'category_name'"
            :label_id="'id'" :placeholder="'Select one'" selected='' required />

        <x-backend.input-label :value="'Caption_title'" for="caption_title" />
        <x-backend.input-field type="text" name="caption_title" id='caption_title' :value="old('caption_title')"
            placeholder="Enter caption title" />

        <x-backend.input-label :value="'Caption_sub_title'" for="caption_sub_title" />
        <x-backend.input-field type="text" name="caption_sub_title" id='caption_sub_title' :value="old('caption_sub_title')"
            placeholder="Enter caption sub title" />

        <x-backend.input-label :value="__('Upload Image')" for="upload_image" />
        <x-backend.input-field type="file" name="image[]" id='upload_image' multiple
            class="block w-full text-sm text-gray-500
    file:me-4 file:py-2 file:px-4
    file:rounded-[4px] file:border-0
    file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
    file:disabled:opacity-50 file:disabled:pointer-events-none
  " />
    </div>
</x-backend.model>
