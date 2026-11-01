@props(['data' => []])

@php
    // Extracting the first item from the 'contact text' group
    $item = $data[0][0] ?? [];

    $title = $item['title'] ?? 'Get In Touch';
    $subtitle = $item['subtitle'] ?? 'Ready to Discuss Your Project?';

    // Note: Your array uses 'descriptiona'
    $description = $item['descriptiona'] ?? $item['description'] ?? '';

    $btn_text = $item['btn_text'] ?? 'Send a Message';
    $btn_link = $item['btn_link'] ?? 'contact';

    $center_title = $item['center_title'] ?? 'Elevating Excellence';
    $center_text = $item['center_text'] ?? 'Your trusted partner in vertical transportation across Bangladesh.';
    $center_img = $item['center_img'] ?? '';

    // Extracting contact options (Phone, Email, etc.)
    $contactOptions = array_values($data[0][1]['instances'] ?? []);
@endphp

<section class="py-16 lg:py-24 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- Left Side: Text and Contact Cards --}}
            <div data-aos="fade-right" data-aos-once="true">
                <div class="mb-4 lg:mb-8">
                    <div class="flex items-center space-x-3 mb-4">
                        <h3 class="text-brand-red font-semibold tracking-widest uppercase text-size-sub-header">
                            {{ $title }}
                        </h3>
                    </div>
                    <h2 class="text-size-title font-bold text-brand-charcoal leading-[1.1]">
                        {{ $subtitle }}
                    </h2>
                </div>

                <p class="text-brand-gray mb-8 text-size-body max-w-lg">
                    {{ $description }}
                </p>

                <div class="space-y-6 mb-4 lg:mb-8">
                    @foreach($contactOptions as $option)
                        <div
                            class="flex items-center p-5 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                            <div
                                class="w-12 h-12 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mr-5 shrink-0">
                                <i class="{{ $option['contact_icon'] ?? 'fa-solid fa-phone' }} text-xl"></i>
                            </div>
                            <div>
                                <p class="text-size-accent text-brand-gray font-bold uppercase tracking-wider mb-1">
                                    {{ $option['contact_title'] ?? '' }}
                                </p>
                                <p class="font-bold text-brand-charcoal text-size-sub-header">
                                    {{ $option['contact_info'] ?? '' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div data-aos="fade-up" data-aos-delay="500" class="flex justify-center sm:justify-start">
                    <a href="{{ url($btn_link) }}"
                        class="inline-flex items-center px-8 py-4 text-size-sub-header bg-brand-charcoal text-white rounded-lg font-bold hover:bg-brand-red transition-all duration-300 shadow-xl group">
                        {{ $btn_text }}
                        <i
                            class="fa-solid fa-arrow-right text-size-sub-header ml-2 group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>

            {{-- Right Side: Decorative Circle UI --}}
            <div class="hidden lg:flex justify-center items-center relative">

                <div class="rounded-full p-2 shadow-2xl relative flex items-center justify-center"
                    style="width:450px; height:450px; background:#0b0f14">

                    <div
                        class="absolute inset-0 border-[3px] border-dashed border-white/10 rounded-full animate-spin-slow">
                    </div>

                    <div class="absolute inset-4 border border-white/5 rounded-full"></div>

                    <div class="w-full h-full rounded-full overflow-hidden relative flex items-center justify-center">

                        <div class="absolute inset-0 bg-black/40 z-10"></div>

                        <div
                            class="relative z-20 flex flex-col items-center justify-center text-white p-12 text-center">

                            @if($center_img)
                                {{-- Added 'z-30' and ensured the folder 'images/' is included --}}
                                <div class="relative z-30 mb-6 group">
                                    <div
                                        class="absolute -inset-4 bg-white/5 rounded-full blur-xl group-hover:bg-white/10 transition-all">
                                    </div>
                                    <img src="{{ asset('images/' . $center_img) }}" alt="Company Logo"
                                        class="h-20 w-auto relative z-30 object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
                                </div>
                            @endif

                            <h3 class="text-2xl font-heading font-bold mb-3 tracking-tight">
                                {{ $center_title }}
                            </h3>

                            <p class="text-white/60 text-sm leading-relaxed max-w-[250px]">
                                {{ $center_text }}
                            </p>

                        </div>
                    </div>
                </div>

                {{-- Floating Experience Badge (Optional Decor) --}}
                <div
                    class="absolute -bottom-4 -right-4 bg-white p-6 rounded-2xl shadow-xl border border-gray-100 z-40 hidden xl:block">
                    <div class="text-brand-red text-3xl font-bold">15+</div>
                    <div class="text-brand-charcoal text-xs font-bold uppercase tracking-widest">Years of Experience
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@pushonce('css')
<style>
    @keyframes spin-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-slow {
        animation: spin-slow 40s linear infinite;
    }
</style>
@endpushonce