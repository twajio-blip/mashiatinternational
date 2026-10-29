@props(['data' => []])

@php
    $records = collect($data)->filter(fn ($item) => is_array($item) && isset($item[0]));
    $record = $records->first(fn ($item) => !empty($item[0]['Section Label']) || !empty($item[0]['Section Title'])) ?? $records->first() ?? [];

    $findGroup = function (array $names) use ($record) {
        $names = array_map(fn ($name) => strtolower(trim($name)), $names);

        foreach ($record as $group) {
            if (! is_array($group)) {
                continue;
            }

            $groupName = strtolower(trim($group['group_name'] ?? ''));
            if (in_array($groupName, $names, true)) {
                return $group;
            }
        }

        return [];
    };

    $groupInstances = fn (array $names) => array_values($findGroup($names)['instances'] ?? []);

    $header = $findGroup(['Consultation Header']) ?: ($record[0] ?? []);
    $items = $groupInstances(['Consultation Information Items']);
    $cta = $findGroup(['Form/CTA Text']);

    $sectionLabel = $header['Section Label'] ?? 'Request a consultation';
    $sectionTitle = $header['Section Title'] ?? 'Tell us where you are in the process';
    $sectionDescription = $header['Section Description'] ?? 'Share a few details and a consultant will contact you to arrange a time. Sponsors are welcome to join the conversation.';
    $privacyNote = $cta['Privacy Note'] ?? 'Your information is used only to respond to this enquiry and is treated in professional confidence.';
    $submitText = $cta['Submit Button'] ?? 'Request Consultation';

    $items = count($items) ? $items : [
        ['Title' => 'A reply within one working day', 'Description' => 'A consultant confirms a time by phone or WhatsApp, whichever you prefer.', 'icon' => '<i class="fa-solid fa-clock"></i>'],
        ['Title' => 'A 30-minute first consultation', 'Description' => 'Held at our Dhaka office or over video. No documents needed for this call.', 'icon' => '<i class="fa-solid fa-user-pen"></i>'],
        ['Title' => 'A written document plan', 'Description' => 'You leave knowing exactly which documents are required and in what order.', 'icon' => '<i class="fa-regular fa-file-lines"></i>'],
    ];

    $optionValues = function (array $groupNames, array $fields) use ($groupInstances) {
        return collect($groupInstances($groupNames))
            ->flatMap(function ($item) use ($fields) {
                return collect($fields)
                    ->map(fn ($field) => $item[$field] ?? null)
                    ->filter(fn ($value) => filled($value));
            })
            ->values()
            ->all();
    };

    $destinations = $optionValues(['Preferred Destination Options', 'Destination Options'], ['Destination Option', 'Preferred destination', 'Destination']);
    $intakes = $optionValues(['Intended Intake Options', 'Intake Options'], ['Intake Option', 'Intended intake', 'Intake']);

    $adminServices = collect($record)
        ->filter(fn ($group) => is_array($group))
        ->flatMap(function ($group) {
            $items = array_values($group['instances'] ?? []);
            unset($group['instances'], $group['group_name']);

            return array_merge([$group], $items);
        })
        ->flatMap(function ($item) {
            return collect(['Service', 'Service Title', 'Service Name', 'Service required'])
                ->map(fn ($field) => $item[$field] ?? null)
                ->filter(fn ($value) => filled($value));
        })
        ->values()
        ->all();

    $services = collect($adminServices)->whenEmpty(function () {
        return \App\Models\ComponentField::query()
            ->where('component_id', 43)
            ->where('name', 'Service Title')
            ->whereNotNull('value')
            ->where('value', '!=', '')
            ->orderByRaw('CAST(`group` AS UNSIGNED)')
            ->pluck('value');
    })
        ->unique()
        ->values()
        ->all();
@endphp

<section id="consultation" class="scroll-mt-28 bg-white py-16 sm:py-24">
    <div class="container">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-16">
            <div class="lg:col-span-5">
                <div class="max-w-2xl">
                    <p class="mb-3 text-[13px] font-semibold text-brand-blue">{{ $sectionLabel }}</p>
                    <h2 class="font-display text-[29px] font-bold text-navy-deep sm:text-[38px] lg:text-[42px]">{{ $sectionTitle }}</h2>
                    <p class="mt-4 text-[17px] leading-relaxed text-muted">{{ $sectionDescription }}</p>
                </div>

                <ul class="mt-9 space-y-6">
                    @foreach ($items as $item)
                        <li class="flex gap-4">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-border-color bg-canvas text-brand-blue" aria-hidden="true">
                                {!! $item['icon'] ?? '<i class="fa-regular fa-circle-check"></i>' !!}
                            </span>
                            <div>
                                <p class="font-display text-[16px] font-semibold text-navy-deep">{{ $item['Title'] ?? '' }}</p>
                                <p class="mt-1 text-[15px] leading-relaxed text-muted">{{ $item['Description'] ?? '' }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="lg:col-span-7">
                @if (session('success'))
                    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-[14px] font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store.frontend') }}" method="POST" x-data="{ submitting: false }" @submit="if (submitting) { $event.preventDefault(); return; } submitting = true" class="rounded-xl border border-border-color bg-white p-6 shadow-card sm:p-8">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="cf-name" class="mb-2 block text-[14px] font-medium text-navy-deep">Full name <span class="ml-1 text-[#B3261E]" aria-hidden="true">*</span></label>
                            <input id="cf-name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}" class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink placeholder:text-muted/70 transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20" placeholder="e.g. Rafiul Karim">
                            @error('name') <p class="mt-1 text-[13px] text-[#B3261E]">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="cf-phone" class="mb-2 block text-[14px] font-medium text-navy-deep">Phone / WhatsApp <span class="ml-1 text-[#B3261E]" aria-hidden="true">*</span></label>
                            <input id="cf-phone" name="phone" type="tel" autocomplete="tel" required value="{{ old('phone') }}" class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink placeholder:text-muted/70 transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20" placeholder="+880 1XXX XXXXXX">
                            @error('phone') <p class="mt-1 text-[13px] text-[#B3261E]">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="cf-email" class="mb-2 block text-[14px] font-medium text-navy-deep">Email address <span class="ml-1 text-[#B3261E]" aria-hidden="true">*</span></label>
                            <input id="cf-email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink placeholder:text-muted/70 transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20" placeholder="name@example.com">
                            @error('email') <p class="mt-1 text-[13px] text-[#B3261E]">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="cf-destination" class="mb-2 flex items-center justify-between gap-2 text-[14px] font-medium text-navy-deep">
                                <span>Preferred destination</span><span class="text-[12px] font-normal text-muted">Optional</span>
                            </label>
                            <select id="cf-destination" name="destination" class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20">
                                <option value="">Select a destination</option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination }}" @selected(old('destination') === $destination)>{{ $destination }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="cf-intake" class="mb-2 flex items-center justify-between gap-2 text-[14px] font-medium text-navy-deep">
                                <span>Intended intake</span><span class="text-[12px] font-normal text-muted">Optional</span>
                            </label>
                            <select id="cf-intake" name="intake" class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20">
                                <option value="">Select an intake</option>
                                @foreach ($intakes as $intake)
                                    <option value="{{ $intake }}" @selected(old('intake') === $intake)>{{ $intake }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="cf-service" class="mb-2 block text-[14px] font-medium text-navy-deep">Service required <span class="ml-1 text-[#B3261E]" aria-hidden="true">*</span></label>
                            <select id="cf-service" name="service" required class="min-h-[48px] w-full rounded-lg border border-border-color bg-white px-4 text-[16px] text-ink transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20">
                                <option value="">Select a service</option>
                                <option value="General consultation - not sure yet" @selected(old('service') === 'General consultation - not sure yet')>General consultation - not sure yet</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service }}" @selected(old('service') === $service)>{{ $service }}</option>
                                @endforeach
                            </select>
                            @error('service') <p class="mt-1 text-[13px] text-[#B3261E]">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="cf-message" class="mb-2 flex items-center justify-between gap-2 text-[14px] font-medium text-navy-deep">
                                <span>Tell us about your situation</span><span class="text-[12px] font-normal text-muted">Optional</span>
                            </label>
                            <textarea id="cf-message" name="message" rows="4" class="min-h-[120px] w-full resize-y rounded-lg border border-border-color bg-white px-4 py-3 text-[16px] leading-relaxed text-ink placeholder:text-muted/70 transition-colors focus:border-brand-blue focus:outline-none focus:ring-2 focus:ring-brand-blue/20" placeholder="Who is sponsoring the study, what documents you already have, and any deadlines you are working towards.">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-7 grid gap-4">
                        <p class="flex w-full items-start gap-2 text-[13px] leading-relaxed text-muted">
                            <i class="fa-solid fa-shield-halved mt-0.5 shrink-0 text-gold"></i>
                            {{ $privacyNote }}
                        </p>

                        <button class="inline-flex min-h-14 w-full items-center justify-center gap-2 rounded-lg bg-header px-6 py-3 text-center text-base font-semibold text-white shadow-card transition-colors duration-200 ease-out hover:bg-btn-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tag disabled:pointer-events-none disabled:opacity-70 sm:px-7" type="submit" :disabled="submitting">
                            <i class="fa-regular fa-paper-plane" x-show="!submitting"></i>
                            <i class="fa-solid fa-spinner animate-spin" x-show="submitting" x-cloak></i>
                            <span x-text="submitting ? 'Submitting...' : @js($submitText)">{{ $submitText }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
