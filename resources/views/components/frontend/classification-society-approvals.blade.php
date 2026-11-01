@props(['data'])

@php
    $section = $data[0][0] ?? null;
    $approvals = $data[0][1]['instances'] ?? [];
@endphp

<section class="custom_py bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- Section Header --}}
        @if($section)
            <div class="mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-4">
                    {{ $section['section_title'] ?? '' }}
                </h2>

                <div class="text-gray-700 text-lg leading-relaxed">
                    {!! $section['section_description'] ?? '' !!}
                </div>
            </div>
        @endif

        {{-- Approval List --}}
        <div class="grid md:grid-cols-2 gap-10">

            @foreach($approvals as $approval)
                <div class="bg-white shadow-lg border-4 border-blue-900 rounded-md overflow-hidden">

                    {{-- Approval Title Bar --}}
                    <div class="bg-blue-900 text-white px-6 py-3 text-lg font-semibold">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                        {{ $approval['approval_name'] }}
                    </div>

                    {{-- Approval Image --}}
                    <div class="p-6 bg-gray-100 flex justify-center">
                        <img src="{{ asset('images/' . $approval['approval_image']) }}"
                            alt="{{ $approval['approval_name'] }}" class="max-h-[400px] object-contain border">
                    </div>

                </div>
            @endforeach

        </div>

    </div>
</section>