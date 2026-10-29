<x-backend.model :id="'career-edit-model'" class="lg:max-w-2xl" :button="'Submit'" :form_id="'career-edit'" :action="route('career.career.store')" :title="'Edit Career'"
    :method="__('post')">
    @csrf
    @method('put')
    <div class="p-6 space-y-2">
        <x-backend.input-label :value="'Component field'" for="component" />
        <x-backend.input-dropdown id="component" name="category_id" class="field" :values="$categories" :label_name="'name'"
            :label_id="'id'" :placeholder="'Select one'" selected='' required />
        <x-backend.input-label :value="__('Job Title')" for="job_title" />
        <x-backend.input-field type="text" name="job_title" id='job_title' :value="old('job_title')"
            placeholder="Enter job title" />
        <x-backend.input-label :value="__('Sallery')" for="sallery" />
        <x-backend.input-field type="text" name="sallery" id='sallery' :value="old('sallery')"
            placeholder="Enter sallery" />
        <x-backend.input-label :value="__('Deadline')" for="deadline" />
        <x-backend.input-field type="date" name="deadline" id='deadline' :value="old('deadline')"
            placeholder="Enter deadline date" />
        <x-backend.input-label :value="__('Vacancy')" for="vacancy" />
        <x-backend.input-field type="number" name="vacancy" id='vacancy' :value="old('vacancy')"
            placeholder="Enter vacancy" />
        <x-backend.input-label :value="__('Job Type')" for="job_type" />
        <x-backend.input-field type="text" name="job_type" id='job_type' :value="old('job_type')"
            placeholder="Enter job type" />
        <x-backend.input-label :value="__('Location')" for="location" />
        <x-backend.input-field type="text" name="location" id='location' :value="old('location')"
            placeholder="Enter location" />
        <x-backend.input-label :value="__('Work Experience')" for="work_exp" />
        <x-backend.input-field type="text" name="work_exp" id='work_exp' :value="old('work_exp')"
            placeholder="Enter work experience" />
        <x-backend.input-label :value="'Short Description'" for="short_job_description" />
        <x-backend.input-field name="short_job_description" rows="4" id='short_job_description' :text="old('short_job_description')" placeholder="Enter short description" />
        <x-backend.input-label :value="__('Job Long Description')" for="long_description" />
        <x-backend.textEditor  :id="'long_description'"  name='long_description' :form_id="'career-edit'"  />
    </div>
</x-backend.model>



<script>
    $(document).on('click', '#update', function() {
        let data = $(this).attr('data');
        
        data = JSON.parse(data);
        
        $('#career-edit-model').find('#component').val(data.category_id);
        $('#career-edit-model').find('#work_exp').val(data.work_exp);
        $('#career-edit-model').find('#job_title').val(data.job_title);
        $('#career-edit-model').find('#deadline').val(data.deadline);
        $('#career-edit-model').find('#sallery').val(data.sallery);
        $('#career-edit-model').find('#vacancy').val(data.vacancy);
        $('#career-edit-model').find('#location').val(data.location);
        $('#career-edit-model').find('#job_type').val(data.job_type);
        $('#career-edit-model').find('#short_job_description').val(data.short_job_description);
        $('#career-edit-model').find('#long_description').val(data.long_description);
        editTextEditor.setContents(data.long_description);
        // Set the content of the editor
        let route = "{{ route('career.career.update', ':id') }}".replace(':id', data.id);
        $('#career-edit').attr('action', route);
    })
</script>
