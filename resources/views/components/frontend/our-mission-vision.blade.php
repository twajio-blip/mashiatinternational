@php
    $section = $data[0] ?? [];

    $mission = $section[0] ?? [];
    $vision = $section[1] ?? [];
@endphp


{{-- Mission & Vision Section --}}
<section class="custom_py bg-navy-900 relative overflow-hidden">

    {{-- Diagonal --}}
    <div class="absolute top-0 left-0 w-full h-24 bg-white transform -skew-y-3 origin-top-left"></div>

    <div class="container mx-auto px-4 sm:px-6 md:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16">

            {{-- MISSION --}}
            <div
                class="bg-navy-800 p-10 border-l-4 border-industrial-red relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">

                {{-- Large Icon Background --}}
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-28 h-28 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 7v5l3 3"></path>
                    </svg>
                </div>

                <div class="relative z-10">

                    {{-- Small Icon Circle --}}
                    <div
                        class="w-16 h-16 bg-navy-900 rounded-full flex items-center justify-center mb-6 text-industrial-red border border-navy-700">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7v5l3 3"></path>
                        </svg>
                    </div>

                    <h3 class="text-3xl font-serif font-bold text-white mb-4">
                        {{ $mission['missin_name'] ?? '' }}
                    </h3>

                    <p class="text-gray-300 leading-relaxed text-lg">
                        {{ $mission['mission_details'] ?? '' }}
                    </p>

                </div>
            </div>


            {{-- VISION --}}
            <div
                class="bg-navy-800 p-10 border-l-4 border-industrial-red relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">

                {{-- Large Icon Background --}}
                <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-28 h-28 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z"></path>
                    </svg>
                </div>

                <div class="relative z-10">

                    {{-- Small Icon Circle --}}
                    <div
                        class="w-16 h-16 bg-navy-900 rounded-full flex items-center justify-center mb-6 text-industrial-red border border-navy-700">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M2 12s4-6 10-6 10 6 10 6-4 6-10 6-10-6-10-6z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>

                    <h3 class="text-3xl font-serif font-bold text-white mb-4">
                        {{ $vision['vision_name'] ?? '' }}
                    </h3>

                    <p class="text-gray-300 leading-relaxed text-lg">
                        {{ $vision['vision_details'] ?? '' }}
                    </p>

                </div>
            </div>

        </div>
    </div>
</section>