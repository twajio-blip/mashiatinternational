@props(['data' => [], 'general' => null])
@php
    $widgets = \App\Models\widget::with('children')
        ->whereNull('parent_id')
        ->orderBy('position')
        ->get();

    $email = $general->email ?? 'info@rarlift.com';
    $phone = $general->contact ?? '+880 1234 567 890';
    $phoneHref = preg_replace('/[^0-9+]/', '', $phone);
    $hours = $general->office_hours ?? 'Saturday — Thursday, 9:30 AM — 6:30 PM';
@endphp

<div x-data="{ isScrolled: false, isMobileMenuOpen: false, mobileActiveDropdown: null }"
    x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 50 })" class="relative">

    <header class="w-full fixed top-0 left-0 right-0 z-50 flex flex-col font-sans">

        {{-- 1. Top Contact Bar --}}
        <div class="hidden xl:block bg-background text-white transition-all duration-500 ease-in-out overflow-hidden"
            :class="isScrolled ? 'h-0' : 'h-11'">
            <div class="container h-full flex items-center justify-between text-sm">
                <div class="flex items-center space-x-6">
                    <a href="tel:{{ $phoneHref }}"
                        class="flex items-center gap-2 whitespace-nowrap hover:text-brand-red transition-colors">
                        <i class="fa-solid fa-phone text-brand-red"></i>
                        <span>{{ $phone }}</span>
                    </a>
                    <a href="mailto:{{ $email }}"
                        class="flex items-center gap-2 whitespace-nowrap hover:text-brand-red transition-colors">
                        <i class="fa-solid fa-envelope text-brand-red"></i>
                        <span>{{ $email }}</span>
                    </a>
                </div>
                <div class="flex items-center gap-2 text-gray-300 whitespace-nowrap">
                    <i class="fa-regular fa-clock text-brand-red"></i>
                    <span>{{ $hours }}</span>
                </div>
            </div>
        </div>

        {{-- 2. Main Navigation --}}
        <div class="bg-white shadow-md transition-all duration-500 ease-in-out h-18.5">
            <div class="container h-full flex items-center justify-between">

                {{-- Logo with Smooth Shrink --}}
                <a href="{{ url('/') }}" class="flex items-center h-full py-2">
                    <img src="{{ !empty($general?->header) ? asset('images/' . $general->header) : asset('image.png') }}"
                        alt="Logo"
                        class="w-auto object-contain transition-all duration-500 ease-in-out will-change-transform"
                        :class="isScrolled ? 'h-10 lg:h-12' : 'h-12 lg:h-16'">
                </a>

                <nav class="flex items-center gap-4 h-full">
                    <div class="hidden lg:flex items-center h-full space-x-1 xl:space-x-2">
                        @foreach ($widgets as $widget)
                            @php 
                                                            $hasChildren = $widget->children && $widget->children->count() > 0;
                                $currentPath = request()->path();
                                $checkLink = trim($widget->link, '/') === '' ? '/' : trim($widget->link, '/');
                                $isActive = request()->is($checkLink) ||
                                    ($hasChildren && $widget->children->pluck('link')->map(fn($l) => trim($l, '/'))->contains($currentPath));
                            @endphp

                            <div class="relative group h-full flex items-center" x-data="{ open: false }"
                                @mouseenter="open = true" @mouseleave="open = false">

                                <a href="{{ $hasChildren ? 'javascript:void(0)' : url($widget->link) }}"
                                    class="px-2 py-2 rounded-md text-sm text-nowrap font-medium transition-colors relative flex items-center {{ $isActive ? 'text-brand-red' : 'text-brand-charcoal hover:text-brand-red' }}">

                                    {{ $widget->name }}

                                    @if($hasChildren)
                                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200"
                                            :class="open ? 'rotate-180' : ''"></i>
                                    @endif

                                    <span
                                        class="absolute bottom-0 left-0 w-full h-0.5 bg-brand-red transform origin-left transition-transform duration-300 {{ $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100'}}"></span>
                                </a>

                                @if($hasChildren)
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        class="absolute top-full left-0 w-64 bg-white shadow-2xl rounded-xl py-3 border border-gray-100 z-[60]"
                                        x-cloak>
                                        @foreach ($widget->children as $child)
                                            <a href="{{ url($child->link) }}" @click="open = false"
                                                class="block px-5 py-2.5 text-sm transition-colors {{ request()->is(trim($child->link, '/')) ? 'text-brand-red bg-brand-light/50' : 'text-brand-charcoal hover:bg-brand-light hover:text-brand-red' }}">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ url('/contact') }}"
                        class="hidden sm:flex ml-4 px-6 py-2.5 bg-brand-red text-white text-nowrap font-medium rounded-lg hover:bg-brand-redHover transition-colors shadow-md items-center">
                        Get Quote <i class="fa-solid fa-chevron-right text-xs ml-2"></i>
                    </a>

                    <button @click="isMobileMenuOpen = !isMobileMenuOpen"
                        class="lg:hidden p-2 text-brand-charcoal text-2xl">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </nav>
            </div>
        </div>

        {{-- 3. Mobile Menu Overlay --}}
        <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="isMobileMenuOpen = false"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden" x-cloak>
        </div>

        {{-- Side Menu Content --}}
        <div x-show="isMobileMenuOpen" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" style="width: clamp(200px, 70vw, 250px);"
            class="fixed top-0 left-0 h-screen bg-white shadow-2xl z-50 overflow-y-auto lg:hidden" x-cloak>

            {{-- Header inside Mobile Menu (Close button & Logo) --}}
            <div class="flex items-center justify-between p-4 border-b border-gray-100 bg-brand-charcoal">
                <span class="text-white font-bold tracking-tight">MENU</span>
                <button @click="isMobileMenuOpen = false" class="text-white hover:text-brand-red p-2 transition-colors">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>

            <div class="flex flex-col px-4 py-6 space-y-1">
                @foreach ($widgets as $widget)
                    @php 
                                            $hasChildren = $widget->children && $widget->children->count() > 0;
                        $checkLink = trim($widget->link, '/') === '' ? '/' : trim($widget->link, '/');
                        $isActive = request()->is($checkLink);
                    @endphp

                    <div class="border-b border-gray-50 last:border-0">
                        <div class="flex items-center justify-between py-3">
                            @if($hasChildren)
                                <button
                                    @click="mobileActiveDropdown === '{{ $widget->id }}' ? mobileActiveDropdown = null : mobileActiveDropdown = '{{ $widget->id }}'"
                                    class="flex items-center justify-between w-full text-left group">
                                    <span
                                        class="text-base font-semibold {{ $isActive ? 'text-brand-red' : 'text-brand-charcoal group-hover:text-brand-red' }}">
                                        {{ $widget->name }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-sm transition-transform duration-300"
                                        :class="mobileActiveDropdown === '{{ $widget->id }}' ? 'rotate-180 text-brand-red' : 'text-gray-400'"></i>
                                </button>
                            @else
                                <a href="{{ url($widget->link) }}"
                                    class="text-base font-semibold {{ $isActive ? 'text-brand-red' : 'text-brand-charcoal hover:text-brand-red' }}">
                                    {{ $widget->name }}
                                </a>
                            @endif
                        </div>

                        @if($hasChildren)
                            <div x-show="mobileActiveDropdown === '{{ $widget->id }}'" x-collapse x-cloak>
                                <div
                                    class="flex flex-col pl-4 pb-4 space-y-2 bg-gray-50 rounded-lg mb-2 mt-1 border-l-2 border-brand-red/20">
                                    @foreach ($widget->children as $child)
                                        <a href="{{ url($child->link) }}"
                                            @click="isMobileMenuOpen = false; mobileActiveDropdown = null"
                                            class="text-left py-2 px-3 text-sm transition-all rounded-md {{ request()->is(trim($child->link, '/')) ? 'text-brand-red bg-white shadow-sm font-semibold' : 'text-gray-600 hover:text-brand-red hover:bg-white' }}">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Optional Footer for Mobile Menu --}}
            <div class="p-6 mt-4 border-t border-gray-100">
                <a href="{{ url('/contact') }}"
                    class="flex justify-center items-center w-full bg-brand-red text-white py-3 rounded-xl font-bold shadow-lg shadow-brand-red/20">
                    GET A QUOTE
                </a>
            </div>
        </div>
    </header>
</div>