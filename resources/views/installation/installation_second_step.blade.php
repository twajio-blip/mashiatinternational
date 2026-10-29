@extends('layouts.blank')

@section('content')
    <div class="flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
        <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
            <div>
                <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                    <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("2")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("3")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("4")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("5")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("6")}}</span></li>
                    <li><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("7")}}</span></li>
                </ul>
            </div>
            <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
                <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-skin-base">
                    {{-- <img src="{{ static_asset('assets/img/logo.png') }}" class="mb-4"> --}}
                    <h2 class="text-xl font-semibold">{{("Checking file permissions")}}</h2>
                </div>
                <div class="border-b py-4 px-4">
                    <p class="text-xs text-gray-400">We ran diagnosis on your server. Review the items that have a red mark on it. <br> If
                        everything is green, you are good to go to the next step.</p>
                </div>

                <ul class="grid grid-cols-12 gap-4 text-start px-4 py-6">
                    <li class="col-span-12 md:col-span-6 text-gray-700 text-sm">
                        @php
                            $phpVersion = number_format((float) phpversion(), 2, '.', '');
                        @endphp
                        @if ($phpVersion >= 8.0)
                            <div class="w-full bg-[#a2e69c] px-3 py-1.5">
                                <span class="text-[#3d7c38]"><i class="fa-regular fa-square-check "></i></span>
                               {{("Php version 8.0 +")}}
                            </div>
                            
                        @else
                            <div class="w-full bg-red-200 px-3 py-1.5">
                                <span class="text-red-600"><i class="fa-regular fa-rectangle-xmark"></i></span>
                                {{("Php version 8.0 +")}}
                            </div>
                        @endif
                    </li>

                    <li class="col-span-12 md:col-span-6 text-gray-700 text-sm">
                        @if ($data['curl_enabled'])
                        <div class="w-full bg-[#a2e69c] px-3 py-1.5">
                            <span class="text-[#3d7c38]"><i class="fa-regular fa-square-check "></i></span>
                                {{("Curl Enabled")}}
                            </div>
                        @else
                            <div class="w-full bg-red-200 px-3 py-1.5">
                                <span class="text-red-600"><i class="fa-regular fa-rectangle-xmark"></i></span>
                                {{("Curl Enabled")}}
                            </div>
                        @endif
                    </li>

                    <li class="col-span-12 md:col-span-6 text-gray-700 text-sm">
                        @if ($data['db_file_write_perm'])
                        <div class="w-full bg-[#a2e69c] px-3 py-1.5">
                            <span class="text-[#3d7c38]"><i class="fa-regular fa-square-check "></i></span>
                                <b>{{(".env")}}</b> {{("File Permission")}}
                            </div>
                        @else
                            <div class="w-full bg-red-200 px-3 py-1.5">
                                <span class="text-red-600"><i class="fa-regular fa-rectangle-xmark"></i></span>
                                <b>{{(".env")}}</b> {{("File Permission")}}
                            </div>
                        @endif
                    </li>

                    <li class="col-span-12 md:col-span-6 text-gray-700 text-sm">

                        @if ($data['routes_file_write_perm'])
                        <div class="w-full bg-[#a2e69c] px-3 py-1.5">
                            <span class="text-[#3d7c38]"><i class="fa-regular fa-square-check "></i></span>
                                <b>RouteServiceProvider.php</b> {{("File Permission")}}
                            </div>
                        @else
                            <div class="w-full bg-red-200 px-3 py-1.5">
                                <span class="text-red-600"><i class="fa-regular fa-rectangle-xmark"></i></span>
                                <b>RouteServiceProvider.php</b> {{("File Permission")}}
                            </div>
                        @endif
                    </li>
                </ul>

                <div class="pb-6">
                    @if ($data['curl_enabled'] == 1 && $data['db_file_write_perm'] == 1 && $data['routes_file_write_perm'] == 1 && $phpVersion >= 8.0)
                        @if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1' )
                        <div class="">
                            <a href="{{ route('step3') }}" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                                <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                                </div>
                               {{("Go To Next Step")}}
                            </a>
                        </div>
                            {{-- <a href="{{ route('step3') }}" class="btn btn-primary">Go To Next Step</a> --}}
                        @else
                            <a href="{{ route('step2') }}" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                                <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                                </div>
                                {{("Go To Next Step")}}
                            </a>
                            {{-- <a href="{{ route('step2') }}" class="btn btn-primary">Go To Next Step</a> --}}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
