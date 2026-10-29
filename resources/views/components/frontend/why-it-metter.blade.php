@props(['data' => []])

@php
    $record = collect($data ?? [])
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = $record[0] ?? [];
    $button = $record[1] ?? [];
    $cards = collect($record[2]['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Title']))
        ->values();

    $label = $section['Section Label'] ?? 'Why it matters';
    $title = $section['Section Title'] ?? 'Why proper financial documentation matters';
    $description = $section['Section Description'] ?? null;
    $buttonText = $button['Button Text'] ?? null;
    $buttonUrl = $button['Button URL'] ?? null;
@endphp

@if($cards->isNotEmpty())
    <section class="bg-header py-16 sm:py-24">
        <div class="container">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-5">
                    <div class="max-w-2xl">
                        <p class="mb-3 text-[13px] font-semibold text-status">
                            {{ $label }}
                        </p>

                        <h2 class="font-heading text-[29px] font-bold text-white sm:text-[38px] lg:text-[42px]">
                            {{ $title }}
                        </h2>

                        @if($description)
                            <p class="mt-4 text-[17px] leading-relaxed text-white/75">
                                {{ $description }}
                            </p>
                        @endif
                    </div>

                    @if($buttonText && $buttonUrl)
                        <a
                            class="mt-8 inline-flex min-h-14 items-center justify-center gap-2 rounded-lg bg-status px-6 py-3 text-base font-semibold text-header shadow-card transition-colors duration-200 ease-out hover:bg-[#B8944B] sm:px-7"
                            href="{{ $buttonUrl }}"
                        >
                            {{ $buttonText }}
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                    @endif
                </div>

                <ul class="lg:col-span-7">
                    @foreach($cards as $card)
                        <li class="flex gap-5 border-b border-white/10 py-7 first:pt-0 last:border-0 last:pb-0">
                            <i class="fa-regular fa-file-lines mt-1 shrink-0 text-[20px] text-status"></i>

                            <div>
                                <h3 class="font-heading text-[19px] font-semibold text-white">
                                    {{ $card['Title'] ?? '' }}
                                </h3>

                                @if(!empty($card['Description']))
                                    <p class="mt-2 text-[16px] leading-relaxed text-white/70">
                                        {{ $card['Description'] }}
                                    </p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endif
