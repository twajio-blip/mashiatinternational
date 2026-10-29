@props(['data' => []])

@php
    $record = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['Section Title'])) ?? [];

    $contentBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['instances']) && collect($block['instances'])->contains(fn ($item) => isset($item['Paragraph']))) ?? [];

    $imageBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['Image'])) ?? [];

    $statsBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['instances']) && collect($block['instances'])->contains(fn ($item) => isset($item['Value']))) ?? [];

    $paragraphs = collect($contentBlock['instances'] ?? [])
        ->pluck('Paragraph')
        ->filter()
        ->values();

    $stats = collect($statsBlock['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Value']))
        ->values();

    $eyebrow = $section['Section Label'] ?? $section['Section Lable'] ?? 'Who we are';
    $title = $section['Section Title'] ?? 'Professional standards applied to personal circumstances';
    $image = $imageBlock['Image'] ?? null;
    $imageAlt = $imageBlock['Image Alt'] ?? $title;
@endphp

@if($paragraphs->isNotEmpty() || $stats->isNotEmpty() || $image)
    <section class="bg-white py-16 sm:py-24">
        <div class="container">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <div class="max-w-2xl">
                        <p class="mb-3 text-[13px] font-semibold text-tag">
                            {{ $eyebrow }}
                        </p>

                        <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                            {{ $title }}
                        </h2>
                    </div>

                    @if($paragraphs->isNotEmpty())
                        <div class="mt-6 space-y-5 text-[17px] leading-relaxed text-muted">
                            @foreach($paragraphs as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-5">
                    @if($image)
                        <div class="overflow-hidden rounded-xl border border-border-color">
                            <img
                                src="{{ asset('images/' . $image) }}"
                                alt="{{ $imageAlt }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    @endif

                    @if($stats->isNotEmpty())
                        <dl class="mt-6 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-border-color bg-border-color">
                            @foreach($stats as $stat)
                                <div class="bg-white p-5">
                                    <dt class="font-heading text-[24px] font-bold text-header">
                                        {{ $stat['Value'] }}
                                    </dt>

                                    <dd class="mt-1.5 text-[13px] leading-snug text-muted">
                                        {{ $stat['Description'] ?? '' }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
