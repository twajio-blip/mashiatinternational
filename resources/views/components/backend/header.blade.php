<header class="relative grid grid-cols-12 justify-between items-center w-full py-4">
    <!-- header left -->
    <section class="col-span-7">
        <ul class="flex items-center gap-4">
            <li class="md:hidden text-skin-hover">
                <x-backend.button class="sm-sidebar-trigger-btn" :icon="'fa-solid fa-bars'" :value="''" />
            </li>
            {{-- <li class="w-full hidden md:block">
                <div class="relative text-skin-backend-text-base">
                    <span class="absolute top-1/2 -translate-y-1/2 left-4"><i
                            class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="search" placeholder="Search For..."
                        class="w-full bg-skin-backend-secondary border border-default border-opacity-25 rounded-[10px] focus:outline-none focus:ring-0 focus:border-highlight pl-10 py-3 text-sm">
                </div>
            </li>  --}}
            <li class="relative w-fit overflow-hidden shrink-0 group rounded-[10px]">
                
                <a href="{{ url('/') }}" target="_blank"
                    class="text-xs text-skin-hover whitespace-nowrap border border-highlight rounded-[10px] p-2 space-x-2 focus:bg-skin-backend-accent focus:text-skin-invert focus:outline-none transition-colors duration-300 inline-block">
                    <i class="fa-solid fa-eye"></i> <span>Preview Webiste</span></a>
                    
                <a href="{{ url('/') }}" target="_blank" class="absolute bg-gradient-to-r from-[#2525251a] via-[#fdeb7277] to-[#2525251a] w-[calc(100%+200px)] h-[calc(100%+400px)] left-0 top-1/2 animate-glossy transition-all duration-1000"></a>
            </li>
        </ul>
    </section>
    <!-- header right -->
    <section class="col-span-5 ml-auto">
        <ul class="flex gap-3 sm:text-sm items-center text-skin-nav-hover-mute">
            {{-- Notification --}}
            @php
                $unseenNotification = $unseenNotification ?? 0;
                $notifications = $notifications ?? collect();
            @endphp
            <li class="hidden md:block group cursor-pointer container relative mx-3 text-skin-hover">
                <a href="{{ route('contact.index') }}">
                    <span class="text-[18px] {{ $unseenNotification == 0 ? 'text-skin-hover' : 'text-skin-hover' }}"><i
                            class="fa-solid fa-bell rotate-45"></i></span>
                    <span
                        class="{{ $unseenNotification == 0 ? 'hidden' : '' }} w-4 h-4 flex items-center justify-center rounded-full bg-red-500 text-white border border-default border-opacity-25 absolute left-full -translate-x-2 translate-y-1 top-0 text-[7.5px] text-center">{{ $unseenNotification > 100 ? '99+' : $unseenNotification }}</span>
                </a>
                <!-- Notification hover -->
                <div class="absolute top-full -right-4 pt-4 hidden group-hover:block">
                    <div class="relative before:absolute before:bottom-full before:right-5 before:w-0 before:h-0 before:border-[12px] before:border-transparent before:border-b-[#252525]">
                        <div class=" bg-skin-backend-secondary rounded-[10px] shadow-lg overflow-hidden">
                            <div class="sm:w-[400px] relative">
                                <ul
                                    class="max-h-[400px] overflow-y-auto scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-50">
                                    @forelse ($notifications as $notification) 
                                        <li>
                                            <a href="{{ $notification->redirect_url }}"
                                                class="flex gap-3 justify-between hover:bg-skin-backend-accent transition-colors px-4 py-4 hover:text-skin-invert">
                                                <div>
                                                    <span
                                                        class="w-12 h-12 rounded-full flex items-center justify-center bg-skin-backend-primary text-skin-hover"><i
                                                            class="fa-solid fa-exclamation"></i></span>
                                                </div>
        
                                                <div class="mr-auto">
                                                    <h2 class="text-base font-bold break-all line-clamp-1">
                                                        {{ $notification->title }}</h2>
                                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $notification->message }}
                                                    </p>
                                                </div>
        
                                                <div class="text-sm font-medium text-nowrap mt-0.5">
                                                    <p>{{ $notification->created_at->format('d-m-Y') }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <li class="px-4 py-4 text-sm text-gray-500 text-center">
                                            No notifications right now. Check back later!
                                        </li>
                                    @endforelse
        
                                </ul>
        
                                <a href="{{ route('notification.index') }}"
                                    class="w-full py-4 px-10 text-center inline-block sticky bottom-0 left-0 font-bold text-base border-t border-default border-opacity-25">View All</a>
                            </div>
        
                        </div>
                    </div>
                    
                </div>
                
            </li>
            {{-- Info --}}
            <li class="hidden md:block group cursor-pointer container relative mx-3 text-skin-hover">
                <a href="{{ route('contact.index') }}">
                    <span class="text-[18px] text-skin-hover"><i class="fa-solid fa-circle-question"></i></span>
                </a>
            </li>
            {{-- Setting --}}
            <li class="hidden md:block group cursor-pointer container relative mx-3 text-skin-hover">
                <a href="{{ route('theme-option.index') }}">
                    <span class="text-[18px] text-skin-hover"><i class="fa-solid fa-gear"></i></span>
                </a>
            </li>
            {{-- Account --}}
            <li class="relative cursor-pointer container w-6 sm:w-9 group lg:ml-12">
                <div class="w-[32px] h-[32px]">
                    <img src="{{ Auth::user()->image ? asset('images/' . Auth::user()->image) : asset('/defualt/user.png') }}"
                        alt="profile" class="rounded-full w-full  h-full object-cover object-center" />
                </div> 
                <!-- Account hover -->
                <div class="absolute top-full -right-4 pt-4 hidden group-hover:block">
                    <div class="relative min-w-[252px] bg-skin-backend-secondary rounded-[10px] shadow-lg before:absolute before:bottom-full before:right-5 before:w-0 before:h-0 before:border-[12px] before:border-transparent before:border-b-[#252525]">
                        <!-- Account header -->
                        <div class="py-4 px-2 flex items-center gap-4">
                            <img src="{{ Auth::user()->image ? asset('images/' . Auth::user()->image) : asset('/defualt/user.png') }}"
                                alt="profile" class="w-[40px] h-[40px] rounded-[13px]">
                            <div>
                                <h1 class="flex items-center gap-2 text-skin-hover text-[16px] font-[800]">
                                    {{ Auth::user()->name }}

                                </h1>
                                <p class="text-skin-backend-text-base text-[13px] hover:text-skin-hover"><a
                                        href="#">{{ Auth::user()->email }}</a></p>
                            </div>
                        </div>
                        <!-- Account body -->
                        <div> 
                            <ul class="font-semibold w-full text-[14px] text-skin-backend-text-base pb-2">
                                <li class="rounded-md text-skin-backend-base hover:text-skin-hover">
                                    <a href="{{ route('profile.index') }}"
                                        class="w-full text-start px-4 py-2 block rounded-md ">Profile</a>
                                </li>
                                <li class="hover:text-[#EA2621]">
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 flex items-center gap-2"><span><i
                                                    class="fa-solid fa-right-from-bracket"></i></span><span>Log
                                                out</span></a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
            </li>
        </ul>
    </section>
</header>
