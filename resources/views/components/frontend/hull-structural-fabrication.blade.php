@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $mediaItems = $data[0][1]['instances'] ?? [];

    $images = [];

    // Get images from second block if exists
    foreach ($mediaItems as $item) {
        if (isset($item['featured_image'])) {
            $decoded = json_decode($item['featured_image'], true);
            if (is_array($decoded)) {
                $images = $decoded;
            }
        }
    }
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- ================= HEADER ================= --}}
        @if($section)
            <div class="mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $section['title'] }}
                </h2>

                <div class="text-gray-700 text-lg leading-relaxed">
                    {!! $section['section_description'] !!}
                </div>
            </div>
        @endif


        {{-- ================= CONTENT BLOCKS ================= --}}
        <div class="space-y-8 mb-12">
            @foreach($mediaItems as $index => $item)
                <div>
                    {{-- Blue Title Bar --}}
                    <div class="inline-block relative bg-blue-900 text-white font-semibold px-6 py-2 text-lg">
                        {{ $loop->iteration }}. {{ $item['title'] }}
                        <span class="absolute right-0 top-0 h-full w-2 bg-red-500"></span>
                    </div>

                    {{-- Description --}}
                    <p class="mt-3 text-gray-700 text-lg max-w-4xl">
                        {{ $item['description'] }}
                    </p>
                </div>
            @endforeach
        </div>


        {{-- ================= IMAGES ================= --}}
        @if(count($images))

            {{-- Large First Image --}}
            @if(isset($images[0]))
                <div class="border-4 border-blue-900 shadow-lg mb-8">
                    <img src="{{ asset('images/' . $images[0]) }}" class="w-full h-[450px] object-cover" alt="Hull Fabrication">
                </div>
            @endif

            {{-- Two Smaller Images --}}
            @if(count($images) > 1)
                <div class="grid md:grid-cols-2 gap-8">
                    @foreach(array_slice($images, 1) as $img)
                        <div class="border-4 border-blue-900 shadow-lg">
                            <img src="{{ asset('images/' . $img) }}" class="w-full h-[300px] object-cover" alt="Hull Structure">
                        </div>
                    @endforeach
                </div>
            @endif

        @endif

    </div>
</section>