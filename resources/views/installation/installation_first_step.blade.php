@extends('layouts.blank')

@section('content')

    <div class="flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
        <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
            <div>
                <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("2")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("3")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("4")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("5")}}</span></li>
                    <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("6")}}</span></li>
                    <li><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("7")}}</span></li>
                </ul>
            </div>
            <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
                <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-skin-base">
                    <h2 class="text-xl font-semibold">{{("WELCOME TO DATADSS")}}</h2>
                </div>
                <div class="space-y-8 py-6 px-10">
                    <p class="text-sm text-gray-400">{{("Welcome to the DDSSCMS Installation Wizard: Your first step towards creating and managing stunning websites with ease.")}}</p>
                    <a href="{{ route('step1') }}" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                        <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                        </div>
                        {{("Start Installation Process")}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
