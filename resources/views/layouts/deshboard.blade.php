<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- fav icon --}}
    <link rel="icon" type="image/png" href="{{asset('images/'.($general->fav_icon??'placeholder.png'))}}">
    
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$general->website_name??''}}</title>
    <!-- Fonts -->
    @if ($font_backend)
        {!!$font_backend->font_links!!}
    @endif

    <!-- Fontawsome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jquery cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <!-- Swiper js -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Magnific popup --}}
    <script src="{{ asset('magnific-popup/magnific-popup.js') }}"></script>
    {{-- Apex chart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- javascript file -->
    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-custom" style="font-family: Inter, system-ui, sans-serif;">
    <section class="flex">
        <!-- side bar starts-->
        <div class="fixed overlay w-fit h-full bg-black bg-opacity-20 z-40 md:w-fit">
            <aside
                class="sidebar sidebar-active fixed top-0 left-0 w-[85vw] sm:w-[50vw] md:w-[270px] transition-all duration-[400ms] h-screen bg-skin-backend-secondary z-50 -translate-x-[110%] md:-translate-x-0">
                <!-- Logo -->
                <div class="flex items-center justify-between gap-4 h-[60px] text-lg text-white font-semibold px-4 py-6">
                    <a href="#" class="flex items-center gap-2">
                        <img src="{{asset('logo/ractangle.png')}}" alt="logo"
                            class="w-8">
                        <h1 class="hideable text-[26px] text-skin-hover text-nowrap">Data DSS</h1>
                    </a>
                    <div class="hideable">
                        <button
                        class="sidebar-trigger-btn bg-[#f4f4f4] w-[28px] h-[28px] text-skin-invert rounded-full cursor-pointer text-sm transition-colors duration-300 hidden md:inline-block hover:text-skin-hover"><i class="fa-solid fa-bars-staggered"></i></button>
                    </div>
                </div>
                <!-- Navigation -->
                <x-backend.navigation></x-backend.navigation>

            </aside>
        </div>
        <!-- side bar ends-->

        <!-- main section starts -->
        <main class="main-content px-6 md:pl-[294px] w-full bg-skin-backend-primary min-h-screen flex flex-col">
            @php
                // Ensure notifications-related variables are always defined
                $unseenNotification = $unseenNotification ?? 0;
            @endphp
            <x-backend.header />
            <section>
                {{ $slot }}
            </section> 
            <x-backend.footer />
        </main>
        <!-- main section ends -->
    </section>

    @stack('js')
    @yield('js')
</body>

</html>
