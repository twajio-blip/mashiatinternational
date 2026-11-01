@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $blocks = $data[0][1]['instances'] ?? [];

    $allImages = [];

    foreach ($blocks as $block) {
        if (isset($block['images'])) {
            $decoded = json_decode($block['images'], true);
            if (is_array($decoded)) {
                $allImages = array_merge($allImages, $decoded);
            }
        }
    }
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- ================= HEADER ================= --}}
        @if($section)
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $section['title'] }}
                </h2>

                <p class="text-gray-700 text-lg leading-relaxed">
                    {{ $section['description'] }}
                </p>
            </div>
        @endif


        {{-- ================= SERVICE BLOCKS ================= --}}
        <div class="space-y-12">

            @foreach($blocks as $index => $block)

                <div>
                    {{-- Ribbon Title --}}
                    <div class="inline-block relative bg-blue-900 text-white font-semibold px-6 py-2 text-lg">
                        {{ $loop->iteration }}. {{ $block['title'] }}
                        <span class="absolute right-0 top-0 h-full w-2 bg-red-500"></span>
                    </div>

                    {{-- Description --}}
                    @if(!empty($block['description']))
                        <p class="mt-3 text-gray-700 text-lg leading-relaxed max-w-4xl">
                            {{ $block['description'] }}
                        </p>
                    @endif
                </div>

            @endforeach

        </div>


        {{-- ================= IMAGE SECTION ================= --}}
        @if(count($allImages))
            <div class="mt-12">

                {{-- First row (2 images if available) --}}
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    @foreach(array_slice($allImages, 0, 2) as $img)
                        <div class="border-4 border-blue-900 shadow-lg">
                            <img src="{{ asset('images/' . $img) }}" class="w-full h-[300px] object-cover"
                                alt="Hydraulic Equipment">
                        </div>
                    @endforeach
                </div>

                {{-- Remaining images centered --}}
                @if(count($allImages) > 2)
                    <div class="flex justify-center">
                        @foreach(array_slice($allImages, 2) as $img)
                            <div class="border-4 border-blue-900 shadow-lg max-w-3xl">
                                <img src="{{ asset('images/' . $img) }}" class="w-full h-[350px] object-cover"
                                    alt="Hydraulic System">
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        @endif

    </div>
</section>