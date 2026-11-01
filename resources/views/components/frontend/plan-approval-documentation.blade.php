@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $certificates = $data[0][1]['instances'] ?? [];
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- Section Header --}}
        @if($section)
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $section['section_title'] ?? '' }}
                </h2>

                <div class="text-gray-700 leading-relaxed text-lg">
                    {!! $section['section_description'] ?? '' !!}
                </div>
            </div>
        @endif


        {{-- Certificates Table --}}
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-blue-900">

            <table class="min-w-full text-left border-collapse">

                {{-- Table Head --}}
                <thead>
                    <tr class="bg-blue-900 text-white text-sm md:text-base">
                        <th class="px-4 py-3 w-16">SL</th>
                        <th class="px-4 py-3">Certificate Name</th>
                        <th class="px-4 py-3">Issuing Authority</th>
                    </tr>
                </thead>

                {{-- Table Body --}}
                <tbody class="text-gray-700 text-sm md:text-base">

                    @foreach($certificates as $certificate)
                        <tr class="{{ $loop->odd ? 'bg-rose-50' : 'bg-gray-100' }} border-b">

                            {{-- Serial --}}
                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </td>

                            {{-- Certificate Name --}}
                            <td class="px-4 py-3">
                                {{ $certificate['certificate_name'] }}
                            </td>

                            {{-- Issuing Authority --}}
                            <td class="px-4 py-3">
                                {{ $certificate['issuing_authority'] }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Decorative Bottom Certificate Image (Optional) --}}
        {{-- <div class="mt-16 flex justify-center">
            <img src="{{ asset('frontend/images/certificate-icon.png') }}" alt="Certification" class="w-60 opacity-90">
        </div> --}}

    </div>
</section>