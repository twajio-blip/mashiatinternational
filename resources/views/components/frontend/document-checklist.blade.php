@props(['data' => []])

@php
    $data = $data ?? [];

    $sectionRecord = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item) && (int) ($item['group'] ?? -1) === 0) ?? [];

    $sectionHeader = collect($sectionRecord)
        ->first(fn ($block) => is_array($block) && isset($block['Section Title'])) ?? [];

    $cards = collect($data)
        ->filter(fn ($item, $key) => is_numeric($key) && is_array($item) && (int) ($item['group'] ?? 0) > 0)
        ->map(function ($item) {
            $titleBlock = collect($item)
                ->first(fn ($block) => is_array($block) && isset($block['Checklist Card Title'])) ?? [];

            $itemsBlock = collect($item)
                ->first(fn ($block) => is_array($block) && isset($block['instances']) && is_array($block['instances'])) ?? [];

            return [
                'title' => $titleBlock['Checklist Card Title'] ?? '',
                'items' => collect($itemsBlock['instances'] ?? [])
                    ->pluck('Items')
                    ->filter()
                    ->values(),
            ];
        })
        ->filter(fn ($card) => $card['title'] !== '' && $card['items']->isNotEmpty())
        ->values();

    $eyebrow = $sectionHeader['Section Label'] ?? $sectionHeader['Section Lable'] ?? 'Financial document checklist';
    $sectionTitle = $sectionHeader['Section Title'] ?? 'What a complete financial file usually contains';
    $sectionDescription = $sectionHeader['Section Description'] ?? 'Requirements differ by destination and institution. Use this as an orientation list - your consultation produces a checklist specific to your case.';
    $buttonText = $sectionHeader['Header Button Text'] ?? 'Request your tailored checklist';
    $buttonUrl = $sectionHeader['Header Button URL'] ?? '/contact';
@endphp

@if($cards->isNotEmpty())
    <section class="bg-background-3 py-16 sm:py-24">
        <div class="container">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
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

                <a
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-center text-[15px] font-medium text-dark transition-[background-color,color,border-color,box-shadow,transform] duration-200 ease-out hover:border-tag hover:text-tag focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tag"
                    href="{{ url($buttonUrl) }}"
                >
                    <i class="fa-solid fa-download text-sm"></i>
                    {{ $buttonText }}
                </a>
            </div>

            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach($cards as $card)
                    <div class="h-full rounded-xl border border-border-color bg-white p-6 shadow-card sm:p-7">
                        <h3 class="font-heading text-[18px] font-semibold text-dark">
                            {{ $card['title'] }}
                        </h3>

                        <div aria-hidden="true" class="mt-4 h-px w-10 bg-status"></div>

                        <ul class="mt-5 space-y-3.5">
                            @foreach($card['items'] as $item)
                                <li class="flex items-start gap-3 text-[15px] leading-relaxed text-dark">
                                    <span
                                        class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-light text-tag"
                                        aria-hidden="true"
                                    >
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                    </span>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
