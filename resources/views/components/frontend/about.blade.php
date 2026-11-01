@props(['data'])

@php
  $component = $data[0] ?? [];

  // Get only numeric group items
  $groups = collect($component)
    ->filter(fn($v, $k) => is_int($k) && is_array($v) && isset($v['group_name']))
    ->keyBy('group_name');

  $about = $groups['About Content'] ?? [];
  $features = $groups['Feature Icons']['instances'] ?? [];
@endphp

<div class="container mx-auto px-4 sm:px-6 md:px-8 relative custom_py">

  <section class="bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

      {{-- IMAGE SIDE (UNCHANGED) --}}
      <div class="relative">
        <div class="absolute -top-10 -left-10 w-full h-full border-4 border-navy-100 z-0 hidden md:block"></div>

        <img src="{{ !empty($about['image'])
  ? asset('images/' . $about['image'])
  : asset('images/placeholder.jpg') }}" alt="Shipyard dry dock" class="relative z-10 w-full shadow-2xl" />

        <div class="absolute -bottom-10 -right-10 bg-industrial-red p-8 z-20 hidden md:block text-white">
          <p class="text-4xl font-bold font-serif">
            {{ $about['experience_number'] ?? '' }}
          </p>
          <p class="text-sm uppercase tracking-wider">
            {{ $about['experience_text'] ?? '' }}
          </p>
        </div>
      </div>

      {{-- CONTENT SIDE (UNCHANGED) --}}
      <div>
        <h4 class="text-industrial-red font-bold uppercase tracking-widest mb-4">
          {{ $about['subtitle'] ?? '' }}
        </h4>

        <h2 class="text-4xl md:text-5xl font-serif font-bold text-navy-900 mb-6">
          {{ $about['title'] ?? '' }}
        </h2>

        {{-- description keeps same spacing --}}
        <div class="text-gray-600 mb-6 leading-relaxed">
          {!! $about['description'] ?? '' !!}
        </div>

        {{-- feature list --}}
        <div class="grid grid-cols-2 gap-6 mb-8">
          @foreach($features as $feature)
            <div class="flex items-center gap-3">
              {!! $feature['icon'] ?? '' !!}
              <span class="font-bold text-navy-900">
                {{ $feature['feature_text'] ?? '' }}
              </span>
            </div>
          @endforeach
        </div>

        <a href="{{ $about['button_url'] ?? '/about' }}">
          <button class="bg-navy-900 text-white px-6 py-4 rounded-md flex items-center gap-2">
            {{ $about['button_text'] ?? 'Learn More About Us' }}
            <i class=""></i>
          </button>
        </a>
      </div>

    </div>
  </section>

</div>