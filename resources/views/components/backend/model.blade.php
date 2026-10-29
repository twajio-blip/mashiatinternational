@props(['id', 'title', 'button', 'form_id', 'action', 'method'])

<div id="{{ $id }}"
    class='hs-overlay hidden w-full h-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto'>
    <div {{ $attributes->merge(['class' => 'hs-overlay-open:mt-7 hs-overlay-open:opacity-100
        hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto']) }}>
        <form action="{{ $action }}" method="{{ $method }}" id="{{ $form_id }}" enctype="multipart/form-data">
            <div
                class="relative flex flex-col bg-skin-backend-secondary text-skin-backend-text-base rounded-[10px] overflow-hidden">
                <div class="h-[73px] bg-[#323232] flex items-center justify-between px-6">
                    <h2 class="text-[18px] font-bold">{{$title??''}}</h2>
                    <button type="button"
                        class="flex justify-center items-center p-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-skin-backend-secondary disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-overlay="#{{ $id }}">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
                {{ $slot }}
                <div class="flex justify-end items-center gap-x-2 pt-3 pb-10 px-4">
                    <button type="button"
                        class="cancle {{ $id }} px-12 py-3 text-skin-hover border border-highlight rounded-[10px] hover:bg-skin-backend-accent hover:text-skin-invert transition-colors font-semibold text-xs disabled:opacity-50 disabled:pointer-events-none"
                        data-hs-overlay="#{{ $id }}">
                        Cancel
                    </button>
                    @if ($button)
                    <button type="submit"
                        class="px-12 py-3 submit bg-skin-backend-accent text-skin-invert  rounded-[10px] hover:bg-opacity-90 transition-opacity text-xs disabled:opacity-50 font-semibold disabled:pointer-events-none">
                        {{ $button }}
                    </button>
                    <button disabled type="button"
                        class="bg-skin-backend-accent loader text-skin-invert  font-medium rounded-[10px]  text-xs px-7 py-3 text-center me-2 inline-flex items-center hidden">
                        <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-skin-invert  animate-spin"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#D3D3D3" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor" />
                        </svg>
                        Loading... </button>
                    @endif

                </div>
            </div>
        </form>
    </div>
</div>