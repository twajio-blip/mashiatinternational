{{-- Cookies --}}
@if (isset($general) && $general?->cookie_title)
    <div class="cookie-alert hidden fixed bottom-0 sm:bottom-4 sm:right-4 z-50 sm:w-[300px] bg-white p-4 py-6 rounded-md shadow-md text-skin-invert">
        <div class="space-y-6">
            <div class="space-y-3">
                <h5 class="font-semibold text-lg">&#x1F36A; {{ $general?->cookie_title }}</h5>
                <p>{{ $general?->cookie_description }}</p>
            </div>
            <div class="space-x-2 text-end">
                <a href="http://cookiesandyou.com/" target="_blank" class="text-blue-500 hover:underline">Learn more</a>
                <a href="#" class="cookie-accept px-3 py-2.5 rounded-md font-semibold bg-blue-500 hover:bg-blue-600 transition-colors duration-300 text-white">Accept</a>
            </div>
        </div>
    </div>
@endif

@php
    $general = $general ?? null;

    $websiteName = $general?->website_name ?? 'Mashiat International';
    $websiteLabel = $general?->website_label ?? 'Financial Documentation & Consultancy';
    $footerLogo = $general?->footer ?? $general?->header ?? $general?->fav_icon ?? null;
    $footerLogoUrl = $footerLogo ? asset('images/' . $footerLogo) : null;
    $footerDescription = $general?->description ?? 'A Dhaka-based professional consultancy specialising in student visa financial documentation, Chartered Accountant reporting, tax, corporate and regulatory services.';
    $footerPhone = $general?->contact ?? '+880 1711 000 111';
    $footerPhoneHref = preg_replace('/[^0-9+]/', '', $footerPhone);
    $footerWhatsapp = $general?->whatsapp_number ?? $footerPhone;
    $footerWhatsappNumber = preg_replace('/[^0-9]/', '', $footerWhatsapp);
    $footerEmail = $general?->email ?? 'info@mashiatintl.com';
    $footerAddress = $general?->location ?? "Level 7, Concord Tower, 113 Kazi Nazrul Islam Avenue\nBanglamotor, Dhaka 1000, Bangladesh";

    $supportComponent = \App\Models\ComponentMaster::where('name', 'support')->first();
    $supportFooterTitle = 'Support';
    if ($supportComponent) {
        $supportFooterTitle = \App\Models\ComponentField::where('component_id', $supportComponent->id)
            ->whereNull('page_id')
            ->whereIn('name', ['Header Title', 'Header Label', 'Header Lable'])
            ->orderByRaw("FIELD(name, 'Header Title', 'Header Label', 'Header Lable')")
            ->value('value') ?: $supportFooterTitle;
    }

$categoryNames = \App\Http\Controllers\Backend\Pages\DynamicComponentController::getRelationshipOptions('service-catagory', 'Catagory Name');
    $categoryNameToKey = collect($categoryNames)
        ->mapWithKeys(fn ($name, $key) => [\Illuminate\Support\Str::lower(trim((string) $name)) => (string) $key])
        ->all();
    $normalizeCategoryKey = function ($value) {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        return preg_match('/^\d+:\d+$/', $value) || preg_match('/^\d+$/', $value)
            ? $value
            : \Illuminate\Support\Str::lower($value);
    };
    $resolveCategoryName = function ($value) use ($categoryNames, $categoryNameToKey, $normalizeCategoryKey) {
        $key = $normalizeCategoryKey($value);

        if (isset($categoryNames[$key])) {
            return $categoryNames[$key];
        }

        return $categoryNames[$categoryNameToKey[$key] ?? null] ?? (string) $value;
    };
    $professionalCategories = collect($categoryNames)
        ->filter(fn ($name) => trim((string) $name) !== '')
        ->unique(fn ($name) => \Illuminate\Support\Str::slug((string) $name))
        ->map(fn ($name) => [
            'name' => (string) $name,
            'url' => url('/service?category=' . \Illuminate\Support\Str::slug((string) $name)),
        ])
        ->values();

    $detailsServiceComponent = \App\Models\ComponentMaster::where('name', 'details-service')->first();
    $supportServices = collect();
    if ($detailsServiceComponent) {
        $supportServices = \App\Models\ComponentField::where('component_id', $detailsServiceComponent->id)
            ->whereNull('page_id')
            ->whereIn('name', ['Service Title', 'Catagory'])
            ->orderBy('group')
            ->get()
            ->groupBy('group')
            ->map(function ($fields) use ($resolveCategoryName) {
                $title = (string) ($fields->firstWhere('name', 'Service Title')->value ?? '');
                $categoryKey = (string) ($fields->firstWhere('name', 'Catagory')->value ?? '');

                return [
                    'title' => $title,
                    'category_name' => $resolveCategoryName($categoryKey),
                    'url' => $title ? route('service-view', \Illuminate\Support\Str::slug($title)) : '#',
                ];
            })
            ->filter(fn ($service) => \Illuminate\Support\Str::lower(trim((string) $service['category_name'])) === 'student visa')
            ->filter(fn ($service) => $service['title'] !== '')
            ->values();
    }

    $widgets = \App\Models\widget::with('children')
        ->whereNull('parent_id')
        ->orderBy('position')
        ->get();

    $fallbackMenuItems = collect([
        (object) ['name' => 'Home', 'link' => '/'],
        (object) ['name' => 'About Us', 'link' => '/about'],
        (object) ['name' => 'Student Visa', 'link' => '/student-visa'],
        (object) ['name' => 'Services', 'link' => '/service'],
        (object) ['name' => 'Our Team', 'link' => '/team'],
        (object) ['name' => 'Contact', 'link' => '/contact'],
    ]);

    $footerMenuItems = $widgets->isNotEmpty() ? $widgets : $fallbackMenuItems;
@endphp

<footer class="bg-header text-white">
    <div class="container">
        <div class="grid gap-12 border-b border-white/10 py-14 lg:grid-cols-12 lg:py-16">
            <div class="lg:col-span-4">
                <a class="group flex min-w-0 items-center gap-2.5 sm:gap-3" aria-label="{{ $websiteName }} home" href="{{ url('/') }}">
                    @if ($footerLogoUrl)
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-white sm:h-11 sm:w-11">
                            <img src="{{ $footerLogoUrl }}" alt="{{ $websiteName }} logo" class="h-full w-full object-contain">
                        </span>
                    @else
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-header font-heading text-[16px] font-extrabold tracking-tight text-status sm:h-11 sm:w-11 sm:text-[17px]" aria-hidden="true">
                            {{ collect(explode(' ', $websiteName))->filter()->map(fn ($word) => mb_substr($word, 0, 1))->take(2)->implode('') ?: 'MI' }}
                        </span>
                    @endif
                    <span class="min-w-0 leading-tight">
                        <span class="block font-heading text-[16px] font-extrabold tracking-tight text-white sm:text-[17px]">{{ $websiteName }}</span>
                        <span class="block text-[10px] font-medium uppercase tracking-[0.11em] text-white/60 sm:text-[11px] sm:tracking-[0.14em]">{{ $websiteLabel }}</span>
                    </span>
                </a>

                <p class="mt-6 max-w-sm text-[15px] leading-relaxed text-white/70">{{ $footerDescription }}</p>

                <div class="mt-7 space-y-3 text-[15px]">
                    <a href="tel:{{ $footerPhoneHref }}" class="flex items-center gap-3 text-white/80 transition-colors duration-200 ease-out hover:text-white">
                        <i class="fa-solid fa-phone text-status" aria-hidden="true"></i>
                        <span>{{ $footerPhone }}</span>
                    </a>
                    @if ($footerWhatsappNumber)
                        <a href="https://wa.me/{{ $footerWhatsappNumber }}" target="_blank" rel="noreferrer" class="flex items-center gap-3 text-white/80 transition-colors duration-200 ease-out hover:text-white">
                            <i class="fa-brands fa-whatsapp text-status" aria-hidden="true"></i>
                            <span>WhatsApp enquiry</span>
                        </a>
                    @endif
                    <a href="mailto:{{ $footerEmail }}" class="flex items-center gap-3 text-white/80 transition-colors duration-200 ease-out hover:text-white">
                        <i class="fa-regular fa-envelope text-status" aria-hidden="true"></i>
                        <span>{{ $footerEmail }}</span>
                    </a>
                    <p class="flex items-start gap-3 text-white/80">
                        <i class="fa-solid fa-location-dot mt-1 shrink-0 text-status" aria-hidden="true"></i>
                        <span>{!! nl2br(e($footerAddress)) !!}</span>
                    </p>
                </div>
            </div>

            <nav aria-label="{{ $supportFooterTitle }}" class="lg:col-span-3">
                <h2 class="font-heading text-[15px] font-semibold text-white">{{ $supportFooterTitle }}</h2>
                <ul class="mt-5 space-y-3 text-[15px]">
                    @forelse ($supportServices as $service)
                        <li>
                            <a class="text-white/70 transition-colors duration-200 ease-out hover:text-white" href="{{ $service['url'] }}">
                                {{ $service['title'] }}
                            </a>
                        </li>
                    @empty
                        <li><a class="text-white/70 transition-colors duration-200 ease-out hover:text-white" href="{{ url('/student-visa') }}">Student visa overview</a></li>
                    @endforelse
                </ul>
            </nav>

            <nav aria-label="Professional services" class="lg:col-span-3">
                <h2 class="font-heading text-[15px] font-semibold text-white">Professional Services</h2>
                <ul class="mt-5 space-y-3 text-[15px]">
                    @forelse ($professionalCategories as $category)
                        <li>
                            <a class="text-white/70 transition-colors duration-200 ease-out hover:text-white" href="{{ $category['url'] }}">
                                {{ $category['name'] }}
                            </a>
                        </li>
                    @empty
                        <li><a class="text-white/70 transition-colors duration-200 ease-out hover:text-white" href="{{ url('/services') }}">Services</a></li>
                    @endforelse
                </ul>
            </nav>

            <nav aria-label="Company" class="lg:col-span-2">
                <h2 class="font-heading text-[15px] font-semibold text-white">Company</h2>
                <ul class="mt-5 space-y-3 text-[15px]">
                    @foreach ($footerMenuItems as $widget)
                        @php
                            $children = $widget->children ?? collect();
                            $hasChildren = $children->count() > 0;
                            $link = $hasChildren && empty($widget->link) ? '#' : ($widget->link ?: '/');
                        @endphp
                        <li>
                            <a class="text-white/70 transition-colors duration-200 ease-out hover:text-white" href="{{ $link === '#' ? '#' : url($link) }}">
                                {{ $widget->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <div class="py-7">
            <p class="text-[13px] leading-relaxed text-white/50">
                {{ $websiteName }} provides financial documentation, accounting, taxation and regulatory consultancy services. We do not process visa applications and have no influence over immigration decisions, which rest solely with the relevant authorities.
            </p>
<div class="mt-6 flex flex-col gap-3 border-t border-white/10 pt-6 text-[13px] text-white/50 sm:flex-row sm:items-center sm:justify-between">
    <p>&copy; {{ date('Y') }} {{ $websiteName }}. All rights reserved.</p>
    <p>
        Developed by
        <a href="https://datadss.com/" target="_blank" rel="noopener noreferrer" class="text-white/70 transition hover:text-white">
            DataDSS LTD
        </a>
        &middot; Data Dynamic Software Solutions
    </p>
</div>
        </div>
    </div>
</footer>
