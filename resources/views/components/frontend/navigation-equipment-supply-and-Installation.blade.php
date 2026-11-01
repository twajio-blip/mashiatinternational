@props(['data'])

@php
    $group1 = $data[0][0] ?? null;
    $group2 = $data[0][1] ?? null;
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- ================= HEADER SECTION ================= --}}
        @if($group1)
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $group1['title'] }}
                </h2>

                <p class="text-gray-700 text-lg leading-relaxed mb-8">
                    {{ $group1['description'] }}
                </p>

                @if(!empty($group1['image']))
                    <div class="border-4 border-blue-900 shadow-lg">
                        <img src="{{ asset('images/' . $group1['image']) }}" class="w-full h-[350px] object-cover"
                            alt="Navigation Equipment">
                    </div>
                @endif
            </div>
        @endif


        {{-- ================= INCLUDED EQUIPMENT ================= --}}
        @if($group2)
            <div class="mt-12">

                {{-- Ribbon Title --}}
                <div class="inline-block relative bg-blue-900 text-white font-semibold px-6 py-2 text-lg mb-4">
                    {{ $group2['title'] }}
                    <span class="absolute right-0 top-0 h-full w-2 bg-red-500"></span>
                </div>

                {{-- Equipment List --}}
                <div class="text-gray-700 text-lg leading-relaxed max-w-4xl mb-8">
                    {!! $group2['description'] !!}
                </div>

                {{-- Bottom Image --}}
                @if(!empty($group2['image']))
                    <div class="border-4 border-blue-900 shadow-lg">
                        <img src="{{ asset('images/' . $group2['image']) }}" class="w-full h-[400px] object-cover"
                            alt="Navigation Bridge">
                    </div>
                @endif

            </div>
        @endif

    </div>
</section>