@props(['data' => []])
@php
    $headerSettings = $data[0][0] ?? [];
    $title = $headerSettings['product_slider_title'] ?? 'Our Products';
    $subtitle = $headerSettings['product_slider_subtitle'] ?? 'Reliable elevator solutions.';

    $allProducts = array_values(array_filter($data, function ($item, $key) {
        return is_numeric($key) && isset($item[0]['product_name']);
    }, ARRAY_FILTER_USE_BOTH));

    $jsProducts = array_map(function ($item) {
        $p = $item[0];
        $imgs = json_decode($p['images'] ?? '[]', true);
        return [
            'src' => !empty($imgs) ? asset('images/' . $imgs[0]) : null,
            'name' => $p['product_name'] ?? 'Product'
        ];
    }, $allProducts);
@endphp

<section class="py-16 lg:py-24 bg-gray-50 relative" x-data="{ 
        productModal: false, 
        pIndex: 0,
        productList: {{ json_encode($jsProducts) }},
        openProduct(index) {
            this.pIndex = index;
            this.productModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeProduct() {
            window.dispatchEvent(new CustomEvent('lightbox:close'));
            this.productModal = false;
            document.body.style.overflow = 'auto';
        },
        nextP() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.pIndex = (this.pIndex + 1) % this.productList.length;
        },
        prevP() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.pIndex = (this.pIndex - 1 + this.productList.length) % this.productList.length;
        }
    }" @keydown.window.escape="closeProduct()" @keydown.window.right="nextP()" @keydown.window.left="prevP()">

    <div class="max-w-7xl mx-auto px-4">
        {{-- Header Area --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div data-aos="fade-right">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-brand-red font-bold uppercase tracking-widest text-size-sub-header">{{ $title }}</span>
                </div>
                <h2 class="text-size-title leading-[1.1] font-bold text-brand-charcoal">{{ $subtitle }}</h2>
            </div>

            <div class="hidden md:flex gap-3">
                <button
                    class="swiper-prev-prod w-12 h-12 rounded-full border border-gray-200 bg-white text-brand-charcoal hover:bg-brand-red hover:text-white transition-all flex items-center justify-center shadow-sm cursor-pointer">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button
                    class="swiper-next-prod w-12 h-12 rounded-full border border-gray-200 bg-white text-brand-charcoal hover:bg-brand-red hover:text-white transition-all flex items-center justify-center shadow-sm cursor-pointer">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>

        {{-- Swiper Slider --}}
        <div class="swiper product-swiper">
            <div class="swiper-wrapper">
                @foreach($allProducts as $index => $item)
                    @php
                        $product = $item[0];
                        $name = $product['product_name'] ?? '';
                        $imagesArr = json_decode($product['images'] ?? '[]', true);
                        $imagePath = (!empty($imagesArr)) ? asset('images/' . $imagesArr[0]) : null;
                    @endphp

                    <div class="swiper-slide h-auto">
                        <div @click="openProduct({{ $index }})"
                            class="group relative aspect-[4/5] rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-xl transition-all duration-500 hover:-translate-y-2 cursor-zoom-in">

                            @if($imagePath)
                                <img src="{{ $imagePath }}" alt="{{ $name }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @endif

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent flex flex-col justify-end p-6">
                                <h3 class="font-bold text-xl text-white mb-1 group-hover:text-brand-red transition-colors">
                                    {{ $name }}
                                </h3>
                                <div
                                    class="flex items-center text-brand-red text-sm font-semibold opacity-0 group-hover:opacity-100 transition-opacity translate-y-2 group-hover:translate-y-0 duration-300">
                                    <i class="fa-solid fa-magnifying-glass-plus mr-2"></i> View Full Image
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination-prod mt-6 w-full text-center"></div>
        </div>
    </div>

    {{-- Universal Lightbox (SAME STYLE AS PORTFOLIO) --}}
    <template x-teleport="body">
        <div x-show="productModal" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeProduct()"></div>

            <!-- UI Controls (Counter top right) -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(pIndex + 1) + ' / ' + productList.length"></span>
                <button @click="closeProduct()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons (Circular Style) -->
            <button @click="prevP()"
                class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
            </button>
            <button @click="nextP()"
                class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
            </button>

            <!-- Content Container -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="productModal" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                <!-- Image (Zoom + Pan) -->
                <div x-data="lightboxZoom()"
                    class="overflow-hidden rounded-sm shadow-2xl border border-white/10 pointer-events-auto"
                    :style="window.innerWidth < 768 ? 'width: 90vw; max-height: 75vh;' : 'max-width: 85vw; max-height: 75vh;'"
                    :class="cursorClass" @mousedown.prevent="startPan($event)" @mousemove.window="doPan($event)"
                    @mouseup.window="stopPan()" @mouseleave.window="stopPan()" @touchstart="startTouchPan($event)"
                    @touchmove.prevent="doTouchPan($event)" @touchend="stopPan()" @click.stop="toggleZoom()">

                    <img :src="productList[pIndex].src" :alt="productList[pIndex].name || 'Product Image'"
                        class="w-full h-full object-contain select-none" :style="imgStyle" draggable="false">
                </div>

                <!-- Caption -->
                <div class="text-center mt-4 pointer-events-none">
                    <p x-text="productList[pIndex].name"
                        class="text-white font-medium text-lg md:text-2xl tracking-wide"></p>
                </div>
            </div>
        </div>
    </template>
</section>
@pushOnce('css')
    <style>
        /* Make the pagination container behave well in the layout */
        .swiper-pagination-prod {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
            margin-top: 2rem !important;
            position: relative !important;
        }

        /* Style the inactive "dots" - Darker gray for white backgrounds */
        .swiper-pagination-prod .swiper-pagination-bullet {
            background: #9ca3af !important;
            /* Tailwind gray-400 */
            opacity: 0.4;
            width: 10px;
            height: 10px;
            transition: all 0.3s ease;
        }

        /* Style the active "dot" - Brand Red and elongated */
        .swiper-pagination-prod .swiper-pagination-bullet-active {
            background: #0089f0 !important;
            /* Your brand-red color */
            opacity: 1;
            width: 14px;
            height: 14px;
            /* Makes it a pill shape */
            border-radius: 99px;
        }
    </style>
@endPushOnce

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.product-swiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true, // Enables continuous loop mode
                autoplay: {
                    delay: 3000, // Slides every 3 seconds
                    disableOnInteraction: false, // Keeps autoplay running even after user clicks
                    pauseOnMouseEnter: false, // Pauses when user hovers over the slider
                },
                pagination: {
                    el: '.swiper-pagination-prod',
                    clickable: true
                },
                navigation: {
                    nextEl: '.swiper-next-prod',
                    prevEl: '.swiper-prev-prod'
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    },
                    1280: {
                        slidesPerView: 4
                    }
                },
                on: {
                    init: function () {
                        if (window.AOS) {
                            window.AOS.refresh();
                        }
                    }
                }
            });
        });
    </script>
@endpush