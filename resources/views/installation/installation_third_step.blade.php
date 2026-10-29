@extends('layouts.blank')

@section('content')

<div class=" flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
    <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
        <div>
            <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("2")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("3")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("4")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("5")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("6")}}</span></li>
                <li><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("7")}}</span></li>
            </ul>
        </div>
        <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
            <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-white">
                <h2 class="text-xl font-semibold">{{("Purchase Code")}}</h2>
            </div>
            <div class="border-b py-4 px-4">
                <p class="text-sm text-gray-400">{{("Provide your codecanyon purchase code")}}.<br>
                    <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code"
                        target="_blank" class="text-[#b1a60a]">{{("Where to get purchase code")}}?</a></p>
            </div>
            <div class="space-y-8 py-6 px-10">
                <form method="POST" action="{{ route('purchase.code') }}" class="grid grid-cols-12 gap-4 text-start py-4 px-4">
                    @csrf
                    <div class="col-span-12 md:col-span-6 text-gray-400 text-sm">
                        <label for="purchase_code" class="text-sm font-medium">{{("Purchase Code")}}</label>
                        <input type="text" class="w-full px-4 py-2 text-sm border border-gray-100 border-opacity-[0.06] rounded-md bg-skin-content bg-opacity-[0.06]" id="purchase_code" name="purchase_code"
                            placeholder="**** **** **** ****" required="">
                    </div>
                    <div class="text-center col-span-12">
                        <button type="submit" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                            <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                            </div>
                            {{("Continue")}}
                        </button>
                    </div>
                </form>
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
                            <h2 class="h3">Purchase Code</h2>
                            <p>
                                Provide your codecanyon purchase code.<br>
                                <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code"
                                    target="_blank" >Where to get purchase code?</a>
                            </p>
                        </div>
                        <p class="text-muted font-13">
                        <form method="POST" action="{{ route('purchase.code') }}">
                            @csrf
                            <div class="form-group">
                                <label for="purchase_code">Purchase Code</label>
                                <input type="text" class="form-control" id="purchase_code" name="purchase_code"
                                    placeholder="**** **** **** ****" required="">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Continue</button>
                            </div>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
