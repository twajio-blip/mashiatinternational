@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $details = $data[0][1]['instances'] ?? [];
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


        {{-- ================= DETAILS SECTIONS ================= --}}
        <div class="space-y-16">

            @foreach($details as $index => $item)

                <div class="grid md:grid-cols-2 gap-10 items-center">

                    {{-- TEXT CONTENT --}}
                    <div class="{{ $loop->even ? 'md:order-2' : '' }}">

                        {{-- Blue Title Tag --}}
                        <div class="inline-block relative bg-blue-900 text-white font-semibold px-6 py-2 text-lg">
                            {{ $item['title'] }}
                            <span class="absolute right-0 top-0 h-full w-2 bg-red-500"></span>
                        </div>

                        {{-- Description --}}
                        <div class="mt-4 text-gray-700 text-lg leading-relaxed">
                            {!! $item['description'] !!}
                        </div>

                    </div>


                    {{-- IMAGE --}}
                    @if(!empty($item['image']))
                        <div class="{{ $loop->even ? 'md:order-1' : '' }}">
                            <div class="border-4 border-blue-900 shadow-lg">
                                <img src="{{ asset('images/' . $item['image']) }}" class="w-full h-[300px] object-cover"
                                    alt="{{ $item['title'] }}">
                            </div>
                        </div>
                    @endif

                </div>

            @endforeach

        </div>

    </div>
</section>