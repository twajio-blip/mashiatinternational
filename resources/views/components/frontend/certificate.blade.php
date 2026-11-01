@props(['data'])

@php
  // $data is an array of blocks. Each block has:
  // [0]['title'] and [1]['instances'] (certificate_name, image)
  $fallback = asset('images/placeholder.webp');
@endphp

<section class="bg-white custom_py">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">

    @foreach(($data ?? []) as $block)
      @php

        $title = $block[0]['title'] ?? null;
        $certificates = $block[1]['instances'] ?? [];
      @endphp

      <div class="mb-14 sm:mb-16">
        {{-- Block Title (navy band style) --}}
        @if($title)
          <div class="rounded-t-md overflow-hidden">
            <div class="bg-[#232A86] text-black-500 text-center px-5 sm:px-6 py-4">
              <h2 class="text-lg text-white sm:text-xl md:text-2xl font-extrabold tracking-tight">
                {{ $title }}
              </h2>
            </div>
          </div>
        @endif

        {{-- Grid --}}
        <div class="border border-slate-200 border-t-0 rounded-b-md p-5 sm:p-6">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

            @foreach($certificates as $certificate)
              @php
                $img = $certificate['image'] ?? null;
                $label = $certificate['certificate_name'] ?? '';
                $src = $img ? asset('images/' . $img) : $fallback;
              @endphp

              <button type="button"
                class="cert-card text-left group w-full rounded-xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition overflow-hidden focus:outline-none focus:ring-2 focus:ring-[#232A86]/40"
                data-image="{{ $src }}" data-caption="{{ e($label) }}">
                {{-- Preview area (better than small icon) --}}
                <div class="relative bg-[#EFF1F6]">
                  <div class="aspect-[4/3] w-full flex items-center justify-center p-4">
                    <img src="{{ $src }}" onerror="this.onerror=null;this.src='{{ $fallback }}';" alt="{{ $label }}"
                      class="max-h-full max-w-full object-contain transition-transform duration-300 group-hover:scale-[1.03]"
                      loading="lazy" />
                  </div>

                  {{-- Overlay icon --}}
                  <div
                    class="absolute inset-0 bg-[#232A86]/0 group-hover:bg-[#232A86]/35 transition flex items-center justify-center">
                    <span
                      class="opacity-0 group-hover:opacity-100 transition duration-300 inline-flex items-center gap-2 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-[#232A86]">
                      View
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 10l4.553-4.553a2 2 0 10-2.828-2.828L12 7m3 3H9m6 0l-4.553 4.553a2 2 0 11-2.828-2.828L12 13" />
                      </svg>
                    </span>
                  </div>
                </div>

                {{-- Caption --}}
                <div class="px-4 py-3 border-t border-slate-100">
                  <div class="text-[13px] font-semibold text-slate-800 leading-snug text-center">
                    {{ $label ?: 'Certificate' }}
                  </div>
                </div>
              </button>
            @endforeach

          </div>
        </div>
      </div>
    @endforeach

  </div>
</section>

{{-- Lightbox (Pure JS, no jQuery) --}}
<div id="certLightbox" class="fixed inset-0 hidden bg-black/90 backdrop-blur-sm items-center justify-center z-50 p-4">
  <button type="button" id="certLightboxClose" aria-label="Close"
    class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <div class="relative max-w-6xl w-full max-h-[90vh] flex flex-col items-center">
    <img id="certLightboxImage" src="" alt=""
      class="max-w-full max-h-[82vh] w-auto object-contain rounded-lg shadow-2xl bg-white" />
    <p id="certLightboxCaption" class="mt-4 text-white text-center text-sm sm:text-base max-w-2xl"></p>
  </div>
</div>

<script>
  (() => {
    const lb = document.getElementById('certLightbox');
    const img = document.getElementById('certLightboxImage');
    const cap = document.getElementById('certLightboxCaption');
    const closeBtn = document.getElementById('certLightboxClose');

    function openLB(src, caption) {
      img.src = src || '';
      img.alt = caption || '';
      cap.textContent = caption || '';
      lb.classList.remove('hidden');
      lb.classList.add('flex');
      document.body.classList.add('overflow-hidden');
    }

    function closeLB() {
      lb.classList.add('hidden');
      lb.classList.remove('flex');
      img.src = '';
      img.alt = '';
      cap.textContent = '';
      document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('.cert-card').forEach((card) => {
      card.addEventListener('click', () => {
        openLB(card.dataset.image, card.dataset.caption || '');
      });
    });

    closeBtn.addEventListener('click', closeLB);

    lb.addEventListener('click', (e) => {
      if (e.target === lb) closeLB();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeLB();
    });
  })();
</script>