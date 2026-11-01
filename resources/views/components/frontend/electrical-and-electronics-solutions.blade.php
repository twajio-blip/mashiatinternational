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

        {{-- ================= SECTION HEADER ================= --}}
        @if($section)
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $section['title'] }}
                </h2>

                <div class="text-gray-700 text-lg leading-relaxed">
                    {!! $section['description'] !!}
                </div>
            </div>
        @endif


        {{-- ================= IMAGE SECTION ================= --}}
        @if(count($images))

            <div class="space-y-10">

                {{-- First Large Image --}}
                @if(isset($images[0]))
                    <div class="border-4 border-blue-900 shadow-lg">
                        <img src="{{ asset('images/' . $images[0]) }}" class="w-full h-[400px] object-cover"
                            alt="Electrical System">
                    </div>
                @endif

                {{-- Additional Images --}}
                @if(count($images) > 1)
                    <div class="grid md:grid-cols-2 gap-8">
                        @foreach(array_slice($images, 1) as $img)
                            <div class="border-4 border-blue-900 shadow-lg">
                                <img src="{{ asset('images/' . $img) }}" class="w-full h-[300px] object-cover"
                                    alt="Electrical Work">
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        @endif

    </div>
</section>