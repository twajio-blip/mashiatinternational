@props(['data' => []])

@php
    $data = $data ?? [];

    // 1. Extract the Header (Index 0)
    $header = $data[0][0] ?? [];

    // 2. Filter and Map Projects (Indices 1+)
    // We filter for numeric keys and map the data to a cleaner format
    $projects = collect($data)
        ->filter(fn($item, $key) => is_numeric($key) && $key > 0)
        ->map(function ($item) {
            $details = $item[0] ?? [];
            $images = json_decode($details['images'] ?? '[]', true) ?: [];

            return [
                'title' => $details['title'] ?? '',
                'category' => $details['category'] ?? '',
                'location' => $details['location'] ?? '',
                'image' => !empty($images) ? asset('images/' . $images[0]) : null,
            ];
        })->values();

    // 3. Build tabs from relatedBlocks
    $rawCategories = $data['relatedBlocks']['category']['data'] ?? [];
    $categoryNames = collect($rawCategories)
        ->filter(fn($item) => isset($item[0]['name']))
        ->map(fn($item) => $item[0]['name'])
        ->unique()
        ->values()
        ->all();

    array_unshift($categoryNames, 'All');
    $defaultTab = 'All';
@endphp

<section id="reference" class="py-16 lg:py-24 bg-white" x-data="{
        activeTab: '{{ $defaultTab }}',
        portLightboxOpen: false,
        portActiveIndex: 0,
        portProjects: {{ json_encode($projects->map(fn($p) => ['src' => $p['image'], 'title' => $p['title'], 'location' => $p['location'], 'category' => $p['category']])->values()) }},
        get filteredProjects() {
            return this.portProjects.filter(p => this.activeTab === 'All' || this.activeTab === p.category);
        },
        openPortfolio(index) {
            this.portActiveIndex = index;
            this.portZoomed = false;
            this.portLightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closePortfolio() {
            window.dispatchEvent(new CustomEvent('lightbox:close'));
            this.portLightboxOpen = false;
            document.body.style.overflow = 'auto';
        },
        nextPort() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.portActiveIndex = (this.portActiveIndex + 1) % this.filteredProjects.length;
        },
        prevPort() {
            window.dispatchEvent(new CustomEvent('lightbox:navigate'));
            this.portActiveIndex = (this.portActiveIndex - 1 + this.filteredProjects.length) % this.filteredProjects.length;
        }
    }" @keydown.escape.window="closePortfolio()" @keydown.right.window="if(portLightboxOpen) nextPort()"
    @keydown.left.window="if(portLightboxOpen) prevPort()">

    <div class="max-w-7xl mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-12">
            <span
                class="text-brand-red font-bold uppercase tracking-widest text-size-sub-header">{{ $header['sub_title'] ?? '' }}</span>
            <h2 class="text-size-title leading-[1.1] font-extrabold text-brand-charcoal mt-2">
                {{ $header['title'] ?? '' }}
            </h2>
        </div>

        {{-- Filter Tabs --}}
        @if (!empty($categoryNames))
            <div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-12">
                @foreach ($categoryNames as $tabName)
                    <button @click="activeTab = '{{ $tabName }}'" :class="activeTab === '{{ $tabName }}'
                                                                    ? 'bg-brand-red text-white shadow-md'
                                                                    : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                        class="px-6 py-2 rounded-full text-size-body font-medium transition-all focus:outline-none">
                        {{ $tabName }}
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Projects Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($projects as $project)
                <div x-show="activeTab === 'All' || activeTab === '{{ $project['category'] }}'" x-cloak
                    @click="openPortfolio(filteredProjects.findIndex(p => p.title === '{{ addslashes($project['title']) }}' && p.category === '{{ addslashes($project['category']) }}'))"
                    class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-100 group cursor-zoom-in">

                    {{-- Image Layer --}}
                    <div class="h-64 bg-gray-200 relative overflow-hidden">
                        @if($project['image'])
                            <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @endif
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                    </div>

                    <div class="p-6">
                        <span class="text-size-accent font-semibold text-brand-red uppercase tracking-wider mb-2 block">
                            {{ $project['category'] }}
                        </span>
                        <h3 class="text-size-header font-bold text-brand-charcoal">
                            {{ $project['title'] }}
                        </h3>

                        <div class="flex items-center text-size-body text-gray-500">
                            <i class="fa-solid fa-location-dot w-4 h-4 mr-2 text-gray-400"></i>
                            {{ $project['location'] }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 italic">
                    No projects found.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Product-Slider Style Lightbox --}}
    <template x-teleport="body">
        <div x-show="portLightboxOpen" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closePortfolio()"></div>

            <!-- UI Controls: Counter + Close -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(portActiveIndex + 1) + ' / ' + filteredProjects.length"></span>
                <button @click="closePortfolio()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons -->
            <template x-if="filteredProjects.length > 1">
                <div class="contents">
                    <button @click="prevPort()"
                        class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
                    </button>
                    <button @click="nextPort()"
                        class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
                    </button>
                </div>
            </template>

            <!-- Content Container -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="portLightboxOpen" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">

                <!-- Image (Zoom + Pan) -->
                <div x-data="lightboxZoom()"
                    class="overflow-hidden rounded-sm shadow-2xl border border-white/10 pointer-events-auto"
                    :style="window.innerWidth < 768 ? 'width: 90vw; max-height: 75vh;' : 'max-width: 85vw; max-height: 75vh;'"
                    :class="cursorClass" @mousedown.prevent="startPan($event)" @mousemove.window="doPan($event)"
                    @mouseup.window="stopPan()" @mouseleave.window="stopPan()" @touchstart="startTouchPan($event)"
                    @touchmove.prevent="doTouchPan($event)" @touchend="stopPan()" @click.stop="toggleZoom()">
                    <img :src="filteredProjects[portActiveIndex]?.src" class="w-full h-full object-contain select-none"
                        :style="imgStyle" draggable="false">
                </div>

                <!-- Caption -->
                <div class="text-center mt-4 pointer-events-none">
                    <p x-text="filteredProjects[portActiveIndex]?.title"
                        class="text-white font-medium text-lg md:text-2xl tracking-wide"></p>
                    <p x-show="filteredProjects[portActiveIndex]?.location"
                        class="text-white/60 text-sm mt-1 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-location-dot text-brand-red"></i>
                        <span x-text="filteredProjects[portActiveIndex]?.location"></span>
                    </p>
                </div>
            </div>
        </div>
    </template>
</section>