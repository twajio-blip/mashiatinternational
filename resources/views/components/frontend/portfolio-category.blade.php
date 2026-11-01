{{-- @props(['data' => []])
@php
   dd($data);
@endphp

<div class="flex flex-wrap justify-center gap-2 md:gap-4 mb-12">
    @foreach ($tabs as $tab)
        <button @click="activeTab = '{{ $tab['name'] }}'"
            :class="activeTab === '{{ $tab['name'] }}' ? 'bg-brand-red text-white shadow-md' : 'bg-brand-light text-gray-500 hover:bg-gray-200'"
            class="px-6 py-2 rounded-full text-sm font-medium transition-all focus:outline-none">
            {{ $tab['name'] }}
        </button>
    @endforeach
</div> --}}