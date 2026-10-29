@props(['data' => []])

@php
    $item = $data[0][0] ?? [];

    $title = $item['title'] ?? 'Ready to Elevate Your Building?';
    $subtitle = $item['subtitle'] ?? 'Get a free consultation and quote for your next project. Our experts are ready to provide the perfect vertical mobility solution tailored to your needs.';
    $btn_text = $item['btn_text'] ?? 'Get Free Quote';
    $btn_link = $item['btn_link'] ?? 'contact';
@endphp

<section class="relative py-16 lg:py-24 bg-brand-charcoal overflow-hidden">

    <!-- Angled Background -->
    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute -top-[50%] -right-[10%] w-[50%] h-[200%] bg-brand-red/10 rotate-12"></div>
        <div class="absolute -bottom-[50%] -left-[10%] w-[30%] h-[200%] bg-white/5 -rotate-12"></div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 relative z-10 text-center">
        <div data-aos="zoom-in" data-aos-duration="500" data-aos-once="true">

            <h2 class="text-size-title leading-[1.1] font-heading font-bold text-white mb-6">
                {{ $title }}
            </h2>

            <p class="text-size-body text-gray-300 mb-10 max-w-2xl mx-auto">
                {{ $subtitle }}
            </p>

            <a href="{{ url($btn_link) }}"
                class="text-size-sub-header inline-flex items-center px-8 py-4 bg-brand-red text-white rounded-lg font-bold hover:bg-white hover:text-brand-red transition-all duration-300 shadow-lg hover:shadow-xl group">

                {{ $btn_text }}

                <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>

            </a>

        </div>
    </div>

</section>