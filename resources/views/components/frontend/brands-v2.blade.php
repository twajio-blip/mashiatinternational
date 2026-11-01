@props(['data' => []])
@php
    $data = $data ?? [];

    // Detect query param
    $queryKeys = array_keys(request()->query());
    $requestedBrandSlug = !empty($queryKeys) ? $queryKeys[0] : null;

    // Build all brands list
    $allBrandItems = collect($data)->filter(
        fn($item, $key) =>
        is_numeric($key) && $key >= 1 && is_array($item) && isset($item[0])
    )->values();

    $brands = $allBrandItems->map(function ($item) use ($data) {
        $details = $item[0] ?? [];
        $factory = $item[2] ?? [];
        $factoryImgs = is_string($factory['testing_factory_img'] ?? null)
            ? (json_decode($factory['testing_factory_img'], true) ?: [])
            : ($factory['testing_factory_img'] ?? []);
        $brandName = $details['brand_name'] ?? ($details['name'] ?? 'Brand');
        $url = url('/brands?' . urlencode(str_replace(' ', '_', $brandName)));

        return [
            'name' => $brandName,
            'logo' => $details['brand_logo'] ?? null,
            'type' => $details['type'] ?? 'Partner',
            'origin' => $details['origin'] ?? 'Global',
            'factory_img' => $factoryImgs[0] ?? null,
            'url' => $url,
            '_raw' => $item,
        ];
    });

    // Match Brand
    $selectedBrandData = null;
    if ($requestedBrandSlug) {
        $needle = strtolower(str_replace(['_'], ' ', urldecode($requestedBrandSlug)));
        $matched = $brands->first(function ($b) use ($needle) {
            $name = strtolower($b['name']);
            return $name === $needle || str_contains($name, $needle) || str_contains($needle, $name);
        });
        if ($matched) {
            $selectedBrandData = $matched['_raw'];
        }
    }

    if ($selectedBrandData) {
        $det = $selectedBrandData[0] ?? [];
        $brandName = $det['brand_name'] ?? 'Brand';
        $brandTitle = $det['title'] ?? '';
        $brandSubtitle = $det['subtitle'] ?? '';
        $desc1 = $det['description_1'] ?? '';
        $desc2 = $det['description_2'] ?? '';
        $origin_flag = $det['origin_flag'] ?? '';
        $origin = $det['origin'] ?? '';
        $established = $det['established'] ?? '';
        $type = $det['type'] ?? '';
        $brandLogo = $det['brand_logo'] ?? null;
        $tags = $selectedBrandData[1]['instances'] ?? [];
        $sectionLabels = $selectedBrandData[5] ?? [];

        $factory = $selectedBrandData[2] ?? [];
        $factoryTitle = $sectionLabels['testing _factory_title'] ?? ($factory['title'] ?? 'Technical Excellence');
        $factorySubtitle = $sectionLabels['testing _factory_subtitle'] ?? ($factory['subtitle'] ?? 'Testing Factory');
        $factoryDesc = $factory['description'] ?? '';
        $factoryImages = json_decode($factory['testing_factory_img'] ?? '[]', true) ?: [];

        $certTitle = $sectionLabels['cartificate_factory_title'] ?? 'Our Credentials';
        $certSubtitle = $sectionLabels['cartificate_factory_subtitle'] ?? 'Quality & Safety Standards';

        $portTitle = $sectionLabels['portfolio_section_title'] ?? 'Proven Track Record';
        $portSubtitle = $sectionLabels['portfolio_section_subtitle'] ?? 'Project Portfolio';

        $certificates = collect($selectedBrandData[3]['instances'] ?? [])->map(fn($cert) => [
            'name' => $cert['certificate_name'] ?? 'Certificate',
            'no' => $cert['certificate_no'] ?? 'N/A',
            'image' => asset('images/' . (json_decode($cert['cartificates_img'] ?? '[]', true)[0] ?? $cert['cartificates_img'] ?? '')),
        ]);

        $portfolio = collect($selectedBrandData[4]['instances'] ?? [])->map(fn($p) => [
            'client' => $p['client'] ?? 'Client',
            'place' => $p['place'] ?? '',
            'image' => asset('images/' . ($p['portfolio_image'] ?? '')),
        ]);

        // Prepare JS arrays for Lightbox
        $factoryJs = collect($factoryImages)->map(fn($img) => [
            'src' => asset('images/' . $img),
            'title' => $factorySubtitle
        ])->values()->toArray();

        $certJs = $certificates->map(fn($c) => [
            'src' => $c['image'],
            'title' => $c['name']
        ])->values()->toArray();

        $portJs = $portfolio->map(fn($p) => [
            'src' => $p['image'],
            'title' => $p['client']
        ])->values()->toArray();
    }
@endphp

<div x-data="{ 
    brandLightboxOpen: false, 
    brandActiveIndex: 0,
    brandActiveList: [],
    brandLists: {
        factory: {{ json_encode($factoryJs ?? []) }},
        cert: {{ json_encode($certJs ?? []) }},
        portfolio: {{ json_encode($portJs ?? []) }}
    },

    init() {
        // Handle keyboard navigation globally without breaking HTML validation
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') this.closeBrandLightbox();
            
            if (this.brandLightboxOpen) {
                if (e.key === 'ArrowRight') this.nextB();
                if (e.key === 'ArrowLeft') this.prevB();
            }
        });
    },

    openBrandLightbox(index, type) {
        this.brandActiveList = this.brandLists[type];
        this.brandActiveIndex = index;
        this.brandLightboxOpen = true;
        document.body.style.overflow = 'hidden';
    },

    closeBrandLightbox() {
        window.dispatchEvent(new CustomEvent('lightbox:close'));
        this.brandLightboxOpen = false;
        document.body.style.overflow = 'auto';
    },

    nextB() {
        window.dispatchEvent(new CustomEvent('lightbox:navigate'));
        this.brandActiveIndex = (this.brandActiveIndex + 1) % this.brandActiveList.length;
    },

    prevB() {
        window.dispatchEvent(new CustomEvent('lightbox:navigate'));
        this.brandActiveIndex = (this.brandActiveIndex - 1 + this.brandActiveList.length) % this.brandActiveList.length;
    }
}">
    @if($selectedBrandData)
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        {{-- Section 1: Testing Factory --}}
        <section class="w-full relative py-16 lg:py-24 bg-white border-b-8 border-brand-red overflow-hidden" x-data="{ 
                        mainImage: '{{ !empty($factoryImages) ? asset('images/' . $factoryImages[0]) : '' }}',
                        mainIndex: 0
                    }">
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <p class="text-size-sub-header font-bold text-brand-red uppercase tracking-widest mb-4">
                            {{ $factoryTitle }}
                        </p>
                        <h1 class="text-brand-charcoal text-size-title font-heading font-bold mb-6 leading-[1.1]">
                            {!! str_replace('Testing', '<br>Testing', $factorySubtitle) !!}
                        </h1>
                        <p class="text-size-body mb-8 leading-relaxed text-slate-700 lg:max-w-xl text-justify">
                            {{ $factoryDesc }}
                        </p>
                        <div class="flex gap-4">
                            <div class="bg-slate-50 border border-slate-100 p-5 rounded-xl flex-1 text-center">
                                <div class="text-brand-red text-size-sub-header font-bold mb-2">
                                    {{ $factory['cert_short_name'] ?? 'ISO' }}
                                </div>
                                <div class="text-size-body text-slate-700">{{ $factory['cert_full_name'] ?? '' }}</div>
                            </div>
                            <div class="bg-slate-50 border border-slate-100 p-5 rounded-xl flex-1 text-center">
                                <div class="text-brand-red text-size-sub-header font-bold mb-2">
                                    {{ $factory['metric_value'] ?? '' }}
                                </div>
                                <div class="text-size-body text-slate-700">{{ $factory['metric_label'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4">
                        {{-- Factory Image Trigger --}}
                        <div class="w-full h-80 md:h-[450px] rounded-2xl overflow-hidden shadow-2xl border-4 border-slate-900 bg-slate-900 relative cursor-zoom-in group"
                            @click="openBrandLightbox(mainIndex, 'factory')">

                            {{-- Added literal src and alt for validator --}}
                            <img src="{{ asset('images/' . ($factoryImages[0] ?? 'placeholder.webp')) }}" :src="mainImage"
                                alt="Factory View"
                                class="w-full h-full object-cover transition-all duration-500 group-hover:scale-105">

                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
                        </div>

                        {{-- Thumbnail Gallery --}}
                        <div class="flex gap-4 overflow-x-auto pb-4 no-scrollbar">
                            @foreach($factoryImages as $imgName)
                                @php $url = asset('images/' . $imgName); @endphp
                                <button @click="mainImage='{{ $url }}'; mainIndex={{ $loop->index }}" type="button"
                                    class="flex-none w-24 h-16 md:w-32 md:h-20 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="mainImage==='{{ $url }}' ? 'border-brand-red scale-95 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100'">

                                    {{-- Added alt for thumbnails --}}
                                    <img src="{{ $url }}" alt="Factory thumbnail {{ $loop->iteration }}"
                                        class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: Brand Details --}}
        <section class="py-24 bg-white relative w-full overflow-hidden">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid lg:grid-cols-12 gap-12 items-start">
                    <div class="lg:col-span-7" data-aos="fade-right">
                        <p class="text-size-body font-bold text-brand-red uppercase tracking-widest mb-4">{{ $brandTitle }}
                        </p>
                        <h2 class="text-brand-charcoal text-size-title font-heading font-bold mb-8 leading-[1.1]">
                            {{ $brandSubtitle }}
                        </h2>
                        <div class="space-y-6 text-size-body text-gray-700 leading-relaxed">
                            <p>{{ $desc1 }}</p>
                            <p>{{ $desc2 }}</p>
                        </div>
                        <div class="mt-8 flex flex-wrap gap-8 justify-center lg:justify-start">
                            @foreach($tags as $tag)
                                <div class="flex flex-col md:flex-row items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-brand-red">
                                        <i class="{{ $tag['tag_icon'] ?? 'fa-solid fa-check' }}"></i>
                                    </div>
                                    <span class="text-size-body font-bold text-slate-900">{{ $tag['tag'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lg:col-span-5" data-aos="fade-left">
                        <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden">
                            <div class="p-8 flex items-center justify-center bg-slate-50/50">
                                @if($brandLogo)
                                    <img src="{{ asset('images/' . $brandLogo) }}" alt="{{ $brandName ?? 'Brand Logo' }}"
                                        class="h-24 object-contain">
                                @endif
                            </div>
                            <div class="p-8 space-y-5">
                                <div class="flex justify-between border-b pb-4">
                                    <span class="text-gray-500">Origin</span>
                                    <span class="font-bold flex items-center gap-2">
                                        @if($origin_flag)
                                            <img src="{{ asset('images/' . $origin_flag) }}" alt="{{ $origin }} Flag"
                                                class="h-4">
                                        @endif
                                        {{ $origin }}
                                    </span>
                                </div>
                                <div class="flex justify-between border-b pb-4"><span
                                        class="text-gray-500">Established</span><span
                                        class="font-bold">{{ $established }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-500">Industry</span><span
                                        class="px-3 py-1 bg-brand-red/10 text-brand-red rounded-full text-xs font-bold">{{ $type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 3: Certificates --}}
        @if($certificates->isNotEmpty())
            <section class="py-20 bg-slate-50 overflow-hidden">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                        <div>
                            <span class="text-brand-red font-bold uppercase tracking-tighter">{{ $certTitle }}</span>
                            <h2 class="text-size-title font-bold text-brand-charcoal">{{ $certSubtitle }}</h2>
                        </div>
                        <div class="flex gap-2">
                            <div
                                class="cert-prev w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center bg-white cursor-pointer hover:bg-brand-red hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-left"></i>
                            </div>
                            <div
                                class="cert-next w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center bg-white cursor-pointer hover:bg-brand-red hover:text-white transition-all">
                                <i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper certificateSwiper !overflow-visible">
                        <div class="swiper-wrapper">
                            @foreach($certificates as $cert)
                                <div class="swiper-slide h-auto">
<div @click="openBrandLightbox({{ $loop->index }}, 'cert')"
    class="group relative bg-white rounded-2xl overflow-hidden shadow-lg aspect-[3/4] cursor-zoom-in">
    
    <img src="{{ $cert['image'] }}"
         alt="Certification: {{ $cert['name'] }}"
         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent">
    </div>
    
    <div class="absolute bottom-0 p-6 text-white">
        <h3 class="font-bold text-lg leading-tight">{{ $cert['name'] }}</h3>
        <p class="text-xs text-white/70 mt-1 font-mono">No: {{ $cert['no'] }}</p>
    </div>
</div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Section 4: Portfolio --}}
        @if($portfolio->isNotEmpty())
            <section class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="flex items-end justify-between mb-12">
                        <div>
                            <span class="text-brand-red font-bold uppercase">{{ $portTitle }}</span>
                            <h2 class="text-size-title font-bold text-brand-charcoal">{{ $portSubtitle }}</h2>
                        </div>
                        <div class="flex gap-2">
                            <div
                                class="port-prev w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center cursor-pointer hover:bg-brand-red hover:text-white transition-all">
                                <i class="fa-solid fa-chevron-left"></i>
                            </div>
                            <div
                                class="port-next w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center cursor-pointer hover:bg-brand-red hover:text-white transition-all">
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper portfolioSwiper">
                        <div class="swiper-wrapper">
                            @foreach($portfolio as $project)
                                <div class="swiper-slide h-auto">
<div @click="openBrandLightbox({{ $loop->index }}, 'portfolio')"
    class="group relative h-[400px] rounded-3xl overflow-hidden shadow-xl cursor-zoom-in bg-slate-900">
    
    <img src="{{ $project['image'] }}"
         alt="Project for {{ $project['client'] }}{{ $project['place'] ? ' in ' . $project['place'] : '' }}"
         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:opacity-60">
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent">
    </div>
    
    <div class="absolute bottom-0 p-8 w-full transition-transform duration-500 group-hover:-translate-y-2">
        <h3 class="text-white text-2xl font-bold mb-2">{{ $project['client'] }}</h3>
        @if($project['place'])
            <p class="text-white/80 flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-brand-red"></i> 
                {{ $project['place'] }}
            </p>
        @endif
    </div>
</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Swiper('.certificateSwiper', {
                    slidesPerView: 1, spaceBetween: 24, loop: true,
                    navigation: { nextEl: '.cert-next', prevEl: '.cert-prev' },
                    breakpoints: { 640: { slidesPerView: 2 }, 1024: { slidesPerView: 4 } }
                });
                new Swiper('.portfolioSwiper', {
                    slidesPerView: 1, spaceBetween: 30, loop: true,
                    navigation: { nextEl: '.port-next', prevEl: '.port-prev' },
                    breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
                });
            });
        </script>

    @else
        {{-- List View (Remains unchanged for structure) --}}
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 space-y-20">
                @foreach ($brands as $index => $brand)
<div class="flex flex-col lg:flex-row items-center gap-12 {{ $index % 2 != 0 ? 'lg:flex-row-reverse' : '' }}">
    {{-- Brand Factory Image --}}
    <div class="w-full lg:w-1/2 h-[400px] rounded-3xl overflow-hidden shadow-2xl">
        <img src="{{ asset('images/' . $brand['factory_img']) }}"
             alt="{{ $brand['name'] }} Manufacturing Factory"
             class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700">
    </div>

    {{-- Brand Details --}}
    <div class="w-full lg:w-1/2 space-y-6 text-center lg:text-left">
        {{-- Brand Logo --}}
        <img src="{{ asset('images/' . $brand['logo']) }}" 
             alt="{{ $brand['name'] }} Logo"
             class="h-12 object-contain mx-auto lg:mx-0">
        
        <h2 class="text-size-title font-bold text-slate-900">{{ $brand['name'] }}</h2>
        
        <a href="{{ $brand['url'] }}"
            class="inline-flex items-center gap-3 text-brand-red font-bold tracking-widest hover:gap-5 transition-all">
            EXPLORE BRAND <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- INTEGRATED PORTFOLIO-STYLE LIGHTBOX --}}
    <template x-teleport="body">
        <div x-show="brandLightboxOpen" class="fixed inset-0 z-[9999] flex items-center justify-center p-4 md:p-12"
            x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeBrandLightbox()">
            </div>

            <!-- UI Controls (Counter top right) -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(brandActiveIndex + 1) + ' / ' + brandActiveList.length"></span>
                <button @click="closeBrandLightbox()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons -->
            <template x-if="brandActiveList.length > 1">
                <div class="contents">
                    <button @click="prevB()"
                        class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
                    </button>
                    <button @click="nextB()"
                        class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
                    </button>
                </div>
            </template>

            <!-- Content Container -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="brandLightboxOpen" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                <!-- Image (Zoom + Pan) -->
                <div x-data="lightboxZoom()"
                    class="overflow-hidden rounded-sm shadow-2xl border border-white/10 pointer-events-auto"
                    :style="window.innerWidth < 768 ? 'width: 90vw; max-height: 75vh;' : 'max-width: 85vw; max-height: 75vh;'"
                    :class="cursorClass" @mousedown.prevent="startPan($event)" @mousemove.window="doPan($event)"
                    @mouseup.window="stopPan()" @mouseleave.window="stopPan()" @touchstart="startTouchPan($event)"
                    @touchmove.prevent="doTouchPan($event)" @touchend="stopPan()" @click.stop="toggleZoom()">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" :src="brandActiveList[brandActiveIndex]?.src"
                        :alt="brandActiveList[brandActiveIndex]?.title || 'Brand Gallery Image'" class="w-full h-full object-contain select-none" :style="imgStyle"
                        draggable="false">
                </div>

                <!-- Caption -->
                <div class="text-center mt-6 pointer-events-none">
                    <p x-text="brandActiveList[brandActiveIndex]?.title"
                        class="text-white font-medium text-lg md:text-2xl tracking-wide"></p>
                    <div class="w-12 h-1 bg-brand-red mx-auto mt-4 rounded-full"></div>
                </div>
            </div>
        </div>
    </template>
</div>