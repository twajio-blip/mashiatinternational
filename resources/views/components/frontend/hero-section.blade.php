<section id="hero-section" class="w-full bg-white overflow-hidden">

    <div class="container relative">

        <div class="grid items-center gap-10 py-12 sm:gap-12 sm:py-16 xl:grid-cols-12 xl:gap-16 xl:py-24">

            {{-- LEFT CONTENT --}}
            <div class="max-w-3xl xl:col-span-6">

                <h1
                    class="text-balance text-text-color font-display text-[34px] font-extrabold leading-[1.08] min-[380px]:text-[36px] sm:text-[42px]"
                >
                    Prepare your student visa financial documents with confidence
                </h1>

                <p
                    class="mt-6 max-w-2xl text-[16px] leading-relaxed text-muted sm:text-[18px] xl:max-w-xl"
                >
                    Mashiat International helps Bangladeshi students and their sponsors assess financial capacity, document sources of funds, obtain certified net worth and valuation reports, and review every document before it reaches an application file.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    {{-- Primary Button --}}
                    <a
                        href="/contact"
                        class="inline-flex min-w-0 items-center justify-center gap-2 rounded-lg text-center font-medium duration-200 ease-out bg-btn-primary text-white hover:bg-btn-primary-hover shadow-card min-h-14 px-6 py-3 text-base sm:px-7 whitespace-nowrap"
                    >
                        Book a Consultation

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>

                    {{-- Secondary Button --}}
                    <a
                        href="/student-visa"
                        class="inline-flex min-w-0 items-center justify-center gap-2 rounded-lg text-center font-medium transition-[background-color,color,border-color,box-shadow,transform] duration-200 ease-out focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-blue disabled:pointer-events-none disabled:opacity-60 border border-line bg-white text-navy hover:border-brand-blue hover:text-brand-blue min-h-14 px-6 py-3 text-base sm:px-7 whitespace-nowrap"
                    >
                        Explore student visa support
                    </a>

                </div>

            </div>


            {{-- RIGHT IMAGE --}}
            <div class="xl:col-span-6">

                <div class="relative">

                    <div class="overflow-hidden rounded-xl border border-line bg-canvas shadow-lift">

                        <img
                            src="{{ asset('images/hero.jpg') }}"
                            alt="A Mashiat International consultant reviewing financial documents with a student and their sponsor"
                            class="h-full w-full object-cover"
                            width="1200"
                            height="900"
                        >

                    </div>


                    {{-- FLOATING INFORMATION CARD --}}
                    <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:absolute xl:-bottom-8 xl:-left-8 xl:mt-0 xl:w-[300px] xl:grid-cols-1 xl:gap-0">

                        <div class="rounded-xl border border-line bg-white p-5 shadow-card">

                            <p class="font-display text-[15px] font-semibold text-navy-deep">
                                Documentation, not decisions
                            </p>

                            <p class="mt-2 text-[14px] leading-relaxed text-muted">
                                We prepare accurate, verifiable financial evidence. Visa outcomes rest solely with immigration authorities.
                            </p>

                        </div>


                        {{-- MOBILE ONLY CARD --}}
                        <div class="rounded-xl border border-line bg-navy-deep p-5 text-white shadow-card xl:hidden">

                            <p class="font-display text-[15px] font-semibold">
                                Start 6–9 months early
                            </p>

                            <p class="mt-2 text-[14px] leading-relaxed text-white/70">
                                Fund maturity and filing history cannot be created retrospectively.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
