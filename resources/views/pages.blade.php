<x-Guest-layout :pageinfo="$page" >
    @if ((int) $page->is_breadcrumb)
        <x-frontend.breadcrumbs :data="$page" />
    @endif
{{-- @dd($components); --}}
    @foreach ($components as $key => $component)
        @component('components.frontend.' . $key, ['data' => $component])
        @endcomponent
    @endforeach

    @if($page->page_text_content && $page->page_text_content!='<p><br></p>')
    <div class="px-10 md:px-[20px]  lg:px-[150px]  prevent-tailwind-css ">
            {!! $page->page_text_content !!}
    </div>
    @endif
</x-Guest-layout>
