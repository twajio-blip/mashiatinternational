@props(['data' => []])

@php
    // The main container is at index 0
    $mainGroup = $data[0] ?? [];

    // Group 0: CEO Profile Details
    $ceoInfo = $mainGroup[0] ?? [];

    $name = $ceoInfo['ceo_name'] ?? 'John Doe';
    $designation = $ceoInfo['designation'] ?? 'Chief Executive Officer';

    // Check if image path needs a folder prefix (e.g., 'uploads/')
    $image = $ceoInfo['ceo_image'] ?? 'images/ceo-photo.jpg';

    $signature = $ceoInfo['ceo_signature'] ?? null;
    $title = $ceoInfo['title'] ?? 'Elevating the Future, Together.';
    $quote = $ceoInfo['quote'] ?? '';

    // Group 1: The dynamic paragraph instances
    $paragraphs = array_values($mainGroup[1]['instances'] ?? []);
@endphp

<section id="ceo-message" class="py-16 lg:py-24 bg-white border border-t border-gray-200 w-full overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-12 items-start">

            {{-- CEO Image --}}
            <div class="w-full md:w-1/3 shrink-0" data-aos="fade-right" data-aos-duration="800">
                {{-- Ensure the container has a relative position and full height --}}
                <div class="aspect-[3/4] bg-gray-200 rounded-2xl overflow-hidden shadow-xl relative w-full h-full">

                    {{-- The image now uses absolute positioning to force-fill the aspect-ratio box --}}
                    <img src="{{ asset('images/' . $image) }}" alt="{{ $name }}"
                        class="absolute inset-0 w-full h-full object-cover">

                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

                    {{-- Text Content --}}
                    <div class="absolute bottom-6 left-6 z-20 text-white">
                        <h3 class="font-bold text-size-sub-header">{{ $name }}</h3>
                        <p class="text-size-body text-gray-200">{{ $designation }}</p>
                    </div>
                </div>
            </div>

            {{-- Message Content --}}
            <div class="w-full md:w-2/3 prose prose-lg text-gray-500" data-aos="fade-left" data-aos-duration="800"
                data-aos-delay="200">
                <h2 class="text-size-title font-heading font-bold text-brand-charcoal mb-6 leading-[1.1]">
                    {{ $title }}
                </h2>

                {{-- 1st Paragraph --}}
                @if(isset($paragraphs[0]))
                    <p class="mb-6 text-size-body">{{ $paragraphs[0]['discription'] }}</p>
                @endif

                {{-- CEO Quote (The customized solution text) --}}
                @if($quote)
                    <blockquote
                        class="border-l-4 border-brand-red pl-6 italic text-size-sub-header text-brand-charcoal my-8 font-medium">
                        "{{ $quote }}"
                    </blockquote>
                @endif

                {{-- Remaining Paragraphs (2, 3, and 4) --}}
                @foreach($paragraphs as $index => $item)
                    @if($index > 0)
                        <p class="mb-6 text-size-body">{{ $item['discription'] }}</p>
                    @endif
                @endforeach

                <div class="mt-12 pt-8 border-t border-gray-100">
                    {{-- Signature - logic check if it's text or an image path --}}
                    @if($signature && Str::contains($signature, ['.jpg', '.png', '.svg', '.webp']))
                        <img src="{{ asset($signature) }}" alt="CEO Signature" class="h-16 opacity-50 mb-2" />
                    @else
                        <p class="italic font-serif text-size-sub-header text-gray-700 mb-2">{{ $signature }}</p>
                    @endif
                    <p class="text-size-body text-gray-700">{{ $designation }}, RAR Lift Limited</p>
                </div>
            </div>
        </div>
    </div>
</section>