<x-backend.model :id="'post-edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'post-edit'" :action="route('blog.posts.store')" :title="'Edit Post'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="__('Blog Title')" for="blog_title" />
        <x-backend.input-field type="text" name="title" id='blog_title' :value="old('blog_title')"
            placeholder="Enter blog title" required />

        <x-backend.input-label :value="__('Blog Subtitle')" for="blog_subtitle" />
        <x-backend.input-field type="text" name="subtitle" id='blog_subtitle' :value="old('blog_subtitle')"
            placeholder="Enter blog subtitle" required />

        <x-backend.input-label :value="__('Author Name')" for="author_name" />
        <x-backend.input-field type="text" name="author_name" id='author_name' :value="old('author_name')"
            placeholder="Enter author name" required />

        <x-backend.input-label :value="__('Author Designation')" for="author_designation" />
        <x-backend.input-field type="text" name="author_designation" id='author_designation' :value="old('author_designation')"
            placeholder="Enter author designation" required />

        <x-backend.input-label :value="__('Author Image')" for="author_image" accept=".png, .jpg, .jpeg" />
        <x-backend.input-field type="file" name="author_image" id='author_image'
            class="block w-full text-sm text-gray-500
    file:me-4 file:py-2 file:px-4
    file:rounded-[4px] file:border-0
    file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
    file:disabled:opacity-50 file:disabled:pointer-events-none
      "/>

        <x-backend.input-label :value="__('Blog Slug')" for="blog_slug" />
        <x-backend.input-field type="text" name="slug" id='blog_slug' :value="old('blog_slug')"
            placeholder="Enter blog slug" required />
        <x-backend.input-label :value="__('Category')" for="category" />
        <x-backend.input-dropdown id="category" name="category_id" class="field" :values="$categories" :label_name="'category_name'"
            :label_id="'id'" :placeholder="'Select one'" selected='' required />

        <x-backend.input-label :value="__('Description')" for="description" />
        <x-backend.textEditor :id="'blog_create'" name='description' :form_id="'post-create'" />

        <x-backend.input-label :value="__('Upload Image')" for="upload_image" accept=".png, .jpg, .jpeg" />
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
        $('#post-edit-model').find('#blog_title').val(data.title);
        $('#post-edit-model').find('#blog_subtitle').val(data.subtitle);
        $('#post-edit-model').find('#author_name').val(data.author_name);
        $('#post-edit-model').find('#author_designation').val(data.author_designation);
        $('#post-edit-model').find('#blog_slug').val(data.slug);
        $('#post-edit-model').find('#category').val(data.category_id);

        editTextEditor.setContents(data.description);
        // Set the content of the editor
        let route = "{{ route('blog.posts.update', ':id') }}".replace(':id', data.id);
        $('#post-edit').attr('action', route);
    })
</script>
