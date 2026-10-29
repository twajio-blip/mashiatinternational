@props(['data' => []])

@php
    $record = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['Section Title'])) ?? [];

    $commitmentBlock = collect($record)
        ->first(fn ($block) => is_array($block) && isset($block['instances']) && is_array($block['instances'])) ?? [];

    $commitments = collect($commitmentBlock['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Title']))
        ->values();

    $eyebrow = $section['Section Label'] ?? $section['Section Lable'] ?? 'How we practise';
    $title = $section['Section Title'] ?? 'Four commitments that shape every engagement';
@endphp

@if($commitments->isNotEmpty())
    <section class="bg-background-3 py-16 sm:py-24">
        <div class="container">
            <div class="max-w-2xl">
                <p class="mb-3 text-[13px] font-semibold text-tag">
                    {{ $eyebrow }}
                </p>

                <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                    {{ $title }}
                </h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2">
                @foreach($commitments as $commitment)
                    <div class="h-full rounded-xl border border-border-color bg-white p-7">
                        <span aria-hidden="true" class="mb-5 block h-0.5 w-8 bg-status"></span>

                        <h3 class="font-heading text-[19px] font-semibold text-dark">
                            {{ $commitment['Title'] }}
                        </h3>

                        <p class="mt-3 text-[15px] leading-relaxed text-muted">
                            {{ $commitment['Description'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
