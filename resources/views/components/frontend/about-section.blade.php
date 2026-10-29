@props(['data' => [], 'general' => null])

@php
    use Illuminate\Support\Str;

    $block = $data[0] ?? [];
    $section = $block[0] ?? [];
    $content = $block[1]['instances'] ?? [];
    $image = $block[2] ?? [];
    $information = $block[3]['instances'] ?? [];
    $button = $block[4] ?? [];

    $label = $section['Section Label'] ?? null;
    $title = $section['Section Title'] ?? null;
    $imageName = $image['Image'] ?? null;
    $imageAlt = $image['Alt Text'] ?? $title ?? 'About Mashiat International';
    $imageUrl = $imageName ? (Str::startsWith($imageName, ['http://', 'https://', '/']) ? $imageName : asset('images/' . $imageName)) : null;
    $buttonText = $button['Button Text'] ?? null;
    $buttonUrl = $button['Button URL'] ?? '#';
@endphp

<section class="bg-white py-16 sm:py-24">
    <div class="container">
        <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-6">
                <div class="overflow-hidden rounded-xl border border-border-color bg-background-3">
                    @if ($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" loading="lazy"
                            class="aspect-[4/3] h-full w-full object-cover">
                    @endif
                </div>
            </div>

            <div class="lg:col-span-6">
                @if ($label)
                    <p class="mb-3 text-[13px] font-semibold text-tag">{{ $label }}</p>
                @endif

                @if ($title)
                    <h2 class="font-display text-[30px] font-bold leading-[1.15] text-header sm:text-[38px]">
                        {{ $title }}
                    </h2>
                @endif

                @if (!empty($content))
                    <div class="mt-5 space-y-4 text-[17px] leading-relaxed text-muted">
                        @foreach ($content as $item)
                            @if (!empty($item['Paragraph']))
                                <p>{{ $item['Paragraph'] }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if (!empty($information))
                    <dl class="mt-8 divide-y divide-border-color border-y border-border-color">
                        @foreach ($information as $item)
                            @if (!empty($item['Title']) || !empty($item['Description']))
                                <div class="flex flex-col gap-1 py-4 sm:flex-row sm:gap-6">
                                    @if (!empty($item['Title']))
                                        <dt class="font-display text-[15px] font-semibold text-header sm:w-36 sm:shrink-0">
                                            {{ $item['Title'] }}
                                        </dt>
                                    @endif
                                    @if (!empty($item['Description']))
                                        <dd class="text-[15px] leading-relaxed text-muted">
                                            {{ $item['Description'] }}
                                        </dd>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </dl>
                @endif

                @if ($buttonText)
                    <a class="mt-8 inline-flex min-w-0 items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-center text-[15px] font-medium text-header transition-colors duration-200 ease-out hover:border-tag hover:text-tag"
                        href="{{ url($buttonUrl) }}">
                        {{ $buttonText }}
                        <i class="fa-solid fa-arrow-right text-[13px]"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
