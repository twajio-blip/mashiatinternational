@php
  // --- SAFE READ FROM YOUR DATA DUMP STRUCTURE ---
  // $data[0][0] => Group 1: title, description
  // $data[0][1] => Group 2: instances
  // $data[0][2] => Images: images JSON string

  $row = $data[0] ?? [];

  $g1 = $row[0] ?? [];
  $g2 = $row[1] ?? [];
  $g3 = $row[2] ?? [];

  $title = $g1['title'] ?? 'Docking Equipment';
  $description = trim($g1['description'] ?? '');

  $instances = $g2['instances'] ?? []; // [1 => ['equipment_type'=>'..','quantity'=>'..'], ...]

  // images stored as JSON string: '["file.webp","file2.webp"]'
  $imagesRaw = $g3['images'] ?? '[]';
  $images = is_string($imagesRaw) ? json_decode($imagesRaw, true) : $imagesRaw;
  if (!is_array($images))
    $images = [];

  // Where images live (your requested method)
  // Put files in: public/images/
  $fallback = asset('images/placeholder.webp');
@endphp

<section class="custom_py w-full">
  <div class="container mx-auto px-4 sm:px-6 md:px-8">

    {{-- Header Card --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 sm:p-6 shadow-sm">
      <div class="flex items-start justify-between gap-4">
        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900">
          {{ $title }}
        </h2>


      </div>

      @if($description)
        <p class="mt-3 text-sm sm:text-base leading-relaxed text-slate-600 whitespace-pre-line">
          {{ $description }}
        </p>
      @endif
    </div>

    {{-- Table --}}
    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
      <div class="bg-indigo-900 text-white px-4 sm:px-6 py-3">
        <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm font-semibold">
          <div class="col-span-2 sm:col-span-1">SL</div>
          <div class="col-span-7 sm:col-span-9">Equipment Type and Characteristics</div>
          <div class="col-span-3 sm:col-span-2 text-right">Quantity</div>
        </div>
      </div>

      <div class="divide-y divide-slate-200">
        @forelse($instances as $idx => $item)
          @php
            // Ensure SL like 01, 02, 03...
            $sl = str_pad((int) $idx, 2, '0', STR_PAD_LEFT);
            $equipment = $item['equipment_type'] ?? '-';
            $qty = $item['quantity'] ?? '-';

            // zebra rows similar feel
            $zebra = ((int) $idx % 2 === 0) ? 'bg-slate-50' : 'bg-rose-50/60';
          @endphp

          <div class="px-4 sm:px-6 py-3 {{ $zebra }}">
            <div class="grid grid-cols-12 gap-2 text-xs sm:text-sm">
              <div class="col-span-2 sm:col-span-1 font-semibold text-slate-700">
                {{ $sl }}
              </div>

              <div class="col-span-7 sm:col-span-9 text-slate-800">
                {{ $equipment }}
              </div>

              <div class="col-span-3 sm:col-span-2 text-right font-semibold text-slate-700">
                {{ $qty }}
              </div>
            </div>
          </div>
        @empty
          <div class="px-4 sm:px-6 py-6 text-sm text-slate-500">
            No equipment data found.
          </div>
        @endforelse
      </div>
    </div>

    {{-- Images --}}
    @if(count($images))
      @php
        // Split into 2 rows like your screenshot vibe
        $topRow = array_slice($images, 0, 4);
        $bottomRow = array_slice($images, 4);
      @endphp

      {{-- Row 1 --}}
      <div class="mt-6 rounded-2xl border-2 border-indigo-900 bg-white shadow-sm p-3">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
          @foreach($topRow as $img)
            @php
              $src = !empty($img) ? asset('images/' . $img) : $fallback;
            @endphp

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
              <img src="{{ $src }}" onerror="this.onerror=null;this.src='{{ $fallback }}';" alt="Docking equipment image"
                class="h-28 sm:h-32 w-full object-cover" loading="lazy">
            </div>
          @endforeach
        </div>
      </div>

      {{-- Row 2 --}}
      @if(count($bottomRow))
        <div class="mt-4 rounded-2xl border-2 border-indigo-900 bg-white shadow-sm p-3">
          <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
            @foreach($bottomRow as $img)
              @php
                $src = !empty($img) ? asset('images/' . $img) : $fallback;
              @endphp

              <div class="overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                <img src="{{ $src }}" onerror="this.onerror=null;this.src='{{ $fallback }}';" alt="Docking equipment image"
                  class="h-24 sm:h-28 w-full object-contain bg-white" loading="lazy">
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @endif

  </div>
</section>