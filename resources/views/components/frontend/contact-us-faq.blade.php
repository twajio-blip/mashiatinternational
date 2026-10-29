@props(['data' => []])

@php
    $record = collect($data ?? [])
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = $record[0] ?? [];
    $contactCard = $record[1] ?? [];
    $faqs = collect($record[2]['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Question']))
        ->values();

    $label = $section['Section Label'] ?? 'Before you enquire';
    $title = $section['Section Title'] ?? 'What to expect when you contact us';
    $cardTitle = $contactCard['Title:'] ?? $contactCard['Title'] ?? null;
    $cardDescription = $contactCard['Description'] ?? null;
    $buttonText = $contactCard['Button Text'] ?? null;
    $buttonUrl = $contactCard['Button URL'] ?? null;
@endphp

@if($faqs->isNotEmpty())
    <section class="bg-white py-16 sm:py-24">
        <div class="container">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-4">
                    <div class="max-w-2xl">
                        <p class="mb-3 text-[13px] font-semibold text-tag">
                            {{ $label }}
                        </p>

                        <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                            {{ $title }}
                        </h2>
                    </div>

                    @if($cardTitle || $cardDescription || ($buttonText && $buttonUrl))
                        <div class="mt-7 rounded-xl border border-border-color bg-background-3 p-6">
                            @if($cardTitle)
                                <p class="font-heading text-[16px] font-semibold text-header">
                                    {{ $cardTitle }}
                                </p>
                            @endif

                            @if($cardDescription)
                                <p class="mt-2 text-[15px] leading-relaxed text-muted">
                                    {{ $cardDescription }}
                                </p>
                            @endif

                            @if($buttonText && $buttonUrl)
                                <a
                                    class="mt-5 inline-flex min-h-10 items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-4 py-2 text-sm font-semibold text-tag transition-colors duration-200 ease-out hover:border-tag hover:text-header"
                                    href="{{ $buttonUrl }}"
                                >
                                    {{ $buttonText }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-8">
                    <div class="divide-y divide-border-color rounded-xl border border-border-color bg-white shadow-card">
                        @foreach($faqs as $index => $faq)
                            <details class="group">
                                <summary class="flex cursor-pointer list-none items-start justify-between gap-6 px-5 py-5 text-left transition-colors duration-200 ease-out hover:bg-background-3 sm:px-7">
                                    <span class="font-heading text-[17px] font-semibold leading-snug text-header">
                                        {{ $faq['Question'] ?? '' }}
                                    </span>

                                    <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-border-color text-tag transition-colors duration-200 ease-out group-open:border-tag group-open:bg-tag group-open:text-white" aria-hidden="true">
                                        <i class="fa-solid fa-plus text-xs transition-transform duration-200 group-open:rotate-45"></i>
                                    </span>
                                </summary>

                                @if(!empty($faq['Answer']))
                                    <div class="px-5 pb-6 pr-12 text-[16px] leading-relaxed text-muted sm:px-7">
                                        {{ $faq['Answer'] }}
                                    </div>
                                @endif
                            </details>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
