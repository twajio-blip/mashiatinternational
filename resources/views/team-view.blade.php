@php
    use Illuminate\Support\Str;

    $member = $memberDetails ?? [];
    $groupData = function ($key) use ($member) {
        $group = $member[$key] ?? [];

        if (isset($group['instances']) && is_array($group['instances'])) {
            return reset($group['instances']) ?: [];
        }

        return is_array($group) ? $group : [];
    };

    $section = $groupData(0);
    $qualifications = $member[1]['instances'] ?? [];
    $expertise = $member[2]['instances'] ?? [];
    $biography = $member[3]['instances'] ?? [];
    $experience = $member[4]['instances'] ?? [];
    $memberships = $member[5]['instances'] ?? [];
    $services = $member[6]['instances'] ?? [];

    $name = $section['Name'] ?? '';
    $position = $section['Position'] ?? '';
    $description = $section['Description'] ?? '';
    $image = $section['Image'] ?? '';
    $alt = $section['Alt Text'] ?? ($name ? 'Portrait of ' . $name : 'Team member portrait');
    $email = $section['Email'] ?? '';
    $phone = $section['Phone'] ?? '';
    $imageUrl = $image ? (Str::startsWith($image, ['http://', 'https://', '/']) ? $image : asset('images/' . $image)) : null;
@endphp

<x-Guest-layout :pageinfo="$page">
    <section class="border-b border-border-color bg-white pb-12 pt-8">
        <div class="container">
            <div class="grid gap-10 lg:grid-cols-12 lg:gap-14">
                <aside class="lg:col-span-4">
                    <div class="overflow-hidden rounded-xl border border-border-color bg-background-3">
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $alt }}" class="aspect-[4/5] w-full object-cover object-top">
                        @endif
                    </div>

                    <div class="mt-5 space-y-3">
                        <a class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-lg bg-btn-primary px-5 py-3 text-center text-[15px] font-semibold text-white shadow-card transition-colors duration-200 ease-out hover:bg-btn-primary-hover" href="{{ url('/contact') }}">
                            Book a consultation
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>

                        @if($email)
                            <a href="mailto:{{ $email }}" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-center text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:border-tag hover:text-header">
                                <i class="fa-regular fa-envelope text-sm"></i>
                                <span class="min-w-0 truncate">{{ $email }}</span>
                            </a>
                        @endif

                        @if($phone)
                            <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="inline-flex min-h-12 w-full items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-center text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:border-tag hover:text-header">
                                <i class="fa-solid fa-phone text-sm"></i>
                                <span>{{ $phone }}</span>
                            </a>
                        @endif
                    </div>
                </aside>

                <div class="lg:col-span-8">
                    <h1 class="font-heading text-[34px] font-bold leading-tight text-header sm:text-[42px]">
                        {{ $name }}
                    </h1>

                    @if($position)
                        <p class="mt-3 text-[18px] font-medium text-tag">
                            {{ $position }}
                        </p>
                    @endif

                    @if($description)
                        <p class="mt-5 max-w-2xl text-[17px] leading-relaxed text-muted">
                            {{ $description }}
                        </p>
                    @endif

                    <div class="mt-8 grid gap-6 sm:grid-cols-2">
                        @if(count($qualifications))
                            <section class="rounded-xl border border-border-color bg-background-3 p-6">
                                <h2 class="font-heading text-[16px] font-semibold text-header">Verified qualifications</h2>
                                <ul class="mt-4 space-y-2.5">
                                    @foreach($qualifications as $item)
                                        @if(!empty($item['Qualifications']))
                                            <li class="flex items-start gap-2.5 text-[15px] leading-snug text-dark">
                                                <i class="fa-solid fa-circle-check mt-0.5 shrink-0 text-status"></i>
                                                <span>{{ $item['Qualifications'] }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </section>
                        @endif

                        @if(count($expertise))
                            <section class="rounded-xl border border-border-color bg-background-3 p-6">
                                <h2 class="font-heading text-[16px] font-semibold text-header">Areas of expertise</h2>
                                <ul class="mt-4 flex flex-wrap gap-2">
                                    @foreach($expertise as $item)
                                        @if(!empty($item['Expertise']))
                                            <li class="rounded border border-border-color bg-white px-2.5 py-1.5 text-[13px] font-medium text-header">
                                                {{ $item['Expertise'] }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </section>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-background-3 py-16 sm:py-20">
        <div class="container">
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
                <article class="space-y-6 lg:col-span-8">
                    @if(count($biography))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[18px] font-semibold text-header sm:px-7">Biography</h2>
                            <div class="px-6 py-6 sm:px-7">
                                <div class="space-y-4 text-[16px] leading-relaxed text-muted">
                                    @foreach($biography as $item)
                                        @if(!empty($item['Biography']))
                                            <p>{{ $item['Biography'] }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif

                    @if(count($experience))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[18px] font-semibold text-header sm:px-7">Professional experience</h2>
                            <div class="px-6 py-6 sm:px-7">
                                <ol class="divide-y divide-border-color">
                                    @foreach($experience as $item)
                                        <li class="flex flex-col gap-1 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-baseline sm:justify-between sm:gap-8">
                                            <div>
                                                <p class="font-heading text-[16px] font-semibold text-header">{{ $item['Position'] ?? '' }}</p>
                                                @if(!empty($item['Company']))
                                                    <p class="mt-0.5 text-[15px] text-muted">{{ $item['Company'] }}</p>
                                                @endif
                                            </div>
                                            @if(!empty($item['Duration']))
                                                <p class="text-[14px] font-medium text-tag sm:shrink-0">{{ $item['Duration'] }}</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </section>
                    @endif

                    @if(count($memberships))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[18px] font-semibold text-header sm:px-7">Professional memberships</h2>
                            <div class="px-6 py-6 sm:px-7">
                                <ul class="space-y-3">
                                    @foreach($memberships as $item)
                                        @if(!empty($item['Name']))
                                            <li class="flex items-start gap-3 text-[16px] leading-relaxed text-dark">
                                                <i class="fa-solid fa-circle-check mt-0.5 shrink-0 text-status"></i>
                                                <span>{{ $item['Name'] }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endif
                </article>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-32">
                        @if(count($services))
                            <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                                <h2 class="border-b border-border-color px-6 py-5 font-heading text-[18px] font-semibold text-header sm:px-7">Associated services</h2>
                                <div class="px-6 py-6 sm:px-7">
                                    <ul class="space-y-1">
                                        @foreach($services as $item)
                                            @php
                                                $serviceName = $item['Service Name'] ?? $item['Name'] ?? '';
                                                $serviceUrl = $item['URL'] ?? null;
                                            @endphp
                                            @if($serviceName)
                                                <li>
                                                    <a class="flex min-h-[44px] items-center gap-2 rounded-lg px-3 text-[15px] leading-snug text-header transition-colors duration-200 ease-out hover:bg-background-3 hover:text-tag" href="{{ $serviceUrl ?: route('service-view', Str::slug($serviceName)) }}">
                                                        <span aria-hidden="true" class="h-1 w-1 shrink-0 rounded-full bg-status"></span>
                                                        <span>{{ $serviceName }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </section>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if(($otherConsultants ?? collect())->isNotEmpty())
        <section class="bg-white py-12 sm:py-16">
            <div class="container">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="mb-2 text-[13px] font-semibold text-tag">Other consultants</p>
                        <h2 class="font-heading text-[26px] font-bold text-header sm:text-[32px]">
                            Meet more of the team
                        </h2>
                    </div>

                    <a class="inline-flex min-h-11 items-center gap-2 text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-header" href="{{ url('/our-team') }}">
                        View full team
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($otherConsultants as $consultant)
                        @php
                            $consultantImage = $consultant['image'] ?? '';
                            $consultantImageUrl = $consultantImage ? (Str::startsWith($consultantImage, ['http://', 'https://', '/']) ? $consultantImage : asset('images/' . $consultantImage)) : null;
                        @endphp
                        <article class="group flex h-full overflow-hidden rounded-xl border border-border-color bg-white shadow-card transition-[box-shadow,transform,border-color] duration-200 ease-out hover:-translate-y-0.5 hover:border-tag hover:shadow-card-hover">
                            @if($consultantImageUrl)
                                <img src="{{ $consultantImageUrl }}" alt="{{ $consultant['alt'] ?? '' }}" loading="lazy" class="h-auto w-28 shrink-0 object-cover object-top sm:w-32">
                            @endif

                            <div class="flex min-w-0 flex-1 flex-col p-5">
                                <h3 class="font-heading text-[17px] font-semibold text-header">
                                    {{ $consultant['name'] }}
                                </h3>

                                @if(!empty($consultant['position']))
                                    <p class="mt-1 text-[13px] leading-snug text-muted">
                                        {{ $consultant['position'] }}
                                    </p>
                                @endif

                                <a class="mt-auto inline-flex items-center gap-2 pt-4 text-[14px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-header" href="{{ route('team-view', $consultant['slug'] ?: $consultant['id']) }}">
                                    View profile
                                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 ease-out group-hover:translate-x-0.5"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-Guest-layout>
