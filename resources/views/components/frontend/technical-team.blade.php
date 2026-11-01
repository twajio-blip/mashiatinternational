@props(['data'])

{{-- Technical Team Section --}}

<div class="bg-white custom_py">

    @foreach($data as $section)

        @php
            $mainContent = $section[0] ?? null;
            $subSection = $section[1]['instances'] ?? [];
            $teamTable = $section[2]['instances'] ?? [];
        @endphp

        {{-- ===============================
        HEADER SECTION
        ================================ --}}
        @if($mainContent)
            <div class="py-10">
                <div class="container mx-auto px-4 sm:px-6 md:px-8">

                    <h2 class="text-3xl md:text-4xl font-bold mb-4 text-blue-900">
                        {{ $mainContent['title'] }}
                    </h2>

                    <div class="text-lg leading-relaxed text-gray-700">
                        {!! $mainContent['description'] !!}
                    </div>

                </div>
            </div>
        @endif


        {{-- ===============================
        MANAGEMENT SECTIONS
        ================================ --}}
        @if(!empty($subSection))
            <div class="py-12">
                <div class="container mx-auto px-4 sm:px-6 md:px-8 space-y-10">

                    @foreach($subSection as $item)
                        <div>

                            <h3 class="inline-block bg-indigo-800 text-white px-4 py-2 font-semibold text-lg rounded">
                                {{ $item['title'] }}
                            </h3>

                            <p class="mt-4 text-gray-700 leading-relaxed">
                                {{ $item['description'] }}
                            </p>

                        </div>
                    @endforeach

                </div>
            </div>
        @endif


        {{-- ===============================
        TEAM COMPOSITION TABLE
        ================================ --}}
        @if(!empty($teamTable))
            <div class="py-12">
                <div class="container mx-auto px-4 sm:px-6 md:px-8">

                    <div class="overflow-x-auto">
                        <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-lg">
                            <table class="min-w-full text-left border-collapse">

                                {{-- Table Head --}}
                                <thead>
                                    <tr class="bg-blue-900 text-white text-sm md:text-base uppercase tracking-wider">
                                        <th class="px-6 py-4 w-20 font-bold border-r border-blue-800/50">SL</th>
                                        <th class="px-6 py-4 font-bold border-r border-blue-800/50">Team Composition</th>
                                        <th class="px-6 py-4 font-bold">Experts</th>
                                    </tr>
                                </thead>

                                {{-- Table Body --}}
                                <tbody class="text-gray-700 text-sm md:text-base">

                                    @foreach($teamTable as $index => $team)
                                        <tr
                                            class="{{ $loop->odd ? 'bg-rose-50' : 'bg-gray-100' }} border-b border-slate-200 transition-colors hover:bg-indigo-50/50">

                                            {{-- Serial Number --}}
                                            <td class="px-6 py-4 font-bold text-blue-900 border-r border-slate-200/60">
                                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                            </td>

                                            {{-- Team Designation --}}
                                            <td class="px-6 py-4 font-semibold text-slate-800 border-r border-slate-200/60">
                                                {{ $team['team_designation'] }}
                                            </td>

                                            {{-- Experts Count/Names --}}
                                            <td class="px-6 py-4 font-medium italic text-slate-600">
                                                {{ $team['experts'] }}
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endif

    @endforeach

</div>