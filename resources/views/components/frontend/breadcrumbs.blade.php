@props(['data'])

@php
    $isObject = is_object($data);
    $description = $isObject ? ($data->description ?? '') : ($data['description'] ?? '');
    $description = html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $description = preg_replace('/<p>\s*(?:<br\s*\/?>)?\s*<\/p>/i', '', $description);
    $description = preg_replace('/<(h[1-6]|p)([^>]*)>\s*<br\s*\/?>\s*/i', '<$1$2>', $description);
    $description = preg_replace('/\s*<br\s*\/?>\s*<\/(h[1-6]|p)>/i', '</$1>', $description);
    $description = preg_replace('/<\/(p|h[1-6])>\s*<br\s*\/?>\s*<(?=p|h[1-6])/i', '</$1><', $description);
    $description = preg_replace('/<p>\s*(?:<br\s*\/?>)?\s*<\/p>/i', '', $description);
    $plainDescription = trim(strip_tags($description));
@endphp

@if($plainDescription !== '')
    <section class="relative overflow-hidden bg-background pb-14 pt-9 sm:pb-20 sm:pt-12">
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 border-l border-white/5 lg:block"
        ></div>

        <div class="container relative">
            <div class="breadcrumb-content max-w-3xl">
                <div class="max-w-3xl text-[16px] leading-relaxed text-white/75 sm:text-lg">
                    {!! $description !!}
                </div>
            </div>
        </div>
    </section>
@endif
