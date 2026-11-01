@props(['data'])
@php
    // 1. Grab the Title from the first item (Index 0, Sub-index 0)
    $title = $data[0][0]['Title'] ?? 'Our Management';

    // 2. Process the team, skipping the first element
    $team = collect($data)
        ->filter(fn($item, $key) => is_int($key) && $key > 0) // Key > 0 ignores the Title element
        ->map(function ($item) {
            return [
                'info' => $item[0] ?? [],
                'social' => $item[1] ?? [],
            ];
        })
        ->values();
@endphp

<section class="custom_py">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">
        <h2 class="text-2xl font-bold text-center mb-8">{{ $title }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach($team as $member)

                <div class="group relative bg-white shadow-xl overflow-hidden">

                    {{-- Image --}}
                    <div class="h-80 overflow-hidden relative">
                        <img src="{{ asset('images/' . ($member['info']['image'] ?? '')) }}"
                            alt="{{ $member['info']['name'] ?? '' }}"
                            class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-110" />

                        {{-- Social Overlay --}}
                        <div
                            class="absolute inset-0 bg-navy-900/80 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-4">

                            @if(!empty($member['social']['facebook_link']))
                                <a href="{{ $member['social']['facebook_link'] }}"
                                    class="w-10 h-10 bg-industrial-red text-white flex items-center justify-center rounded-sm hover:bg-white hover:text-industrial-red transition-colors">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            @endif

                            @if(!empty($member['social']['Instagram_link']))
                                <a href="{{ $member['social']['Instagram_link'] }}"
                                    class="w-10 h-10 bg-industrial-red text-white flex items-center justify-center rounded-sm hover:bg-white hover:text-industrial-red transition-colors">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            @endif

                            @if(!empty($member['social']['mail']))
                                <a href="mailto:{{ $member['social']['mail'] }}"
                                    class="w-10 h-10 bg-industrial-red text-white flex items-center justify-center rounded-sm hover:bg-white hover:text-industrial-red transition-colors">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            @endif

                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 text-center relative">

                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-1 bg-industrial-red">
                        </div>

                        <h3 class="text-2xl font-serif font-bold text-navy-900 mb-1">
                            {{ $member['info']['name'] ?? '' }}
                        </h3>

                        <p class="text-gray-500 font-medium uppercase text-sm tracking-wider">
                            {{ $member['info']['designation'] ?? '' }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>
</section>