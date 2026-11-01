@props(['data' => []])
@php
    $item = $data[0][0] ?? [];
    $features = $data[0][1]['instances'] ?? [];

    $title = $item['title'] ?? 'Our Advantages';
    $subtitle = $item['subtitle'] ?? 'Why Choose RAR Lifts';
    $description = $item['description'] ?? "We don't just sell elevators; we provide seamless mobility solutions.";
@endphp

{{-- Upper Vertical Track --}}
<div class="flex justify-center py-12 relative overflow-hidden bg-white">
    {{-- The Smooth Line --}}
    <div class="w-[1.5px] h-32 bg-gray-100 relative">
        {{-- The Red Core Scanner --}}
        <div class="absolute left-1/2 -translate-x-1/2 w-3 h-3 animate-scanner">
            {{-- Glowing Pulse --}}
            <div class="absolute inset-0 bg-brand-red rounded-full blur-[3px] opacity-70 shadow-[0_0_15px_#ef4444]">
            </div>
            {{-- Solid Core --}}
            <div class="absolute inset-0 bg-brand-red rounded-full z-10"></div>
        </div>
    </div>
</div>

<section id="why-us" class="py-16 lg:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header Section --}}
        <div class="text-center mb-8 lg:mb-16" data-aos="fade-up" data-aos-offset="50">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <h2 class="text-brand-red font-semibold tracking-wider uppercase text-size-sub-header">
                    {{ $title }}
                </h2>
            </div>
            <h1 class="text-size-title leading-[1.1] font-bold text-brand-charcoal mb-4">
                {{ $subtitle }}
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-size-body">
                {{ $description }}
            </p>
        </div>

        {{-- Features Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">
            @foreach($features as $index => $feature)
                <div class="relative bg-white p-4 lg:p-8 rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 group overflow-hidden"
                    data-aos="fade-up" data-aos-delay="{{ $index * 50 }}" data-aos-offset="0">

                    {{-- Animated Bottom Bar --}}
                    <div
                        class="absolute bottom-0 left-0 w-full h-1.5 bg-transparent group-hover:bg-brand-red transition-colors duration-300">
                    </div>

                    {{-- Icon Container --}}
                    <div
                        class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-4 lg:mb-8 group-hover:bg-brand-red/20 transition-colors">
                        <i
                            class="text-brand-charcoal group-hover:text-brand-red text-xl transition-colors {{ $feature['icon'] ?? 'fa-solid fa-check' }}"></i>
                    </div>

                    {{-- Content --}}
                    <h2
                        class="font-bold text-size-header text-brand-charcoal mb-3 transition-colors group-hover:text-brand-red leading-[1.1]">
                        {{ $feature['title'] ?? 'Feature Title' }}
                    </h2>
                    <p class="text-gray-500 leading-relaxed text-size-accent">
                        {{ $feature['desc'] ?? 'Feature description goes here.' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Lower Vertical Track --}}
    <div class="flex justify-center py-12 relative overflow-hidden bg-white">
        <div class="w-[1.5px] h-32 bg-gray-100 relative">
            <div class="absolute left-1/2 -translate-x-1/2 w-3 h-3 animate-scanner">
                <div class="absolute inset-0 bg-brand-red rounded-full blur-[3px] opacity-70 shadow-[0_0_15px_#ef4444]">
                </div>
                <div class="absolute inset-0 bg-brand-red rounded-full z-10"></div>
            </div>
        </div>
    </div>
</section>

@pushOnce('css')
    <style>
        @keyframes scanner-loop {

            /* Start at Top - Fully Visible */
            0%,
            100% {
                top: 0%;
                transform: translate(-50%, 0%);
                opacity: 1;
            }

            /* Reach Bottom - Fully Visible */
            50% {
                top: 100%;
                transform: translate(-50%, -100%);
                opacity: 1;
            }
        }

        .animate-scanner {
            /* 6 seconds for a full round trip */
            /* Using a smoother 'in-out' curve to prevent a 'jerk' at the ends */
            animation: scanner-loop 6s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            will-change: top;
        }
    </style>
@endPushOnce