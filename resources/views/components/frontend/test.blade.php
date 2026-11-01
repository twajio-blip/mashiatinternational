@php
    // Static Portfolio Data
    $staticProjects = [
        [
            'title' => 'MRT Line 2 Infrastructure',
            'client' => 'Mass Rapid Transit Corp',
            'category' => 'Public Transport',
            'image' => 'https://images.unsplash.com/photo-1519010470956-6d877008eaa4?q=80&w=800',
            'desc' => 'Busduct Systems & Power Distribution'
        ],
        [
            'title' => 'LRT 3 Elevators',
            'client' => 'Prasarana Malaysia',
            'category' => 'Vertical Transport',
            'image' => 'https://images.unsplash.com/photo-1565103447967-7ced08d88e6e?q=80&w=800',
            'desc' => 'Heavy Duty Escalators & Lifts'
        ],
        [
            'title' => 'HKL Extension',
            'client' => 'Ministry of Health',
            'category' => 'Healthcare',
            'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=800',
            'desc' => 'Specialized Hospital Lifts'
        ]
    ];

    // Static Design Categories
    $staticDesigns = [
        'Landing Doors',
        'Operating Panels',
        'Floor Finishes',
        'Ceiling Designs',
        'Interior Design'
    ];
@endphp

{{-- Testing Factory Hero Section --}}
<section class="w-full relative pt-24 pb-20 bg-slate-900 border-b-8 border-brand-red overflow-hidden"
    x-data="{ mainImage: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1200' }">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <svg fill="none" viewBox="0 0 100 100" xmlns="http://www.w300.org/2000/svg" preserveAspectRatio="none"
            class="w-full h-full">
            <path stroke="white" stroke-width="0.5" d="M0,50 L100,50 M50,0 L50,100" />
            <circle cx="50" cy="50" r="20" stroke="white" stroke-width="0.5" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Text details --}}
            <div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight whitespace-pre-line ">
                    EITA-Schneider Testing Factory
                </h1>

                <p class="text-lg mb-8 leading-relaxed">
                    Our world-class testing facility ensures every elevator system meets rigid international safety and
                    performance specifications. Through advanced diagnostics and 24/7 load simulations, we deliver
                    unparalleled reliability to our partners before any deployment.
                </p>

                <div class="flex gap-4">
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-5 rounded-xl flex-1">
                        <div class="text-3xl font-bold mb-2">ISO</div>
                        <div class="text-sm">9001:2015 Certified</div>
                    </div>
                    <div class="bg-white/5 backdrop-blur-sm border border-white/10 p-5 rounded-xl flex-1">
                        <div class="text-3xl font-bold mb-2">10k+</div>
                        <div class="text-sm">Tests Annually</div>
                    </div>
                </div>
            </div>

            {{-- Image Gallery --}}
            <div class="flex flex-col gap-4">
                {{-- Main Image --}}
                <div
                    class="w-full h-80 md:h-[450px] rounded-2xl overflow-hidden shadow-2xl border-4 border-slate-800 bg-slate-800 relative group">
                    {{-- Small loader placeholder to ensure smooth transitions --}}
                    <div class="absolute inset-0 flex items-center justify-center -z-10 bg-slate-800">
                        <i class="fa-solid fa-spinner fa-spin text-slate-600 text-3xl"></i>
                    </div>
                    <img :src="mainImage" alt="Testing Factory"
                        class="w-full h-full object-cover transition-opacity duration-500 z-10 relative">
                </div>

                {{-- Thumbnails --}}
                <div class="grid grid-cols-4 gap-3 lg:gap-4">
                    @php
                        $thumbnails = [
                            'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=1200',
                            'https://images.unsplash.com/photo-1581092160562-40aa08e78837?q=80&w=1200',
                            'https://images.unsplash.com/photo-1563986768494-4dee2763ff3f?q=80&w=1200',
                            'https://images.unsplash.com/photo-1581092335397-9583eb92d232?q=80&w=1200'
                        ];
                    @endphp
                    @foreach($thumbnails as $thumb)
                        <button @click="mainImage = '{{ $thumb }}'"
                            class="h-16 md:h-24 rounded-xl overflow-hidden focus:outline-none transition-all duration-300 relative group"
                            :class="mainImage === '{{ $thumb }}' ? 'border-2 border-brand-red scale-[1.02] shadow-lg shadow-brand-red/20' : 'border-2 border-transparent hover:border-slate-600 opacity-60 hover:opacity-100'">
                            <img src="{{ $thumb }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Brand Details Section --}}

<section class="py-24 bg-slate-50 relative w-full">
    {{-- Decorative background element --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-red/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -left-24 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10 w-full">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">

            {{-- Left Content --}}
            <div class="lg:col-span-8">
                {{-- Badges --}}
                <div class="flex flex-wrap items-center gap-3 mb-8">
                    <div
                        class="flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                        <span class="w-2 h-2 rounded-full bg-brand-red animate-pulse"></span>
                        <span class="text-slate-800 text-xs font-bold uppercase tracking-widest">Bursa: 5208</span>
                    </div>
                    <div
                        class="flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                        <i class="fa-solid fa-earth-asia text-slate-400 text-sm"></i>
                        <span class="text-slate-600 text-xs font-bold uppercase tracking-widest">Origin: Malaysia</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h2 class="text-4xl lg:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
                    Innovative Engineering Solutions
                </h2>

                <p class="text-lg text-slate-600 mb-14 leading-relaxed">
                    EITA-Schneider represents the pinnacle of Malaysian engineering, providing mission-critical
                    solutions from high-speed elevators to robust power distribution systems for the maritime and
                    construction sectors. We design ecosystems that empower modern infrastructures.
                </p>

                {{-- Portfolio Loop --}}
                <div class="mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-slate-900 flex items-center">
                            <span
                                class="w-10 h-10 rounded-xl bg-brand-red/10 text-brand-red flex items-center justify-center mr-4">
                                <i class="fa-solid fa-microchip text-lg"></i>
                            </span>
                            Project Portfolio
                        </h3>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6">
                        @foreach($staticProjects as $project)
                            <div
                                class="group relative h-80 overflow-hidden rounded-2xl shadow-sm hover:shadow-xl transition-all duration-500 bg-white">
                                <img src="{{ $project['image'] }}"
                                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">

                                {{-- Gradient Overlay --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent opacity-80 group-hover:opacity-90 transition-opacity">
                                </div>

                                {{-- Content --}}
                                <div
                                    class="absolute inset-x-0 bottom-0 p-6 xl:p-8 flex flex-col justify-end transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <div class="mb-3">
                                        <span
                                            class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-white font-bold text-[10px] uppercase tracking-widest">{{ $project['category'] }}</span>
                                    </div>
                                    <h4 class="text-white font-bold text-2xl mb-1">{{ $project['title'] }}</h4>
                                    <p class="text-slate-300 text-sm font-medium">{{ $project['client'] }}</p>

                                    {{-- Hidden desc that appears on hover --}}
                                    <div
                                        class="mt-4 pt-4 border-t border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                        <p class="text-slate-200 text-sm leading-relaxed">{{ $project['desc'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Design Section (Static Loop) --}}
                <div class="pt-12 relative w-full">
                    <div class="absolute top-0 left-0 w-16 h-1 bg-brand-red rounded-full"></div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-8 flex items-center">
                        <span
                            class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-600 flex items-center justify-center mr-4">
                            <i class="fa-solid fa-palette text-lg"></i>
                        </span>
                        Aesthetic Customization
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        @foreach($staticDesigns as $design)
                            <a href="#"
                                class="px-6 py-3 bg-white shadow-sm border border-slate-200 rounded-full text-slate-700 font-bold hover:border-brand-red hover:text-brand-red hover:shadow-md transition-all flex items-center group">
                                {{ $design }}
                                <div
                                    class="ml-4 w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-brand-red/10 transition-colors">
                                    <i
                                        class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-brand-red"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-4 lg:sticky lg:top-32 h-fit">
                <div
                    class="relative bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden group">
                    {{-- Top colored border --}}
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand-red to-orange-500"></div>

                    <div
                        class="bg-slate-50 p-6 rounded-2xl flex items-center justify-center mb-8 border border-slate-100 group-hover:bg-brand-red/5 transition-colors">
                        <img src="https://via.placeholder.com/180x60?text=EITA+BRAND" alt="Logo"
                            class="h-12 object-contain mix-blend-multiply opacity-80 group-hover:opacity-100 transition-opacity">
                    </div>

                    <h3 class="text-xl font-extrabold text-slate-900 mb-6">Technical Overview</h3>

                    <div class="space-y-4 mb-8">
                        <div
                            class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100 group-hover:border-slate-200 transition-colors">
                            <div class="flex items-center space-x-3 text-slate-500">
                                <i class="fa-solid fa-users text-lg"></i>
                                <span class="text-sm font-semibold">Workforce</span>
                            </div>
                            <span class="font-extrabold text-slate-900">590+ Staff</span>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-100 group-hover:border-slate-200 transition-colors">
                            <div class="flex items-center space-x-3 text-slate-500">
                                <i class="fa-solid fa-map-location-dot text-lg"></i>
                                <span class="text-sm font-semibold">Coverage</span>
                            </div>
                            <span class="font-extrabold text-slate-900">24/7 Nationwide</span>
                        </div>
                    </div>

                    <button
                        class="w-full py-4 px-6 bg-slate-900 hover:bg-brand-red text-white font-bold rounded-xl transition-colors flex items-center justify-center group/btn shadow-lg shadow-slate-900/20">
                        Download Brochure
                        <i
                            class="fa-solid fa-download ml-3 text-sm group-hover/btn:-translate-y-1 transition-transform"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>