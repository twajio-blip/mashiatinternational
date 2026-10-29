@props(['data' => []])

@php
    $statistics = $data['relatedBlocks']['who-we-are']['data'][0][3]['instances'] ?? [];

    $statistics = collect($statistics)
        ->filter(fn($stat) => is_array($stat))
        ->values();
@endphp

@if ($statistics->isNotEmpty())
    <section aria-label="Practice credentials" class="bg-background">
        <div class="container">
            <dl class="grid divide-y divide-white/10 min-[460px]:grid-cols-2 min-[460px]:divide-y-0 xl:grid-cols-4 xl:divide-x xl:divide-white/10">
                @foreach ($statistics as $stat)
                    <div class="px-0 py-7 min-[460px]:pr-6 xl:px-8 xl:first:pl-0 xl:last:pr-0">
                        <dt class="font-heading text-[30px] font-bold leading-none text-status sm:text-[34px]">
                            {{ $stat['Value'] ?? '' }}
                        </dt>

                        @if (!empty($stat['Description']))
                            <dd class="mt-3 max-w-[240px] text-[14px] leading-snug text-white/70">
                                {{ $stat['Description'] }}
                            </dd>
                        @endif
                    </div>
                @endforeach
            </dl>
        </div>
    </section>
@endif
