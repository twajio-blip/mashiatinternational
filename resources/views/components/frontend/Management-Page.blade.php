@props(['data' => []])

@php
    $allManagement = [];
    $sectionTitle = 'Our Leadership Team';
    $sectionSubtitle = 'The experts behind RAR Lift, dedicated to safety, innovation, and excellence.';

    foreach ($data as $key => $section) {
        if (is_array($section)) {
            foreach ($section as $subKey => $group) {
                if (is_array($group) && isset($group['group_name']) && $group['group_name'] === 'Management') {
                    foreach ($group['instances'] as $instance) {
                        if (isset($instance['title'])) {
                            $sectionTitle = $instance['title'];
                            $sectionSubtitle = $instance['subtitle'] ?? '';
                        } elseif (isset($instance['name'])) {
                            $allManagement[] = $instance;
                        }
                    }
                }
            }
        }
    }
@endphp

<section id="management" class="py-16 lg:py-24 bg-gray-50" x-data="{ activeMember: null }">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Section Header --}}
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-size-title leading-[1.1] font-bold text-brand-charcoal mb-4">
                {{ $sectionTitle }}
            </h2>
            <div class="w-20 h-1 bg-brand-red mx-auto"></div>
            <p class="mt-6 text-gray-500 max-w-2xl mx-auto text-size-body">
                {{ $sectionSubtitle }}
            </p>
        </div>

        {{-- Cards Container --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($allManagement as $index => $member)
                @php
                    $m_name = $member['name'] ?? 'Team Member';
                    $m_role = $member['role'] ?? 'Management';
                    $m_image = $member['image'] ?? '';
                    $m_desc = $member['desc'] ?? '';
                    $m_linkedin = $member['linked_link'] ?? '#';
                    $m_email = $member['email'] ?? null;
                    $img_src = !empty($m_image)
                        ? asset('images/' . $m_image)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($m_name) . '&background=1a1c20&color=fff';
                @endphp

                {{-- Management Card --}}
                <div {{-- Logic: Toggle activeMember only on screens smaller than md (768px) --}}
                    @click="if (window.innerWidth < 768) { activeMember = (activeMember === {{ $index }} ? null : {{ $index }}) }"
                    {{-- Active class applies only when activeMember matches index --}}
                    :class="{ 'is-active': activeMember === {{ $index }} }"
                    class="bg-white rounded-2xl overflow-hidden shadow-sm md:hover:shadow-2xl transition-all duration-500 group cursor-pointer"
                    data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 150 }}">

                    {{-- Image Container --}}
                    <div class="h-80 bg-brand-charcoal relative overflow-hidden">
                        <img src="{{ $img_src }}" alt="{{ $m_name }}"
                            class="w-full h-full object-cover grayscale md:group-hover:grayscale-0 group-[.is-active]:grayscale-0 md:group-hover:scale-105 group-[.is-active]:scale-105 transition-all duration-700">

                        {{-- Gradient Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-brand-charcoal/90 via-transparent to-transparent opacity-60 md:group-hover:opacity-80 group-[.is-active]:opacity-80 transition-opacity">
                        </div>

                        {{-- Social Float --}}
                        <div
                            class="absolute bottom-6 left-0 right-0 flex justify-center space-x-3 z-20 translate-y-12 md:group-hover:translate-y-0 group-[.is-active]:translate-y-0 transition-transform duration-500">
                            @if($m_linkedin && $m_linkedin !== '#')
                                <a href="{{ $m_linkedin }}" target="_blank"
                                    class="w-10 h-10 rounded-full bg-white text-brand-charcoal flex items-center justify-center md:hover:bg-brand-red md:hover:text-white transition-all shadow-lg"
                                    @click.stop>
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            @endif
                            @if($m_email)
                                <a href="mailto:{{ $m_email }}"
                                    class="w-10 h-10 rounded-full bg-white text-brand-charcoal flex items-center justify-center md:hover:bg-brand-red md:hover:text-white transition-all shadow-lg"
                                    @click.stop>
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-8 text-center relative">
                        {{-- Top Animated Bar --}}
                        <div
                            class="absolute top-0 left-1/2 -translate-x-1/2 w-0 md:group-hover:w-full group-[.is-active]:w-full h-1 bg-brand-red transition-all duration-500">
                        </div>

                        <h3
                            class="font-bold text-size-header text-brand-charcoal mb-1 md:group-hover:text-brand-red group-[.is-active]:text-brand-red transition-colors">
                            {{ $m_name }}
                        </h3>

                        <p class="text-brand-red font-semibold text-size-accent uppercase tracking-widest mb-4">
                            {{ $m_role }}
                        </p>

                        <p class="text-gray-500 text-size-body leading-relaxed line-clamp-2">
                            {{ $m_desc }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-400 italic text-size-body">Management profiles are being updated.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>