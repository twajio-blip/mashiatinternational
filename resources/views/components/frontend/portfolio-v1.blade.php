@props(['data' => []])
@php
    $data = $data ?? [];

    // 1. Extract Header Block
    $headerBlock = $data[0][0] ?? [];
    $headerTitle = $headerBlock['title'] ?? 'Recent Installations';
    $headerSubTitle = $headerBlock['sub_title'] ?? 'Our Portfolio';
    $btnLink = $headerBlock['btn_link'] ?? '#';
    $btnText = $headerBlock['btn_text'] ?? 'View All Projects';

    // 2. Filter and Reverse Projects
    $projectItems = array_filter($data, function ($item, $key) {
        return is_numeric($key) && $key > 0 && isset($item[0]['title']);
    }, ARRAY_FILTER_USE_BOTH);

    $projectItems = array_reverse($projectItems);
    $limitedProjects = array_slice($projectItems, 0, 3);

    // 3. Logic for Blade View
    $featured = null;
    $others = [];
    if (count($limitedProjects) > 0) {
        $featured = $limitedProjects[0][0];
        $others = array_slice($limitedProjects, 1);
    }

    // 4. PREPARE JS GALLERY ARRAY (Same to same logic)
    $jsGallery = array_map(function($item) {
        $p = $item[0];
        $imgs = json_decode($p['images'] ?? '[]', true);
        return [
            'src' => !empty($imgs) ? asset('images/' . $imgs[0]) : '',
            'name' => $p['title'] ?? '', // Changed 'title' to 'name' to match previous logic
            'location' => $p['location'] ?? ''
        ];
    }, $limitedProjects);
@endphp

<section class="py-16 lg:py-24 bg-gray-50 w-full overflow-hidden" 
    x-data="{ 
        imgModal: false, 
        currentIndex: 0,
        products: {{ json_encode($jsGallery) }},
        openModal(index) {
            this.currentIndex = index;
            this.imgModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            window.dispatchEvent(new CustomEvent('lightbox:close'));
            this.imgModal = false;
            document.body.style.overflow = 'auto';
        },
        next() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.currentIndex = (this.currentIndex + 1) % this.products.length;
        },
        prev() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.currentIndex = (this.currentIndex - 1 + this.products.length) % this.products.length;
        }
    }"
    @keydown.window.escape="closeModal()"
    @keydown.window.right="next()"
    @keydown.window.left="prev()">

    <div class="max-w-7xl mx-auto px-4">
        {{-- Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <h3 class="text-brand-red tracking-wider uppercase text-size-sub-header">{{ $headerSubTitle }}</h3>
            </div>
            <h2 class="text-size-title font-bold text-brand-charcoal mb-4 leading-[1.1]">{{ $headerTitle }}</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Featured Large Project --}}
            @if($featured)
                @php $featImg = !empty(json_decode($featured['images'] ?? '[]', true)) ? asset('images/' . json_decode($featured['images'])[0]) : ''; @endphp
                <div @click="openModal(0)"
                    class="lg:col-span-2 block group rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-500 cursor-zoom-in relative h-[400px] lg:h-[600px]"
                    data-aos="fade-right">
                    <div class="absolute inset-0 bg-gray-200">
                        <img src="{{ $featImg }}" alt="{{ $featured['title'] }}" class="absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent z-10"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12 z-20">
                        <span class="inline-block px-3 py-1 bg-brand-red text-white text-xs font-bold uppercase tracking-wider rounded-md mb-4">{{ $featured['category'] ?? '' }}</span>
                        <h3 class="text-3xl md:text-4xl font-heading font-bold text-white mb-4">{{ $featured['title'] }}</h3>
                        <div class="flex items-center text-white/80"><i class="fa-solid fa-location-dot mr-2 text-brand-red"></i>{{ $featured['location'] ?? '' }}</div>
                    </div>
                </div>
            @endif

            {{-- Smaller Projects Column --}}
            <div class="flex flex-col gap-8">
                @foreach($others as $index => $item)
                    @php 
                        $project = $item[0];
                        $pImg = !empty(json_decode($project['images'] ?? '[]', true)) ? asset('images/' . json_decode($project['images'])[0]) : '';
                        $galleryIndex = $index + 1; 
                    @endphp
                    <div @click="openModal({{ $galleryIndex }})"
                        class="flex-1 block group rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-500 cursor-zoom-in relative min-h-[280px]"
                        data-aos="fade-left" data-aos-delay="{{ $index * 200 }}">
                        <div class="absolute inset-0 bg-gray-200">
                            <img src="{{ $pImg }}" alt="{{ $project['title'] }}" class="absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-6 z-20">
                            <span class="text-brand-red text-xs font-bold uppercase tracking-wider mb-2 block">{{ $project['category'] ?? '' }}</span>
                            <h4 class="text-xl font-bold text-white mb-2 group-hover:text-brand-red transition-colors">{{ $project['title'] }}</h4>
                            <div class="flex items-center text-sm text-white/70"><i class="fa-solid fa-location-dot mr-1 text-brand-red"></i>{{ $project['location'] ?? '' }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Footer Link --}}
        <div class="text-center mt-16" data-aos="fade-up">
            <a href="{{ url($btnLink) }}" class="inline-flex items-center px-8 py-4 bg-gray-50 text-brand-charcoal font-bold rounded-lg hover:bg-gray-200 transition-colors border border-gray-200 group">
                {{ $btnText }}
                <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>

    {{-- Gallery Lightbox (SAME TO SAME STYLE) --}}
    <template x-teleport="body">
        <div x-show="imgModal" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeModal()"></div>

            <!-- UI Controls (Counter top right) -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(currentIndex + 1) + ' / ' + products.length"></span>
                <button @click="closeModal()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Arrows -->
            <button @click="prev()" class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white text-size-body bg-black/60 rounded-full md:text-size-header z-50 px-2 py-1 transition-all ">
                <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
            </button>
            <button @click="next()" class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white text-size-body bg-black/60 rounded-full md:text-size-header z-50 px-2 py-1 transition-all">
                <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
            </button>

            <!-- Content -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="imgModal" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                <!-- Image (Zoom + Pan) -->
                <div x-data="lightboxZoom()"
                    class="overflow-hidden rounded-sm shadow-2xl pointer-events-auto"
                    :style="window.innerWidth < 768 ? 'width: 70vw; max-height: 75vh;' : 'max-width: 85vw; max-height: 75vh;'"
                    :class="cursorClass"
                    @mousedown.prevent="startPan($event)"
                    @mousemove.window="doPan($event)"
                    @mouseup.window="stopPan()"
                    @mouseleave.window="stopPan()"
                    @touchstart="startTouchPan($event)"
                    @touchmove.prevent="doTouchPan($event)"
                    @touchend="stopPan()"
                    @click.stop="toggleZoom()">
                    <img :src="products[currentIndex].src"
                        class="w-full h-full object-contain select-none"
                        :style="imgStyle" draggable="false">
                </div>

                <!-- Caption -->
                <div class="text-center mt-2 pointer-events-none">
                    <p x-text="products[currentIndex].name" class="text-white font-medium text-lg md:text-2xl tracking-wide"></p>
                    <p x-text="products[currentIndex].location" class="text-white/50 text-sm mt-1"></p>
                </div>
            </div>
        </div>
    </template>
</section>