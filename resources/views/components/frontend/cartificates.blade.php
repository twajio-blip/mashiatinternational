@props(['data' => []])

@php
    $data = $data ?? [];

    // 1. Extract Header Data (Group 0)
    $headerBlock = $data[0][0]['instances'][1] ?? [];
    $title = $headerBlock['title'] ?? 'Quality & Compliance';
    $subtitle = $headerBlock['subtitile'] ?? 'Our Certifications'; // Matches your array typo "subtitile"
    $description = $headerBlock['description'] ?? '';

    // 2. Extract Certificates List (Group 2)
    $certificates = $data[1][0]['instances'] ?? [];
@endphp

<section class="py-24 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header Section --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <h3 class="text-brand-red font-semibold tracking-wider uppercase text-sm">
                    {{ $subtitle }}
                </h3>
            </div>
            <h2 class="text-3xl md:text-5xl font-heading font-bold text-brand-charcoal mb-4">
                {{ $title }}
            </h2>
            @if($description)
                <p class="max-w-2xl mx-auto text-gray-500 leading-relaxed">
                    {{ $description }}
                </p>
            @endif
        </div>

        {{-- Certificates Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($certificates as $index => $cert)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                    <div class="relative bg-white p-4 rounded-2xl shadow-sm border border-gray-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                        
                        {{-- Certificate Image --}}
                        <div class="relative overflow-hidden rounded-xl aspect-[3/4] bg-gray-200">
                            <img src="{{ asset('images/' . ($cert['certificate_image'] ?? '')) }}" 
                                 alt="{{ $cert['certificate_name'] ?? 'Certificate' }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                            {{-- Hover Overlay --}}
                            <div class="absolute inset-0 bg-brand-charcoal/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <a href="{{ asset('images/' . ($cert['certificate_image'] ?? '')) }}" target="_blank"
                                   class="w-12 h-12 bg-brand-red text-white rounded-full flex items-center justify-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Certificate Info --}}
                        <div class="mt-6 text-center">
                            <h4 class="font-bold text-lg text-brand-charcoal group-hover:text-brand-red transition-colors">
                                {{ $cert['certificate_name'] ?? 'N/A' }}
                            </h4>
                            <p class="text-sm text-gray-500 uppercase tracking-wide mt-1">
                                {{ $cert['Category'] ?? 'Standard' }} {{-- Matches your array key "Category" --}}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        {{-- Footer Call to Action --}}
        <div class="mt-20 p-8 bg-brand-charcoal rounded-3xl flex flex-col md:flex-row items-center justify-between text-white"
            data-aos="zoom-in">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h4 class="text-xl font-bold mb-2">Need to verify a document?</h4>
                <p class="text-white/60 text-sm">Contact our compliance department for official verification codes.</p>
            </div>
            <a href="{{ url('contact') }}"
                class="px-8 py-3 bg-brand-red hover:bg-white hover:text-brand-charcoal transition-all font-bold rounded-xl text-sm">
                Inquire Now
            </a>
        </div>
    </div>
</section>