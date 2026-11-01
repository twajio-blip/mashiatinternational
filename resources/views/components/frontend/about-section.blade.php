@props(['data' => []])
@php
    $item = $data[0][0] ?? [];
    $feature_group = $data[0][1]['instances'] ?? [];

    // Main Content
    $title = $item['title'] ?? 'Elevating Standards';
    $sub_title = $item['subtitle'] ?? 'Welcome to RAR Lift';
    $description = $item['description'] ?? $item['discription'] ?? 'We specialize in comprehensive lifting solutions.';

    // Call to Action
    $btn_text = $item['btn_text'] ?? 'Discover Our Story';
    $btn_link = $item['btn_link'] ?? '#';

    // Right Side Composition
    $image = $item['ceo_image'] ?? 'about-placeholder.jpg';
    $ceo_quote = $item['ceo_quote'] ?? 'A lift is considered the heart of a building.';
    $years_experience = $item['years_experience'] ?? '15+';
@endphp

@pushOnce('css')
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
@endPushOnce

<section class="py-16 lg:py-24 bg-white relative overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
        style="background-image: radial-gradient(#1A1A1A 1px, transparent 1px); background-size: 32px 32px;">
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

            {{-- Left Content Column --}}
            <div class="lg:col-span-5">

                {{-- Heading Section --}}
                <div class="mb-8" data-aos="fade-right">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-brand-red font-bold uppercase tracking-widest text-size-sub-header">
                            {{ $title }}
                        </span>
                    </div>
                    <h1 class="text-size-title font-bold text-brand-charcoal leading-[1.1]">
                        {{ $sub_title }}
                    </h1>
                </div>

                <p class="text-size-body text-gray-600 mb-8 leading-relaxed font-medium" data-aos="fade-right"
                    data-aos-delay="100">
                    {{ $description }}
                </p>

                {{-- Feature List --}}
                <div class="space-y-6 mb-12">
                    @foreach($feature_group as $index => $feature)
                        <div class="flex items-start" data-aos="fade-up" data-aos-delay="{{ 200 + ($index * 100) }}">
                            <div
                                class="w-12 h-12 rounded-full bg-brand-red/10 flex items-center justify-center shrink-0 mr-4">
                                @if(str_contains($feature['feature_icon'], '<i'))
                                    <span class="text-brand-red text-size-sub-header">
                                        {!! $feature['feature_icon'] !!}
                                    </span>
                                @else
                                    <i class="{{ $feature['feature_icon'] }} text-brand-red text-size-sub-header"></i>
                                @endif
                            </div>
                            <div>
                                <h2 class="font-bold text-size-sub-header text-brand-charcoal">
                                    {{ $feature['feature_title'] ?? 'Feature Title' }}
                                </h2>
                                <p class="text-size-body text-gray-500">
                                    {{ $feature['feature_desc'] ?? 'Feature description goes here.' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div data-aos="fade-up" data-aos-delay="500" class="flex justify-center sm:justify-start">
                    <a href="{{ url($btn_link) }}"
                        class="inline-flex items-center px-8 py-4 text-size-sub-header bg-brand-charcoal text-white rounded-lg font-bold hover:bg-brand-red transition-all duration-300 shadow-xl group">
                        {{ $btn_text }}
                        <i
                            class="fa-solid fa-arrow-right text-size-sub-header ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- Right Image/Quote Column --}}
            <div class="lg:col-span-7 relative" data-aos="fade-left" data-aos-duration="1200">
                <div class="relative h-[550px] w-full rounded-2xl overflow-hidden shadow-2xl group">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 group-hover:scale-110"
                        style="background-image: url('{{ asset('images/' . $image) }}'); background-color: #1a1a1a;">
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-14">
                        <div class="border-l-4 border-brand-red pl-8" data-aos="fade-up" data-aos-delay="800">
                            <p class="font-heading font-bold text-size-header text-white mb-4 leading-snug">
                                "{{ $ceo_quote }}"
                            </p>
                            <p class="text-brand-red font-bold tracking-widest uppercase text-size-sub-header">
                                — Message from CEO
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Floating Experience Badge --}}
                <div class="absolute -top-6 right-0 xl:-right-12 2xl:top-12 2xl:-right-12 bg-white p-4 md:p-8 rounded-2xl shadow-2xl border border-gray-100 hidden sm:block animate-float"
                    data-aos="zoom-in" data-aos-delay="1000">
                    <div class="text-center">
                        <span class="block text-size-title font-heading font-bold text-brand-red mb-1">
                            {{ $years_experience }}
                        </span>
                        <span
                            class="block text-accent font-medium text-brand-charcoal uppercase tracking-tighter leading-tight">
                            Years of <br> Excellence
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@pushOnce('css')
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }
    </style>
@endPushOnce