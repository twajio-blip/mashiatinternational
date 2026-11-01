@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $details = $data[0][1]['instances'] ?? [];

    $paintingImages = [];

    foreach ($details as $item) {
        if (isset($item['image'])) {
            $decoded = json_decode($item['image'], true);
            if (is_array($decoded)) {
                $paintingImages = $decoded;
            }
        }
    }
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- ================= SECTION HEADER ================= --}}
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


        {{-- ================= DETAILS ================= --}}
        <div class="space-y-12">

            @foreach($details as $item)

                <div>
                    {{-- Blue Title Ribbon --}}
                    <div class="inline-block relative bg-blue-900 text-white font-semibold px-6 py-2 text-lg">
                        {{ $item['titles'] }}
                        <span class="absolute right-0 top-0 h-full w-2 bg-red-500"></span>
                    </div>

                    {{-- Description --}}
                    @if(!empty($item['description']))
                        <div class="mt-4 text-gray-700 text-lg leading-relaxed max-w-4xl">
                            {!! $item['description'] !!}
                        </div>
                    @endif

                </div>

            @endforeach

        </div>


        {{-- ================= IMAGES SECTION ================= --}}
        @if(count($paintingImages))

            <div class="grid md:grid-cols-2 gap-10 mt-12">

                @foreach($paintingImages as $img)
                    <div class="border-4 border-blue-900 shadow-lg">
                        <img src="{{ asset('images/' . $img) }}" class="w-full h-[350px] object-cover"
                            alt="Blasting & Painting">
                    </div>
                @endforeach

            </div>

        @endif

    </div>
</section>