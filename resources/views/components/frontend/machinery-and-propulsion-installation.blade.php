@props(['data'])

@php
    $section = $data[0][0] ?? null;

    $images = [];

    if (isset($section['images'])) {
        $decoded = json_decode($section['images'], true);
        if (is_array($decoded)) {
            $images = $decoded;
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

                <div class="text-gray-700 text-lg leading-relaxed">
                    {!! nl2br(e($section['description'])) !!}
                </div>
            </div>
        @endif


        {{-- ================= IMAGES ================= --}}
        @if(count($images))

            {{-- First Row (2 Images) --}}
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                @foreach(array_slice($images, 0, 2) as $img)
                    <div class="border-4 border-blue-900 shadow-lg">
                        <img src="{{ asset('images/' . $img) }}" class="w-full h-[350px] object-cover"
                            alt="Machinery Installation">
                    </div>
                @endforeach
            </div>

            {{-- Second Row (Full Width Image) --}}
            @if(count($images) > 2)
                <div class="border-4 border-blue-900 shadow-lg">
                    <img src="{{ asset('images/' . $images[2]) }}" class="w-full h-[450px] object-cover"
                        alt="Propulsion System">
                </div>
            @endif

        @endif

    </div>
</section>