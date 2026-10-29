@extends('layouts.blank')

@section('content')
<div class=" flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
    <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
        <div>
            <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("2")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("3")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("4")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("5")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("6")}}</span></li>
                <li><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("7")}}</span></li>
            </ul>
        </div>
        <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
            <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-white">
                <h2 class="text-xl font-semibold">{{("Import SQL")}}</h2>
            </div>
            <div class="space-y-8 py-6 px-10">
                <p class="text-sm text-gray-400"><strong class="text-green-700">{{("Your database is successfully connected")}}</strong>. {{("All you need to do now is")}}
                    <strong>{{("hit the 'Import SQL' button")}}</strong>.
                    {{("The auto installer will run a sql file, will do all the tiresome works and set up your
                    application automatically")}}.</p>
                <a href="{{ route('import_sql') }}" onclick="showLoder()" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                    <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                    </div>
                   {{("Import SQL")}}
                </a>
                <div id="loader" style="margin-top: 20px; display:none;" class="flex items-center justify-center">
                    {{-- <img loading="lazy" src="{{ asset('loader.gif') }}" alt="" width="20">
                    &nbsp; Importing database .... --}}
                    
                    {{-- Tailwind spinner --}}
                    <div role="status">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">{{("Loading")}}...</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>




    {{-- <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mar-ver pad-btm text-center">
                            <img src="{{ static_asset('assets/img/logo.png') }}" class="mb-4">
                            <h2 class="h3">Import SQL</h2>
                        </div>
                        <p class="text-muted font-13 text-center">
                            <strong>Your database is successfully connected</strong>. All you need to do now is
                            <strong>hit the 'Import SQL' button</strong>.
                            The auto installer will run a sql file, will do all the tiresome works and set up your
                            application automatically.
                        </p>
                        <div class="text-center mar-top pad-top">
                            <a href="{{ route('import_sql') }}" class="btn btn-primary" onclick="showLoder()">Import
                                SQL</a>
                            <div id="loader" style="margin-top: 20px; display: none;">
                                <img loading="lazy" src="{{ asset('loader.gif') }}" alt="" width="20">
                                &nbsp; Importing database ....
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script type="text/javascript">
        function showLoder() {
            $('#loader').fadeIn();
        }
    </script>
@endsection
