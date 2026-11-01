@props(['data' => []])
@php
    $data = $data ?? [];

    // 1. Header Logic: Extract from Group 0 -> index 0
    $headerBlock = $data[0][0] ?? [];
    $sub_title = $headerBlock['subtitle'] ?? 'Our Trusted Brands';
    $title = $headerBlock['title'] ?? 'Global Partners';

    // 2. Filter and Map Brands: Starting from index 1 and 2
    $brands = collect($data)
        ->filter(function ($item, $key) {
            // Only look at numeric keys >= 1
            // Check if index 0 exists and has a 'brand_name' or 'name'
            return is_numeric($key) && $key >= 1 && is_array($item) &&
                (isset($item[0]['brand_name']) || isset($item[0]['name']));
        })
        ->map(function ($item, $key) use ($data) {
            $rawBrand = $item[0]; // This is the "Brands Details" array

            $brandName = $rawBrand['brand_name'] ?? ($rawBrand['name'] ?? 'Partner');
            $url = url('/brands?' . urlencode(str_replace(' ', '_', $brandName)));

            return [
                'brands_logo' => $rawBrand['brand_logo'] ?? null,
                // Fallback sequence for the name
                'brands_name' => $brandName,
                // Use 'type' (Premium Partner) or 'origin' (Greek/Malaysian)
                'brands_desc' => $rawBrand['type'] ?? ($rawBrand['origin'] ?? 'Partner'),
                'url' => $url,
            ];
        })
        ->values()
        ->all();

    // 3. Footer CTA Logic
    $btn_text = 'View All Brand Partners';
    $btn_link = '/brands';
@endphp

<section class="py-16 lg:py-24 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 text-center">

        {{-- Header --}}
        <div class="mb-8" data-aos="fade-up">
            <p class="text-size-sub-header font-bold text-brand-red uppercase tracking-widest">
                {{ $sub_title }}
            </p>
            <h2 class="text-size-title font-heading font-bold text-brand-charcoal leading-[1.1]">
                {{ $title }}
            </h2>
        </div>

        {{-- Brands Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 mb-12">
            @foreach($brands as $index => $brand)
                <a href="{{ $brand['url'] }}"
                    class="group p-6 rounded-2xl bg-white border border-gray-100 hover:bg-gray-50 hover:shadow-xl cursor-pointer transition-all duration-300 flex flex-col lg:flex-row items-center justify-center gap-2"
                    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                    {{-- Logo Container - No background, but centered --}}
                    <div
                        class="w-24 h-16 shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                        @if(!empty($brand['brands_logo']))
                            {{-- Using mix-blend-multiply ensures white logo backgrounds disappear on gray hover --}}
                            <img src="{{ asset('images/' . $brand['brands_logo']) }}" alt="{{ $brand['brands_name'] }}"
                                class="w-full h-full object-contain filter drop-shadow-sm">
                        @else
                            <span
                                class="font-heading font-bold text-3xl text-gray-300 group-hover:text-brand-red transition-colors">
                                {{ substr($brand['brands_name'], 0, 1) }}
                            </span>
                        @endif
                    </div>

                    {{-- Info Container --}}
                    <div class="text-center lg:text-left">
                        <h3
                            class="font-bold text-size-body text-brand-charcoal mb-0.5 whitespace-nowrap group-hover:text-brand-red transition-colors">
                            {{ $brand['brands_name'] }}
                        </h3>
                        <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest whitespace-nowrap">
                            {{ $brand['brands_desc'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Footer Link --}}
        <div data-aos="fade-up">
            <a href="{{ $btn_link }}"
                class="inline-flex items-center text-size-sub-header text-brand-charcoal font-bold hover:text-brand-red transition-colors group">
                {{ $btn_text }}
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>
</section>