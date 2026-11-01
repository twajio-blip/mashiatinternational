@props(['data' => []])
@php
    // 1. Extract Header Information
    $header = $data[0][0] ?? [];

    // 2. Identify requested brand from URL
    $requestedBrand = collect(request()->all())->keys()->first();

    // 3. Map and FILTER the Decoration Items FIRST 
    $items = collect($data)
        ->filter(function ($val, $key) {
            return is_numeric($key) && $key > 0 && isset($val[0]);
        })
        ->map(function ($group, $index) {
            $details = $group[0] ?? [];
            $categoryLabel = trim($details['category'] ?? 'General');

            return [
                'id' => $index,
                'brand' => $details['brand'] ?? null,
                'category_id' => strtr(strtolower($categoryLabel), ' ', '-'),
                'category_label' => $categoryLabel,
                'title' => trim($details['title'] ?? 'Untitled Design'),
                'desc' => trim($details['descripton'] ?? ($details['description'] ?? '')),
                'image_url' => isset($details['img']) ? asset('images/' . $details['img']) : null,
            ];
        })
        ->filter(function ($item) use ($requestedBrand) {
            if (!$requestedBrand)
                return true;
            return strtolower($item['brand'] ?? '') === strtolower($requestedBrand);
        })
        ->values();

    // 4. Fetch categories and REMOVE those that have no products
    $categoryComp = \App\Models\ComponentMaster::where('name', 'decoration-category')->first();
    $categories = collect();
    if ($categoryComp) {
        $categoryFields = \App\Models\ComponentField::where('component_id', $categoryComp->id)->get();
        $categories = $categoryFields->groupBy('group')->map(function ($fields) use ($items) {
            $name = $fields->firstWhere('name', 'category-name')->value ?? 'Untitled';
            $catId = strtr(strtolower($name), ' ', '-');

            if ($catId !== 'all' && !$items->contains('category_id', $catId)) {
                return null;
            }

            $iconRaw = $fields->firstWhere('name', 'category-icon')->value ?? '';
            preg_match('/class="([^"]+)"/', $iconRaw, $matches);
            return [
                'id' => $catId,
                'label' => $name,
                'icon' => $matches[1] ?? 'fa-solid fa-cube'
            ];
        })->filter()->values();
    }

    $defaultTab = $categories->first()['id'] ?? '';
@endphp

<section id="decoration" class="py-16 lg:py-24 text-brand-charcoal bg-white relative overflow-hidden" x-data='{
        activeTab: @json($defaultTab),
        decLightboxOpen: false,
        decActiveIndex: 0,
        items: @json($items),
        get filteredItems() {
            return this.items.filter(i => this.activeTab === "all" || this.activeTab === i.category_id);
        },
        openDecLightbox(index) {
            this.decActiveIndex = index;
            this.decLightboxOpen = true;
            document.body.style.overflow = "hidden";
        },
        closeDecLightbox() {
            window.dispatchEvent(new CustomEvent("lightbox:close"));
            this.decLightboxOpen = false;
            document.body.style.overflow = "auto";
        },
        nextDec() {
            window.dispatchEvent(new CustomEvent("lightbox:navigate"));
            this.decActiveIndex = (this.decActiveIndex + 1) % this.filteredItems.length;
        },
        prevDec() {
            window.dispatchEvent(new CustomEvent("lightbox:navigate"));
            this.decActiveIndex = (this.decActiveIndex - 1 + this.filteredItems.length) % this.filteredItems.length;
        }
    }' @keydown.escape.window="closeDecLightbox()" @keydown.right.window="if(decLightboxOpen) nextDec()"
    @keydown.left.window="if(decLightboxOpen) prevDec()" x-cloak>

    <div class="max-w-7xl mx-auto px-4 relative z-10">

        <div class="text-center mb-16">
            <h2 class="text-size-title leading-[1.1] font-heading font-bold mb-4">
                {{ $requestedBrand ? $requestedBrand . ' Designs' : ($header['subtitile'] ?? 'Design Your Experience') }}
            </h2>
            <p class="text-gray-700 max-w-2xl mx-auto text-size-body">
                {{ $header['description'] ?? '' }}
            </p>
        </div>

        {{-- Category Tabs --}}
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            @foreach($categories as $cat)
                <button @click="activeTab = '{{ $cat['id'] }}'"
                    :class="activeTab === '{{ $cat['id'] }}'
                                    ? 'bg-brand-red text-white shadow-md shadow-brand-red/30 border-brand-red scale-105'
                                    : 'bg-white text-brand-charcoal border-gray-200 hover:border-brand-red/50 hover:bg-gray-50'"
                    class="flex items-center px-6 py-2.5 rounded-full text-size-body font-bold border-2 transition-all duration-300 ease-out active:scale-95">
                    <i class="{{ $cat['icon'] }} mr-2.5 text-base transition-colors duration-300"
                        :class="activeTab === '{{ $cat['id'] }}' ? 'text-white' : 'text-brand-red'">
                    </i>

                    {{ $cat['label'] }}
                </button>
            @endforeach
        </div>

        {{-- Dynamic Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 min-h-[350px]">
            @foreach($items as $index => $item)
                <div x-show='activeTab === "all" || activeTab === @json($item["category_id"])'
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click="openDecLightbox(filteredItems.findIndex(i => i.id === {{ $item['id'] }}))"
                    class="group relative h-72 overflow-hidden rounded-[1.5rem] bg-slate-900 cursor-zoom-in shadow-md transition-shadow hover:shadow-xl border border-white/5"
                    x-cloak>

                    {{-- Card Background --}}
                    <div class="absolute inset-0 w-full h-full">
                        @if($item['image_url'])
                            <img src="{{ $item['image_url'] }}"
                                class="w-full h-full object-cover opacity-90 transition-all duration-700 group-hover:scale-110 group-hover:opacity-100"
                                alt="{{ $item['title'] }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-black"></div>
                        @endif
                    </div>

                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10"></div>

                    {{-- Card Label Content --}}
                    <div
                        class="absolute inset-x-0 bottom-0 p-5 z-20 transition-all duration-500 group-hover:translate-y-[-5px]">
                        <h3 class="text-white text-size-sub-header font-bold tracking-tight leading-tight">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-size-accent text-gray-400 mt-1">{{ $item['category_label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    {{-- PRODUCT-SLIDER STYLE LIGHTBOX --}}
    <template x-teleport="body">
        <div x-show="decLightboxOpen" class="fixed inset-0 flex items-center justify-center p-4 md:p-12"
            style="z-index: 99999;" x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/95 backdrop-blur-sm cursor-pointer" @click="closeDecLightbox()"></div>

            <!-- UI Controls: Counter + Close -->
            <div class="absolute top-0 w-full flex justify-between p-5 z-50 pointer-events-none">
                <span class="text-white/70 font-mono text-sm pointer-events-auto"
                    x-text="(decActiveIndex + 1) + ' / ' + filteredItems.length"></span>
                <button @click="closeDecLightbox()"
                    class="text-white/50 hover:text-brand-red text-3xl pointer-events-auto transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Navigation Buttons -->
            <template x-if="filteredItems.length > 1">
                <div class="contents">
                    <button @click="prevDec()"
                        class="flex items-center justify-center absolute left-4 md:left-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-left text-size-header md:text-size-title"></i>
                    </button>
                    <button @click="nextDec()"
                        class="flex items-center justify-center absolute right-4 md:right-8 text-white/70 hover:text-white bg-black/60 rounded-full z-50 px-2 py-1 transition-all">
                        <i class="fa-solid fa-chevron-right text-size-header md:text-size-title"></i>
                    </button>
                </div>
            </template>

            <!-- Content Container -->
            <div class="relative w-full h-full flex flex-col items-center justify-center pointer-events-none"
                x-show="decLightboxOpen" x-transition:enter="transition duration-500 cubic-bezier(0.4, 0, 0.2, 1)"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

                <!-- Image (Zoom + Pan) -->
                <div x-data="lightboxZoom()" class="overflow-hidden rounded-sm shadow-2xl pointer-events-auto"
                    :style="window.innerWidth < 768 ? 'width: 90vw; max-height: 72vh;' : 'max-width: 85vw; max-height: 75vh;'"
                    :class="cursorClass" @mousedown.prevent="startPan($event)" @mousemove.window="doPan($event)"
                    @mouseup.window="stopPan()" @mouseleave.window="stopPan()" @touchstart="startTouchPan($event)"
                    @touchmove.prevent="doTouchPan($event)" @touchend="stopPan()" @click.stop="toggleZoom()">
                    <img :src="filteredItems[decActiveIndex]?.image_url" :alt="filteredItems[decActiveIndex]?.title"
                        class="w-full h-full object-contain select-none" :style="imgStyle" draggable="false">
                </div>

                <!-- Caption -->
                <div class="text-center mt-6 pointer-events-none px-4">
                    <p x-text="filteredItems[decActiveIndex]?.title"
                        class="text-white font-medium text-lg md:text-2xl tracking-wide mt-1"></p>
                    <p x-show="filteredItems[decActiveIndex]?.desc" x-text="filteredItems[decActiveIndex]?.desc"
                        class="text-slate-400 text-sm mt-2 max-w-xl mx-auto line-clamp-2"></p>
                    <div class="w-12 h-1 bg-brand-red mx-auto mt-4 rounded-full"></div>
                </div>
            </div>
        </div>
    </template>
</section>