@props(['data'])

@php
    $header = $data[0][0] ?? $data[0][1] ?? [];

    $blockCid = $data['component_id'] ?? null;
    $blockPid = $data['current_page_id'] ?? 0;

    // (A) $data = [0=>rec0, 1=>rec1, 2=>rec2, component_id, current_page_id] -> use $data so all 3 show
    // (B) $data = [0=>headerBlock, 1=>projectsBlock] where projectsBlock = [0=>p0, 1=>p1, 2=>p2] -> use $data[1]
    // Only use (B) when $data[1][0] exists and looks like a record (has 'group' or 'component_id'), not when $data[1] is a single record
    $source = $data;
    if (isset($data[1][0]) && is_array($data[1][0]) && (isset($data[1][0]['group']) || isset($data[1][0]['component_id']))) {
        $source = $data[1];
        $blockCid = $source['component_id'] ?? $blockCid;
        $blockPid = $source['current_page_id'] ?? $blockPid;
    }

    $projects = collect($source)
        ->skip(1)
        ->filter(fn($v, $k) => is_int($k) && is_array($v))
        ->values()
        ->map(function ($item, $index) use ($blockCid, $blockPid) {
            $cid = $item['component_id'] ?? $blockCid;
            $pid = $item['current_page_id'] ?? $blockPid;
            $recordId = $item['group'] ?? $item['id'] ?? $index;
            $flat = array_merge($item, [
                'component_id' => $cid,
                'current_page_id' => $pid,
                '_record_id' => $recordId,
            ]);
            if (!isset($flat['title']) && !isset($flat['project_image'])) {
                foreach ($item as $k => $v) {
                    if (is_int($k) && is_array($v) && (isset($v['title']) || isset($v['project_image']))) {
                        $flat = array_merge($flat, $v);
                        break;
                    }
                }
            }
            return $flat;
        })
        ->filter(fn($item) => isset($item['title']) || isset($item['project_image']))
        ->values();

    // Hide header when we're on the projects page (full listing)
    $isProjectsPage = request()->path() === 'projects' || request()->is('projects');
@endphp
{{-- Featured Projects --}}
<section class="custom_py bg-gray-100">
    <div class="container mx-auto px-4 sm:px-6 md:px-8">

        {{-- Header (hidden on projects page) --}}
        @if(!$isProjectsPage)
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h4 class="text-industrial-red font-bold uppercase tracking-widest mb-4">
                        {{ $header['title'] ?? '' }}
                    </h4>

                    <h2 class="text-4xl md:text-5xl font-serif font-bold text-navy-900">
                        {{ $header['subtitle'] ?? '' }}
                    </h2>
                </div>

                <a href="/projects"
                    class="hidden md:flex items-center gap-2 font-bold text-navy-900 hover:text-industrial-red transition-colors">
                    View All Projects →
                </a>
            </div>
        @endif

        {{-- Projects Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach($projects as $project)
                <a href="{{ route('data-view', ['id' => $project['component_id'], 'current_page_id' => $project['current_page_id'] ?? 0]) }}?group={{ urlencode($project['_record_id'] ?? $loop->index) }}"
                    class="block group relative h-[400px] overflow-hidden cursor-pointer transition-transform duration-300 hover:-translate-y-2">

                    {{-- Image --}}
                    <img src="{{ asset('images/' . ($project['project_image'] ?? '')) }}"
                        alt="{{ $project['title'] ?? '' }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-navy-900/40 group-hover:bg-navy-900/80 transition-colors duration-300">
                    </div>

                    {{-- Content --}}
                    <div
                        class="absolute bottom-0 left-0 w-full p-8 translate-y-4 group-hover:translate-y-0 transition-transform duration-300">

                        {{-- Category --}}
                        <span
                            class="text-industrial-red font-bold uppercase tracking-wider text-sm mb-2 block opacity-0 group-hover:opacity-100 transition-opacity duration-300 delay-100">
                            {{ $project['category'] ?? '' }}
                        </span>

                        {{-- Title --}}
                        <h3 class="text-2xl font-serif font-bold text-white mb-4">
                            {{ $project['title'] }}
                        </h3>

                        {{-- Animated underline --}}
                        <div class="h-1 w-0 bg-industrial-red group-hover:w-full transition-all duration-500"></div>

                    </div>

                </a>
            @endforeach

        </div>

        {{-- Mobile Button (hidden on projects page) --}}
        @if(!$isProjectsPage)
            <div class="mt-12 text-center md:hidden">
                <a href="/projects"
                    class="inline-flex items-center gap-2 border border-navy-900 text-navy-900 px-6 py-3 hover:bg-navy-900 hover:text-white transition">
                    View All Projects →
                </a>
            </div>
        @endif

    </div>
</section>