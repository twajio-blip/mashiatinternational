@props(['data' => []])

@php
    $record = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['Section Title'])) ?? [];

    $historyBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['instances']) && is_array($block['instances'])) ?? [];

    $historyItems = collect($historyBlock['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Year']))
        ->values();

    $eyebrow = $section['Section Label'] ?? $section['Section Lable'] ?? 'Our history';
    $title = $section['Section Title'] ?? 'How the practice grew';
@endphp

@if($historyItems->isNotEmpty())
    <section class="bg-white py-16 sm:py-24">
        <div class="container">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-4">
                    <div class="max-w-2xl">
                        <p class="mb-3 text-[13px] font-semibold text-tag">
                            {{ $eyebrow }}
                        </p>

                        <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                            {{ $title }}
                        </h2>
                    </div>
                </div>

                <ol class="lg:col-span-8">
                    @foreach($historyItems as $item)
                        <li class="flex flex-col gap-2 border-b border-border-color py-6 first:pt-0 last:border-0 last:pb-0 sm:flex-row sm:gap-10">
                            <span class="font-heading text-[17px] font-bold text-tag sm:w-20 sm:shrink-0">
                                {{ $item['Year'] }}
                            </span>

                            <p class="text-[16px] leading-relaxed text-muted">
                                {{ $item['Description'] ?? '' }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>
@endif
