@php
    $general = $general ?? null;
    $preloaderLogo = $general?->logo ?? $general?->fav_icon ?? $general?->footer ?? 'placeholder.png';
    $preloaderLogoUrl = asset('images/' . $preloaderLogo);
    $isHome = request()->is('/');
@endphp

@if (false && $isHome)
    <style>
        body.preloader-active {
            overflow: hidden;
        }
        #site-preloader {
            opacity: 1;
            transition: opacity 0.6s ease;
        }
        #site-preloader.fade-out {
            opacity: 0;
            pointer-events: none;
        }
        #left-door,
        #right-door {
            will-change: transform;
            backface-visibility: hidden;
            transition: transform 1.4s cubic-bezier(0.77, 0, 0.175, 1);
        }
        #left-door.open { transform: translateX(-100%) !important; }
        #right-door.open { transform: translateX(100%) !important; }
        #preloader-brand {
            opacity: 0;
            transform: scale(0.85);
            transition: opacity 0.8s ease 0.3s, transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s;
        }
        #preloader-brand.show {
            opacity: 1;
            transform: scale(1);
        }
        #preloader-brand img {
            animation: preloader-logo-pulse 2s ease-in-out infinite;
        }
        #preloader-brand.show img {
            animation: preloader-logo-pulse 2.5s ease-in-out infinite 0.5s;
        }
        @keyframes preloader-logo-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.92; transform: scale(1.02); }
        }
        #preloader-floor {
            transition: opacity 0.15s ease;
        }
    </style>

    <div id="site-preloader" class="fixed inset-0 z-[9999] overflow-hidden bg-[#0d0d0d]" aria-hidden="true">
        <div class="absolute inset-0 flex items-center justify-center px-4">
            <div class="relative w-full max-w-[420px] h-[78vh] min-h-[420px] max-h-[700px] overflow-hidden rounded-t-lg border-[10px] border-[#252525] bg-black shadow-2xl">

                {{-- Floor display --}}
                <div class="absolute top-4 left-1/2 z-30 flex -translate-x-1/2 items-center gap-3 rounded-lg bg-black/90 px-5 py-2.5 border border-brand-red/40 shadow-[0_0_20px_rgba(204,0,0,0.15)]">
                    <div class="flex items-center gap-1">
                        <span class="h-2 w-2 rounded-full bg-brand-red animate-pulse"></span>
                        <span class="h-2 w-2 rounded-full bg-brand-red/30"></span>
                    </div>
                    <span id="preloader-floor" class="font-bold tracking-[0.2em] text-brand-red text-xl tabular-nums">G</span>
                </div>

                {{-- Center content: logo + tagline --}}
                <div class="absolute inset-0 z-10 flex items-center justify-center bg-gradient-to-b from-neutral-900 via-black to-neutral-950">
                    <div id="preloader-brand" class="text-center px-6">
                        <img
                            src="{{ $preloaderLogoUrl }}"
                            alt="{{ $general?->website_name ?? 'RAR Lift' }}"
                            class="mx-auto mb-5 h-20 w-auto max-w-[180px] rounded-xl bg-white/5 p-4 object-contain object-center shadow-xl"
                            loading="eager"
                        >
                        <p class="text-xs font-medium uppercase tracking-[0.35em] text-white/70">
                            Elevating Excellence
                        </p>
                    </div>
                </div>

                <div class="absolute inset-y-0 left-1/2 z-20 w-px -translate-x-1/2 bg-white/10"></div>

                {{-- Left door --}}
                <div id="left-door" class="absolute inset-y-0 left-0 z-20 w-1/2 border-r border-black/30 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#4a4a4a] via-[#5a5a5a] to-[#484848]"></div>
                    <div class="absolute inset-y-0 right-3 w-px bg-white/10"></div>
                    <div class="absolute inset-x-0 top-0 h-[18%] bg-white/5"></div>
                </div>

                {{-- Right door --}}
                <div id="right-door" class="absolute inset-y-0 right-0 z-20 w-1/2 border-l border-black/30 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-l from-[#4a4a4a] via-[#5a5a5a] to-[#484848]"></div>
                    <div class="absolute inset-y-0 left-3 w-px bg-white/10"></div>
                    <div class="absolute inset-x-0 top-0 h-[18%] bg-white/5"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            if (!document.getElementById('site-preloader')) return;
            document.body.classList.add('preloader-active');

            var preloader = document.getElementById('site-preloader');
            var floorEl = document.getElementById('preloader-floor');
            var leftDoor = document.getElementById('left-door');
            var rightDoor = document.getElementById('right-door');
            var brand = document.getElementById('preloader-brand');

            var floor = 0;
            var floorTimer = setInterval(function() {
                if (floor < 10) {
                    floor++;
                    if (floorEl) floorEl.textContent = String(floor).padStart(2, '0');
                } else clearInterval(floorTimer);
            }, 160);

            setTimeout(function() {
                if (brand) brand.classList.add('show');
            }, 800);

            setTimeout(function() {
                if (leftDoor) leftDoor.classList.add('open');
                if (rightDoor) rightDoor.classList.add('open');
            }, 2200);

            setTimeout(function() {
                if (preloader) preloader.classList.add('fade-out');
                document.body.classList.remove('preloader-active');
            }, 3600);

            setTimeout(function() {
                if (preloader) preloader.remove();
            }, 4300);
        })();
    </script>
@endif
