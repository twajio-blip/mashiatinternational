@props(['message', 'type'])
<div id="dismiss-alert"
    class=" absolute top-5 right-5 hs-removing:translate-x-5 hs-removing:opacity-0 transition duration-300  {{$type=='success' ? 'bg-teal-50 border-teal-200' : 'bg-red-200 border-red-200'}} border  text-sm text-teal-800 rounded-lg p-4"
    role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fa-regular fa-circle-check"></i>

        </div>
        <div class="ms-2">
            <div class="text-sm font-medium pr-5">
                {{ $message }}
            </div>
        </div>
        <div class="ps-3 ms-auto">
            <div class="-mx-1.5 -my-1.5">
                <button type="button"
                    class="inline-flex remove bg-teal-50 rounded-lg p-1.5 {{$type=='success' ? 'text-teal-500 focus:ring-teal-600 focus:ring-offset-teal-50 hover:bg-teal-100' : 'text-red-500 focus:ring-red-600 focus:ring-offset-red-50 hover:bg-red-100'}}  focus:outline-none focus:ring-2 focus:ring-offset-2 "
                    data-hs-remove-element="#dismiss-alert">
                    <span class="sr-only">Dismiss</span>
                    <svg class="flex-shrink-0 h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(() => {
        $('.remove').trigger('click')
    }, 3000);
</script>
