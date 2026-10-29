<x-Guest-layout :pageinfo="$page">
    @php
        $data = $data ?? [];
        // Extracting the main portfolio item and merging details from group 2
        $item = data_prepared_items($data, 'Portfolio', [
            'merge_group' => 'Portfolio_Details',
            'decode_json' => ['images']
        ])[0] ?? [];

        $info = $item;
        $overview = $item['details'] ?? '';

        // Building technical specifications
        $specs = [
            'brand' => $item['brand'] ?? '',
            'elevator_type' => $item['elevator_type'] ?? '',
            'capacity' => $item['capacity'] ?? '',
            'speed' => $item['speed'] ?? '',
            'floors_served' => $item['floors_served'] ?? '',
        ];

        $gallery = $item['images'] ?? [];
    @endphp

    <main class="bg-white">
        <x-frontend.page-banner :title="($info['title'] ?? 'Project Details')" :breadcrumbs="[
        ['label' => 'Home', 'url' => url('/')],
        ['label' => 'Portfolio', 'url' => url('/portfolio')],
        ['label' => ($info['title'] ?? 'Project')],
    ]" />

        <section class="py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-4">

                {{-- Hero Section --}}
                <div
                    class="w-full h-[50vh] min-h-[350px] md:h-[65vh] bg-gray-200 rounded-3xl overflow-hidden mb-16 relative shadow-2xl">
                    <img src="{{ asset('images/' . ($gallery[0] ?? 'default-project.jpg')) }}"
                        alt="{{ $info['title'] ?? '' }}" class="absolute inset-0 w-full h-full object-cover" />

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent z-10"></div>

                    <div class="absolute bottom-8 left-6 md:left-12 z-20 text-white max-w-2xl">
                        <span
                            class="px-4 py-1 bg-brand-red rounded-full text-xs md:text-sm font-bold uppercase tracking-wider mb-4 inline-block">
                            {{ $info['category'] ?? 'Commercial' }}
                        </span>
                        <h1 class="text-3xl md:text-6xl font-heading font-bold mb-4">
                            {{ $info['title'] ?? '' }}
                        </h1>
                        <div class="flex flex-wrap gap-4 md:gap-8 text-sm md:text-base opacity-90">
                            <div class="flex items-center">
                                <i class="fa-solid fa-location-dot mr-2 text-brand-red"></i>
                                {{ $info['location'] ?? '' }}
                            </div>
                            <div class="flex items-center">
                                <i class="fa-solid fa-elevator mr-2 text-brand-red"></i>
                                {{ $info['elevators'] ?? '' }}
                            </div>
                            <div class="flex items-center">
                                <i class="fa-solid fa-calendar-check mr-2 text-brand-red"></i>
                                Completed {{ $info['completion_year'] ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-12">
                    {{-- Left Side: Project Description --}}
                    <div class="lg:col-span-2">
                        <div class="prose prose-lg max-w-none text-gray-700 prevent-tailwind-css">
                            {!! $overview !!}
                        </div>
                    </div>

                    {{-- Right Side: Specifications Sidebar --}}
                    <div class="space-y-8">
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-4">
                                Technical Specifications
                            </h3>
                            <ul class="space-y-5">
                                @foreach($specs as $key => $value)
                                    @continue(empty($value))
                                    <li class="flex justify-between items-start gap-4">
                                        <span class="text-gray-500 text-sm font-medium uppercase tracking-tight">
                                            {{ str_replace('_', ' ', $key) }}
                                        </span>
                                        <span class="font-bold text-gray-900 text-right">
                                            {!! $value !!}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Call to Action --}}
                        <div class="bg-brand-charcoal p-8 rounded-2xl text-center text-white shadow-xl">
                            <h3 class="text-xl font-bold mb-3">Project Consultation</h3>
                            <p class="text-gray-400 mb-6 text-sm">
                                Interested in a similar vertical mobility solution for your building?
                            </p>
                            <a href="{{ url('/contact') }}"
                                class="w-full block py-4 bg-brand-red text-white rounded-xl font-bold hover:bg-red-700 transition-all transform hover:-translate-y-1">
                                Get a Free Quote
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- NEW: Full Width Bottom Gallery Grid --}}
        @if(is_array($gallery) && count($gallery) > 0)
            <section class="py-20 bg-gray-50 border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="mb-12">
                        <h3 class="text-3xl font-bold text-gray-900">Project Visuals</h3>
                        <p class="text-gray-500 mt-2">A closer look at the installation and finishing details.</p>
                        <div class="w-16 h-1 bg-brand-red mt-4"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($gallery as $index => $img)
                            <div class="group relative aspect-[4/3] bg-white rounded-2xl overflow-hidden shadow-md cursor-pointer gallery-item"
                                data-index="{{ $index }}" data-image="{{ asset('images/' . $img) }}">

                                <img src="{{ asset('images/' . $img) }}" alt="Installation Photo {{ $index + 1 }}"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

                                {{-- Hover Overlay --}}
                                <div
                                    class="absolute inset-0 bg-brand-charcoal/60 opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center">
                                    <div class="bg-white/20 p-4 rounded-full backdrop-blur-md">
                                        <i class="fa-solid fa-maximize text-white text-2xl"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    {{-- Lightbox Component --}}
    <div id="lightbox" class="fixed inset-0 backdrop-blur-2xl hidden items-center justify-center z-[9999] p-4 md:p-12">
        <button id="lightbox-close"
            class="absolute top-8 right-8 text-white/70 hover:text-white text-5xl transition-all">&times;</button>
        <button id="lightbox-prev"
            class="absolute left-4 md:left-8 text-white/50 hover:text-white text-5xl transition-all">&#10094;</button>

        <div class="relative max-w-5xl max-h-full">
            <img id="lightbox-image" src=""
                class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl shadow-black">
        </div>

        <button id="lightbox-next"
            class="absolute right-4 md:right-8 text-white/50 hover:text-white text-5xl transition-all">&#10095;</button>
    </div>

    <script>
        $(document).ready(function () {
            let images = [];
            let currentIndex = 0;

            // Collect unique images from all gallery items
            $('.gallery-item').each(function () {
                let imgPath = $(this).data('image');
                if (!images.includes(imgPath)) {
                    images.push(imgPath);
                }
            });

            // Click event for gallery items
            $(document).on('click', '.gallery-item', function () {
                const clickedImg = $(this).data('image');
                currentIndex = images.indexOf(clickedImg);
                openLightbox();
            });

            function openLightbox() {
                $('#lightbox-image').hide().attr('src', images[currentIndex]).fadeIn(400);
                $('#lightbox').removeClass('hidden').addClass('flex');
                $('body').addClass('overflow-hidden'); // Prevent scrolling
            }

            function closeLightbox() {
                $('#lightbox').removeClass('flex').addClass('hidden');
                $('body').removeClass('overflow-hidden');
            }

            $('#lightbox-close').on('click', closeLightbox);

            $('#lightbox-prev').on('click', function (e) {
                e.stopPropagation();
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                $('#lightbox-image').attr('src', images[currentIndex]);
            });

            $('#lightbox-next').on('click', function (e) {
                e.stopPropagation();
                currentIndex = (currentIndex + 1) % images.length;
                $('#lightbox-image').attr('src', images[currentIndex]);
            });

            // Close on background click
            $('#lightbox').on('click', function (e) {
                if (e.target.id === 'lightbox') closeLightbox();
            });

            // Keyboard Navigation
            $(document).keydown(function (e) {
                if ($('#lightbox').hasClass('flex')) {
                    if (e.keyCode == 27) closeLightbox(); // Esc
                    if (e.keyCode == 37) $('#lightbox-prev').click(); // Left
                    if (e.keyCode == 39) $('#lightbox-next').click(); // Right
                }
            });
        });
    </script>
</x-Guest-layout>