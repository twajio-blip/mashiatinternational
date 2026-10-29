@props(['data' => []])

@php
    use App\Http\Controllers\Backend\Pages\DynamicComponentController;
    use Illuminate\Support\Str;

    $data = $data ?? [];
    $categoryFilter = Str::slug((string) request('category'));

    $categoryNames = DynamicComponentController::getRelationshipOptions('catagory', 'Catagory Name');
    $categoryNameToKey = collect($categoryNames)
        ->mapWithKeys(fn ($name, $key) => [Str::lower(trim((string) $name)) => (string) $key])
        ->all();

    $normalizeCategoryKey = function ($value) {
        $value = trim((string) $value);

        if ($value === '') {
            return '';
        }

        return preg_match('/^\d+:\d+$/', $value) || preg_match('/^\d+$/', $value)
            ? $value
            : Str::lower($value);
    };

    $resolveCategoryName = function ($value) use ($categoryNames, $categoryNameToKey, $normalizeCategoryKey) {
        $key = $normalizeCategoryKey($value);

        if (isset($categoryNames[$key])) {
            return $categoryNames[$key];
        }

        return $categoryNames[$categoryNameToKey[$key] ?? null] ?? (string) $value;
    };

    // Fetch all services from the component data
    $services = collect($data)
        ->filter(fn($item, $key) => is_numeric($key))
        ->map(function ($item) use ($resolveCategoryName) {
            $details = $item[0] ?? [];
            $title = $details['Service Title'] ?? '';
            $category = $resolveCategoryName($details['Catagory'] ?? '');

            return [
                'url' => route('service-view', Str::slug($title)),
                'category' => $category,
                'category_slug' => Str::slug($category),
                'title' => $title,
                'description' => $details['Service Description'] ?? '',
                'icon' => $details['Service Header Icon'] ?? '',
            ];
        })
        ->when($categoryFilter !== '', fn ($items) => $items->filter(fn ($service) => $service['category_slug'] === $categoryFilter))
        ->values();
@endphp

<section class="bg-background-3 py-12 sm:py-16">
    <div class="container">
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">

            @foreach ($services as $service)
                <div>
                    <article class="group flex h-full flex-col rounded-xl border border-border-color bg-white p-6 shadow-card transition-all duration-300 ease-in-out hover:-translate-y-1 hover:border-tag hover:shadow-card-hover sm:p-7">

                        <span
                            class="mb-5 inline-flex h-11 w-11 items-center justify-center rounded-lg border border-border-color bg-background-3 text-tag transition-[background-color,border-color,transform] duration-300 ease-in-out group-hover:-translate-y-0.5 group-hover:border-tag group-hover:bg-light"
                            aria-hidden="true"
                        >
                            {!! $service['icon'] !!}
                        </span>

                        <p class="mb-2 text-[12px] font-semibold uppercase tracking-wide text-muted">
                            {{ $service['category'] }}
                        </p>

                        <h3 class="text-[19px] font-semibold leading-snug transition-colors duration-300 ease-in-out hover:text-tag">
                            <a
                                class="transition-colors duration-300 ease-in-out"
                                href="{{ $service['url'] }}"
                            >
                                {{ $service['title'] }}
                            </a>
                        </h3>

                        <p class="mt-3 text-[15px] leading-relaxed text-muted">
                            {{ $service['description'] }}
                        </p>

                        <a
                            class="mt-auto inline-flex items-center gap-2 pt-6 text-[15px] font-semibold text-tag transition-colors duration-300 ease-in-out hover:text-dark"
                            href="{{ $service['url'] }}"
                        >
                            View service

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-arrow-right transition-transform duration-300 ease-in-out group-hover:translate-x-1"
                                aria-hidden="true"
                            >
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>

                    </article>
                </div>
            @endforeach

        </div>
    </div>
</section>
