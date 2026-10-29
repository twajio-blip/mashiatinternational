@php
    use Illuminate\Support\Str;

    $service = $serviceDetails ?? [];
    $groupData = function ($key) use ($service) {
        $group = $service[$key] ?? [];

        if (isset($group['instances']) && is_array($group['instances'])) {
            return reset($group['instances']) ?: [];
        }

        return is_array($group) ? $group : [];
    };

    $header = $groupData(0);
    $overview = $groupData(1);
    $assistanceTitle = $groupData(2)['Service Assistance Section Title'] ?? 'What we assist with';
    $assistanceItems = $service[3]['instances'] ?? [];
    $requiredTitle = $groupData(4)['Required Information & Documents Section Title'] ?? 'Information and documents required';
    $requiredDocs = $service[5]['instances'] ?? [];
    $note = $groupData(6)['Additional Note'] ?? '';
    $processTitle = $groupData(7)['Engagement Process Section Title'] ?? 'How the engagement runs';
    $steps = $service[8]['instances'] ?? [];
    $faqTitle = $groupData(9)['Frequently Asked Questions Section Title'] ?? 'Frequently asked questions';
    $faqs = $service[10]['instances'] ?? [];
    $associatedMembers = $associatedMembers ?? collect();
@endphp

<x-Guest-layout :pageinfo="$page">
    <section class="border-b border-border-color bg-white pb-10 pt-8 sm:pb-12">
        <div class="container">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-lg border border-border-color bg-background-3 text-tag" aria-hidden="true">
                            {!! $header['Service Header Icon'] ?? '' !!}
                        </span>
                        <a class="text-[13px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-header" href="{{ url('/services') }}">
                            {{ $header['Catagory Title'] ?? $header['Catagory Name'] ?? $header['Service Category Name'] ?? $header['Catagory'] ?? '' }}
                        </a>
                    </div>

                    <h1 class="mt-5 font-heading text-[32px] font-bold leading-[1.12] text-header sm:text-[42px]">
                        {{ $header['Service Title'] ?? '' }}
                    </h1>

                    <p class="mt-4 text-[17px] leading-relaxed text-muted sm:text-[18px]">
                        {{ $header['Service Description'] ?? '' }}
                    </p>
                </div>

                <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                    <a class="inline-flex min-h-12 items-center justify-center gap-2 rounded-lg bg-btn-primary px-5 py-3 text-[15px] font-semibold text-white shadow-card transition-colors duration-200 ease-out hover:bg-btn-primary-hover" href="{{ url('/contact') }}">
                        Book Consultation
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </a>
                    <a class="inline-flex min-h-12 items-center justify-center gap-2 rounded-lg border border-border-color bg-white px-5 py-3 text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:border-tag hover:text-header" href="tel:+8801711000111">
                        <i class="fa-solid fa-phone text-sm"></i>
                        Call us
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-background-3 py-10 sm:py-14">
        <div class="container">
            <div class="grid gap-8 lg:grid-cols-12 lg:gap-12">
                <aside class="lg:col-span-4 xl:col-span-3">
                    <details class="group rounded-xl border border-border-color bg-white shadow-card lg:hidden">
                        <summary class="flex min-h-[56px] cursor-pointer list-none items-center justify-between px-5 text-[15px] font-semibold text-header">
                            Browse all services
                            <i class="fa-solid fa-chevron-down text-xs text-tag transition-transform duration-200 ease-out group-open:rotate-180"></i>
                        </summary>
                        <nav class="border-t border-border-color px-4 py-5" aria-label="Services">
                            <div class="space-y-6">
                            @foreach ($allService->groupBy('category') as $category => $items)
                                <div>
                                    <p class="mb-2 text-[12px] font-semibold uppercase tracking-wide {{ $items->contains('id', $service['group'] ?? null) ? 'text-tag' : 'text-muted' }}">{{ $category }}</p>
                                    <ul class="space-y-0.5">
                                        @foreach ($items as $item)
                                            <li>
                                                <a class="flex min-h-[44px] items-center rounded-lg px-3 text-[14px] leading-snug transition-colors duration-200 ease-out {{ (int) $item['id'] === (int) ($service['group'] ?? 0) ? 'bg-background-3 font-semibold text-tag' : 'text-header hover:bg-background-3 hover:text-tag' }}"
                                                href="{{ route('service-view', $item['slug'] ?? $item['id']) }}">
                                                    {{ $item['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                            </div>
                        </nav>
                    </details>

                    <nav aria-label="Services" class="hidden lg:sticky lg:top-32 lg:block lg:max-h-[calc(100vh-10rem)] lg:overflow-y-auto lg:rounded-xl lg:border lg:border-border-color lg:bg-white lg:p-6 lg:shadow-card">
                        <p class="mb-5 font-heading text-[15px] font-bold text-header">Services directory</p>
                        <div class="space-y-6">
                            @foreach ($allService->groupBy('category') as $category => $items)
                                <div>
                                    <p class="mb-2 text-[12px] font-semibold uppercase tracking-wide {{ $items->contains('id', $service['group'] ?? null) ? 'text-tag' : 'text-muted' }}">{{ $category }}</p>
                                    <ul class="space-y-0.5">
                                        @foreach ($items as $item)
                                            <li>
                                                <a class="flex min-h-[44px] items-center rounded-lg px-3 text-[14px] leading-snug transition-colors duration-200 ease-out {{ (int) $item['id'] === (int) ($service['group'] ?? 0) ? 'bg-background-3 font-semibold text-tag' : 'text-header hover:bg-background-3 hover:text-tag' }}"
                                                href="{{ route('service-view', $item['slug'] ?? $item['id']) }}">
                                                    {{ $item['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        <a class="mt-6 inline-flex items-center gap-2 border-t border-border-color pt-5 text-[14px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-header" href="{{ url('/service') }}">
                            View full directory
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </nav>
                </aside>

            <div class="lg:col-span-8 xl:col-span-9">
                <article class="space-y-6">
                    <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                        <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">{{ $overview['Service Overview Section Title'] ?? 'Service overview' }}</h2>
                        <div class="px-6 py-6 sm:px-8 sm:py-7">
                            <p class="text-[17px] leading-relaxed text-muted">{{ $overview['Description'] ?? '' }}</p>
                        </div>
                    </section>

                    @if(count($assistanceItems))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">{{ $assistanceTitle }}</h2>
                            <div class="px-6 py-6 sm:px-8 sm:py-7">
                                <ul class="grid gap-x-8 gap-y-3.5 sm:grid-cols-2">
                                    @foreach ($assistanceItems as $item)
                                        <li class="flex items-start gap-3 text-[15px] leading-relaxed text-dark">
                                            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-background-3 text-tag" aria-hidden="true">
                                                <i class="fa-solid fa-check text-[11px]"></i>
                                            </span>
                                            <span>{{ $item['Assistance Item'] ?? '' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endif

                    @if(count($requiredDocs))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">{{ $requiredTitle }}</h2>
                            <div class="px-6 py-6 sm:px-8 sm:py-7">
                                <ul class="grid gap-x-8 gap-y-3.5 sm:grid-cols-2">
                                    @foreach ($requiredDocs as $item)
                                        <li class="flex items-start gap-3 text-[15px] leading-relaxed text-dark">
                                            <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-tag"></span>
                                            <span>{{ $item['Required Document'] ?? '' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($note)
                                    <p class="mt-6 rounded-lg bg-background-3 p-4 text-[14px] leading-relaxed text-muted">{{ $note }}</p>
                                @endif
                            </div>
                        </section>
                    @endif

                    @if(count($steps))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">{{ $processTitle }}</h2>
                            <div class="px-6 py-6 sm:px-8 sm:py-7">
                                <ol class="space-y-5 border-l border-border-color pl-7">
                                    @foreach ($steps as $index => $step)
                                        <li class="relative">
                                            <span class="absolute -left-[41px] flex h-6 w-6 items-center justify-center rounded-full border border-border-color bg-white text-[11px] font-bold text-tag">{{ $index }}</span>
                                            <h3 class="font-heading text-[17px] font-semibold text-header">{{ $step['Step Title'] ?? '' }}</h3>
                                            <p class="mt-1.5 text-[15px] leading-relaxed text-muted">{{ $step['Step Description'] ?? '' }}</p>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </section>
                    @endif

                    @if(count($faqs))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">{{ $faqTitle }}</h2>
                            <div class="divide-y divide-border-color">
                                @foreach ($faqs as $faq)
                                    <details class="group">
                                        <summary class="flex cursor-pointer list-none items-start justify-between gap-6 px-6 py-5 text-left transition-colors duration-200 ease-out hover:bg-background-3 sm:px-8">
                                            <span class="font-heading text-[17px] font-semibold leading-snug text-header">{{ $faq['Question'] ?? '' }}</span>
                                            <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-border-color text-tag transition-colors duration-200 ease-out group-open:border-tag group-open:bg-tag group-open:text-white" aria-hidden="true">
                                                <i class="fa-solid fa-plus text-xs transition-transform duration-200 group-open:rotate-45"></i>
                                            </span>
                                        </summary>
                                        <p class="px-6 pb-6 text-[15px] leading-relaxed text-muted sm:px-8">{{ $faq['Answer'] ?? '' }}</p>
                                    </details>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if($associatedMembers->isNotEmpty())
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">Consultants for this service</h2>
                            <div class="px-6 py-6 sm:px-8 sm:py-7">
                                <ul class="grid gap-4 sm:grid-cols-2">
                                    @foreach ($associatedMembers as $member)
                                        @php
                                            $memberImage = $member['image'] ?? '';
                                            $memberImageUrl = $memberImage ? (Str::startsWith($memberImage, ['http://', 'https://', '/']) ? $memberImage : asset('images/' . $memberImage)) : null;
                                        @endphp
                                        <li>
                                            <a href="{{ route('team-view', $member['slug'] ?: $member['id']) }}" class="group flex h-full items-center gap-4 rounded-lg border border-border-color p-4 transition-colors duration-200 ease-out hover:border-tag hover:bg-background-3">
                                                @if($memberImageUrl)
                                                    <img src="{{ $memberImageUrl }}" alt="{{ $member['alt'] ?? '' }}" loading="lazy" class="h-14 w-14 rounded-lg object-cover object-top">
                                                @endif
                                                <span class="min-w-0">
                                                    <span class="block font-heading text-[15px] font-semibold text-header">{{ $member['name'] ?? '' }}</span>
                                                    <span class="mt-0.5 block text-[13px] leading-snug text-muted">{{ $member['position'] ?? '' }}</span>
                                                </span>
                                                <i class="fa-solid fa-arrow-right ml-auto shrink-0 text-xs text-tag transition-transform duration-200 ease-out group-hover:translate-x-0.5"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @elseif(!empty($service[12]['instances'] ?? []))
                        <section class="overflow-hidden rounded-xl border border-border-color bg-white shadow-card">
                            <h2 class="border-b border-border-color px-6 py-5 font-heading text-[19px] font-semibold text-header sm:px-8">Consultants for this service</h2>
                            <div class="px-6 py-6 sm:px-8 sm:py-7">
                                <ul class="grid gap-4 sm:grid-cols-2">
                                    @foreach (($service[12]['instances'] ?? []) as $consultant)
                                        <li class="flex items-center gap-4 rounded-lg border border-border-color p-4 transition-colors duration-200 ease-out hover:border-tag hover:bg-background-3">
                                            @if(!empty($consultant['Image']))
                                                <img src="{{ asset('images/' . $consultant['Image']) }}" alt="" loading="lazy" class="h-14 w-14 rounded-lg object-cover object-top">
                                            @endif
                                            <span>
                                                <span class="block font-heading text-[15px] font-semibold text-header">{{ $consultant['Name'] ?? '' }}</span>
                                                <span class="mt-0.5 block text-[13px] leading-snug text-muted">{{ $consultant['Designation'] ?? '' }}</span>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endif

                    <section class="rounded-xl border border-border-color bg-header p-7 shadow-card sm:p-9">
                        <h2 class="font-heading text-[24px] font-bold leading-snug text-white sm:text-[28px]">
                            Discuss {{ Str::lower($header['Service Title'] ?? 'this service') }} with a consultant
                        </h2>
                        <p class="mt-3 max-w-xl text-[16px] leading-relaxed text-white/75">
                            Tell us what you already have and what you need. We will confirm the scope, timeline and documents required before any work begins.
                        </p>
                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            <a class="inline-flex min-h-14 items-center justify-center gap-2 rounded-lg bg-status px-6 py-3 text-base font-semibold text-header shadow-card transition-colors duration-200 ease-out hover:bg-[#B8944B] sm:px-7" href="{{ url('/contact') }}">
                                Book Consultation
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                            <a class="inline-flex min-h-14 items-center justify-center rounded-lg border border-white/25 bg-white/5 px-6 py-3 text-base font-semibold text-white transition-colors duration-200 ease-out hover:bg-white/15 sm:px-7" href="https://wa.me/8801711000111" target="_blank" rel="noreferrer">
                                Message on WhatsApp
                            </a>
                        </div>
                    </section>
                </article>
            </div>
            </div>
        </div>
    </section>
</x-Guest-layout>
