<x-backend.model :id="'edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'faq-edit'" :action="route('faq.store')" :title="'Edit FAQ'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Question'" for="question" />
        <x-backend.input-field type="text" name="question" id='question' :value="old('question')"
            placeholder="Enter question" />

        <x-backend.input-label :value="'Answer'" for="ans" />
        <x-backend.input-textarea name="ans" rows="4" id='ans' :text="old('ans')"
            placeholder="Enter Answer" /> 
    </div>
</x-backend.model>


<script>
    $(document).on('click', '#update', function() {
        let data = $(this).attr('data');
        data = JSON.parse(data);
        $('#faq-edit').find('#question').val(data.question);
        $('#faq-edit').find('#ans').val(data.ans);

        let route = "{{ route('faq.update', ':id') }}".replace(':id', data.id);
        $('#faq-edit').attr('action', route)
    })
</script>
