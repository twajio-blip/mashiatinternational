@props([
    'title' => null,
    'subtitle' => null,
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => '/'],
    ],
    'data' => []
])

@php
    /* LOGIC PRIORITY:
       1. Manual Props (Highest)
       2. URL Query Params
       3. CMS Data ($data[0][0])
       4. Hardcoded Fallbacks
    */
    $displayTitle = $title 
        ?? request()->query('title') 
        ?? ($data[0][0]['title'] ?? 'Our Products');

    $displaySubtitle = $subtitle 
        ?? request()->query('subtitle') 
        ?? ($data[0][0]['subtitle'] ?? 'Quality solutions tailored to your needs.');
@endphp

<section class="relative pt-32 pb-20 bg-brand-charcoal overflow-hidden mt-16">
    {{-- Elevator-themed background elements (Line Accents) --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute left-1/4 top-0 bottom-0 w-px bg-white"></div>
        <div class="absolute right-1/4 top-0 bottom-0 w-px bg-white"></div>
        <div class="absolute left-0 right-0 top-1/2 h-px bg-white"></div>
    </div>
    
    {{-- Red Gradient Overlay from React Design --}}
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-red/20 to-transparent pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div data-aos="fade-up" data-aos-duration="600">
            
            {{-- Breadcrumbs --}}
            <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-6">
                @foreach($breadcrumbs as $index => $crumb)
                    @if($index > 0)
                        <span class="text-gray-600">/</span>
                    @endif
                    
                    @if(isset($crumb['url']))
                        <a href="{{ url($crumb['url']) }}" class="hover:text-brand-red transition-colors">
                            {{ $crumb['label'] }}
                        </a>
                    @else
                        <span class="text-white font-medium">{{ $crumb['label'] }}</span>
                    @endif
                @endforeach
            </nav>

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-heading font-bold text-white mb-6 leading-tight">
                {{ $displayTitle }}
            </h1>

            {{-- Subtitle --}}
            @if($displaySubtitle)
                <p class="text-lg md:text-xl text-white/70 max-w-2xl leading-relaxed">
                    {{ $displaySubtitle }}
                </p>
            @endif
        </div>
    </div>
</section>