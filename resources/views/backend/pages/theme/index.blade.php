<x-Deshboard-layout>

    <!-- Table Section -->
    <div class="py-10 space-y-4"> 
        <!-- Header -->
        <div class="space-y-2 max-w-[304px]">
            <h2 class="text-[24px] font-bold text-skin-backend-text-base">
                <a href="{{route('theme-option.index')}}" class="font-bold text-skin-backend-text-base">Settings</a> / <span class="text-skin-backend-text-base text-opacity-50">Website Setting</span>
            </h2>
            <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                Configure your website’s general details, social media links, footer navigation, and upload your brand logo—all in one place.
            </p>
        </div>  
        <!-- End Header -->  

        <div class=" sm:grid grid-cols-12 text-skin-backend-text-base">
            {{-- nav --}}
            <div class="sidebar-nav-container col-span-12 w-full flex flex-wrap items-center"> 
                <button target='general' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-skin-hover text-sm relative before:absolute before:w-full before:h-[2px] before:bg-skin-backend-accent before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">General</button>
                <button target='social' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-sm relative before:absolute before:w-full before:h-[2px] before:bg-[#eaeaea] before:bg-opacity-25 before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">Social Link</button>
                <button target='footer' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-sm relative before:absolute before:w-full before:h-[2px] before:bg-[#eaeaea] before:bg-opacity-25 before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">Footer Link</button>
                <button target='logo' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-sm relative before:absolute before:w-full before:h-[2px] before:bg-[#eaeaea] before:bg-opacity-25 before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">Logo</button> 
            </div>
            {{-- nav end --}}
            <div class="col-span-12 sm:p-3  pt-4 "> 
                <div id='general' class="space-y-3  status">
                    <form action="{{ route('theme-option.contact') }}" method="post" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">General Information</h2>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Website Name'" for="website_name" />
                                <x-backend.input-field type="text" name="website_name" id='website_name' :value="$general?->website_name"
                                    placeholder="Contact Number" required />
                                {{-- <label for="for" class="text-sm ">Website Name</label>
                                <input type="text" name="website_name" value="{{ $general?->website_name }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                    placeholder="Contact Number" required> --}}
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Contact Number'" for="contact" />
                                <x-backend.input-field type="text" name="contact" id='contact' :value="$general?->contact"
                                    placeholder="Contact Number" required />
                                {{-- <label for="for" class="text-sm ">Contact Number</label>
                                <input type="text" name="contact" value="{{ $general?->contact }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                    placeholder="Contact Number" required> --}}
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Email'" for="email" />
                                <x-backend.input-field type="email" name="email" id='email' :value="$general?->email"
                                    placeholder="Email" required />
                                {{-- <label for="for" class="text-sm ">Email</label>
                                <input type="text" name="email" value="{{ $general?->email }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Email" required> --}}
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Location'" for="location" />
                                <x-backend.input-field type="text" name="location" id='location' :value="$general?->location"
                                    placeholder="Location" required />
                                {{-- <label for="for" class="text-sm ">Location </label>
                                <input type="text" name="location" value="{{ $general?->location }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Location" required> --}}
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Description'" for="description" />
                                <x-backend.input-textarea type="text" name="description" id='description' :text="$general?->description"
                                    placeholder="Location" required />
                                {{-- <label for="for" class="text-sm ">Description </label>
                                <textarea name="description"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    rows="3" placeholder="Description" required>{{ $general?->description }}</textarea> --}}
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">Google Analytics</h2> 
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Google Analytics'" for="google_analytics" />
                                <x-backend.input-field type="text" name="google_analytics" id='google_analytics' :value="$general?->google_analytics"
                                    placeholder="Google Analytics" />
                                {{-- <label for="google_analytics" class="text-sm ">Google Analytics</label>
                                <input id="google_analytics" type="text" name="google_analytics" value="{{$general?->google_analytics}}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                    placeholder="Google Analytics"> --}}
                            </div>

                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">Cookie Content</h2>
                            <div class="col-span-12">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input name="applyCookie" type="checkbox" value="true"
                                        class="cookie-switch sr-only peer"
                                        {{ $general?->cookie_title ? 'checked' : '' }}>
                                    <div
                                        class="relative w-11 h-6 bg-skin-backend-secondary peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-default after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-default after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-skin-backend-accent">
                                    </div>
                                    <span class="cookie-switch-label ms-3 text-sm">Enable
                                        Cookie</span>
                                </label>
                            </div>
                            <div class="cookie-form {{ $general?->cookie_title ? '' : 'hidden' }}  col-span-12 grid grid-cols-12 gap-4">
                                @if ($general?->cookie_title)
                                    <div class="col-span-12 md:col-span-6">
                                        <x-backend.input-label :value="'Cookie Title'" for="cookie_title" />
                                        <x-backend.input-field type="text" name="cookie_title" id='cookie_title' :value="$general?->cookie_title"
                                            placeholder="Cookie Title" required />
                                        {{-- <label for="for" class="text-sm ">Cookie Title</label>
                                        <input type="text" name="cookie_title" value="{{ $general?->cookie_title }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                            placeholder="Cookie Title" required> --}}
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <x-backend.input-label :value="'Cookie Description'" for="cookie_description" />
                                        <x-backend.input-field type="text" name="cookie_description" id='cookie_description' :value="$general?->cookie_description"
                                            placeholder="Cookie Description" required />
                                        {{-- <label for="for" class="text-sm ">Cookie Description</label>
                                        <input type="text" name="cookie_description"
                                            value="{{ $general?->cookie_description }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            placeholder="Cookie Description" required> --}}
                                    </div>
                                @endif

                            </div>

                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">reCAPTCHA Settings</h2>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Site Key'" for="sitekey" />
                                <x-backend.input-field type="text" name="sitekey" id='sitekey' :value="env('NOCAPTCHA_SITEKEY')"
                                    placeholder="Site Key"/>
                                {{-- <label for="sitekey" class="text-sm ">Site Key</label>
                                <input id="sitekey" type="text" name="sitekey" value="{{env('NOCAPTCHA_SITEKEY')}}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                    placeholder="Site Key"> --}}
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Secret Key'" for="secretkey" />
                                <x-backend.input-field type="text" name="secretkey" id='secretkey' :value="env('NOCAPTCHA_SECRET')"
                                    placeholder="Secret Key"/>
                                {{-- <label for="secretkey" class="text-sm ">Secret Key</label>
                                <input id="secretkey" type="text" name="secretkey" value="{{env('NOCAPTCHA_SECRET')}}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                    placeholder="Secret Key"> --}}
                            </div>
                        </div>
                        <div class="py-4 text-end">
                            <button type="submit"
                                class="px-6 py-2 text-sm font-semibold bg-skin-backend-accent rounded-[10px] text-skin-invert hover:bg-opacity-90 transition-opacity">Submit</button>
                        </div>
                    </form>
                </div>
                <div id='social' class="space-y-3 hidden status">
                    <form action="{{ route('theme-option.social') }}" method="post" class="space-y-6">
                        @csrf
                        @php

                            $data = json_decode($general->social??'[]');
                        @endphp
                        <h2 class="text-[18px] font-bold">Socila Link</h2>
                        <div class=" add-social space-y-6">
                            @foreach ($data as $item)
                                <div class="relative bg-skin-backend-secondary rounded-[10px]">
                                    <div class="relative space-y-4 sm:space-y-0 sm:grid grid-cols-12 gap-4 p-5 pt-14">
                                        <span
                                            class='absolute top-6 right-4 itemremove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'><i
                                                class="fa-solid fa-trash"></i></span>
                                        <div class="col-span-12 md:col-span-6">
                                            <x-backend.input-label :value="'Name'" for="social_name" />
                                            <x-backend.input-field type="text" name="name[]" id="social_name" :value="$item['2']"
                                                placeholder="Enter Name" required /> 
                                        </div>
                                        <div class="col-span-12 md:col-span-6">
                                            <x-backend.input-label :value="'Icone'" for="social_icon" />
                                            <x-backend.input-field type="text" name="icone[]" id="social_icon" :value="$item['0']"
                                                placeholder="Enter Icone" required />
                                        </div>
                                        <div class="col-span-12">
                                            <x-backend.input-label :value="'Link'" for="social_link" />
                                            <x-backend.input-field type="text" name="link[]" id="social_link" :value="$item['1']"
                                                placeholder="Enter Link" required /> 
                                        </div>
                                        {{-- <label for="for" class="text-sm ">Name</label> 
                                        <input type="text"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Enter Name" name="name[]" value="{{ $item['2'] }}"
                                        required> --}} 
                                        {{-- <label for="for" class="text-sm ">icone</label>
                                        <input type="text" name="icone[]"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            placeholder="Enter icone" value="{{ $item['0'] }}" required> --}}
                                        {{-- <label for="for" class="text-sm ">Link</label>
                                        <input type="text" name="link[]"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            placeholder="Enter link" value="{{ $item['1'] }}" required> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>  
                        <div class="flex flex-wrap justify-center items-center gap-4 sm:justify-between">
                            <button type="button"
                                class="add-more px-12 py-2.5 text-skin-hover border border-highlight rounded-[10px] hover:bg-skin-backend-accent hover:text-skin-invert transition-colors font-semibold text-xs disabled:opacity-50 disabled:pointer-events-none"><i class="fa-solid fa-plus"></i> Add
                                More</button>
                            <button type="submit"
                                class="px-12 py-2.5 bg-skin-backend-accent text-skin-invert border border-highlight rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Submit
                            </button>
                        </div>

                    </form>
                </div>
                <div id='footer' class="hidden status">
                    <h2 class="text-[18px] font-bold py-6">Footer Link</h2>
                    <div class="md:w-1/2">
                        <x-backend.input-label :value="'Number of Group'" for="footer-group-input" />
                        <x-backend.input-field type="number" id='footer-group-input'
                            placeholder="Enter no of groups" min="0" step="1" :value="count($footerGroups)"/>
                        {{-- <input type="number" min="0" step="1" id="footer-group-input"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                placeholder="Enter no of groups"> --}}
                    </div>
                    <form action="{{ route('theme-option.footer') }}" method="post">
                        @csrf
                        @php
                            $data = json_decode($general->social??'[]');
                        @endphp
                        <div class="footer-group-container space-y-4">
                            {{-- @dd($footerGroup->all()) --}}
                            @foreach ($footerGroups as $groupIndex => $footerGroup)
                                @php $groupNum = $groupIndex + 1; @endphp
                                {{-- footer group --}}
                                <div id="group_{{ $groupNum }}" class="footer-group grid grid-cols-12 gap-4">
                                    <div class="col-span-12 relative group_id sm:w-1/2 py-3">
                                        <h2 class="font-semibold group_name">Group {{ $groupNum }}</h2>
                                        <span class='absolute top-1/2 -translate-y-1/2  right-6 group_remove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'>
                                            <i class="fa-solid fa-trash"></i>
                                        </span>
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <x-backend.input-label :value="'Group Name'" for="groupName" />
                                        <x-backend.input-field type="text" name="groupName[]" id='groupName' :value="$footerGroup->name"
                                            placeholder="Enter Group Name" required />

                                        {{-- <div class="relative">
                                            <label for="for" class="text-sm ">Group Name</label>
                                        </div>
                                        <input type="text"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            placeholder="Enter Group Name" name="groupName[]" required value='{{$footerGroup->name}}'> --}}
                                    </div>
                                    <div class="col-span-12 grid grid-cols-12 gap-4 footer-link-container">
                                        {{-- @dd($footerGroup->details) --}}
                                        @foreach ($footerGroup->details ?? [] as $linkIndex => $detail)
                                            <div class="footer-link col-span-12 md:col-span-6">
                                                <h2 class="font-semibold link_name">link {{ $linkIndex + 1 }}</h2>
                                                <div class="relative bg-skin-backend-secondary rounded-[10px]">
                                                    <div class="relative space-y-4 sm:space-y-0 sm:grid grid-cols-12 gap-4 p-5 pt-14">
                                                    <span
                                                            class='absolute top-6 right-4 link-remove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'><i
                                                                class="fa-solid fa-trash"></i></span>
                                                    <div class="col-span-12 md:col-span-6">
                                                        <x-backend.input-label :value="'Name'" for="link_name" />
                                                        <x-backend.input-field type="text"
                                                        name="linkName[{{ $groupNum }}][]"
                                                         id="link_name" :value="$detail->name ?? ''"
                                                            placeholder="Enter Name" required />
                                                    </div>
                                                    <div class="col-span-12 md:col-span-6">
                                                        <x-backend.input-label :value="'Icon'" for="link_icon" />
                                                        <x-backend.input-field type="text"
                                                        name="linkIcon[{{ $groupNum }}][]"
                                                         id="link_icon" :value="$detail->icon ?? ''"
                                                            placeholder="Enter Icone" required />
                                                    </div>
                                                    <div class="col-span-12">
                                                        <x-backend.input-label :value="'Link'" for="link_url" />
                                                        <x-backend.input-field type="text"
                                                        name="linkUrl[{{ $groupNum }}][]"
                                                         id="link_url" :value="$detail->url ?? ''"
                                                            placeholder="Enter Link" required /> 
                                                    </div>
                                                    {{-- <label for="for" class="text-sm ">Name</label>
                                                    <input type="text"
                                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                        placeholder="Enter Name" name="linkName[${groupId}][]" required value="{{$detail->name}}">

                                                    <label for="for" class="text-sm ">Icon</label>
                                                    <input type="text"
                                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                        placeholder="Enter link" name="linkIcon[${groupId}][]" value="{{$detail->icon}}">
                                    
                                                    <label for="for" class="text-sm ">Link</label>
                                                    <input type="text"
                                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                        placeholder="Enter link" name="linkUrl[${groupId}][]" required value="{{$detail->url}}"> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                    </div>
                                    <div class="col-span-12">
                                        <span class="footer-new-link-button px-12 py-2.5 text-skin-hover border border-highlight rounded-[10px] hover:bg-skin-backend-accent hover:text-skin-invert transition-colors font-semibold text-xs disabled:opacity-50 disabled:pointer-events-none  cursor-pointer"><i class="fa-solid fa-plus"></i> Add new link</span>
                                    </div>
                                </div>
                                {{-- footer group --}}
                            @endforeach
                            
                        </div>
                        <div class="text-end py-5 sm:py-0">
                            <button type="submit" class="px-12 py-3 bg-skin-backend-accent text-skin-invert rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Save</button>
                        </div>
                    </form>
                </div>
                <div id='logo' class=" hidden status">
                    <h2 class="text-[18px] font-bold py-6">Logo</h2>
                    <div class="">
                        <form action="{{ route('theme-option.logo') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-12 gap-4">
                                <div
                                    class="w-full col-span-12 md:col-span-4 space-y-10 flex flex-col justify-between border border-default border-opacity-25 rounded-[4px] bg-skin-backend-secondary overflow-hidden">
                                    <label for="for"
                                        class="bg-skin-backend-accent px-4 py-2 font-bold w-full inline-block text-skin-invert">Fav
                                        Icon</label>
                                        <div class="px-4 pb-2">
                                            <img src="{{ asset('images/' . ($general->fav_icon ?? 'placeholder.png')) }}"
                                            alt="" class="mx-auto  h-[45px] object-cover object-center">
                                        </div>
                                        <div class="px-4 pb-2">
                                            <input type="file" name="fav_icon"
                                            class="upload-profile-pic cursor-pointer relative border border-default border-opacity-25 rounded-[4px] w-full pl-[28px] pr-4 py-2.5 transition-colors focus:border-highlight focus:outline-none text-sm before:text-skin-invert before:rounded-[4px] before:border before:border-default before:absolute before:top-1/2 before:-translate-y-1/2 before:left-2 before:w-[110px] before:h-[80%] before:bg-[#B3B3B3] before:flex before:items-center before:justify-center before:content-['Choose_File']">
                                        </div> 
                                </div>
                                <div
                                class="w-full col-span-12 md:col-span-4 space-y-10 flex flex-col justify-between border border-default border-opacity-25 rounded-[4px] bg-skin-backend-secondary overflow-hidden">
                                    <label for="for"
                                    class="bg-skin-backend-accent px-4 py-2 font-bold w-full inline-block text-skin-invert">Header
                                        logo</label>
                                        <div class="px-4 pb-2">
                                            <img src="{{ asset('images/' . ($general->header ?? 'placeholder.png')) }}"
                                            alt="" class="mx-auto  h-[45px] object-cover object-center">
                                        </div>
                                        <div class="px-4 pb-2">
                                            <input type="file" name="header"
                                            class="upload-profile-pic cursor-pointer relative border border-default border-opacity-25 rounded-[4px] w-full pl-[28px] pr-4 py-2.5 transition-colors focus:border-highlight focus:outline-none text-sm before:text-skin-invert before:rounded-[4px] before:border before:border-default before:absolute before:top-1/2 before:-translate-y-1/2 before:left-2 before:w-[110px] before:h-[80%] before:bg-[#B3B3B3] before:flex before:items-center before:justify-center before:content-['Choose_File']">
                                        </div>
                                    
                                </div>
                                <div
                                class="w-full col-span-12 md:col-span-4 space-y-10 flex flex-col justify-between border border-default border-opacity-25 rounded-[4px] bg-skin-backend-secondary overflow-hidden">
                                    <label for="for"
                                    class="bg-skin-backend-accent px-4 py-2 font-bold w-full inline-block text-skin-invert">Footer
                                        logo</label>
                                    <div class="px-4 pb-2">
                                        <img src="{{ asset('images/' . ($general->footer ?? 'placeholder.png')) }}"
                                        alt="" class="mx-auto h-[45px] object-cover object-center">
                                    </div>
                                    <div class="px-4 pb-2">
                                        <input type="file" name="footer"
                                        class="upload-profile-pic cursor-pointer relative border border-default border-opacity-25 rounded-[4px] w-full pl-[28px] pr-4 py-2.5 transition-colors focus:border-highlight focus:outline-none text-sm before:text-skin-invert before:rounded-[4px] before:border before:border-default before:absolute before:top-1/2 before:-translate-y-1/2 before:left-2 before:w-[110px] before:h-[80%] before:bg-[#B3B3B3] before:flex before:items-center before:justify-center before:content-['Choose_File']">
                                    </div> 
                                </div>
                            </div>
                            <div class="mt-6 text-center">
                                <button type="submit"
                                    class="px-24 py-2.5 bg-skin-backend-accent text-skin-invert border border-highlight rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Submit
                                </button>
                            </div>
                        </form>

                    </div>
                </div> 
            </div> 
        </div> 
        <!-- End Card -->
    </div>

    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>

<script>

    // footer link: when group qty changes, add or remove from end only (keep existing data)
    $('#footer-group-input').on('change', function(){
        let numOfGroups = parseInt($(this).val(), 10) || 0;
        let $container = $('.footer-group-container');
        let currentCount = $container.children().length;
        if (numOfGroups > currentCount) {
            for (let i = currentCount; i < numOfGroups; i++) {
                let groupNum = i + 1;
                $container.append(`<div id="group_${groupNum}" class="footer-group grid grid-cols-12 gap-4">
                                <div class="col-span-12 relative group_id sm:w-1/2 py-3">
                                    <h2 class="font-semibold group_name">Group ${groupNum}</h2>
                                    <span class='absolute top-1/2 -translate-y-1/2  right-6 group_remove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'>
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                </div>
                                <div class="col-span-12 md:col-span-6">
                                    <x-backend.input-label :value="'Group Name'" for="groupName" />
                                    <x-backend.input-field type="text" name="groupName[]" id='groupName' placeholder="Enter Group Name" required />
                                </div>
                                <div class="col-span-12 grid grid-cols-12 gap-4 footer-link-container">
                                </div>
                                <div class="col-span-12">
                                    <span class="footer-new-link-button px-12 py-2.5 text-skin-hover border border-highlight rounded-[10px] hover:bg-skin-backend-accent hover:text-skin-invert transition-colors font-semibold text-xs disabled:opacity-50 disabled:pointer-events-none cursor-pointer"><i class="fa-solid fa-plus"></i> Add new link</span>
                                </div>
                            </div>`);
            }
        } else if (numOfGroups < currentCount && numOfGroups >= 0) {
            $container.children().slice(numOfGroups).remove();
            footerRenumberGroups();
        }
    });

    function footerRenumberGroups() {
        $('.footer-group-container').children().each(function(i) {
            let n = i + 1;
            let $g = $(this);
            $g.attr('id', 'group_' + n);
            $g.find('.group_name').text('Group ' + n);
            $g.find('.footer-link-container input[name*="linkName"]').attr('name', 'linkName[' + n + '][]');
            $g.find('.footer-link-container input[name*="linkIcon"]').attr('name', 'linkIcon[' + n + '][]');
            $g.find('.footer-link-container input[name*="linkUrl"]').attr('name', 'linkUrl[' + n + '][]');
        });
    }
    
    $(document).on('click','.footer-new-link-button', function(){
        groupId = $(this).closest('.footer-group').attr('id').match(/\d+/g);
        let linkNo =  $(this).closest('.footer-group').find('.footer-link-container').children().length;
        $(this).closest('.footer-group').find('.footer-link-container').append(`<div class="footer-link col-span-12 md:col-span-6">
            <h2 class="font-semibold link_name">link ${linkNo+1}</h2>
            <div class="relative bg-skin-backend-secondary rounded-[10px]">
                <div class="relative space-y-4 sm:space-y-0 sm:grid grid-cols-12 gap-4 p-5 pt-14">

                <span class='absolute top-6 right-4 link-remove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'><i class="fa-solid fa-trash"></i></span>
                

                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Name'" for="link_name" />
                    <x-backend.input-field type="text" name="linkName[${groupId}][]" id="link_name" 
                        placeholder="Enter Name" required /> 
                </div>
                <div class="col-span-12 md:col-span-6">
                    <x-backend.input-label :value="'Icon'" for="link_icon" />
                    <x-backend.input-field type="text" name="linkIcon[${groupId}][]" id="link_icon" 
                        placeholder="Enter Icone" required />
                </div>
                <div class="col-span-12">
                    <x-backend.input-label :value="'Link'" for="link_url" />
                    <x-backend.input-field type="text" name="linkUrl[${groupId}][]" id="link_url" 
                        placeholder="Enter Link" required /> 
                </div> 
            </div>
        </div>`)
    });
    // footer link
    

    $(document).on('click', '.sidebar', function() {
        let id = $(this).attr('target');

        $(this).closest('.sidebar-nav-container').find('.sidebar').removeClass('text-skin-hover before:bg-skin-backend-accent').addClass('before:bg-[#eaeaea] before:bg-opacity-25');
        $(this).addClass('text-skin-hover before:bg-skin-backend-accent').removeClass('before:bg-[#eaeaea] before:bg-opacity-25');

        $('.status').hide();
        $('#' + id).show();

    })
    $(document).on('click', '.add-more', function() {
        let element = `  <div class=" add-social space-y-6">
                            <div class="relative bg-skin-backend-secondary rounded-[10px]">
                                <div class="relative grid grid-cols-12 gap-4 p-5 pt-14">

                                    <span
                                        class='absolute top-6 right-4 itemremove size-7 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-red-200 bg-red-600 disabled:opacity-50 disabled:pointer-events-none cursor-pointer'><i
                                            class="fa-solid fa-trash"></i></span>
                                    <div class="col-span-12 md:col-span-6">
                                        <x-backend.input-label :value="'Name'" for="social_name" />
                                        <x-backend.input-field type="text" name="name[]" id="social_name"
                                            placeholder="Enter Name" required /> 
                                    </div>
                                    <div class="col-span-12 md:col-span-6">
                                        <x-backend.input-label :value="'Icone'" for="social_icon" />
                                        <x-backend.input-field type="text" name="icone[]" id="social_icon"
                                            placeholder="Enter Icone" required />
                                    </div>
                                    <div class="col-span-12">
                                        <x-backend.input-label :value="'Link'" for="social_link" />
                                        <x-backend.input-field type="text" name="link[]" id="social_link"
                                            placeholder="Enter Link" required />  
                                </div>
                            </div>
                        </div>`;
        $('.add-social').append(element)

    })
    $(document).on('click', '.itemremove', function() {
        $(this).parents('.relative').remove();
    })

    $(document).on('submit', '#delete', function() {
        let con = confirm('Are you sure to Delete it')
        if (con) {

            return true;

        } else {
            return false;
        }

    })
    $('.cookie-switch').on('change', function() {
        if ($(this).is(':checked')) {
            $('.cookie-form').html(`<div class="grid grid-cols-12 gap-4">
                                        <div class="col-span-12 md:col-span-6">
                                            <x-backend.input-label :value="'Cookie Title'" for="cookie_title" />
                                            <x-backend.input-field type="text" name="cookie_title" id='cookie_title' :value="$general?->cookie_title"
                                                placeholder="Cookie Title" required />
                                            {{-- <label for="for" class="text-sm ">Cookie Title</label>
                                            <input type="text" name="cookie_title" value="{{ $general?->cookie_title }}"
                                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none "
                                                placeholder="Cookie Title" required> --}}
                                        </div>
                                        <div class="col-span-12 md:col-span-6">
                                            <x-backend.input-label :value="'Cookie Description'" for="cookie_description" />
                                            <x-backend.input-field type="text" name="cookie_description" id='cookie_description' :value="$general?->cookie_description"
                                                placeholder="Cookie Description" required />
                                            {{-- <label for="for" class="text-sm ">Cookie Description</label>
                                            <input type="text" name="cookie_description"
                                                value="{{ $general?->cookie_description }}"
                                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                                placeholder="Cookie Description" required> --}}
                                        </div>
                                    </div>`).slideDown(200);
            $('.cookie-switch-label').text('Disable Cookie');
        } else {
            $('.cookie-form').slideUp(200).delay(200).html('');
            $('.cookie-switch-label').text('Enable Cookie');
        }
    })

    // Group Remove
    $(document).on('click', '.group_remove', function () {
        $(this).closest('.footer-group').remove();
        footerRenumberGroups();
        $('#footer-group-input').val($('.footer-group-container').children().length);
    });
    // Link Remove
    $(document).on('click', '.link-remove', function () {
        const container = $(this).closest('.footer-link-container');
        // Remove the clicked link
        $(this).closest('.footer-link').remove();
        // Renumber remaining links
        container.children().each(function (i) {
            $(this).find('.link_name').text(`Link ${i + 1}`);
        });
    });

</script>
