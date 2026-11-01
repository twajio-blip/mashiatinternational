@props(['data' => []])
@php
    $data = $data ?? [];

    // Header from group 0: title, subtitle, description
    $headerBlock = $data[0][0]['instances'][1] ?? [];
    $headerTitle = $headerBlock['title'] ?? 'Get In Touch';
    $headerSubtitle = $headerBlock['subtitle'] ?? 'Contact Us';
    $headerDescription = $headerBlock['description'] ?? 'Have a question or need a quote? Reach out to our team of experts. We\'re here to help you with all your elevator needs.';

    // Contact items & map from group 2 (index 1)
    $contactItems = [];
    $googleMap = null;
    if (isset($data[1]) && is_array($data[1])) {
        foreach ($data[1] as $block) {
            if (!is_array($block)) continue;
            if (isset($block['instances']) && is_array($block['instances'])) {
                foreach ($block['instances'] as $instance) {
                    if (isset($instance['contact_head']) || isset($instance['value'])) {
                        $contactItems[] = [
                            'contact_head' => $instance['contact_head'] ?? '',
                            'value' => $instance['value'] ?? '',
                            'icon' => $instance['icon'] ?? '',
                        ];
                    }
                }
            }
            if (isset($block['google_map'])) {
                $googleMap = $block['google_map'];
            }
        }
    }
@endphp

<section id="contact" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div>
                <div class="flex items-center justify-center space-x-2 mb-4">
                    <h3 class="text-brand-red font-semibold tracking-wider uppercase text-sm">
                        {{ $headerTitle }}
                    </h3>
                </div>

                <h2 class="text-3xl md:text-4xl font-heading font-bold text-brand-charcoal mb-4">
                    {{ $headerSubtitle }}
                </h2>

                <p class="text-brand-gray max-w-2xl mx-auto">
                    {{ $headerDescription }}
                </p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12">
            {{-- Contact Form --}}
            <div class="bg-brand-light p-8 rounded-2xl border border-gray-100">
                <h3 class="text-2xl font-bold text-brand-charcoal mb-6">
                    Send us a Message
                </h3>

                <form method="POST" action="{{ route('contact.store.frontend') }}" class="space-y-6">
                    @csrf

                    @if (session('success'))
                        <p class="text-green-600 font-medium">{{ session('success') }}</p>
                    @endif
                    @if ($errors->any())
                        <ul class="text-red-600 text-sm list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-brand-charcoal mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all"
                                placeholder="Name">
                            @error('name')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-brand-charcoal mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all"
                                placeholder="name@email.com">
                            @error('email')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-brand-charcoal mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all"
                                placeholder="+880 1...">
                            @error('phone')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-brand-charcoal mb-2">
                                Address
                            </label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all"
                                placeholder="Company / Address">
                            @error('address')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-charcoal mb-2">
                            Subject / Interested In <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all"
                            placeholder="e.g. General Inquiry, Quote, Maintenance">
                        @error('subject')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-brand-charcoal mb-2">
                            Message <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="5" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:border-brand-red focus:outline-none transition-all resize-none"
                            placeholder="Tell us how we can help...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="subscribe" id="subscribe" value="1" {{ old('subscribe', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-brand-red focus:ring-brand-red">
                        <label for="subscribe" class="text-sm text-brand-charcoal">Subscribe to updates / newsletter</label>
                    </div>

                    <button type="submit"
                        class="bg-brand-red text-white px-6 py-3 font-semibold rounded-lg hover:opacity-90 transition">
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Contact Info & Map --}}
            <div class="space-y-8">
                @if (!empty($contactItems))
                    <div class="grid sm:grid-cols-2 gap-6">
                        @foreach ($contactItems as $item)
                            <div class="bg-white p-6 rounded-xl shadow-card border border-gray-100 flex items-start">
                                <div class="w-10 h-10 bg-brand-red/10 rounded-lg flex items-center justify-center text-brand-red mr-4 shrink-0">
                                    @if(!empty($item['icon']))
                                        {!! $item['icon'] !!}
                                    @else
                                        <i class="fa-solid fa-address-card w-5 h-5"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-charcoal mb-1">
                                        {{ $item['contact_head'] }}
                                    </h4>
                                    <p class="text-sm text-brand-gray whitespace-pre-line">
                                        {{ $item['value'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Google Map --}}
                @if(!empty($googleMap))
                    <div class="w-full h-64 md:h-80 rounded-2xl overflow-hidden border border-gray-200 [&>iframe]:w-full [&>iframe]:h-full [&>iframe]:min-h-[16rem]">
                        {!! $googleMap !!}
                    </div>
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-2xl overflow-hidden relative flex items-center justify-center border border-gray-300">
                        <span class="text-gray-500 font-medium">Map not configured</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>