@props(['pageinfo' => false])
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta property="og:title" content="{{ $pageinfo->seo_title ?? '' }}">
    <meta property="og:description" content="{{ $pageinfo->seo_description ?? '' }}">
    <meta property="og:image" content="{{ asset('images/' . ($pageinfo->seo_image ?? '')) }}">
    <meta name="robots" content="{{ $pageinfo->seo_index ?? '' }}">

    {{-- favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/' . ($general->fav_icon ?? 'placeholder.png')) }}">
    <!-- font inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    {{-- Font --}}
    @if ($font_frontend)
        {!! $font_frontend->font_links !!}
    @endif


    {{--
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" /> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- Swiper js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <link rel="stylesheet" href="{{ asset('magnific-popup/magnific-popup.css') }}">

    <!-- jquery (must load before Vite bundle) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Swiper js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('magnific-popup/magnific-popup.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>
        {{ is_object($pageinfo) && $pageinfo->permalink == '/' ? $general->website_name ?? '' : (is_object($pageinfo) ? $pageinfo->name : 'Default Title') }}
    </title>

</head>

<body class="bg-skin-primary">
    {{-- <x-frontend.top-header /> --}}
    @php
        $headerComponent = $pageinfo?->header_component ?? $general?->header_component;
        $headerPosition = $pageinfo?->header_component_position ?? $general?->header_component_position;
    @endphp

    @if ($headerComponent)
        @component('components.frontend.header.' . $headerComponent, ['position' => $headerPosition])
        @endcomponent
    @endif


    <div class=" min-h-screen bg-white flex flex-col font-sans">
        <!-- Main -->
        <main class="flex-grow ">

            {{ $slot }}

        </main>

    </div>
    @php
        $footerComponent = $pageinfo?->footer_component ?? $general?->footer_component;

    @endphp

    @if ($footerComponent)
        @component('components.frontend.footer.' . $footerComponent)
        @endcomponent
    @endif

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $general?->google_analytics }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '{{ $general?->google_analytics }}');
    </script>
    @stack('js')
</body>

</html>
