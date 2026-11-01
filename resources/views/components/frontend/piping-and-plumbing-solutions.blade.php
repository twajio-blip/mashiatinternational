@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $blocks = $data[0][1]['instances'] ?? [];

    $plumbingImage = null;

    foreach ($blocks as $block) {
        if (isset($block['image'])) {
            $plumbingImage = $block['image'];
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


        {{-- ================= CONTENT BLOCKS ================= --}}
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
                        <div class="mt-4 text-gray-700 text-lg leading-relaxed max-w-4xl">
                            {!! $block['description'] !!}
                        </div>
                    @endif
                </div>

            @endforeach

        </div>


        {{-- ================= IMAGE SECTION ================= --}}
        @if($plumbingImage)
            <div class="mt-12 border-4 border-blue-900 shadow-lg max-w-4xl">
                <img src="{{ asset('images/' . $plumbingImage) }}" class="w-full h-[350px] object-cover"
                    alt="Piping & Plumbing">
            </div>
        @endif

    </div>
</section>