@props(['data'])
@php
    $milestones = collect($data)
        ->map(fn($item) => $item[0] ?? null)
        ->filter()
        ->values();
@endphp


<section class="custom_py bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        <div class="text-center mb-16">
            <h2 class="text-4xl font-serif font-bold text-navy-900">
                Our Journey
            </h2>
        </div>

        <div class="relative max-w-5xl mx-auto">

            {{-- Center Vertical Line --}}
            <div
                class="hidden md:block absolute left-1/2 top-0 bottom-0 w-[2px] bg-gray-200 transform -translate-x-1/2">
            </div>

            <div class="space-y-20">

                @foreach($milestones as $index => $item)

                    <div class="relative flex items-center justify-between">

                        {{-- LEFT SIDE --}}
                        @if($index % 2 == 0)

                            <div class="w-full md:w-1/2 md:pr-12 text-left md:text-right">
                                <div
                                    class="bg-white p-6 shadow-md border-l-4 md:border-r-4 md:border-l-0 border-industrial-red">
                                    <span class="text-industrial-red font-bold text-lg block mb-1">
                                        {{ $item['year'] }}
                                    </span>
                                    <h3 class="text-xl font-bold text-navy-900 mb-2">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ $item['short_description'] }}
                                    </p>
                                </div>
                            </div>

                            <div class="hidden md:block w-1/2"></div>

                            {{-- RIGHT SIDE --}}
                        @else

                            <div class="hidden md:block w-1/2"></div>

                            <div class="w-full md:w-1/2 md:pl-12 text-left">
                                <div class="bg-white p-6 shadow-md border-l-4 border-industrial-red">
                                    <span class="text-industrial-red font-bold text-lg block mb-1">
                                        {{ $item['year'] }}
                                    </span>
                                    <h3 class="text-xl font-bold text-navy-900 mb-2">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="text-gray-600 text-sm">
                                        {{ $item['short_description'] }}
                                    </p>
                                </div>
                            </div>

                        @endif


                        {{-- DOT --}}
                        <div
                            class="absolute top-0 md:top-1/2 left-0 md:left-1/2 transform -translate-y-1/2 md:translate-y-0 -translate-x-1/2 w-8 h-8 bg-industrial-red rounded-full border-4 border-white shadow-md z-10 flex items-center justify-center">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>
</section>