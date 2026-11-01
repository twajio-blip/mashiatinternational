@props(['data' => []])
@php
    $item = $data[0][0] ?? [];
    $newsItems = array_values($data[0][1]['instances'] ?? []);

    $title = $item['title'] ?? 'Latest News & Insights..';
    $subtitle = $item['subtitle'] ?? 'Company Updates..';
    $btn_text = $item['btn_text'] ?? 'View All Articles..';
    $btn_link = $item['btn_link'] ?? 'news..';
@endphp

<section class="py-24 bg-brand-light border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div data-aos="fade-up">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <h3 class="text-brand-red font-semibold tracking-wider uppercase text-sm">
                        {{ $subtitle }}
                    </h3>
                </div>
                <h2 class="text-3xl md:text-4xl font-heading font-bold text-brand-charcoal">
                    {{ $title }}
                </h2>
            </div>

            <a href="{{ url($btn_link) }}"
                class="hidden md:flex items-center text-brand-charcoal font-bold hover:text-brand-red transition-colors group mb-2">
                {{ $btn_text }}
                <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        {{-- News Grid --}}
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($newsItems as $index => $news)
                <article
                    class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl transition-all group cursor-pointer border border-gray-100 flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="{{ $index * 100 }}"
                    onclick="window.location.href='{{ url('news-detail/' . ($news['id'] ?? '')) }}'">

                    {{-- Category & Date --}}
                    <div class="flex items-center justify-between mb-6">
                        <span
                            class="px-3 py-1 bg-brand-light text-brand-charcoal rounded-full text-[10px] font-bold uppercase tracking-wider">
                            {{ $news['category'] ?? 'General' }}
                        </span>
                        <div class="flex items-center text-gray-400 text-xs font-medium">
                            <i class="fa-regular fa-calendar mr-1.5"></i>
                            {{ \Carbon\Carbon::parse($news['created_at'] ?? now())->format('M d, Y') }}
                        </div>
                    </div>

                    {{-- Title --}}
                    <h4
                        class="font-bold text-xl text-brand-charcoal mb-6 group-hover:text-brand-red transition-colors line-clamp-3 leading-snug">
                        {{ $news['title'] ?? 'News Title' }}
                    </h4>

                    {{-- Footer Link (Pushed to bottom) --}}
                    <div
                        class="flex items-center text-sm font-bold text-brand-red group-hover:text-brand-red transition-colors mt-auto pt-4 border-t border-gray-50">
                        Read Full Story
                        <i
                            class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Mobile-only button (Visible when md hidden) --}}
        <div class="mt-12 md:hidden text-center">
            <a href="{{ url($btn_link) }}" class="inline-flex items-center text-brand-red font-bold">
                {{ $btn_text }} <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>