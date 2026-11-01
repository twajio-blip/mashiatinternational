<ul
    class="sidebar-nav pb-4 md:py-4 mt-4 text-white text-[14px] bg-skin-backend-secondary h-[calc(100%-60px)] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-800 space-y-2">
    <!-- Search -->
    <li class="px-2 space-y-1 pb-4">
      <!-- Search box -->
    <div class="relative text-skin-backend-text-base">
        <span class="absolute top-1/2 -translate-y-1/2 left-4">
            <i class="fa-solid fa-magnifying-glass"></i>
        </span>
        <input type="search" id="menuSearch" placeholder="Search For..."
            class="w-full bg-skin-backend-secondary border border-default border-opacity-25 rounded-[10px] focus:outline-none focus:ring-0 focus:border-highlight pl-10 py-3 text-sm"
            autocomplete="off">
    
        <!-- Suggestions dropdown -->
        <ul id="menuSuggestions"
            class="absolute z-50 w-full bg-white text-black mt-1 rounded-md shadow hidden max-h-64 overflow-y-auto text-sm border border-gray-300">
            <!-- Suggestions are inserted here -->
        </ul>
    </div>  
    </li>
    <!-- Dashboard -->
    <li class=" px-2 space-y-1">
        <a href="/admin/dashboard">
            <div
                class="dropdown-trigger  {{ Route::is('dashboard') ? 'sidebar-nav-active active-nav' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                <span class="w-6 flex items-center text-lg"><i class="fa-solid fa-chart-line"></i></span>

                <h1 class="hideable">Dashboard</h1>
            </div>
        </a>
    </li>
    {{-- Pages --}}
    <li class="px-2 space-y-1">
        <a href="{{ route('pages.index') }}">
            <div
                class="dropdown-trigger  {{ Route::is('pages.index') || Route::is('pages.create') || Route::is('pages.edit') ? 'sidebar-nav-active active-nav' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                <span class="w-6 flex items-center text-lg"><i class="fa-regular fa-file-lines"></i></span>
                <h1 class="hideable">Pages</h1>
            </div>
        </a>
    </li>
    {{-- Dynamic Components (field-wise table, insert, edit, delete) --}}
    @isset($dynamicComponents)
        @if($dynamicComponents->isNotEmpty())
            <li class="px-2 space-y-1">
                <div
                    class="dropdown-trigger {{ Route::is('dynamic-component.*') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                    <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-database"></i></span>
                    <h1 class="hideable">Components </h1>
                    <i class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
                </div>
                <ul class="dropdown space-y-1" style="display: {{ Route::is('dynamic-component.*') ? 'block' : 'none' }};">
                    @foreach($dynamicComponents as $comp)
                        <li>
                            <a href="{{ route('dynamic-component.index', $comp->name) }}"
                                class="active-trigger relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors {{ (request()->route()?->parameter('slug') ?? '') === $comp->name ? 'sidebar-nav-active active-nav' : '' }}">
                                {{ ucfirst(str_replace('-', ' ', $comp->name)) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
    @endisset
    {{-- <h2 old_data="Content & Media"
        class="px-6 py-2 text-skin-backend-text-base text-opacity-40 nav-section-title text-[12px]">Content & Media</h2>
    <!-- Element -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('slider.*') || Route::is('service.index') || Route::is('faq.index') || Route::is('company.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-puzzle-piece"></i></span>
            <h1 class="hideable">Elements</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Dashboard more -->
        <ul class="dropdown space-y-1"
            style="display:  {{ Route::is('slider.index') || Route::is('service.index') || Route::is('faq.index') || Route::is('company.index') ? 'block' : 'none' }};">
            <li><a href="{{ route('slider.index') }}"
                    class="active-trigger  {{ Route::is('slider.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Slider</a>
            </li>
            <li><a href="{{ route('service.index') }}"
                    class="active-trigger {{ Route::is('service.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Service</a>
            </li>
            <li><a href="{{ route('faq.index') }}"
                    class="active-trigger {{ Route::is('faq.index') ? 'sidebar-nav-active active-nav' : '' }} relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    FAQ</a>
            </li>
            <li><a href="{{ route('company.index') }}"
                    class="active-trigger {{ Route::is('company.index') ? 'sidebar-nav-active active-nav' : '' }} relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Client
                </a>
            </li>

        </ul>
    </li>
    <!-- gallery -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('gallery.categories.index') || Route::is('gallery.image.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-image"></i></span>
            <h1 class="hideable">Gallery</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Dashboard more -->
        <ul class="dropdown space-y-1"
            style="display:  {{ Route::is('gallery.categories.index') || Route::is('gallery.images.index') ? 'block' : 'none' }};">
            <li><a href="{{ route('gallery.categories.index') }}"
                    class="active-trigger  {{ Route::is('gallery.categories.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Category</a>
            </li>
            <li><a href="{{ route('gallery.images.index') }}"
                    class="active-trigger {{ Route::is('gallery.images.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Gallery</a>
            </li>
        </ul>
    </li>
    <!-- Career -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('career.categories.index') || Route::is('career.image.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-briefcase"></i></span>
            <h1 class="hideable">Career</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Dashboard more -->
        <ul class="dropdown space-y-1"
            style="display:  {{ Route::is('career.categories.index') || Route::is('career.career.index') ? 'block' : 'none' }};">
            <li><a href="{{ route('career.categories.index') }}"
                    class="active-trigger {{ Route::is('career.categories.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Category</a>
            </li>
            <li><a href="{{ route('career.career.index') }}"
                    class="active-trigger {{ Route::is('career.career.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Career</a>
            </li>
        </ul>
    </li>
    <!-- Blog -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('slider.*') || Route::is('service.index') || Route::is('faq.index') || Route::is('company.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-brands fa-blogger-b"></i></span>
            <h1 class="hideable">Blog</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Dashboard more -->
        <ul class="dropdown space-y-1"
            style="display:  {{ Route::is('blog.categories.index') || Route::is('blog.posts.index') ? 'block' : 'none' }};">
            <li><a href="{{ route('blog.categories.index') }}"
                    class="active-trigger  {{ Route::is('blog.categories.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Category</a>
            </li>

            <li><a href="{{ route('blog.posts.index') }}"
                    class="active-trigger {{ Route::is('blog.posts.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Blog</a>
            </li>
        </ul>
    </li>
    <!-- Work -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('slider.*') || Route::is('service.index') || Route::is('faq.index') || Route::is('company.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-screwdriver-wrench"></i></span>
            <h1 class="hideable">Work</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Work more -->
        <ul class="dropdown space-y-1"
            style="display:  {{ Route::is('work.categories.index') || Route::is('work.posts.index') ? 'block' : 'none' }};">
            <li><a href="{{ route('work.categories.index') }}"
                    class="active-trigger  {{ Route::is('blog.categories.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Category</a>
            </li>

            <li><a href="{{ route('work.posts.index') }}"
                    class="active-trigger {{ Route::is('work.posts.index') ? 'sidebar-nav-active active-nav' : '' }}  relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Work</a>
            </li>
        </ul>
    </li> --}}
    <h2 old_data="Administration"
        class="px-6 py-2 text-skin-backend-text-base text-opacity-40 nav-section-title text-[12px]">Administration</h2>
    <!-- Notification -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('contact.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-bell"></i></span>

            <h1 class="hideable">Notifications</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Element more -->
        <ul class="dropdown space-y-1"
            style="display: {{ Route::is('contact.index') ? 'block' : 'none' }}; ">
            <li><a href="{{ route('contact.index') }}"
                    class="active-trigger  {{ Route::is('contact.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Inquiries
                </a>
            </li>
            {{-- Subscriber hidden --}}
            {{-- <li><a href="{{ route('subscriber.index') }}"
                    class="active-trigger  {{ Route::is('subscriber.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Subscriber</a>
            </li> --}}
        </ul>

    </li>
    <!-- Section -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('widget.index') || Route::is('theme-option.index') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-layer-group"></i></span>
            <h1 class="hideable">Sections</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Element more -->
        <ul class="dropdown space-y-1" style="display: {{ Route::is('component.index') ? 'block' : 'none' }}; ">
            <li><a href="{{ route('component.index') }}"
                    class="active-trigger  {{ Route::is('component.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Sections</a>
            </li>
        </ul>
    </li>
    <!-- Setting -->
    <li class="px-2 space-y-1">
        <div
            class="dropdown-trigger {{ Route::is('widget.index') || Route::is('theme-option.index') || Route::is('header.footer.settings') || Route::is('font.index') || Route::is('cache.clear') ? 'sidebar-nav-active' : '' }}  active-trigger flex items-center gap-2 py-2.5 px-4 cursor-pointer rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
            <span class="w-4 h-4 flex items-center"><i class="fa-solid fa-gear"></i></span>

            <h1 class="hideable">Setting</h1>
            <i
                class="dropdown-icon hideable fa-solid fa-angle-down ml-auto rotate-0 transition-transform inline-block"></i>
        </div>
        <!-- Element more -->
        <ul class="dropdown space-y-1"
            style="display: {{ Route::is('widget.index') || Route::is('theme-option.index') || Route::is('header.footer.settings') || Route::is('font.index') || Route::is('cache.clear') ? 'block' : 'none' }}; ">
            <li><a href="{{ route('theme-option.index') }}"
                    class="active-trigger  {{ Route::is('theme-option.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Website
                    Setting
                </a>
            </li>
            <li><a href="{{ route('header.footer.settings') }}"
                    class="active-trigger  {{ Route::is('header.footer.settings') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Header Setting
                </a>
            </li>
            <li><a href="{{ route('font.index') }}"
                    class="active-trigger  {{ Route::is('font.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Font
                    Setting
                </a>
            </li>
            <li><a href="{{ route('widget.index') }}"
                    class="active-trigger  {{ Route::is('widget.index') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">Manage
                    Navigation</a>
            </li>
            {{-- SMTP hidden --}}
            {{-- <li><a href="{{ route('smtp_setup') }}"
                    class="active-trigger  {{ Route::is('smtp_setup') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                    SMTP Setup</a>
            </li> --}}
            <li><a href="{{ route('cache.clear') }}"
                    class="active-trigger  {{ Route::is('cache.clear') ? 'sidebar-nav-active active-nav' : '' }}   relative inline-block w-full py-2.5 px-4 pl-14 before:absolute before:top-1/2 before:left-9 before:-translate-y-1/2 before:w-2 before:h-2 before:border-2 before:border-gray-600 before:rounded-full rounded-md hover:bg-skin-backend-accent hover:text-skin-invert transition-colors">
                    Clear Cache</a>
            </li>
        </ul>

    </li>
</ul>
