@props(['data' => [], 'general' => null])

@php
$general = $general ?? \Illuminate\Support\Facades\Cache::rememberForever('general_settings', fn () => \App\Models\General::first());

$widgets = \App\Models\widget::with('children')
->whereNull('parent_id')
->orderBy('position')
->get();

$email = $general?->email ?? 'info@mashiatintl.com';
$phone = $general?->contact ?? '+880 1711 000 111';
$websiteName = $general?->website_name ?? 'Mashiat International';
$websiteLabel = $general?->website_label ?? 'Financial Documentation & Consultancy';
$headerLogo = $general?->header ?? null;
$headerLogoUrl = $headerLogo ? asset('images/' . $headerLogo) : null;
$phoneHref = preg_replace('/[^0-9+]/', '', $phone);
$hours = $general?->office_hours ?? 'Saturday - Thursday, 9:30 AM - 6:30 PM';
$whatsappPhone = $general?->whatsapp_number ?? $phone;
$whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappPhone);

$fallbackWidgets = collect([
(object) ['id' => 'home', 'name' => 'Home', 'link' => '/', 'children' => collect()],
(object) ['id' => 'about', 'name' => 'About Us', 'link' => '/about-us', 'children' => collect()],
(object) ['id' => 'student-visa', 'name' => 'Student Visa', 'link' => '/student-visa', 'children' => collect()],
(object) ['id' => 'services', 'name' => 'Services', 'link' => '/services', 'children' => collect()],
(object) ['id' => 'team', 'name' => 'Our Team', 'link' => '/team', 'children' => collect()],
(object) ['id' => 'contact', 'name' => 'Contact', 'link' => '/contact', 'children' => collect()],
]);

$menuItems = $widgets->isNotEmpty() ? $widgets : $fallbackWidgets;

$isActiveLink = function ($link, $children = null) {
$path = trim((string) $link, '/');
$active = $path === '' ? request()->is('/') : request()->is($path) || request()->is($path . '/*');

if (!$active && $children) {
$active = $children->contains(function ($child) {
$childPath = trim((string) $child->link, '/');
return $childPath !== '' && (request()->is($childPath) || request()->is($childPath . '/*'));
});
}

return $active;
};
@endphp

<header x-data="{ mobileOpen: false, mobileActive: null }" class="fixed inset-x-0 top-0 z-50">
    <div class="hidden bg-header text-white xl:block">
        <div class="container flex h-11 items-center justify-between text-[13px]">
            <div class="flex items-center gap-6">
                <a href="tel:{{ $phoneHref }}" class="inline-flex items-center gap-2 transition-colors hover:text-status">
                    <i class="fa-solid fa-phone text-status"></i>
                    <span>{{ $phone }}</span>
                </a>
                <a href="mailto:{{ $email }}" class="inline-flex items-center gap-2 transition-colors hover:text-status">
                    <i class="fa-regular fa-envelope text-status"></i>
                    <span>{{ $email }}</span>
                </a>
                <span class="inline-flex items-center gap-2 text-white/80">
                    <i class="fa-regular fa-clock text-status"></i>
                    <span>{{ $hours }}</span>
                </span>
            </div>

            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 font-semibold text-status transition-colors hover:text-white">
                <i class="fa-brands fa-whatsapp"></i>
                <span>WhatsApp</span>
            </a>
        </div>
    </div>

    <div class="border-b border-border-color bg-white">
        <div class="container flex h-18.5 items-center justify-between sm:gap-6">
            <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-3">
                @if ($headerLogoUrl)
                <span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-border-color bg-white">
                    <img src="{{ $headerLogoUrl }}" alt="{{ $websiteName }} logo" class="h-full w-full object-contain">
                </span>
                @else
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-header font-display text-[18px] font-bold text-status">
                    {{ collect(explode(' ', $websiteName))->filter()->map(fn ($word) => mb_substr($word, 0, 1))->take(2)->implode('') ?: 'MI' }}
                </span>
                @endif
                <span class="min-w-0">
                    <span class="block font-display text-[16px] sm:text-[18px] font-bold leading-tight text-header">
                        {{ $websiteName }}
                    </span>
                    <span class="block text-[12px] font-medium leading-tight text-muted">
                        {{ $websiteLabel }}
                    </span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 xl:flex" aria-label="Main navigation">
                @foreach ($menuItems as $widget)
                @php
                $children = $widget->children ?? collect();
                $hasChildren = $children->count() > 0;
                $isActive = $isActiveLink($widget->link, $children);
                @endphp

                <div class="group relative">
                    <a href="{{ $hasChildren ? '#' : url($widget->link ?: '/') }}"
                        class="inline-flex h-20 items-center gap-1.5 px-3 text-[14px] font-semibold transition-colors {{ $isActive ? 'text-tag' : 'text-header hover:text-tag' }}">
                        <span>{{ $widget->name }}</span>
                        @if ($hasChildren)
                        <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 group-hover:rotate-180"></i>
                        @endif
                    </a>

                    @if ($hasChildren)
                    <div class="invisible absolute left-0 top-full w-64 translate-y-2 rounded-lg border border-border-color bg-white py-2 opacity-0 shadow-card transition-all duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100">
                        @foreach ($children as $child)
                        @php
                        $childPath = trim((string) $child->link, '/');
                        $childActive = $childPath !== '' && (request()->is($childPath) || request()->is($childPath . '/*'));
                        @endphp
                        <a href="{{ url($child->link) }}"
                            class="block px-4 py-2.5 text-[14px] font-medium transition-colors {{ $childActive ? 'bg-background-3 text-tag' : 'text-header hover:bg-background-3 hover:text-tag' }}">
                            {{ $child->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ url('/contact') }}"
                    class="hidden items-center justify-center rounded-lg bg-status px-4 py-2 text-[14px] font-semibold text-header shadow-card transition-colors hover:bg-[#b8944b] md:inline-flex">
                    Book Consultation
                </a>

                <button type="button" @click="mobileOpen = true"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-border-color bg-white text-header transition-colors hover:border-status hover:text-tag xl:hidden"
                    aria-label="Open menu">
                    <i class="fa-solid fa-bars text-[18px]"></i>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileOpen" x-transition.opacity @click="mobileOpen = false"
        class="fixed inset-0 z-40 bg-header/70 backdrop-blur-sm xl:hidden" x-cloak></div>

    <aside x-show="mobileOpen"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 w-[min(86vw,340px)] overflow-y-auto bg-white shadow-card xl:hidden"
        x-cloak>
        <div class="flex items-center justify-between border-b border-border-color bg-header p-4 text-white">
            <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-2" @click="mobileOpen = false">
                @if ($headerLogoUrl)
                <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-white">
                    <img src="{{ $headerLogoUrl }}" alt="{{ $websiteName }} logo" class="h-full w-full object-contain">
                </span>
                @endif
                <span class="min-w-0">
                    <span class="block truncate font-display text-[17px] font-bold">{{ $websiteName }}</span>
                    <span class="block truncate text-[11px] font-medium text-white/70">{{ $websiteLabel }}</span>
                </span>
            </a>
            <button type="button" @click="mobileOpen = false"
                class="flex h-10 w-10 items-center justify-center rounded-lg text-white transition-colors hover:bg-white/10"
                aria-label="Close menu">
                <i class="fa-solid fa-xmark text-[20px]"></i>
            </button>
        </div>

        <div class="space-y-1 p-4">
            @foreach ($menuItems as $widget)
            @php
            $children = $widget->children ?? collect();
            $hasChildren = $children->count() > 0;
            $isActive = $isActiveLink($widget->link, $children);
            $mobileKey = (string) $widget->id;
            @endphp

            <div class="border-b border-border-color/70 pb-1 last:border-b-0">
                @if ($hasChildren)
                <button type="button"
                    @click="mobileActive === '{{ $mobileKey }}' ? mobileActive = null : mobileActive = '{{ $mobileKey }}'"
                    class="flex w-full items-center justify-between gap-3 py-3 text-left text-[15px] font-semibold {{ $isActive ? 'text-tag' : 'text-header' }}">
                    <span>{{ $widget->name }}</span>
                    <i class="fa-solid fa-chevron-down text-[11px] transition-transform duration-200"
                        :class="mobileActive === '{{ $mobileKey }}' ? 'rotate-180 text-status' : ''"></i>
                </button>

                <div x-show="mobileActive === '{{ $mobileKey }}'" x-cloak
                    class="mb-2 rounded-lg bg-background-3 px-3 py-2">
                    @foreach ($children as $child)
                    <a href="{{ url($child->link) }}" @click="mobileOpen = false"
                        class="block rounded-md px-3 py-2 text-[14px] font-medium text-muted transition-colors hover:bg-white hover:text-tag">
                        {{ $child->name }}
                    </a>
                    @endforeach
                </div>
                @else
                <a href="{{ url($widget->link ?: '/') }}" @click="mobileOpen = false"
                    class="block py-3 text-[15px] font-semibold transition-colors {{ $isActive ? 'text-tag' : 'text-header hover:text-tag' }}">
                    {{ $widget->name }}
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <div class="space-y-3 border-t border-border-color p-4">
            <a href="{{ url('/contact') }}"
                class="flex min-h-11 w-full items-center justify-center rounded-lg bg-status px-5 py-2.5 text-[14px] font-semibold text-header shadow-card transition-colors hover:bg-[#b8944b]">
                Book Consultation
            </a>
            @if ($whatsappNumber)
            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener"
                class="flex items-center gap-2 text-[14px] font-semibold text-header">
                <i class="fa-brands fa-whatsapp text-status"></i>
                <span>{{ $whatsappPhone }}</span>
            </a>
            @endif
            <a href="tel:{{ $phoneHref }}" class="flex items-center gap-2 text-[14px] font-semibold text-header">
                <i class="fa-solid fa-phone text-status"></i>
                <span>{{ $phone }}</span>
            </a>
            <a href="mailto:{{ $email }}" class="flex items-center gap-2 text-[14px] font-semibold text-header">
                <i class="fa-regular fa-envelope text-status"></i>
                <span>{{ $email }}</span>
            </a>
        </div>
    </aside>
</header>
