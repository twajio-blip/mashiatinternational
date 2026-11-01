@props(['data' => []])
@php
    $data = $data ?? [];

    // 1. Correct Header Logic for this array
    $header = $data[0][0] ?? [];
    $title = $header['product_slider_title'] ?? 'Our Products';
    $subtitle = $header['product_slider_subtitle'] ?? '';

    // 2. Filter and Map Products (indices 1 to 12)
    $products = collect($data)
        ->filter(fn($item, $key) => is_numeric($key) && $key > 0)
        ->map(function ($item) {
            $details = $item[0] ?? [];
            $images = json_decode($details['images'] ?? '[]', true) ?: [];

            return [
                'name' => $details['product_name'] ?? 'Elevator Solution',
                'image' => !empty($images) ? asset('images/' . $images[0]) : null,
            ];
        })->values();
@endphp

<section class="py-16 lg:py-24 bg-gray-50" x-data="{
        productModal: false,
        pIndex: 0,
        productList: {{ json_encode($products->map(fn($p) => ['src' => $p['image'], 'name' => $p['name']])->values()) }},
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

        {{-- Section Header --}}
        <div class="text-center mb-16">
            <h2 class="text-size-title font-extrabold text-brand-charcoal">{{ $title }}</h2>
            @if($subtitle)
                <p class="text-size-body text-gray-500 mt-4 max-w-2xl mx-auto">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Products Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($products as $product)
                {{-- Main Card Container --}}
                <div @click="openProduct({{ $loop->index }})" class="group relative cursor-zoom-in" data-aos="fade-up">

                    {{-- Modern Floating Shadow Effect --}}
                    <div
                        class="relative bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] transition-all duration-500 group-hover:-translate-y-3">

                        {{-- Full-Bleed Image Container (No Padding) --}}
                        <div class="relative aspect-[4/5] overflow-hidden">
                            @if($product['image'])
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                                    class="w-full h-full object-cover transition-transform duration-1000 ease-out group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50">
                                    <i class="fa-solid fa-image text-4xl text-slate-200"></i>
                                </div>
                            @endif

                            {{-- Minimalist Overlay --}}
                            <div
                                class="absolute inset-0 bg-brand-charcoal/40 opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center backdrop-blur-[2px]">
                                <div
                                    class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-2xl translate-y-4 group-hover:translate-y-0 transition-all duration-500">
                                    <i class="fa-solid fa-expand text-brand-charcoal text-xl"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Simple, Clean Title Area --}}
                        <div class="p-6 text-center">
                            <h2
                                class="text-lg font-bold text-brand-charcoal group-hover:text-brand-red transition-colors duration-300">
                                {{ $product['name'] }}
                            </h2>

                            {{-- Animated Accent Line --}}
                            <div class="mt-4 flex justify-center">
                                <div class="h-[3px] w-6 bg-slate-100 rounded-full overflow-hidden relative">
                                    <div
                                        class="absolute inset-0 bg-brand-red -translate-x-full group-hover:translate-x-0 transition-transform duration-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center opacity-40">
                    <p>No images found.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Product-Slider Style Lightbox --}}
    <template x-teleport="body">
        <div x-show="productModal" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeProduct()"></div>

            <!-- UI Controls: Counter + Close -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(pIndex + 1) + ' / ' + productList.length"></span>
                <button @click="closeProduct()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons -->
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
                    <img :src="productList[pIndex].src" class="w-full h-full object-contain select-none"
                        :style="imgStyle" draggable="false">
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