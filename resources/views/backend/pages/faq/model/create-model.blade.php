<x-backend.model :id="'create-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'faq-create'" :action="route('faq.store')" :title="'Create FAQ'"
    :method="__('post')">
    @csrf
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Question'" for="question" />
        <x-backend.input-field type="text" name="question" id='question' :value="old('question')"
            placeholder="Enter question" />

        <x-backend.input-label :value="'Answer'" for="ans" />
        <x-backend.input-textarea name="ans" rows="4" id='ans' :text="old('ans')"
            placeholder="Enter Answer" /> 
    </div>
</x-backend.model>
