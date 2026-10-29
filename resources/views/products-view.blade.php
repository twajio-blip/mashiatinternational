<x-Guest-layout :pageinfo="$page">
    @php
        $record = $data[0] ?? null;
        if (!$record) {
            abort(404);
        }

        $product = $record[0] ?? [];
        // Group 1: Features with Icons
        $featuresWithIcons = $record[1]['instances'] ?? [];
        // Group 2: Key Features (Bullet points)
        $keyFeatures = $record[2]['instances'] ?? [];
        // Group 3: Specifications
        $specsGroup = $record[3] ?? [];

        $productName = $product['product_name'] ?? 'Product';
        $productDesc = $product['product_desc'] ?? '';

        // --- PRESERVED MEDIA LOGIC ---
        $images = json_decode($product['images'] ?? '[]', true) ?: [];
        $videos = json_decode($product['videos'] ?? '[]', true) ?: [];

        $mainContent = !empty($images) ? asset('images/' . $images[0]) : null;
        $isMainContentVideo = false;

        if (!$mainContent && !empty($videos)) {
            $mainContent = asset('images/' . $videos[0]);
            $isMainContentVideo = true;
        }

        $productBreadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Products', 'url' => url('/products')],
            ['label' => $productName],
        ];
    @endphp

    <main>
        {{-- MATCHED HEADER STYLE: Charcoal background with technical grid lines --}}
        <section class="relative pt-32 pb-20 bg-brand-charcoal overflow-hidden mt-16">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute left-1/4 top-0 bottom-0 w-px bg-white"></div>
                <div class="absolute right-1/4 top-0 bottom-0 w-px bg-white"></div>
                <div class="absolute left-0 right-0 top-1/2 h-px bg-white"></div>
            </div>
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-red/20 to-transparent pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto px-4 relative z-10">
                <div data-aos="fade-up" data-aos-duration="600">
                    <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-6">
                        @foreach($productBreadcrumbs as $breadcrumb)
                            @if(!$loop->last)
                                <a href="{{ $breadcrumb['url'] }}" class="hover:text-brand-red transition-colors">{{ $breadcrumb['label'] }}</a>
                                <span class="text-gray-600">/</span>
                            @else
                                <span class="text-white font-medium">{{ $breadcrumb['label'] }}</span>
                            @endif
                        @endforeach
                    </nav>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-white mb-6 leading-tight">
                        {{ $productName }}
                    </h1>
                    <p class="text-lg md:text-xl text-white/70 max-w-2xl leading-relaxed">
                        Quality solutions tailored to your needs.
                    </p>
                </div>
            </div>
        </section>

        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid lg:grid-cols-2 gap-16">

                    {{-- LEFT COLUMN: Media Gallery (PRESERVED) --}}
                    <div class="space-y-6" data-aos="fade-right">
                        <div id="hero-container" class="aspect-[4/3] bg-black rounded-2xl overflow-hidden shadow-xl relative">
                            @if($isMainContentVideo)
                                <video id="hero-video" src="{{ $mainContent }}" controls class="w-full h-full object-cover"></video>
                                <img id="hero-image" class="hidden w-full h-full object-cover">
                            @elseif($mainContent)
                                <img id="hero-image" src="{{ $mainContent }}" class="w-full h-full object-cover">
                                <video id="hero-video" class="hidden w-full h-full object-cover" controls></video>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Media Available</div>
                            @endif
                        </div>

                        <div class="relative overflow-hidden group">
                            <div id="thumb-slider" class="flex space-x-4 overflow-x-auto pb-4 cursor-grab active:cursor-grabbing select-none snap-x scroll-smooth custom-scrollbar">
                                @foreach($images as $img)
                                    <div class="snap-start shrink-0">
                                        <button type="button" class="media-thumb w-24 h-24 rounded-xl overflow-hidden border-2 {{ $loop->first ? 'border-brand-red' : 'border-transparent' }} transition-all hover:border-brand-red" data-type="image" data-src="{{ asset('images/' . $img) }}">
                                            <img src="{{ asset('images/' . $img) }}" class="w-full h-full object-cover pointer-events-none">
                                        </button>
                                    </div>
                                @endforeach

                                @foreach($videos as $vid)
                                    <div class="snap-start shrink-0">
                                        <button type="button" class="media-thumb w-24 h-24 rounded-xl overflow-hidden border-2 border-transparent transition-all hover:border-brand-red bg-gray-900 relative" data-type="video" data-src="{{ asset('images/' . $vid) }}">
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 pointer-events-none">
                                                <i class="fa-solid fa-play text-white"></i>
                                            </div>
                                            <video src="{{ asset('images/' . $vid) }}" class="w-full h-full object-cover pointer-events-none"></video>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: Detail Styling --}}
                    <div data-aos="fade-left">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $productName }}</h2>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ $productDesc }}</p>

                        {{-- Features with Icons --}}
                        @if(!empty($featuresWithIcons))
                            <div class="grid sm:grid-cols-2 gap-6 mb-10">
                                @foreach($featuresWithIcons as $f)
                                    <div class="flex items-start">
                                        <span class="text-2xl text-brand-red mr-3 shrink-0">
                                            {!! $f['Feature icon'] ?? '<i class="fa-solid fa-check"></i>' !!}
                                        </span>
                                        <div>
                                            <h4 class="font-bold text-gray-900">{{ $f['Feature title'] ?? '' }}</h4>
                                            <p class="text-sm text-gray-500">{{ $f['Feature desc'] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Bullet Key Features List --}}
                        @if(!empty($keyFeatures))
                            <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Key Features</h3>
                            <ul class="space-y-3 mb-10">
                                @foreach($keyFeatures as $kf)
                                    <li class="flex items-start">
                                        <i class="fa-solid fa-circle-check text-green-500 mr-3 shrink-0 mt-1"></i>
                                        <span class="text-gray-600">{{ $kf['Features'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Technical Specifications Card --}}
                        @if(!empty($specsGroup))
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Technical Specifications</h3>
                                <div class="space-y-3">
                                    @foreach($specsGroup as $key => $val)
                                        @if(!in_array($key, ['group_name', 'component_id', 'group']))
                                            <div class="flex justify-between border-b border-gray-200 pb-2 last:border-0 last:pb-0">
                                                <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                                <span class="text-gray-600 text-right">{{ $val }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Media gallery logic for image/video switching
        document.querySelectorAll('.media-thumb').forEach(thumb => {
            thumb.addEventListener('click', function () {
                const type = this.dataset.type;
                const src = this.dataset.src;
                const heroImg = document.getElementById('hero-image');
                const heroVid = document.getElementById('hero-video');

                document.querySelectorAll('.media-thumb').forEach(t => t.classList.remove('border-brand-red'));
                this.classList.add('border-brand-red');

                if (type === 'image') {
                    if (heroVid) { heroVid.pause(); heroVid.classList.add('hidden'); }
                    heroImg.classList.remove('hidden');
                    heroImg.src = src;
                } else {
                    heroImg.classList.add('hidden');
                    heroVid.classList.remove('hidden');
                    heroVid.src = src;
                    heroVid.load();
                    heroVid.play().catch(() => {});
                }
            });
        });
    </script>
</x-Guest-layout>