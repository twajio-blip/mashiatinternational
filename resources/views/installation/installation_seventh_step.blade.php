@extends('layouts.blank')

@section('content')
<div class="flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
    <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
        <div>
            <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("2")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("3")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("4")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("5")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("6")}}</span></li>
                <li><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("7")}}</span></li>
            </ul>
        </div>
        <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
            <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-skin-base">
                {{-- <img src="{{ static_asset('assets/img/logo.png') }}" class="mb-4"> --}}
                <h2 class="text-2xl font-semibold">{{("Congratulations")}}!!!</h2>
            </div>
            <div class="border-b py-4 px-4">
                <p class="text-xs text-gray-400">{{("You have successfully completed the installation process. Please")}} <strong>{{("Login")}}</strong> {{("to continue")}}.</p>
                <p class="text-xs text-gray-400"><strong>{{("Configure the following setting to run the system properly")}}.</strong></p>
            </div>

            <ul class="grid grid-cols-12 gap-4 text-start py-4 px-4">
                <li class="col-span-12 md:col-span-6 text-[#543A14] text-sm bg-[#FFF0DC] px-3 py-1.5">
                    <i class="fa-solid fa-gear"></i>
                    {{("SMTP Setting")}}
                </li>

                <li class="col-span-12 md:col-span-6 text-[#543A14] text-sm bg-[#FFF0DC] px-3 py-1.5">
                    <i class="fa-solid fa-gear"></i>
                    {{("Payment Method Configuration")}}
                </li>

                <li class="col-span-12 md:col-span-6 text-[#543A14] text-sm bg-[#FFF0DC] px-3 py-1.5">
                    <i class="fa-solid fa-gear"></i>
                    {{("Social Media Login Configuration")}}
                </li>
                
                <li class="text-center col-span-12 mt-7">
                    <div class="flex items-center gap-2 justify-center">
                        <div>
                            <a href="{{ env('APP_URL') }}" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                                <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                                </div>
                                {{("Go to Frontend Website")}}
                            </a>
                        </div>
                        <div>
                            <a href="{{ env('APP_URL') }}admin/login" class="group relative bg-gradient-to-r from-[#7e3b5a] to-[#bb684a] px-10 py-3 block w-fit mx-auto rounded-md text-white font-semibold text-xs z-[1]">
                                <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#bb684a] to-[#7e3b5a] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                                </div>
                                {{("Login to Admin panel")}}
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


    {{-- <div class="container h-100 d-flex flex-column justify-content-center">
        <div class="row">
            <div class="col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="{{ static_asset('assets/img/logo.png') }}" class="mb-4">
                            <h2 class="h3">Congratulations!!!</h2>
                            <p>You have successfully completed the installation process. Please Login to continue.</p>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="fs-16 mb-0 card-title">
                                    Configure the following setting to run the system properly.
                                </h3>
                            </div>
                            <div class="card-body">
                                <ul class="">
                                    <li class="">SMTP Setting</li>
                                    <li class="">Payment Method Configuration</li>
                                    <li class="">Social Media Login Configuration</li>
                                </ul>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ env('APP_URL') }}" class="btn btn-primary">Go to Frontend Website</a>
                            <a href="{{ env('APP_URL') }}/admin" class="btn btn-success">Login to Admin panel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
