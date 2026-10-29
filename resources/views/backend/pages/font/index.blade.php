<x-Deshboard-layout>

    <!-- =============================SMTP configuration=============================================== -->
    {{-- @dd($fonts) --}}
    <section class="py-10 space-y-4">
        <!-- Header -->
        <div class="space-y-2 max-w-[304px]">
            <h2 class="text-[24px] font-bold text-skin-backend-text-base">
                <a href="{{route('theme-option.index')}}" class="font-bold text-skin-backend-text-base">Settings</a> / <span class="text-skin-backend-text-base text-opacity-50">Fonts</span>
            </h2>
            <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                Customize the fonts used across your website to enhance readability and style.
            </p>
        </div> 
        <div class="w-full flex flex-wrap md:flex-nowrap items-start gap-4 text-skin-backend-text-base"> 
            <div class="w-full md:w-[40%] space-y-2">
                <h2 class="text-[18px] font-bold">Your Fonts</h2>
                <ul class="border border-default border-opacity-25 rounded-[10px] p-2 max-h-[400px] overflow-y-auto space-y-4">
                    @foreach ($fonts as $key => $font)
                    {{-- @dd($font) --}}
                        <li class="">
                            <input font="{{ $font }}" type="radio" id="{{ 'font' . $key }}" name="hosting"
                                value="{{ 'font' . $key }}" class="hidden peer font-card" required />
                            <label for="{{ 'font' . $key }}"
                                class="inline-flex flex-wrap md:flex-nowrap gap-4 items-center justify-between w-full p-5 text-skin-backend-text-base border border-default border-opacity-25 rounded-[4px] cursor-pointer bg-skin-backend-secondary peer-checked:border-highlight peer-checked:text-skin-hover hover:bg-[#323232]">
                                <div class="block text-center">
                                    <div class="w-full text-lg font-semibold">{{ $font->font_family }}</div>
                                </div>

                                <span
                                    class="inline-block bg-opacity-15 px-1.5 py-0.5 text-[11px] {{ $font->is_frontend == 1 ? 'bg-skin-backend-accent text-skin-hover' : 'bg-gray-500 text-gray-500' }} ml-auto">Website</span>
                                <span
                                    class="inline-block bg-opacity-15 px-1.5 py-0.5 text-[11px] {{ $font->is_backend == 1 ? 'bg-skin-backend-accent text-skin-hover' : 'bg-gray-500 text-gray-500' }} ">Admin</span>
                            </label>
                        </li>
                    @endforeach
                </ul> 
            </div>
            <form action="{{ route('font.store') }}" method="POST" class="w-full md:w-[60%] space-y-4">
                @csrf
                <h2 class="form-title text-[18px] font-bold">Create Fonts</h2>
                <div class="space-y-3">
                    <input type="hidden" id="font_id">
                    <div class="w-full">
                        <x-backend.input-label :value="'Font family'" for="font_family" />
                        <x-backend.input-field required  type="text" name="font_family" id='font_family' placeholder="Ex: 'Public Sans', serif" />
                    </div>
                    <div class="w-full">
                        <x-backend.input-label :value="'Font links'" for="font_links" />
                        <x-backend.input-textarea required name="font_links" rows="5" id='font_links' :text="''" placeholder="Write your code here..." />
                        <small class="text-[12px]">Give Embedded code from <a href="https://fonts.google.com/" add the target="_blank"
                                class="text-skin-hover">Google Fonts.</a></small>
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-[18px] font-bold">Make Active</h2>
                        <div class="flex items-center gap-2"> 
                            <x-backend.input-checkbox :value="'1'" :id="'is_frontend'" :label="'Website'" name="is_frontend"/>  

                            <x-backend.input-checkbox :value="'1'" :id="'is_backend'" :label="'Admin Panel'" name="is_backend"/>   
                        </div> 
                    </div>
                    <div class="button-container text-end space-x-2">
                        <button class="px-4 py-2 bg-skin-backend-accent text-skin-invert rounded-[10px] font-bold hover:bg-opacity-90 transition-opacity">Create</button> 
                    </div>
                </div> 
            </form>
        </div>
    </section>
</x-Deshboard-layout>

<script>
    $(document).ready(function() {
        $('.font-card').on('change', function() {
            if ($(this).is(':checked')) {
                // Parse the JSON string from the 'font' attribute
                var font = JSON.parse($(this).attr('font'));
                $('#font_id').val(font.id);
                
                $('#font_family').val(font.font_family);
                $('#font_links').val(font.font_links);
                if(font.is_frontend == 1){
                    $('#is_frontend').prop('checked', true);
                }else{
                    $('#is_frontend').prop('checked', false);
                }

                if(font.is_backend == 1){
                    $('#is_backend').prop('checked', true);
                }else{
                    $('#is_backend').prop('checked', false);
                }
                // Chnage form title
                $('.form-title').text('Update Font');

                // add more buttons
                $('.button-container').html(
                    `<span class="cancel-button cursor-pointer px-4 py-2 bg-skin-backend-secondary text-skin-backend-text-base rounded-[10px] font-bold hover:bg-opacity-90 transition-opacity">Cancel</span>`
                );
                $('.button-container').append(
                    `<span class="delete-button cursor-pointer px-4 py-2 bg-red-500 text-skin-backend-text-base rounded-[10px] font-bold hover:bg-opacity-90 transition-opacity">Delete</span>`
                );
                $('.button-container').append(
                    `<button class="px-4 py-2 bg-skin-backend-accent text-skin-invert rounded-[10px] font-bold hover:bg-opacity-90 transition-opacity">Update</button>`);


                $('form').attr('action', '{{ route('font.update', ':id') }}'.replace(':id', font.id));
                $('form').append('<input type="hidden" name="_method" value="PUT" class="input_put">');

            }
        });

        $(document).on('click', '.cancel-button', function() {
            // Clear input values
            $('#font_family').val('');
            $('#font_links').val('');

            // Change form title
            $('.form-title').text('Create Font');

            // Replace buttons in the button container
            $('.button-container').html(
                `<button type="submit" class="px-4 py-2 bg-[#5A6ACF] text-white font-bold">Create</button>`
            );
            $('#is_frontend').prop('checked', false);
            $('#is_backend').prop('checked', false);
            // Set form action to the 'store' route
            $('form').attr('action', '{{ route('font.store') }}');

            // Remove input fields with the class 'input_put'
            $('.input_put').remove();

            $('input[type="radio"]').prop('checked', false);
        }); 

        $(document).on('click', '.delete-button', function() {
            // Confirm the delete action
            if (confirm('Are you sure you want to delete this item?')) {
                var font_id = $('#font_id').val();
                // Set the form action dynamically
                $('form').attr('action', '{{ route('font.destroy', ':id') }}'.replace(':id', font_id));

                // Remove any existing input fields with the class 'input_put'
                $('.input_put').remove();

                // Append a hidden input field to indicate the DELETE request
                $('form').append('<input type="hidden" name="_method" value="DELETE" class="input_put">');
                // Submit the form if the user confirms
                $('form').submit();
            }
        }); 
    });
</script>
