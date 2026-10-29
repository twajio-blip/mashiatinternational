<x-layouts.guest :pageinfo="null">
    <section class="relative overflow-hidden bg-gradient-to-br from-sky-50 via-white to-indigo-50">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-sky-200/40 blur-3xl"></div>
            <div class="absolute -bottom-24 -left-10 h-64 w-64 rounded-full bg-indigo-200/40 blur-3xl"></div>
        </div>

        <div class="relative mx-auto flex min-h-[80vh] max-w-6xl flex-col items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
            <div class="mb-10 inline-flex items-center rounded-full border border-sky-100 bg-white/70 px-3 py-1 text-xs font-medium text-sky-700 shadow-sm backdrop-blur">
                <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Default landing page
            </div>

            <h1 class="text-center text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">
                Welcome to
                <span class="bg-gradient-to-r from-sky-500 to-indigo-600 bg-clip-text text-transparent">
                    DDSS CMS
                </span>
            </h1>

            <p class="mt-4 max-w-2xl text-center text-sm text-slate-600 sm:text-base">
                This is your default page. Start creating dynamic pages from the admin panel,
                or customize this screen to match your brand.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center rounded-full bg-sky-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-sky-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-sky-500 focus-visible:ring-offset-2">
                    <span class="mr-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-white/15">
                        <i class="fa-solid fa-gauge-high text-xs"></i>
                    </span>
                    Go to Admin Dashboard
                </a>

                <a href="{{ url()->current() }}"
                   class="inline-flex items-center rounded-full border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:border-sky-300 hover:text-sky-700">
                    <i class="fa-regular fa-circle-question mr-2 text-sm"></i>
                    Learn more about this page
                </a>
            </div>

            <div class="mt-12 grid w-full gap-6 md:grid-cols-3">
                <div class="flex flex-col rounded-2xl border border-slate-100 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <div class="mb-3 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 text-sky-600">
                        <i class="fa-solid fa-layer-group text-sm"></i>
                    </div>
                    <h2 class="text-sm font-semibold text-slate-900">Component based</h2>
                    <p class="mt-2 text-xs text-slate-600">
                        Build pages from reusable components to keep your frontend fast, consistent, and easy to manage.
                    </p>
                </div>

                <div class="flex flex-col rounded-2xl border border-slate-100 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <div class="mb-3 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                    </div>
                    <h2 class="text-sm font-semibold text-slate-900">Live preview</h2>
                    <p class="mt-2 text-xs text-slate-600">
                        Instantly preview content changes so you know exactly what your visitors will see.
                    </p>
                </div>

                <div class="flex flex-col rounded-2xl border border-slate-100 bg-white/80 p-5 shadow-sm backdrop-blur">
                    <div class="mb-3 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <h2 class="text-sm font-semibold text-slate-900">Secure & modern</h2>
                    <p class="mt-2 text-xs text-slate-600">
                        Powered by Laravel 12, following modern security and performance best practices out of the box.
                    </p>
                </div>
            </div>

            <p class="mt-10 text-center text-[11px] uppercase tracking-[0.18em] text-slate-400">
                You can customize this default page at
                <span class="font-semibold text-slate-500">resources/views/default-page.blade.php</span>
            </p>
        </div>
    </section>
</x-layouts.guest>