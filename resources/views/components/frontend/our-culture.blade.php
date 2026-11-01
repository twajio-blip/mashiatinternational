@props(['data'])
@php
    // Data: 0 = header (title, subtitle, description), 1,2,... = cards (card_icon, card_title, card_short_description)
    $records = collect($data)->filter(fn($v, $k) => is_int($k) && is_array($v))->values();
    $header = [];
    $cards = [];
    foreach ($records as $index => $record) {
        $content = null;
        foreach ($record as $k => $v) {
            if (is_int($k) && is_array($v)) {
                $content = $v;
                break;
            }
        }
        if ($content === null) {
            continue;
        }
        if ($index === 0 && isset($content['title'])) {
            $header = $content;
        } elseif (isset($content['card_title']) || isset($content['card_icon'])) {
            $cards[] = $content;
        }
    }
@endphp


<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- Header --}}
        <div class="text-center mb-16 max-w-3xl mx-auto">

            <h4 class="text-industrial-red font-bold uppercase tracking-widest mb-4">
                {{ $header['title'] ?? '' }}
            </h4>

            <h2 class="text-4xl font-serif font-bold text-navy-900 mb-6">
                {{ $header['subtitle'] ?? '' }}
            </h2>

            <p class="text-gray-600">
                {{ $header['description'] ?? '' }}
            </p>

        </div>


        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($cards as $card)
                <div
                    class="bg-white p-8 shadow-lg hover:shadow-xl transition-shadow border-t-4 border-transparent hover:border-industrial-red group">

                    {{-- Icon --}}
                    <div
                        class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-6 text-navy-900 group-hover:bg-industrial-red group-hover:text-white transition-colors duration-300 text-xl">
                        {!! $card['card_icon'] ?? '' !!}
                    </div>

                    {{-- Title --}}
                    <h3 class="text-xl font-bold text-navy-900 mb-3">
                        {{ $card['card_title'] ?? '' }}
                    </h3>

                    {{-- Description --}}
                    <p class="text-gray-600">
                        {{ $card['card_short_description'] ?? '' }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
</section>