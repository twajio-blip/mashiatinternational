<x-backend.model :id="'styling-model'" class="lg:max-w-fit " :button="'Submit'" :form_id="'commonent-style-form'" :action="''"
    :method="__('get')">
    @csrf
    <div class=" sm:p-2 grid grid-cols-12 overflow-y-auto space-y-2">
        <div class="col-span-2 pr-2">
            <div class="hs-accordion-group ">
                <div
                    class="hs-accordion active  hs-accordion-active:border-gray-200 bg-white border rounded-xl border-gray-500">
                    <button onclick="event.preventDefault()"
                        class="hs-accordion-toggle text-md hs-accordion-active:text-blue-600 inline-flex justify-between items-center gap-x-3 w-full font-semibold text-start text-gray-800 py-4 px-5 hover:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                        aria-expanded="false" aria-controls="hs-basic-active-bordered-collapse-one">
                        Positioning
                        <svg class="hs-accordion-active:hidden block size-3.5" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                        <svg class="hs-accordion-active:block hidden size-3.5" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                        </svg>
                    </button>
                    <div id="hs-basic-active-bordered-collapse-one"
                        class="dropdown-group hs-accordion-content  w-full overflow-hidden transition-[height] duration-300"
                        role="region" aria-labelledby="hs-active-bordered-heading-one">
                        {{-- text-align --}}
                        <div class="p-2 border-t">
                            {{-- Align Text --}}
                            <div
                                class="dropdown-trigger flex items-center justify-between text-sm bg-gray-100 border-b mb-1 px-4 py-2">
                                <p class="">Text Align</p>
                                <span class="dropdown-icon transition-transform duration-150"><i
                                        class="fa-solid fa-angle-down"></i></span>
                            </div>

                            <div class="dropdown hidden p-2">
                                <button
                                    class="p-2 apply-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='text-left'>
                                    <i class="fa-solid fa-align-left"></i>
                                </button>
                                <button
                                    class="p-2 apply-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='text-center'>
                                    <i class="fa-solid fa-align-center"></i>
                                </button>
                                <button
                                    class="p-2 apply-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='text-right'>
                                    <i class="fa-solid fa-align-right"></i>
                                </button>
                            </div>

                        </div>

                        {{-- Margin Align --}}
                        <div class="p-2 border-t">
                            <div
                                class="dropdown-trigger flex items-center justify-between text-sm bg-gray-100 border-b mb-1 px-4 py-2">
                                <p class="">Margin Align</p>
                                <span class="dropdown-icon transition-transform duration-150"><i
                                        class="fa-solid fa-angle-down"></i></span>
                            </div>

                            <div class="dropdown hidden p-2">
                                <div class="flex gap-2 flex-wrap">
                                    <div class="mr-auto">
                                        <button class="p-2 active-margin" property='m'>
                                            <div class="w-5 h-5 border-2 border-gray-500"></div>
                                        </button>

                                    </div>
                                    <div>
                                        <button class="p-2 active-margin" property='ml'>
                                            <div class="w-5 h-5 border border-l-2 border-gray-500"></div>
                                        </button>

                                    </div>
                                    <div>
                                        <button class="p-2 active-margin" property='mt'>
                                            <div class="w-5 h-5 border border-t-2 border-gray-500"></div>
                                        </button>

                                    </div>
                                    <div>
                                        <button class="p-2 active-margin" property='mr'>
                                            <div class="w-5 h-5 border border-r-2 border-gray-500"></div>
                                        </button>

                                    </div>
                                    <div>
                                        <button class="p-2 active-margin" property='mb'>
                                            <div class="w-5 h-5 border border-b-2 border-gray-500"></div>
                                        </button>

                                    </div>
                                </div>

                                <div class="mt-1 px-2 ">
                                    <input min="0" value="0" max="500" type="range"
                                        class="w-full apply-margin cursor-pointer appearance-none disabled:opacity-50 disabled:pointer-events-none focus:outline-none bg-gray-100 h-1"
                                        id="basic-range-slider-usage" aria-orientation="horizontal">
                                </div>

                                <input type="text" class="w-10 text-sm h-6 p-0 text-center m-value invisible"
                                    value="0"readonly>
                                <div class="relative w-full h-[150px]">
                                    <div class="absolute top-1/2 left-5 -translate-y-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center ml-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                    <div class="absolute top-0 left-1/2 -translate-x-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center mt-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>

                                    <span
                                        class="absolute text-blue-500 text-xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"><i
                                            class="fa-solid fa-link rotate-45"></i></span>

                                    <div class="absolute top-1/2 -translate-y-1/2 right-5">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center mr-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center mb-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                        {{-- Padding Align --}}
                        <div class="p-2 border-t z-50">
                            {{-- <p class="text-sm bg-gray-100 border-b mb-1 px-4 py-2">Padding Align</p> --}}
                            <div
                                class="dropdown-trigger flex items-center justify-between text-sm bg-gray-100 border-b mb-1 px-4 py-2">
                                <p class="">Padding Align</p>
                                <span class="dropdown-icon transition-transform duration-150"><i
                                        class="fa-solid fa-angle-down"></i></span>
                            </div>
                            <div class="dropdown hidden p-2">
                                <div class="flex gap-2 flex-wrap">
                                    <div class="mr-auto">
                                        <button class="p-2 active-padding" property='p'>
                                            <div class="w-5 h-5 border-2 border-gray-500"></div>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="p-2 active-padding" property='pl'>
                                            <div class="w-5 h-5 border border-l-2 border-gray-500"></div>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="p-2 active-padding" property='pr'>
                                            <div class="w-5 h-5 border border-r-2 border-gray-500"></div>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="p-2 active-padding" property='pt'>
                                            <div class="w-5 h-5 border border-t-2 border-gray-500"></div>
                                        </button>
                                    </div>
                                    <div>
                                        <button class="p-2 active-padding" property='pb'>
                                            <div class="w-5 h-5 border border-b-2 border-gray-500"></div>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-1 px-2">
                                    <input min="0" value="0" max="500" type="range"
                                        class="w-full h-1 apply-padding cursor-pointer appearance-none disabled:opacity-50 disabled:pointer-events-none focus:outline-none bg-gray-100 "
                                        id="basic-range-slider-usage" aria-orientation="horizontal">
                                </div>

                                <input type="text" class="w-10 text-sm h-6 p-0 text-center p-value invisible"
                                    value="0" readonly>
                                <div class="relative w-full h-[150px]">
                                    <div class="absolute top-1/2 left-5 -translate-y-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center pl-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                    <div class="absolute top-0 left-1/2 -translate-x-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center pt-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>

                                    <span
                                        class="absolute text-blue-500 text-xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"><i
                                            class="fa-solid fa-link rotate-45"></i></span>

                                    <div class="absolute top-1/2 -translate-y-1/2 right-5">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center pr-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2">
                                        <div class="relative">
                                            <input type="text"
                                                class=" w-14 text-sm h-11  p-0 pr-2 text-center pb-value rounded-md border border-gray-300"
                                                value="0" readonly>
                                            <span
                                                class="content-['Px'] absolute right-1 top-1/2 -translate-y-1/2 text-blue-500 text-xs">Px</span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- Content Center --}}

                        <div class="p-2 border-t">
                            {{-- Align Text --}}
                            <div
                                class="dropdown-trigger flex items-center justify-between text-sm bg-gray-100 border-b mb-1 px-4 py-2">
                                <p class="">Align Possition</p>
                                <span class="dropdown-icon transition-transform duration-150"><i
                                        class="fa-solid fa-angle-down"></i></span>
                            </div>
                            <div class="dropdown hidden p-2">
                                <button
                                    class="p-2 apply-posstion-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='left'>
                                    <i class="fa-solid fa-align-left"></i>
                                </button>
                                <button
                                    class="p-2 apply-posstion-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='center'>
                                    <i class="fa-solid fa-align-center"></i>
                                </button>
                                <button
                                    class="p-2 apply-posstion-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='right'>
                                    <i class="fa-solid fa-align-right"></i>
                                </button>
                                <button
                                    class="p-2 apply-posstion-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='move'>
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                                </button>
                                {{-- <button
                                    class="p-2 apply-posstion-style bg-gray-50 hover:bg-gray-100 transition-colors duration-300"
                                    property='reset'>
                                    <i class="fa-solid fa-rotate"></i>
                                </button> --}}
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    <!-- Right Content Section -->
    <div class="col-span-10 add-component bg-black ">
        <!-- Content here -->
    </div>
    </div>

</x-backend.model>
<script>
    $(document).ready(function() {
        let component_name = ''
        $(document).on('click', '.style-component', function(e) {
            e.preventDefault();
         
            let data = $(this).attr('data');
            $('form').attr('novalidate', 'novalidate');

            component_name = data;
            fetch('{{ route('load.style.component') }}', {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(), // CSRF token in headers
                    'Accept': 'text/html',
                },
                body: new URLSearchParams({
                    data: data
                }),
            }).then(function(response) {
                return response.text();
            }).then(function(html) {
                // Regular expression to find all 'class' attributes
                const classRegex = /class="([^"]*)"/g;


                const modifiedHtml = html.replace(classRegex, function(match, p1) {

                    if (!p1.includes('active-border')) {
                        return `class="${p1} active-border"`;
                    }
                    return match;
                });


                $('.add-component').html(modifiedHtml);



            }).catch(function(error) {
                console.error('There was a problem with the fetch operation:', error);
            });


        })

        $('.add-component').on('click', '*', function(event) {
            event.stopPropagation()
            event.preventDefault()
            $('.add-component .active-style-apply').removeClass('active-style-apply');
            $(this).addClass('active-style-apply')

        })

        $(document).on('click', '.apply-style', function(event) {
            event.preventDefault()
            let property = $(this).attr('property');
            $('.active-style-apply').removeClass(
                'text-left text-right text-center text-start text-end');
            $('.active-style-apply').addClass(property)
        })

        //Active Margin
        $(document).on('click', '.active-margin ', function(event) {
            event.preventDefault()
            $('.avtive-margin').find('div').removeClass('border-blue-500').addClass('border-gray-500');
            $('.avtive-margin').removeClass('avtive-margin');

            $(this).addClass('avtive-margin')
            $(this).find('div').addClass('border-blue-500').removeClass('border-gray-500');

        })

        //Apply Margin
        $(document).on('input', '.apply-margin ', function(event) {
            event.preventDefault()
            let value = $(this).val();
            let activedMargin = $('.avtive-margin').attr('property');


            if (activedMargin == 'ml') {
                $('.ml-value').val(value);
            } else if (activedMargin == 'mr') {
                $('.mr-value').val(value);

            } else if (activedMargin == 'mt') {
                $('.mt-value').val(value);

            } else if (activedMargin == 'mb') {
                $('.mb-value').val(value);
            } else {
                $('.m-value').val(value);
                $('.ml-value').val(value);
                $('.mb-value').val(value);
                $('.mt-value').val(value);
                $('.mr-value').val(value);
            }

            let mlNew = $('.ml-value').val();
            let mbNew = $('.mb-value').val();
            let mtNew = $('.mt-value').val();
            let mrNew = $('.mr-value').val();

            // Remove old margin using jQuery CSS method
            $('.active-style-apply').css({
                'margin-left': '', // Clear left margin
                'margin-right': '', // Clear right margin
                'margin-top': '', // Clear top margin
                'margin-bottom': '' // Clear bottom margin
            });

            $('.active-style-apply').css({
                'margin-left': `${mlNew}px`,
                'margin-right': `${mrNew}px`,
                'margin-top': `${mtNew}px`,
                'margin-bottom': `${mbNew}px`
            });

        })

        //Active padding
        $(document).on('click', '.active-padding ', function(event) {
            event.preventDefault()


            $('.avtive-padding').find('div').removeClass('border-blue-500').addClass('border-gray-500');
            $('.avtive-padding').removeClass('avtive-padding');

            $(this).addClass('avtive-padding')
            $(this).find('div').addClass('border-blue-500').removeClass('border-gray-500');


            // $('.avtive-padding').removeClass('avtive-padding  border border-gray-950');
            // $(this).addClass('avtive-padding border border-gray-950')

        })

        //Apply Margin
        $(document).on('input', '.apply-padding ', function(event) {
            event.preventDefault()
            let value = $(this).val();
            let paddingMargin = $('.avtive-padding').attr('property');


            if (paddingMargin == 'pl') {
                $('.pl-value').val(value);
            } else if (paddingMargin == 'pr') {
                $('.pr-value').val(value);

            } else if (paddingMargin == 'pt') {
                $('.pt-value').val(value);

            } else if (paddingMargin == 'pb') {
                $('.pb-value').val(value);
            } else {
                $('.p-value').val(value);
                $('.pl-value').val(value);
                $('.pb-value').val(value);
                $('.pt-value').val(value);
                $('.pr-value').val(value);
            }

            let plNew = $('.pl-value').val();
            let pbNew = $('.pb-value').val();
            let ptNew = $('.pt-value').val();
            let prNew = $('.pr-value').val();

            // Remove old margin using jQuery CSS method
            $('.active-style-apply').css({
                'padding-left': '', // Clear left padding
                'padding-right': '', // Clear right padding
                'padding-top': '', // Clear top padding
                'padding-bottom': '' // Clear bottom padding
            });

            $('.active-style-apply').css({
                'padding-left': `${plNew}px`,
                'padding-right': `${prNew}px`,
                'padding-top': `${ptNew}px`,
                'padding-bottom': `${pbNew}px`
            });


        })

        function flexCol(data) {

            if (data === 'left' || data === 'center' || data === 'right') {
                $('.active-style-apply')
                    .addClass('!flex !flex-col') // Ensure flex and flex-col are always applied
                    .removeClass('!items-start !items-center !items-end') // Reset existing alignment classes
                    .toggleClass(data === 'left' ? '!items-start' : data === 'center' ? '!items-center' :
                        '!items-end');
            }

        }

        function flexRow(data) {
            if (data === 'left' || data === 'center' || data === 'right') {
                $('.active-style-apply')
                    .addClass('!flex !flex-row') // Ensure flex and flex-row are always applied
                    .removeClass(
                        '!justify-start !justify-center !justify-end') // Reset existing justification classes
                    .toggleClass(data === 'left' ? '!justify-start' : data === 'center' ? '!justify-center' :
                        '!justify-end');
            }

        }

        function float(data) {
            if (data === 'left' || data === 'center' || data === 'right') {

                if (data === 'left') {
                    $('.active-style-apply')
                        .removeClass('mx-auto justify-center')
                        .addClass('mr-auto');
                } else if (data === 'right') {
                    $('.active-style-apply')
                        .removeClass('mx-auto  justify-center')
                        .addClass('ml-auto');
                } else if (data === 'center') {
                    $('.active-style-apply')
                        .removeClass('ml-auto mr-auto')
                        .addClass('mx-auto justify-center');
                }
            }
        }

        //Apply Align Content 
        $(document).on('click', '.apply-posstion-style', function(event) {
            event.preventDefault()
            let data = $(this).attr('property');

            if (data == 'move') {
                if ($('.active-style-apply').hasClass('flex')) {
                    $('.active-style-apply').toggleClass('!flex !flex-row-reverse ');
                } else {
                    $('.active-style-apply').toggleClass(' scale-x-[-1]');

                }

                return false;
            }


            if (data == 'reset') {
                $('.active-style-apply').removeClass(
                    '!flex !flex-row-reverse scale-x-[-1] !flex-col !float-left  !justify-start !justify-center !justify-end  !flex-row ml-auto mr-auto mx-auto'
                );
                return false;

            }


            // Check if the div has the flex class
            if ($('.active-style-apply').hasClass('flex')) {
                // Check if it also has the 'flex-col' class
                if ($('.active-style-apply').hasClass('flex-col')) {
                    float(data)
                }
                // Check if it has the 'flex-row' class
                else if ($('.active-style-apply').hasClass('flex')) {
                    float(data)
                } else {
                    float(data)
                }

            } else {

                if ($('.active-style-apply').children().length > 0) {
                    float(data)
                } else {
                    float(data)
                }

            }
        })
        //Apply Align Content 
        $(document).on('submit', '#commonent-style-form', function(event) {
            event.preventDefault()


            $('.active-style-apply').removeClass('active-style-apply ');
            $('.active-border').removeClass('active-border');
            let html = $('.add-component').html();
            fetch('{{ route('load.style.component.store') }}', {
                method: "POST",
                credentials: "same-origin", // Ensures cookies like CSRF are sent
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(), // CSRF token in headers
                    'Accept': 'text/html', // Expecting HTML as the response
                },
                body: new URLSearchParams({
                    data: html,
                    component: component_name
                }),
            }).then(function(response) {
                return response.text();
            }).then(function(json) {

                $('.styling-model').click();

                // $('.add-component').html(json)
 

            })


        })







    });
</script>
