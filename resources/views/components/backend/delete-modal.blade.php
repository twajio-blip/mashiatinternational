{{-- Delete Modal --}}
<div id="hs-danger-alert"
class="hs-overlay hidden size-full fixed top-0 start-0 z-[1000] overflow-x-hidden overflow-y-auto" role="dialog"
tabindex="-1" aria-labelledby="hs-danger-alert-label">
<div
    class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
    <div
        class="relative flex flex-col bg-skin-backend-secondary text-skin-backend-text-base shadow-sm rounded-[10px] overflow-hidden">
        <div class="absolute top-2 end-2">
            <button type="button"
                class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent hover:bg-[#323232] focus:outline-none focus:bg-[#323232] disabled:opacity-50 disabled:pointer-events-none"
                aria-label="Close" data-hs-overlay="#hs-danger-alert">
                <span class="sr-only">Close</span>
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <div class="p-4 sm:p-10 overflow-y-auto">
            <div class="flex gap-x-4 md:gap-x-7">
                <!-- Icon -->
                <span
                    class="shrink-0 inline-flex justify-center items-center size-[46px] sm:w-[62px] sm:h-[62px] rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16"
                        height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                    </svg>
                </span>
                <!-- End Icon -->

                <div class="grow">
                    <h3 id="hs-danger-alert-label"
                        class="mb-2 text-xl font-bold">
                        Confirm Deletion
                    </h3>
                    <p class="">
                        Are you sure you want to delete this? This action cannot be undone
                    </p>
                </div>
            </div>
        </div>

        <div
            class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-default border-opacity-25">
            <button type="button"
                class="delete-button py-2 px-3 inline-flex items-center gap-x-2 text-sm font-bold rounded-[4px] bg-[#323232] shadow-sm hover:bg-opacity-90 transition-opacity disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-opacity-90"
                data-hs-overlay="#hs-danger-alert" delete-status="false">
                Cancel
            </button>
            <form action="" method="post" id="delete">
                @csrf
                @method('delete') 
                <button type="submit" class="delete-button py-2 px-3 inline-flex items-center gap-x-2 text-sm font-bold rounded-[4px] bg-red-500 shadow-sm hover:bg-opacity-90 transition-opacity disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-opacity-90"
                    delete-status="true">
                    Delete
                </button>
            </form>
            
        </div>
    </div>
</div>
</div>
{{-- Delete Modal --}}