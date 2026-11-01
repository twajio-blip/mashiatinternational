@props(['data' => []])

@php
    // [0][0]: Main Text Content
    $content = $data[0][0] ?? [];

    // [0][1]: Core Values Loop
    $values = $data[0][1]['instances'] ?? [];

    // Content Variables
    $label = $content['label'] ?? 'About RAR Lift';
    $title = $content['title'] ?? 'Elevating Standards in Vertical Transportation';
    $desc1 = $content['desc1'] ?? '';
    $desc2 = $content['desc2'] ?? '';

    // CEO Data
    $quote = $content['quote'] ?? '';
    $ceo_name = $content['ceo_name'] ?? 'Message from CEO';

    // Image Data
    $mainImg = $content['img'] ?? null;
    $imgText = $content['img_text'] ?? 'Premium Installation';
@endphp

<section id="about" class="py-16 lg:py-24 bg-white overflow-hidden w-full">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left Content --}}
            <div data-aos="fade-right" data-aos-duration="800">
                <div class="flex items-center space-x-2 mb-4">
                    <h3 class="text-brand-red font-semibold tracking-wider uppercase text-size-sub-header">
                        {{ $label }}
                    </h3>
                </div>

                <h1 class="text-size-title font-heading font-bold text-brand-charcoal mb-6 leading-[1.1]">
                    {{ $title }}
                </h1>

                <p class="text-gray-700 text-size-body mb-6 leading-relaxed">
                    {{ $desc1 }}
                </p>

                <p class="text-gray-700 text-size-body mb-8 leading-relaxed">
                    {{ $desc2 }}
                </p>

                {{-- CEO Quote --}}
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-brand-red relative mb-10">
                    <i class="fa-solid fa-quote-right absolute top-4 right-4 text-4xl text-gray-700"></i>

                    <p class="text-brand-charcoal text-size-accent italic font-medium mb-4 relative z-10">
                        "{{ $quote }}"
                    </p>

                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-brand-charcoal rounded-full mr-3 flex items-center justify-center text-white text-[10px] font-bold uppercase">
                            {{ substr($ceo_name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="font-bold text-brand-charcoal text-size-body">{{ $ceo_name }}</h2>
                            <span class="text-size-accent text-gray-700">RAR Lift Limited</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content - Dynamic Values Grid --}}
            <div class="relative" data-aos="fade-left" data-aos-delay="200" data-aos-duration="800">
                {{-- Background Decorative Element - Reduced rotation for a cleaner look --}}
                <div
                    class="absolute -inset-4 bg-gradient-to-tr from-gray-50 to-gray-100/50 rounded-3xl transform rotate-2 -z-10 border border-gray-100">
                </div>

                <div class="bg-white p-10 rounded-2xl shadow-2xl border border-gray-50 relative overflow-hidden">
                    {{-- Subtle background pattern for modern feel --}}
                    <div class="absolute top-0 right-0 w-32 h-32 bg-brand-red/5 rounded-full -mr-16 -mt-16 blur-3xl">
                    </div>

                    <h3
                        class="text-size-header font-heading font-bold mb-10 text-brand-charcoal flex items-center gap-3">
                        {{ $content['values_title'] ?? 'Our Core Values' }}
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-10">
                        @foreach($values as $value)
                            <div class="group flex flex-col transition-all duration-300">
                                {{-- Icon Container: Modern Gradient & Glow --}}
                                <div
                                    class="w-14 h-14 bg-white shadow-md rounded-xl flex items-center justify-center text-brand-red mb-5 group-hover:bg-brand-red group-hover:text-white transition-all duration-500 border border-gray-100 group-hover:border-brand-red group-hover:shadow-brand-red/20">
                                    <i class="{{ $value['icon'] ?? 'fa-solid fa-check' }} text-xl"></i>
                                </div>

                                <h3
                                    class="text-size-sub-header font-bold text-brand-charcoal mb-3 group-hover:text-brand-red transition-colors">
                                    {{ $value['title'] ?? 'Value' }}
                                </h3>

                                <p class="text-size-body text-gray-700 leading-relaxed">
                                    {{ $value['desc'] ?? '' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Floating Image: Modern Glassmorphism treatment --}}
                <div class="absolute -bottom-12 right-0 xl:-right-12 w-56 h-56 hidden lg:block z-20">
                    <div class="relative w-full h-full group">
                        {{-- Image Shadow/Glow --}}
                        <div
                            class="absolute inset-0 bg-brand-charcoal/20 rounded-2xl blur-xl group-hover:blur-2xl transition-all">
                        </div>

                        <div
                            class="relative w-full h-full bg-brand-charcoal rounded-2xl overflow-hidden border-8 border-white shadow-2xl transition-transform duration-500 group-hover:-translate-y-2 group-hover:rotate-2">
                            @if($mainImg)
                                <img src="{{ asset('images/' . $mainImg) }}" alt="{{ $imgText }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

                                {{-- Modern Overlay: Bottom-up gradient --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end p-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-brand-red text-size-accent font-black uppercase tracking-[0.2em] mb-1">Feature</span>
                                        <span class="text-white font-bold text-xs uppercase tracking-wider leading-tight">
                                            {{ $imgText }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-brand-charcoal to-black flex items-center justify-center p-6 text-center">
                                    <span class="text-white/30 font-bold text-[10px] uppercase tracking-widest">
                                        {{ $imgText }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>