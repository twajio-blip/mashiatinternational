@php
    $about = $data[0][0] ?? [];
@endphp


<section class="bg-white custom_py">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- IMAGE SIDE --}}
            <div class="relative">

                <div
                    class="hidden md:block absolute -top-6 -left-6 w-24 h-24 border-t-4 border-l-4 border-industrial-red z-0">
                </div>

                <img src="{{ asset('images/' . $about['image']) }}" alt="Our History"
                    class="relative z-10 w-full shadow-2xl rounded-sm" />

                <div
                    class="hidden md:block absolute -bottom-6 -right-6 w-24 h-24 border-b-4 border-r-4 border-navy-900 z-0">
                </div>

            </div>


            {{-- CONTENT SIDE --}}
            <div>

                {{-- Render CMS HTML --}}
                <div class="prose max-w-none prevent-tailwind-css">

                    {!! $about['about-content'] ?? '' !!}

                </div>
            </div>

        </div>
    </div>
</section>