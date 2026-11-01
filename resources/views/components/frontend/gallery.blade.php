@props(['data'])

@php
    // Extracting the Section Title from index 0
    $sectionTitle = $data[0][0]['instances'][1]['title'] ?? 'Our Gallery';

    // Gallery Items from index 1
    $galleryData = $data[1][0]['instances'] ?? [];

    $items = collect($galleryData)->map(function ($inst) {
        $file = $inst['image/video'] ?? '';
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];

        return [
            'src' => asset('images/' . $file),
            'type' => in_array($extension, $videoExtensions) ? 'video' : 'image',
            'title' => $inst['name'] ?? 'Gallery Item',
        ];
    });
@endphp

<section class="py-16 lg:py-24 bg-slate-50" x-data="{
        activeTab: 'all',
        galleryLightboxOpen: false,
        galleryActiveIndex: 0,
        galleryItems: {{ json_encode($items->values()) }},
        get filteredGallery() {
            return this.galleryItems.filter(item => this.activeTab === 'all' || this.activeTab === item.type);
        },
        openGallery(index) {
            this.galleryActiveIndex = index;
            this.galleryLightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeGallery() {
            window.dispatchEvent(new CustomEvent('lightbox:close'));
            this.galleryLightboxOpen = false;
            document.body.style.overflow = 'auto';
        },
        nextGallery() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.galleryActiveIndex = (this.galleryActiveIndex + 1) % this.filteredGallery.length;
        },
        prevGallery() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.galleryActiveIndex = (this.galleryActiveIndex - 1 + this.filteredGallery.length) % this.filteredGallery.length;
        }
    }" @keydown.escape.window="closeGallery()" @keydown.right.window="if(galleryLightboxOpen) nextGallery()"
    @keydown.left.window="if(galleryLightboxOpen) prevGallery()">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Modern Stylist Title Section --}}
        <div class="text-center mb-8" data-aos="fade-up">
            <span class="text-brand-red font-bold uppercase tracking-[0.3em] text-xs mb-3 block">Visual Journey</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-brand-charcoal mb-4 relative inline-block">
                {{ $sectionTitle }}
                <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-12 h-1 bg-brand-red rounded-full"></span>
            </h2>
        </div>

        {{-- Category Tabs --}}
        <div class="flex items-center justify-center mb-12" data-aos="fade-up" data-aos-delay="100">
            <div
                class="flex bg-white p-1.5 rounded-2xl shadow-[0_10px_25px_-10px_rgba(0,0,0,0.1)] border border-slate-100">
                <template x-for="tab in ['all', 'image', 'video']">
                    <button @click="activeTab = tab"
                        :class="activeTab === tab ? 'bg-brand-red text-white shadow-lg scale-105' : 'text-slate-400 hover:text-brand-red'"
                        class="px-2 sm:px-6 lg:px-8 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 capitalize flex items-center gap-2">
                        <template x-if="tab === 'image'"><i class="fa-regular fa-image"></i></template>
                        <template x-if="tab === 'video'"><i class="fa-solid fa-circle-play"></i></template>
                        <span x-text="tab === 'all' ? 'Everything' : tab + 's'"></span>
                    </button>
                </template>
            </div>
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($items as $item)
                <div x-show="activeTab === 'all' || activeTab === '{{ $item['type'] }}'"
                    x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="group relative h-80 overflow-hidden rounded-[2rem] bg-slate-900 cursor-pointer shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2"
                    @click="openGallery(filteredGallery.findIndex(item => item.src === @js($item['src'])))">

                    {{-- Media Layer --}}
                    <div class="absolute inset-0 w-full h-full">
                        @if($item['type'] === 'video')
                            <video loop muted playsinline
                                class="w-full h-full object-cover opacity-70 transition-all duration-700 group-hover:scale-110 group-hover:opacity-100"
                                onmouseover="this.play()" onmouseout="this.pause();">
                                <source src="{{ $item['src'] }}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center z-20">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 group-hover:bg-brand-red group-hover:border-brand-red transition-all duration-500">
                                    <i class="fa-solid fa-play ml-1"></i>
                                </div>
                            </div>
                        @else
                            <img src="{{ $item['src'] }}" alt="{{ $item['title'] }}" loading="lazy"
                                class="w-full h-full object-cover transition-all duration-1000 opacity-90 group-hover:scale-110 group-hover:opacity-100">
                        @endif
                    </div>

                    {{-- Gradient Overlay --}}
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-brand-charcoal/90 via-transparent to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-500 z-10">
                    </div>

                    {{-- Text Content --}}
                    <div
                        class="absolute inset-x-0 bottom-0 p-6 z-20 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                        <p
                            class="text-brand-red text-[10px] font-bold uppercase tracking-widest mb-1 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                            View Fullscreen</p>
                        <h3 class="text-white text-lg font-bold tracking-tight">
                            {{ $item['title'] }}
                        </h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Standardized Lightbox --}}
    <template x-teleport="body">
        <div x-show="galleryLightboxOpen" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeGallery()"></div>

            <!-- UI Controls: Counter + Close -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(galleryActiveIndex + 1) + ' / ' + filteredGallery.length"></span>
                <button @click="closeGallery()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons -->
            <template x-if="filteredGallery.length > 1">
                <div class="contents">
                    <button @click="prevGallery()"
                        class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
                    </button>
                    <button @click="nextGallery()"
                        class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
                    </button>
                </div>
            </template>

            <!-- Content Container -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="galleryLightboxOpen" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                <template x-if="filteredGallery[galleryActiveIndex]?.type === 'image'">
                    <!-- Image (Zoom + Pan) -->
                    <div x-data="lightboxZoom()"
                        class="overflow-hidden rounded-sm shadow-2xl border border-white/10 pointer-events-auto"
                        :style="window.innerWidth < 768 ? 'width: 90vw; max-height: 75vh;' : 'max-width: 85vw; max-height: 75vh;'"
                        :class="cursorClass" @mousedown.prevent="startPan($event)" @mousemove.window="doPan($event)"
                        @mouseup.window="stopPan()" @mouseleave.window="stopPan()" @touchstart="startTouchPan($event)"
                        @touchmove.prevent="doTouchPan($event)" @touchend="stopPan()" @click.stop="toggleZoom()">
                        <img :src="filteredGallery[galleryActiveIndex]?.src"
                            class="w-full h-full object-contain select-none" :style="imgStyle" draggable="false">
                    </div>
                </template>

                <template x-if="filteredGallery[galleryActiveIndex]?.type === 'video'">
                    <div class="overflow-hidden rounded-3xl shadow-2xl bg-black pointer-events-auto max-w-5xl w-full">
                        <video controls class="max-h-[75vh] w-full h-auto block"
                               :src="filteredGallery[galleryActiveIndex]?.src"
                               x-effect="
                                   let _ = galleryActiveIndex; 
                                   if (galleryLightboxOpen) { 
                                       setTimeout(() => { $el.play().catch(()=>{}) }, 50); 
                                   } else { 
                                       $el.pause(); 
                                   }">
                        </video>
                    </div>
                </template>

                <!-- Caption -->
                <div class="text-center mt-6 pointer-events-none">
                    <h3 x-text="filteredGallery[galleryActiveIndex]?.title"
                        class="text-white text-2xl font-bold tracking-tight"></h3>
                    <div class="w-12 h-1 bg-brand-red mx-auto mt-3 rounded-full"></div>
                </div>
            </div>
        </div>
    </template>
</section>