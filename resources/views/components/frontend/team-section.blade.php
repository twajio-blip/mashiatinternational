@props(['data' => []])

@php
    use Illuminate\Support\Str;

    $data = $data ?? [];

    $header = $data[0][0] ?? [];

    $membersData = $data['relatedBlocks']['members-details']['data']
        ?? $data['relatedBlocks']['member-details']['data']
        ?? $data;

    $members = collect($membersData)
        ->filter(fn ($item, $key) => is_numeric($key) && is_array($item))
        ->map(function ($item) {
            $section = $item[0] ?? [];

            $qualifications = collect($item[1]['instances'] ?? [])
                ->pluck('Qualifications')
                ->filter()
                ->values();

            return [
                'name' => $section['Name'] ?? '',
                'position' => $section['Position'] ?? '',
                'image' => $section['Image'] ?? '',
                'alt' => $section['Alt Text'] ?? ($section['Name'] ?? 'Team member'),
                'qualifications' => $qualifications,
                'slug' => Str::slug($section['Name'] ?? ''),
            ];
        })
        ->filter(fn ($member) => $member['name'] !== '')
        ->values();
@endphp

@if($members->isNotEmpty())
    <section class="bg-background-3 py-16 sm:py-24">
        <div class="container">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="mb-3 text-[13px] font-semibold text-tag">
                        {{ $header['Section lable'] ?? '' }}
                    </p>

                    <h2 class="font-heading text-[29px] font-bold text-header sm:text-[38px] lg:text-[42px]">
                        {{ $header['Section title'] ?? '' }}
                    </h2>

                    <p class="mt-4 text-[17px] leading-relaxed text-muted">
                        {{ $header['section description'] ?? '' }}
                    </p>
                </div>

                <a
                    class="inline-flex min-h-12 shrink-0 items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:border-tag hover:text-header"
                    href="{{ $header['Button url'] ?? '#' }}"
                >
                    {{ $header['Button text'] ?? '' }}
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @foreach($members->take(3) as $member)
                    <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-border-color bg-white shadow-card transition-[box-shadow,transform,border-color] duration-200 ease-out hover:-translate-y-0.5 hover:border-tag hover:shadow-card-hover">
                        <div class="aspect-[4/3] w-full overflow-hidden bg-background-3">
                            @if($member['image'])
                                <img
                                    src="{{ Str::startsWith($member['image'], ['http://', 'https://', '/']) ? $member['image'] : asset('images/' . $member['image']) }}"
                                    alt="{{ $member['alt'] }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover object-top transition-transform duration-300 ease-out group-hover:scale-[1.03]"
                                >
                            @endif
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <h3 class="font-heading text-[19px] font-semibold text-header">
                                {{ $member['name'] }}
                            </h3>

                            @if($member['position'])
                                <p class="mt-1 text-[14px] font-medium leading-snug text-tag">
                                    {{ $member['position'] }}
                                </p>
                            @endif

                            @if($member['qualifications']->isNotEmpty())
                                <ul class="mt-4 space-y-1.5">
                                    @foreach($member['qualifications'] as $qualification)
                                        <li class="flex items-start gap-2 text-[14px] text-muted">
                                            <i class="fa-solid fa-circle-check mt-0.5 shrink-0 text-status"></i>
                                            <span>{{ $qualification }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <a
                                class="mt-auto inline-flex min-h-[44px] items-center gap-2 pt-6 text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-header"
                                href="{{ $member['slug'] ? route('team-view', $member['slug']) : url('/team') }}"
                            >
                                View profile
                                <i class="fa-solid fa-arrow-right text-sm transition-transform duration-200 ease-out group-hover:translate-x-0.5"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
