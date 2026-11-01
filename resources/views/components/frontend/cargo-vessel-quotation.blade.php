@props(['data'])

@php
    $header = $data[0][0] ?? null;
    $specifications = $data[0][1]['instances'] ?? [];
    $items = $data[0][2]['instances'] ?? [];
@endphp

<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- ================= HEADER CONTENT ================= --}}
        @if($header)
            <div class="mb-10 text-gray-700 leading-relaxed text-lg">
                {!! $header['content'] ?? '' !!}
            </div>
        @endif


        {{-- ================= SPECIFICATION TABLE ================= --}}
        @if(count($specifications))
            <div class="overflow-x-auto mb-12 bg-white shadow-lg border border-blue-900 rounded-lg">

                <table class="min-w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-4 py-3 w-16">SL</th>
                            <th class="px-4 py-3">Length</th>
                            <th class="px-4 py-3">Breadth</th>
                            <th class="px-4 py-3">Depth</th>
                            <th class="px-4 py-3">Back Body Shape</th>
                            <th class="px-4 py-3">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($specifications as $spec)
                            <tr class="bg-rose-50 border-b">
                                <td class="px-4 py-3 font-semibold">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3">{{ $spec['length'] }}</td>
                                <td class="px-4 py-3">{{ $spec['breadth'] }}</td>
                                <td class="px-4 py-3">{{ $spec['depth'] }}</td>
                                <td class="px-4 py-3">{{ $spec['shape'] }}</td>
                                <td class="px-4 py-3">{{ $spec['capacity'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif


        {{-- ================= ITEMS TABLE ================= --}}
        @if(count($items))
            <div class="overflow-x-auto bg-white shadow-lg border border-blue-900 rounded-lg">

                <table class="min-w-full border-collapse text-sm md:text-base">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-4 py-3 w-16">SL</th>
                            <th class="px-4 py-3">Items</th>
                            <th class="px-4 py-3">Particulars</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $item)
                            <tr class="{{ $loop->odd ? 'bg-rose-50' : 'bg-gray-100' }} border-b">
                                <td class="px-4 py-3 font-semibold">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3">{{ $item['Items'] }}</td>
                                <td class="px-4 py-3">{{ $item['particulars'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        @endif

    </div>
</section>