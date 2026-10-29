<x-backend.model :id="'slide-create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'slide-create'" :action="route('gallery.categories.store')" :title="'Add Category'"
    :method="__('post')">
    @csrf
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
