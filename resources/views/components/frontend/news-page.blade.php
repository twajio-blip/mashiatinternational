@php
    $news = [
        [
            'date' => 'Oct 15, 2023',
            'title' => 'RAR Lift Partners with New Global Brand for High-Speed Elevators',
            'excerpt' => 'Expanding our portfolio to include ultra-high-speed solutions for skyscrapers in the growing urban landscape.'
        ],
        [
            'date' => 'Sep 28, 2023',
            'title' => 'Safety First: Annual Maintenance Training Completed',
            'excerpt' => 'Our engineering team successfully completed the advanced safety and maintenance certification program.'
        ],
        [
            'date' => 'Aug 10, 2023',
            'title' => 'Smart Elevators: The Future of Building Mobility',
            'excerpt' => 'Exploring how IoT and AI are transforming vertical transportation and improving energy efficiency.'
        ]
    ];
@endphp

<section id="news" class="py-24 bg-brand-light mt-20">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
            <div data-aos="fade-right" data-aos-duration="600">
                <div class="flex items-center space-x-2 mb-4">
                    <h3 class="text-brand-red font-semibold tracking-wider uppercase text-sm">
                        Updates
                    </h3>
                </div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-brand-charcoal">
                    Latest News & Insights
                </h2>
            </div>

            <a href="{{ url('/news') }}"
                class="hidden md:flex items-center text-brand-red font-medium hover:text-brand-redHover transition-colors"
                data-aos="fade-left" data-aos-duration="600">
                View All News <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>

        {{-- News Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($news as $index => $item)
                <article class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all group"
                    data-aos="fade-up" data-aos-duration="500" data-aos-delay="{{ $index * 100 }}">
                    {{-- Image Placeholder --}}
                    <div class="h-48 bg-gray-200 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10"></div>
                        <div class="w-full h-full bg-gray-300 group-hover:scale-105 transition-transform duration-500">
                        </div>

                        <div class="absolute bottom-4 left-4 z-20 flex items-center text-white text-sm font-medium">
                            <i class="fa-regular fa-calendar mr-2"></i>
                            {{ $item['date'] }}
                        </div>
                    </div>

                    <div class="p-6">
                        <h4
                            class="font-bold text-lg text-brand-charcoal mb-3 group-hover:text-brand-red transition-colors line-clamp-2">
                            {{ $item['title'] }}
                        </h4>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-3">
                            {{ $item['excerpt'] }}
                        </p>
                        <a href="{{ url('/news-detail/' . $index) }}"
                            class="inline-flex items-center text-sm font-semibold text-brand-charcoal group-hover:text-brand-red transition-colors">
                            Read More <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Mobile View All News Button --}}
        <div class="mt-8 md:hidden text-center">
            <a href="{{ url('/news') }}" class="inline-flex items-center text-brand-red font-medium">
                View All News <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
            </a>
        </div>

    </div>
</section>