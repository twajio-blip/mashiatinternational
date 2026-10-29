@php
    use Illuminate\Support\Str;

    $content = $data[0] ?? [];
    $hero = $content[0] ?? [];
    $buttons = $content[1] ?? [];
    $floatingCard1 = $content[2] ?? [];
    $floatingCard2 = $content[3] ?? [];
    $heroImage = $hero['Hero Image'] ?? '';
    $heroImageUrl = $heroImage ? (Str::startsWith($heroImage, ['http://', 'https://', '/']) ? $heroImage : asset('images/' . $heroImage)) : null;
@endphp

<section id="hero-section" class="w-full bg-white overflow-hidden">

    <div class="container relative">

        <div class="grid items-center gap-10 py-12 sm:gap-12 sm:py-16 xl:grid-cols-12 xl:gap-16 xl:py-24">

            {{-- LEFT CONTENT --}}
            <div class="max-w-3xl xl:col-span-6">

                <h1
                    class="text-header text-[34px] font-extrabold leading-[1.08] min-[380px]:text-[36px] sm:text-[42px]"
                >
                    {{ $hero['Hero Title'] ?? '' }}
                </h1>

                <p
                    class="mt-6 max-w-2xl text-[16px] leading-relaxed text-muted sm:text-[18px] xl:max-w-xl"
                >
                    {{ $hero['Hero Subtitle'] ?? '' }}
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    {{-- Primary Button --}}
                    <a
                        href="{{ $buttons['Primary Button URL'] ?? '#' }}"
                        class="inline-flex min-w-0 items-center justify-center gap-2 rounded-lg text-center font-medium duration-200 ease-out bg-btn-primary text-white hover:bg-btn-primary-hover shadow-card min-h-14 px-6 py-3 text-base sm:px-7 whitespace-nowrap"
                    >
                        {{ $buttons['Primary Button Text'] ?? '' }}

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>

                    {{-- Secondary Button --}}
                    <a
                        href="{{ $buttons['Secondary Button URL'] ?? '#' }}"
                        class="inline-flex min-w-0 items-center justify-center gap-2 rounded-lg text-center font-medium duration-200 ease-out border border-border-color hover:border-background-2 hover:text-tag bg-white min-h-14 px-6 py-3 text-base sm:px-7 whitespace-nowrap"
                    >
                        {{ $buttons['Secondary Button Text'] ?? '' }}
                    </a>

                </div>

            </div>


            {{-- RIGHT IMAGE --}}
            <div class="xl:col-span-6">

                <div class="relative">

                    <div class="overflow-hidden rounded-xl border border-border-color">

                        @if($heroImageUrl)
                            <img
                                src="{{ $heroImageUrl }}"
                                alt="{{ $hero['Hero Image Alt Text'] ?? '' }}"
                                class="h-full w-full object-cover"
                                width="1200"
                                height="900"
                            >
                        @endif

                    </div>


                    {{-- FLOATING INFORMATION CARD --}}
                    <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:absolute xl:-bottom-8 xl:-left-8 xl:mt-0 xl:grid-cols-1 xl:gap-0 w-fill xl:w-[60%]">

                        {{-- FLOATING CARD 1 --}}
                        <div class="rounded-xl border border-border-color bg-white p-5 shadow-card">

                            <p class="text-[15px] font-semibold">
                                {{ $floatingCard1['Floating Card 1 Title'] ?? '' }}
                            </p>

                            <p class="mt-2 text-[14px] leading-relaxed text-muted">
                                {{ $floatingCard1['Floating Card 1 Description'] ?? '' }}
                            </p>

                        </div>


                        {{-- MOBILE ONLY CARD --}}
                        <div class="rounded-xl border border-border-color bg-background p-5 text-white xl:hidden">

                            <p class="text-[15px] font-semibold">
                                {{ $floatingCard2['Floating Card 2 Title'] ?? '' }}
                            </p>

                            <p class="mt-2 text-[14px] leading-relaxed text-white/70">
                                {{ $floatingCard2['Floating Card 2 Description'] ?? '' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
