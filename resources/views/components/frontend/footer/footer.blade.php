{{-- Cookies --}}
@if (isset($general) && $general?->cookie_title)
    <div
        class="cookie-alert hidden fixed bottom-0 sm:bottom-4 sm:right-4 z-50 sm:w-[300px] bg-white p-4 py-6 rounded-md shadow-md">
        <div class="space-y-6">
            <div class="space-y-3">
                <h5 class="font-semibold text-lg">&#x1F36A; {{ $general?->cookie_title }}</h5>
                <p class="">{{ $general?->cookie_description }}</p>
            </div>
            <div class="space-x-2 text-end">
                <a href="http://cookiesandyou.com/" target="_blank" class="text-blue-500 hover:underline">Learn more</a>
                <a href="#"
                    class="cookie-accept px-3 py-2.5 rounded-md font-semibold bg-blue-500 hover:bg-blue-600 transition-colors duration-300 text-white">Accept</a>
            </div>
        </div>
    </div>
@endif

@php
    $general = $general ?? null;
    $footerGroups = $footerGroups ?? collect();
    $galleryImages = $galleryImages ?? collect();
    $footerLogo = $general?->footer ?? $general?->logo ?? $general?->fav_icon ?? null;
    $footerLogoUrl = $footerLogo ? asset('images/' . $footerLogo) : asset('image.png');
    $footerDescription = $general?->description ?? $general?->tagline ?? 'RAR Lift is a premier vendor and distributor of international lift brands, committed to providing safe, reliable, and innovative vertical mobility solutions.';
    $footerAddress = $general?->address ?? $general?->location ?? '123 Business Avenue, Block C, Dhaka 1212, Bangladesh';
    $footerPhone = $general?->phone ?? $general?->contact ?? "+880 1713 018 796\n+880 197 301 8796";
    $footerEmail = $general?->email ?? 'info@rarlift.com';
    $socialData = isset($general?->social) && is_string($general->social) ? json_decode($general->social, true) : [];
    $socialData = is_array($socialData) ? $socialData : [];
    $socialIsList = isset($socialData[0]) && is_array($socialData[0]);


@endphp

<footer class="bg-brand-charcoal text-white border-t-4 border-brand-red">
    <div class="container mx-auto px-4 md:px-6 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-12 py-16 lg:py-24">

            {{-- Column 1: About --}}
            <div>
                @if ($general)
                    <div class="mb-6">
<a href="/">
    <img src="{{ $footerLogoUrl }}" alt="{{ $general->website_name ?? 'RAR Lift' }} Logo"
        class="h-20 w-auto object-contain">
</a>
                    </div>
                    <p class="text-gray-400 md:mb-6 leading-relaxed text-size-accent">
                        {{ $footerDescription }}
                    </p>
                    <div class="flex gap-3 flex-wrap">
                        @if ($socialIsList && count($socialData) > 0)
                            @foreach ($socialData as $item)
                                <a href="{{ $item[1] ?? '#' }}" target="_blank" rel="noopener"
                                    class="w-10 h-10 bg-white/10 flex items-center justify-center rounded-sm hover:bg-brand-red transition-colors duration-300">
                                    {!! $item[0] ?? '' !!}
                                </a>
                            @endforeach
                        @else
                            @foreach (['facebook', 'twitter', 'linkedin', 'instagram'] as $social)
                                @php $url = $socialData[$social] ?? $socialData[ucfirst($social)] ?? '#'; @endphp
                                <a href="{{ $url }}"
                                    class="w-10 h-10 bg-white/10 flex items-center justify-center rounded-sm hover:bg-brand-red transition-colors duration-300">
                                    <i class="fab fa-{{ $social }}"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
            {{-- Contact Us: Appears 3rd on mobile, 2nd on tablet, 4th on desktop --}}
            <div class="hidden md:block lg:hidden">
                <h1 class="text-size-header font-heading font-bold mb-4 md:mb-6 relative inline-block text-white">
                    Contact Us
                    <span class="absolute -bottom-2 left-0 w-full h-1 bg-brand-red"></span>
                </h1>
                <ul class="space-y-4 text-gray-400 text-size-body p-2">
                    <li>{!! nl2br(e($footerAddress)) !!}</li>
                    <li class="whitespace-pre-line">{{ $footerPhone }}</li>
                    <li><a href="mailto:{{ $footerEmail }}" class="hover:text-brand-red">{{ $footerEmail }}</a></li>
                </ul>
            </div>

            {{-- Quick Links Group --}}
            @if ($footerGroups->count() > 0)
                @foreach ($footerGroups->take(2) as $index => $footerGroup)
                    <div class="hidden md:block">
                        <h1 class="text-size-header font-heading font-bold mb-4 md:mb-6 relative inline-block text-white">
                            {{ $footerGroup->name }}
                            <span class="absolute -bottom-2 left-0 w-full h-1 bg-brand-red"></span>
                        </h1>
                        <ul class="space-y-2">
                            @foreach ($footerGroup->details ?? [] as $detail)
                                <li>
                                    <a href="{{ url($detail->url ?? '#') }}"
                                        class="text-gray-400 hover:text-brand-red transition-colors flex items-center gap-2 group text-size-body">
                                        <span
                                            class="w-1.5 h-1.5 bg-brand-red rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                        {{ $detail->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif

            <div class="flex justify-between md:hidden">
                {{-- Quick Links Group mobile order-2 md:order-3 lg:order-{{ $index + 2 }} --}}
                @if ($footerGroups->count() > 0)
                    @foreach ($footerGroups->take(2) as $index => $footerGroup)
                        <div>
                            <h1 class="text-size-header font-heading font-bold mb-4 md:mb-6 relative inline-block text-white">
                                {{ $footerGroup->name }}
                                <span class="absolute -bottom-2 left-0 w-full h-1 bg-brand-red"></span>
                            </h1>
                            <ul class="space-y-2">
                                @foreach ($footerGroup->details ?? [] as $detail)
                                    <li>
                                        <a href="{{ url($detail->url ?? '#') }}"
                                            class="text-gray-400 hover:text-brand-red transition-colors flex items-center gap-2 group text-size-body">
                                            <span
                                                class="w-1.5 h-1.5 bg-brand-red rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                            {{ $detail->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Contact Us: Appears 3rd on mobile, 2nd on tablet, 4th on desktop --}}
            <div class="md:hidden lg:block">
                <h1 class="text-size-header font-heading font-bold mb-4 md:mb-6 relative inline-block text-white">
                    Contact Us
                    <span class="absolute -bottom-2 left-0 w-full h-1 bg-brand-red"></span>
                </h1>
                <ul class="space-y-4 text-gray-400 text-size-body p-2">
                    <li>{!! nl2br(e($footerAddress)) !!}</li>
                    <li class="whitespace-pre-line">{{ $footerPhone }}</li>
                    <li><a href="mailto:{{ $footerEmail }}" class="hover:text-brand-red">{{ $footerEmail }}</a></li>
                </ul>
            </div>

        </div>



        <div
            class="border-t border-white/10 py-6 flex flex-col md:flex-row justify-between items-center gap-2 md:gap-4">
            <p class="text-gray-500 text-size-body">
                &copy; {{ date('Y') }} {{ $general && $general->website_name ? $general->website_name : 'RAR Lift' }}.
                All rights reserved.
            </p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition-colors text-size-body">Privacy Policy</a>
                <a href="#" class="hover:text-white transition-colors text-size-body">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>