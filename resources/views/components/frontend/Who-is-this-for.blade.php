@props(['data' => []])

@php
    $record = collect($data ?? [])
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = $record[0] ?? [];
    $cards = collect($record[1]['instances'] ?? [])
        ->filter(fn ($item) => is_array($item) && !empty($item['Title']))
        ->values();

    $label = $section['Section Label'] ?? 'Who this is for';
    $title = $section['Section Title'] ?? 'Students, sponsors and families at any stage';
    $description = $section['Section Description'] ?? null;
@endphp

@if($cards->isNotEmpty())
    <section class="bg-white py-16 sm:py-24">
        <div class="container">
            <div class="max-w-2xl">
                <p class="mb-3 text-[13px] font-semibold text-tag">
                    {{ $label }}
                </p>

                <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                    {{ $title }}
                </h2>

                @if($description)
                    <p class="mt-4 text-[17px] leading-relaxed text-muted">
                        {{ $description }}
                    </p>
                @endif
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2">
                @foreach($cards as $card)
                    <article class="flex h-full gap-5 rounded-xl border border-border-color bg-white p-6 shadow-card transition-[box-shadow,transform,border-color] duration-200 ease-out hover:-translate-y-0.5 hover:border-tag hover:shadow-card-hover sm:p-7">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-border-color bg-background-3 text-tag" aria-hidden="true">
                            {!! $card['Icon'] ?? '<i class="fa-solid fa-circle-check"></i>' !!}
                        </span>

                        <div>
                            <h3 class="font-heading text-[18px] font-semibold text-header">
                                {{ $card['Title'] ?? '' }}
                            </h3>

                            @if(!empty($card['Description']))
                                <p class="mt-2 text-[15px] leading-relaxed text-muted">
                                    {{ $card['Description'] }}
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
