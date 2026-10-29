@props(['data' => []])

@php
    $component = $data[0] ?? [];

    $header = $component[0] ?? [];
    $address = $component[1] ?? [];
    $phone = $component[2] ?? [];
    $whatsapp = $component[3] ?? [];
    $email = $component[4] ?? [];
    $hours = $component[5] ?? [];
    $map = $component[6] ?? [];

    $general = $general ?? \Illuminate\Support\Facades\Cache::rememberForever('general_settings', fn () => \App\Models\General::first());

    $generalAddress = $general?->location ?? ($address['Address'] ?? '');
    $generalPhone = $general?->contact ?? ($phone['Phone Number'] ?? '');
    $generalWhatsapp = $general?->whatsapp_number ?? ($whatsapp['WhatsApp Number'] ?? $generalPhone);
    $generalEmail = $general?->email ?? ($email['Email Address'] ?? '');
    $generalHours = $general?->office_hours ?? ($hours['Hours'] ?? '');
@endphp

<section class="bg-background-3 py-16 sm:py-24">
    <div class="container">

        <div class="max-w-2xl">
            <p class="mb-3 text-[13px] font-semibold text-brand-blue">
                {{ $header['Section Label'] ?? '' }}
            </p>

            <h2 class="font-display font-bold text-[29px] sm:text-[38px] lg:text-[42px] text-navy-deep">
                {{ $header['Section Title'] ?? '' }}
            </h2>

            <p class="mt-4 text-[17px] leading-relaxed text-muted">
                {{ $header['Section Description'] ?? '' }}
            </p>
        </div>

        <div class="mt-12 grid gap-8 lg:grid-cols-12">

            <div class="lg:col-span-5">
                <ul class="space-y-4">

                    {{-- Office Address --}}
                    <li class="flex gap-4 rounded-xl border border-border-color bg-white p-5">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-canvas text-brand-blue"
                            aria-hidden="true">
                            {!! $address['Icon'] ?? '' !!}
                        </span>

                        <div>
                            <p class="text-[13px] font-semibold uppercase tracking-wide text-muted">
                                {{ $address['Contact Label'] ?? '' }}
                            </p>

                            <div class="mt-1.5 text-[15px] leading-relaxed text-ink">
                                {!! nl2br(e($generalAddress)) !!}
                            </div>
                        </div>
                    </li>

                    {{-- Phone --}}
                    <li class="flex gap-4 rounded-xl border border-border-color bg-white p-5">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-canvas text-brand-blue"
                            aria-hidden="true">
                            {!! $phone['Icon'] ?? '' !!}
                        </span>

                        <div>
                            <p class="text-[13px] font-semibold uppercase tracking-wide text-muted">
                                {{ $phone['Contact Label'] ?? '' }}
                            </p>

                            <div class="mt-1.5 text-[15px] leading-relaxed text-ink">
                                <a
                                    href="tel:{{ preg_replace('/[^0-9+]/', '', $generalPhone) }}"
                                    class="font-medium text-brand-blue transition-colors duration-200 ease-out hover:text-navy">
                                    {{ $generalPhone }}
                                </a>
                            </div>
                        </div>
                    </li>

                    {{-- WhatsApp --}}
                    <li class="flex gap-4 rounded-xl border border-border-color bg-white p-5">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-canvas text-brand-blue"
                            aria-hidden="true">
                            {!! $whatsapp['Icon'] ?? '' !!}
                        </span>

                        <div>
                            <p class="text-[13px] font-semibold uppercase tracking-wide text-muted">
                                {{ $whatsapp['Contact Label'] ?? '' }}
                            </p>

                            <div class="mt-1.5 text-[15px] leading-relaxed text-ink">
                                <a
                                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $generalWhatsapp) }}"
                                    target="_blank"
                                    rel="noreferrer"
                                    class="font-medium text-brand-blue transition-colors duration-200 ease-out hover:text-navy">
                                    {{ $generalWhatsapp }}
                                </a>
                            </div>
                        </div>
                    </li>

                    {{-- Email --}}
                    <li class="flex gap-4 rounded-xl border border-border-color bg-white p-5">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-canvas text-brand-blue"
                            aria-hidden="true">
                            {!! $email['Icon'] ?? '' !!}
                        </span>

                        <div>
                            <p class="text-[13px] font-semibold uppercase tracking-wide text-muted">
                                {{ $email['Contact Label'] ?? '' }}
                            </p>

                            <div class="mt-1.5 text-[15px] leading-relaxed text-ink">
                                <a
                                    href="mailto:{{ $generalEmail }}"
                                    class="font-medium text-brand-blue transition-colors duration-200 ease-out hover:text-navy">
                                    {{ $generalEmail }}
                                </a>
                            </div>
                        </div>
                    </li>

                    {{-- Office Hours --}}
                    <li class="flex gap-4 rounded-xl border border-border-color bg-white p-5">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-canvas text-brand-blue"
                            aria-hidden="true">
                            {!! $hours['Icon'] ?? '' !!}
                        </span>

                        <div>
                            <p class="text-[13px] font-semibold uppercase tracking-wide text-muted">
                                {{ $hours['Contact Label'] ?? '' }}
                            </p>

                            <div class="mt-1.5 text-[15px] leading-relaxed text-ink">
                                {!! nl2br(e($generalHours)) !!}
                            </div>
                        </div>
                    </li>

                </ul>
            </div>

            {{-- Google Maps --}}
            <div class="lg:col-span-7">
                <div class="h-[320px] overflow-hidden rounded-xl border border-border-color bg-white sm:h-[420px] lg:h-full">
                    <iframe
                        title="{{ $map['Map Title / Accessible Label'] ?? 'Office location map' }}"
                        src="{{ $map['Map Embed URL'] ?? '' }}"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="h-full w-full border-0">
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</section>
