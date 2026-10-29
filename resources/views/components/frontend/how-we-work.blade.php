@props(['data' => []])

@php
    $record = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $header = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['Section Title'])) ?? [];

    $stepsBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['instances']) && is_array($block['instances'])) ?? [];

    $steps = collect($stepsBlock['instances'] ?? [])
        ->filter(fn ($step) => is_array($step) && !empty($step['Step Title']))
        ->values();

    $eyebrow = $header['Section Lable'] ?? $header['Section Label'] ?? 'How we work';
    $sectionTitle = $header['Section Title'] ?? 'A six-step path from first conversation to an application-ready file';
    $sectionDescription = $header['Section Description'] ?? 'Each step has a defined output, so you always know what has been completed and what remains.';
@endphp

@if($steps->isNotEmpty())
    <section class="bg-white py-16 sm:py-24">
        <div class="container">
            <div class="max-w-2xl lg:max-w-[70%]">
                <p class="mb-3 text-[13px] font-semibold text-tag">
                    {{ $eyebrow }}
                </p>

                <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                    {{ $sectionTitle }}
                </h2>

                <p class="mt-4 text-[17px] leading-relaxed text-muted">
                    {{ $sectionDescription }}
                </p>
            </div>

            <div class="relative mt-12">
                <div
                    aria-hidden="true"
                    class="absolute bottom-2 left-[15px] top-2 w-px bg-border-color xl:hidden"
                ></div>

                <div
                    aria-hidden="true"
                    class="absolute left-[15px] top-2 w-px origin-top bg-tag xl:hidden"
                    style="bottom: 0.5rem; transform: none;"
                ></div>

                <ol class="grid gap-8 xl:grid-cols-3 xl:gap-x-10 xl:gap-y-12">
                    @foreach($steps as $step)
                        <li class="relative pl-12 xl:pl-0">
                            <div class="xl:relative">
                                <div
                                    aria-hidden="true"
                                    class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-full border border-border-color bg-white font-heading text-[13px] font-bold text-tag xl:static xl:mb-5 xl:h-11 xl:w-11 xl:text-[15px]"
                                >
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div
                                    aria-hidden="true"
                                    class="mb-5 hidden h-px w-full bg-border-color xl:block"
                                ></div>

                                <h3 class="font-heading text-[19px] font-semibold text-dark">
                                    {{ $step['Step Title'] }}
                                </h3>

                                <p class="mt-2.5 text-[15px] leading-relaxed text-muted">
                                    {{ $step['Step Description'] ?? '' }}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>
@endif
