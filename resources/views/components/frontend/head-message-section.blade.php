@props(['data'])

@php
    $title = $data[0][0]['title'] ?? '';
    $subtitle = $data[0][0]['subtitle'] ?? '';
    $items = collect($data)->skip(1)->map(fn($item) => $item[0] ?? null)->filter()->values();
@endphp

<section class="relative custom_py bg-gradient-to-br from-gray-50 to-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900">{{ $title }}</h2>
            <p class="text-gray-500 mt-3 text-lg">{{ $subtitle }}</p>
        </div>

        <div class="swiper swiperHeadMessage relative">

            <div class="swiper-wrapper">

                @foreach($items as $index => $content)
                            <div class="swiper-slide">

                                <div class="grid md:grid-cols-2 gap-16 items-center">

                                    {{-- IMAGE --}}
                                    <div class="{{ $index % 2 != 0 ? 'md:order-2' : '' }}">
                                        <div class="relative group">
                                            <img src="{{ !empty($content['image'])
                    ? asset('images/' . ltrim($content['image'], '/'))
                    : asset('images/placeholder.jpg') }}" alt="{{ $content['name'] }}"
                                                class="w-full h-[420px] object-contain rounded-2xl " />

                                        </div>
                                    </div>

                                    {{-- TEXT --}}
                                    <div class="{{ $index % 2 != 0 ? 'md:order-1' : '' }}">

                                        <div class="bg-white/70 backdrop-blur-xl p-10 rounded-2xl shadow-xl border border-gray-100">

                                            <div class="flex items-start mb-6">
                                                <span class="text-6xl text-indigo-200 leading-none font-serif mr-4">
                                                    &ldquo;
                                                </span>

                                                <div class="text-gray-700 text-lg leading-relaxed">
                                                    {!! $content['description'] !!}
                                                </div>
                                            </div>

                                            <div class="pt-6 border-t border-gray-200 mt-6">
                                                <h3 class="text-2xl font-bold text-gray-900">
                                                    {{ $content['name'] }}
                                                </h3>
                                                <p class="text-indigo-600 font-semibold mt-1 tracking-wide">
                                                    {{ $content['designation'] }}
                                                </p>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                @endforeach

            </div>

            @if($items->count() > 1)

                <div class="swiper-button-next !text-indigo-600 after:!text-2xl"></div>
                <div class="swiper-button-prev !text-indigo-600 after:!text-2xl"></div>

                <div class="swiper-pagination mt-8"></div>

            @endif

        </div>
    </div>
</section>

@if($items->count() > 0)
    @push('js')
        <script>
            (function () {
                if (typeof Swiper === 'undefined') return;
                var el = document.querySelector('.swiperHeadMessage');
                if (!el) return;
                function init() {
                    new Swiper('.swiperHeadMessage', {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        speed: 600,
                        loop: {{ $items->count() > 1 ? 'true' : 'false' }},
                        autoplay: { delay: 5000, disableOnInteraction: false },
                        navigation: {
                            nextEl: '.swiperHeadMessage .swiper-button-next',
                            prevEl: '.swiperHeadMessage .swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiperHeadMessage .swiper-pagination',
                            clickable: true,
                        },
                        watchOverflow: true,
                    });
                }
                if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
                else init();
            })();
        </script>
    @endpush
@endif