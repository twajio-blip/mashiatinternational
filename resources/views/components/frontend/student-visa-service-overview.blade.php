@props(['data' => []])

@php
    use Illuminate\Support\Str;

    $record = collect($data ?? [])
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $section = $record[0] ?? [];
    $paragraphs = collect($record[1]['instances'] ?? [])
        ->pluck('Paragraph')
        ->filter()
        ->values();

    $label = $section['Section Label'] ?? 'Service overview';
    $title = $section['Section Title'] ?? 'What this service actually covers';
    $image = $section['Image'] ?? '';
    $alt = $section['Alt Text'] ?? $title;
    $imageUrl = $image ? (Str::startsWith($image, ['http://', 'https://', '/']) ? $image : asset('images/' . $image)) : null;
@endphp

@if($paragraphs->isNotEmpty() || $imageUrl)
    <section class="bg-background-3 py-16 sm:py-24">
        <div class="container">
            <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="lg:col-span-7">
                    <div class="max-w-2xl">
                        <p class="mb-3 text-[13px] font-semibold text-tag">
                            {{ $label }}
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

                @if($imageUrl)
                    <div class="lg:col-span-5">
                        <div class="h-full min-h-[320px] overflow-hidden rounded-xl border border-border-color bg-background-3 sm:min-h-[420px] lg:min-h-0">
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $alt }}"
                                loading="lazy"
                                class="h-full w-full object-cover"
                            >
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
