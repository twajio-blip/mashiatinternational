<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{config('app.name', 'Laravel') }}</title>

    <!-- Fontawsome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- Swiper cdn --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('/packages/css/datatables.min.css') }}">

    <!-- Select2 CSS CDN Link -->
    <link href="{{ asset('/packages/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet" />

    {{-- Sweet alert cdn --}}
    <link href="{{ asset('/packages/sweetalert2-11.10.8/package/dist/sweetalert2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/packages/css/magnific-popup.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#f6f8f8]">
    <!-- jquery cdn link -->
    <script src="{{ asset('/packages/js/jquery.min.js') }}"></script>
    {{-- swiper cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Datatable -->
    <script src="{{ asset('/packages/js/datatables.min.js') }}"></script>
    <!-- Select2 cdn link -->
    <script src="{{ asset('/packages/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>

    <!-- Tiny MCE -->
    <script src="{{ asset('/tinymce/tinymce.min.js') }}"></script>
    <!-- Place the following
    and < textarea > tags your HTML 's <body> -->
    <script type="module">
        tinymce.init({
            selector: "textarea:not(#additional-information)",
            plugins: "ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss",
            toolbar: "undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat",
            tinycomments_mode: "embedded",
            tinycomments_author: "Author name",
            mergetags_list: [{
                    value: "First.Name",
                    title: "First Name"
                },
                {
                    value: "Email",
                    title: "Email"
                },
            ],
            ai_request: (request, respondWith) =>
                respondWith.string(() =>
                    Promise.reject("See docs to implement AI Assistant"),
                ),
        });
    </script>

    <!-- Sweet alert -->
    <script src="{{ asset('/packages/sweetalert2-11.10.8/package/dist/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">

    </script>
    {{-- zoom --}}
    <script src="{{ asset('/packages/zoom-master/jquery.zoom.min.js') }}"></script>
    {{-- megnific pop up --}}
    <script src="{{ asset('/packages/js/megnificpopup.min.js') }}"></script>
    <script src="magnific-popup/jquery.magnific-popup.js"></script>
    <section>
        @yield('content')
    </section>
</body>

</html>
