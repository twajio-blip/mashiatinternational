<x-Deshboard-layout>
    <div class="space-y-4 py-10 text-skin-backend-text-base">
        <!-- content header -->
        <div class="space-y-2 max-w-[304px] text-skin-backend-text-base">
            <h2 class="text-[24px]">
                <a href="{{ route('dashboard') }}" class="font-bold text-skin-backend-text-base">Dashboard</a> / <span
                    class="text-skin-backend-text-base text-opacity-50">Profile</span>
            </h2>
            <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                View and update your personal information and account settings. 
            </p>
        </div> 

        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" id='profile-form'
            enctype="multipart/form-data" class="grid grid-cols-12 gap-4">
            @csrf
            @method('PATCH')
            <div
                class="col-span-12 md:col-span-4 border border-default border-opacity-25 rounded-[10px] px-4 py-4 flex items-center justify-center bg-skin-backend-secondary">
                <div class="text-center">
                    <div class="relative">
                        <img id="show_profile_pic"
                        src="{{ Auth::user()->image ? asset('images/' . Auth::user()->image) : asset('/defualt/user.png') }}"
                        alt="profile-pic" class="w-40 h-40 object-cover rounded-full mx-auto">
                        <span class="w-4 h-4 rounded-full bg-green-500 absolute bottom-2 right-6"></span>
                    </div>
                    
                    <h2 class="text-[18px] mt-4 font-bold">{{Auth::user()->name}}</h2>
                    <h2 class="text-[14px] text-skin-backend-text-base text-opacity-50">{{Auth::user()->email}}</h2>
                </div>
                
            </div>
            <div class="col-span-12 md:col-span-8 border border-default border-opacity-25 rounded-[10px] px-4 py-4">
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Name'" for="name" />
                    <x-backend.input-field type="text" name="name" id='name' :value="Auth::user()->name"
                        placeholder="Name" />

                    {{-- <label for="name" class="text-sm text-skin-backend-heading">Name</label>
            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                class="w-full rounded-md text-skin-backend-base bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                placeholder="Name"> --}}
                </div>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Email'" for="email" />
                    <x-backend.input-field type="email" name="email" id='email' :value="Auth::user()->email"
                        placeholder="Email" />
                    {{-- <label for="email" class="text-sm text-skin-backend-heading">Email</label>
            <input type="text" id="email" name="email" value="{{ Auth::user()->email }}"
                class="w-full rounded-md text-skin-backend-base bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                placeholder="Email"> --}}
                </div>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Password'" for="password" />
                    <x-backend.input-field type="password" name="password" id='password' :value="''"
                        placeholder="Password" />

                    {{-- <label for="pass" class="text-medium text-skin-backend-heading">Password</label>
            <input type="text" id="pass" name="password" value=""
                class="w-full rounded-md text-skin-backend-base bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                placeholder="Password"> --}}
                </div>
                @error('pass')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Confirm Password'" for="confirm_password" />
                    <x-backend.input-field type="password" name="confirm_password" id='confirm_password'
                        :value="''" placeholder="Confirm Password" />

                    {{-- <label for="confirm_password" class="text-medium text-skin-backend-heading">Confirm Password</label>
            <input type="text" id="confirm_password" name="confirm_password" value=""
                class="w-full rounded-md text-skin-backend-base bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                placeholder="Password"> --}}
                </div>
                @error('confirm_password')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="__('Profile Picture (Ratio 1:1 (500x500)Px)')" for="profile_picture" />
                    <x-backend.input-field type="file" name="image" id='profile_picture'
                        class="block w-full text-sm text-gray-500
            file:me-4 file:py-2 file:px-4
            file:rounded-[4px] file:border-0
            file:text-sm file:font-semibold file:w-[90px] file:h-[90px] file:bg-placeholder file:bg-cover file:bg-center file:text-transparent
            file:disabled:opacity-50 file:disabled:pointer-events-none "
                        value="{{ Auth::user()->user_photo }}" />

                    {{-- <label for="profile_picture" class="text-sm text-skin-backend-heading">Profile Picture<span
                    class="text-skin-backend-hover">Ratio 1:1 (500x500)Px</span></label>

            <div class="flex items-center rounded-md relative cursor-pointer text-skin-backend-base ">
                <label for="photo"
                    class="cursor-pointer absolute rounded-l-md top-1/2 left-[1px] -translate-y-1/2 bg-slate-800 border-r px-4 py-2 w-32 h-[95%] text-sm flex items-center text-white">Choose
                    File</label>
                <input readonly type="text"
                    class="check_files cursor-pointer w-full h-full rounded-md bg-skin-backend-highlight border border-gray-300 px-4 pl-[8.8rem] py-2.5 focus:outline-none focus:ring-0 focus:border-backend-highlight transition-colors duraiton-300 open-file"
                    placeholder="No File Chosen" data-modal-target="default-modal"
                    data-modal-toggle="default-modal" input_field="photo" input_type="file" />
                <input type="file" class="hidden" id="photo" value="{{ Auth::user()->user_photo }}"
                    name="image">
            </div> --}}

                </div>
            </div>

            <div class="col-span-12 text-end">
                <button type="submit"
                    class="px-12 py-3 bg-skin-backend-accent text-skin-invert rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Submit</button>
            </div>
        </form> 

        <x-backend.server-error :form_id="'profile-form'" :request_form="'Profile\ProfileRequest'" />
    </div> 

    <script>
        $(document).on('click', '.open-file', function() {
            $('#photo').click();
        })
    </script>

    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>
