@props(['data' => []])

@php
    use App\Http\Controllers\Backend\Pages\DynamicComponentController;
    use Illuminate\Support\Str;

    $data = $data ?? [];
    $relatedBlocks = $data['relatedBlocks'] ?? [];

    // Read section fields from either the older flat shape or the grouped frontend format.
    $sectionRecord = collect($data)
        ->first(fn ($item, $key) => is_numeric($key) && is_array($item)) ?? [];

    $findField = function (array $record, array $names) use (&$findField) {
        foreach ($names as $name) {
            if (array_key_exists($name, $record) && $record[$name] !== null && $record[$name] !== '') {
                return $record[$name];
            }
        }

        foreach ($record as $value) {
            if (!is_array($value)) {
                continue;
            }

            $found = $findField($value, $names);
            if ($found !== null && $found !== '') {
                return $found;
            }
        }

        return null;
    };

    $normalizeCategoryKey = function ($value) {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        return preg_match('/^\d+:\d+$/', $value) || preg_match('/^\d+$/', $value)
            ? $value
            : Str::lower($value);
    };

    $headerLabel = $findField($sectionRecord, ['Header Lable', 'Header Label']);
    $headerTitle = $findField($sectionRecord, ['Header Title']);
    $headerDescription = $findField($sectionRecord, ['Header Description']);

    // Services come from the connected "details-service" related block.
    $servicesBlock = $relatedBlocks['details-service']['data'] ?? [];

    $categoryNames = DynamicComponentController::getRelationshipOptions('catagory', 'Catagory Name');
    $categoryTitles = DynamicComponentController::getRelationshipOptions('catagory', 'Catagory Title');
    $categoryNameToKey = collect($categoryNames)
        ->mapWithKeys(fn ($name, $key) => [Str::lower(trim((string) $name)) => (string) $key])
        ->all();

    $resolveCategoryName = function ($value) use ($categoryNames, $categoryNameToKey, $normalizeCategoryKey) {
        $key = $normalizeCategoryKey($value);

        if (isset($categoryNames[$key])) {
            return $categoryNames[$key];
        }

        return $categoryNames[$categoryNameToKey[$key] ?? null] ?? (string) $value;
    };

    $resolveCategoryTitle = function ($value) use ($categoryTitles, $categoryNameToKey, $normalizeCategoryKey) {
        $parts = collect(explode(',', (string) $value))
            ->map(fn ($part) => trim($part))
            ->filter();

        return $parts
            ->map(function ($part) use ($categoryTitles, $categoryNameToKey, $normalizeCategoryKey) {
                $key = $normalizeCategoryKey($part);

                return $categoryTitles[$key] ?? $categoryTitles[$categoryNameToKey[$key] ?? null] ?? $part;
            })
            ->implode(', ');
    };

    $services = collect($servicesBlock)
        ->filter(fn ($item, $key) => is_numeric($key) && is_array($item))
        ->map(function ($item) use ($resolveCategoryName, $resolveCategoryTitle) {
            $details = $item[0] ?? [];
            $title = $details['Service Title'] ?? '';
            $categoryKey = $details['Catagory'] ?? '';

            return [
                'category_key' => $categoryKey,
                'category_name' => $resolveCategoryName($categoryKey),
                'category_title' => $details['Catagory Title'] ?? $resolveCategoryTitle($categoryKey),
                'title' => $title,
                'description' => $details['Service Description'] ?? '',
                'icon' => $details['Service Header Icon'] ?? '',
                'url' => $title ? route('service-view', Str::slug($title)) : '#',
            ];
        })
        ->filter(fn ($service) => Str::lower(trim((string) $service['category_name'])) === 'student visa')
        ->filter(fn ($service) => $service['title'] !== '')
        ->values();

    $eyebrow = $headerLabel ?? $services->first()['category_title'] ?? $services->first()['category_name'] ?? 'Student visa financial documentation';
    $sectionTitle = $headerTitle ?? 'Four areas of support, from first assessment to final review';
    $sectionDescription = $headerDescription ?? 'Most applications are weakened by documentation gaps rather than insufficient funds. Each service below closes a specific gap.';
    $swiperClass = 'supportServicesSwiper-' . uniqid();
@endphp

@if($services->isNotEmpty())
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
        </div>

        <div class="swiper {{ $swiperClass }} mt-12 min-w-0 overflow-hidden pt-1">
            <div class="swiper-wrapper !items-stretch">
                @foreach($services as $service)
                <div class="swiper-slide !h-auto">
                    <article class="group flex h-full w-full flex-col rounded-xl border border-border-color bg-white p-6 shadow-card transition-[box-shadow,transform,border-color] duration-200 ease-out hover:-translate-y-0.5 hover:border-tag hover:shadow-card-hover sm:p-7">
                        <span
                            class="mb-5 inline-flex h-11 w-11 items-center justify-center rounded-lg border border-border-color bg-background-3 text-tag transition-colors duration-200 ease-out group-hover:border-tag group-hover:bg-light"
                            aria-hidden="true">
                            {!! $service['icon'] !!}
                        </span>

                        <h3 class="font-heading text-[19px] font-semibold leading-snug text-dark">
                            <a class="transition-colors duration-200 ease-out hover:text-tag" href="{{ $service['url'] }}">
                                {{ $service['title'] }}
                            </a>
                        </h3>

                        <p class="mt-3 text-[15px] leading-relaxed text-muted">
                            {{ $service['description'] }}
                        </p>

                        <a
                            class="mt-auto inline-flex items-center gap-2 pt-6 text-[15px] font-semibold text-tag transition-colors duration-200 ease-out hover:text-dark"
                            href="{{ $service['url'] }}">
                            View service
                            <i class="fa-solid fa-arrow-right text-sm transition-transform duration-200 ease-out group-hover:translate-x-0.5"></i>
                        </a>
                    </article>
                </div>
                @endforeach
            </div>

            <div class="{{ $swiperClass }}-pagination mt-8 text-center"></div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Swiper === 'undefined') {
            return;
        }

        new Swiper('.{{ $swiperClass }}', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: {{ $services->count() > 1 ? 'true' : 'false' }},
            pagination: {
                el: '.{{ $swiperClass }}-pagination',
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1280: {
                    slidesPerView: 4
                }
            }
        });
    });
</script>
@endif
