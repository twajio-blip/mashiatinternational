<x-Deshboard-layout>

    <!-- Table Section -->
    <div class="py-10 space-y-4">
        <!-- Header -->
        <div class="space-y-2 max-w-[304px]">
            <h2 class="text-[24px] font-bold text-skin-backend-text-base">
                <a href="{{ route('theme-option.index') }}" class="font-bold text-skin-backend-text-base">Settings</a> /
                <span class="text-skin-backend-text-base text-opacity-50">Header & Footer Setting</span>
            </h2>
            <p class="text-[14px] text-skin-backend-text-base text-opacity-50">
                Configure your website’s general details, social media links, footer navigation, and upload your brand
                logo—all in one place.
            </p>
        </div>
        <!-- End Header -->

        <div class=" sm:grid grid-cols-12 text-skin-backend-text-base">
            {{-- nav --}}
            <div class="sidebar-nav-container col-span-12 w-full flex flex-wrap items-center">
                <button target='header' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-skin-hover text-sm relative before:absolute before:w-full before:h-[2px] before:bg-skin-backend-accent before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">Header</button>
                <button target='footer' type="button"
                    class="sidebar w-full sm:w-auto px-12 py-2 text-center text-sm relative before:absolute before:w-full before:h-[2px] before:bg-[#eaeaea] before:bg-opacity-25 before:bottom-0 before:left-0 hover:text-skin-hover hover:before:bg-skin-backend-accent transition-colors duration-300 before:transition-colors before:duration-300">Footer
                </button>

            </div>
            {{-- nav end --}}
            <div class="col-span-12 sm:p-3  pt-4 ">
                <div id='header' class="space-y-3  status">
                    <form action="{{ route('header.footer.setting.store') }}" method="post" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">Header Information</h2>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Header'" for="header" />

                                <x-backend.input-dropdown id="component" name="header" class="field" :values="getHeaderFooter()->get('header')"
                                    :label_name="'level'" :label_id="'value'" :placeholder="'Select one'"
                                    selected="{{ isset($data['setting']) ? $data['setting']->header_component : '' }}"
                                    required />
                                <div class="flex items-center gap-4 mt-4">
                                    <x-backend.input-checkbox :value="'fix'" :checked="isset($data['setting']) &&
                                        $data['setting']->header_component_position == 'fix'" :id="'fix'"
                                        :label="'Fixed Header'" name="position" />

                                    <x-backend.input-checkbox :value="'sticky'" :checked="isset($data['setting']) &&
                                        $data['setting']->header_component_position == 'sticky'" :id="'sticky'"
                                        :label="'Sticky Header'" name="position" />

                                </div>

                            </div>



                            <div class="col-span-12 mt-6 ">
                                <button type="button "
                                    class=" px-12 py-2.5 bg-skin-backend-accent text-skin-invert border border-highlight rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Submit
                                </button>
                            </div>


                        </div>

                    </form>
                </div>
                <div id='footer' class="space-y-3 hidden  status">
                    <form action="{{ route('header.footer.setting.store') }}" method="post" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-12 gap-4">
                            <h2 class="col-span-12 text-[18px] font-bold">Footer Information</h2>
                            <div class="col-span-12 md:col-span-6">
                                <x-backend.input-label :value="'Footer'" for="header" />

                                <x-backend.input-dropdown id="component" name="footer" class="field"
                                    selected="{{ isset($data['setting']) ? $data['setting']->footer_component : '' }}"
                                    :values="getHeaderFooter()->get('footer')" :label_name="'level'" :label_id="'value'" :placeholder="'Select one'"
                                    required />



                            </div>

                        </div>


                        <div class="col-span-12 mt-6 ">
                            <button type="button "
                                class=" px-12 py-2.5 bg-skin-backend-accent text-skin-invert border border-highlight rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">Submit
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <!-- End Card -->
    </div>

    @if ($message = Session::get('success'))
        <x-backend.flash-error :message="$message" :type="'success'" />
    @endif

</x-Deshboard-layout>


<script>
    $('input[name="position"]').on('change', function() {
        $('input[name="position"]').not(this).prop('checked', false);
    });

    $(document).on('click', '.sidebar', function() {
        let id = $(this).attr('target');

        $(this).closest('.sidebar-nav-container').find('.sidebar').removeClass(
            'text-skin-hover before:bg-skin-backend-accent').addClass(
            'before:bg-[#eaeaea] before:bg-opacity-25');
        $(this).addClass('text-skin-hover before:bg-skin-backend-accent').removeClass(
            'before:bg-[#eaeaea] before:bg-opacity-25');

        $('.status').hide();
        $('#' + id).show();

    })
</script>
