@props(['data'])

@php
    // Title (first item)
    $title = $data[0][0]['title'] ?? '';

    // Client names (remaining items)
    $clients = collect($data)
        ->skip(1)
        ->map(function ($item) {
            return [
                'name' => $item[0]['name'] ?? null,
                'image' => $item[0]['image'] ?? null,
            ];
        })
        ->filter(fn($client) => !empty($client['name']))
        ->values();


@endphp
{{-- Client Logos Slider --}}
<div class="bg-white custom_py border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        <h2 class="text-2xl font-bold text-center mb-8">{{ $title }}</h2>

        {{-- Slider --}}
        <div class="swiper swiperClients relative overflow-hidden flex justify-center">
            <div class="swiper-wrapper !items-center">
                @foreach($clients as $client)
                            <div class="swiper-slide flex items-center justify-center">
                                <div
                                    class="w-32 h-16 flex items-center justify-center opacity-60 grayscale transition duration-300 hover:grayscale-0 hover:opacity-100">
                                    <img src="{{ !empty($client['image'])
                    ? asset('images/' . ltrim($client['image'], '/'))
                    : asset('images/placeholder.jpg') }}" alt="{{ $client['name'] }}"
                                        class="w-full h-full object-contain object-center" />
                                </div>
                            </div>
                @endforeach
            </div>
            <div class="swiper-button-next !text-gray-400 after:!text-xl"></div>
            <div class="swiper-button-prev !text-gray-400 after:!text-xl"></div>
            {{-- <div class="swiper-pagination "></div> --}}
        </div>

    </div>
</div>

@push('js')
    <script>
        (function () {
            if (typeof Swiper === 'undefined') return;
            var el = document.querySelector('.swiperClients');
            if (!el) return;
            function init() {
                new Swiper('.swiperClients', {
                    slidesPerView: 2,
                    spaceBetween: 24,
                    speed: 600,
                    centeredSlides: true,
                    loop: {{ count($clients) > 3 ? 'true' : 'false' }},
                    autoplay: { delay: 3000, disableOnInteraction: false },
                    navigation: {
                        nextEl: '.swiperClients .swiper-button-next',
                        prevEl: '.swiperClients .swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiperClients .swiper-pagination',
                        clickable: true,
                    },
                    watchOverflow: true,
                    breakpoints: {
                        480: { slidesPerView: 3, spaceBetween: 24, centeredSlides: true },
                        768: { slidesPerView: 4, spaceBetween: 32, centeredSlides: true },
                        1024: { slidesPerView: 5, spaceBetween: 40, centeredSlides: true },
                    },
                });
            }
            if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
            else init();
        })();
    </script>
@endpush