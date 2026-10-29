<x-backend.model :id="'create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'company-create'" :action="route('company.store')" :title="'Create Company'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Name'" for="name" />
        <x-backend.input-field type="text" name="name" id='name' :value="old('name')"
            placeholder="Enter name" />

        <x-backend.input-label :value="'url'" for="url" />
        <x-backend.input-field type="text" name="url" id='url' :value="old('url')"
            placeholder="Enter url" />

        <x-backend.input-label :value="'Question'" for="upload_image" />
        <x-backend.input-field type="file" name="image" id='upload_image'
            class="block w-full text-sm text-gray-500
    file:me-4 file:py-2 file:px-4
    file:rounded-[4px] file:border-0
    file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
    file:disabled:opacity-50 file:disabled:pointer-events-none
  " /> 
    </div>
</x-backend.model>
