<x-backend.model :id="'category-create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'slide-create'" :action="route('blog.categories.store')" :title="'Add Category'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Category Name')" for="category_name" />
        <x-backend.input-field type="text" name="category_name" id='category_name' :value="old('category_name')"
            placeholder="Enter category name" /> 
    </div>
</x-backend.model>
