@extends('layouts.blank')

@section('content')



<div class="flex flex-col items-center w-screen h-screen text-center bg-gradient-to-r from-[#1d1d1d] via-[#111] to-[#111000]">
    <div class="2xl:container 2xl:mx-auto w-full px-4 sm:w-[60%] mx-auto space-y-2">
        <div>
            <ul class="flex items-center py-10 px-4 sm:px-20 text-sm">
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("1")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("2")}}</span></li>
                <li class="flex-1 relative after:bg-skin-secondary after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("3")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1 "><span class="w-6 h-6 rounded-full bg-skin-secondary text-skin-title flex items-center justify-center">{{("4")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("5")}}</span></li>
                <li class="flex-1 relative after:bg-skin-content after:bg-opacity-[0.06] after:absolute after:top-1/2 after:left-6 after:-translate-y-1/2 after:w-[calc(100%-24px)] after:h-1"><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("6")}}</span></li>
                <li><span class="w-6 h-6 rounded-full bg-skin-content bg-opacity-[0.06] text-skin-base flex items-center justify-center">{{("7")}}</span></li>
            </ul>
        </div>
        <div class="rounded-xl bg-skin-content bg-opacity-[0.06] overflow-hidden shadow-md">
            <div class="bg-gradient-to-r from-[#504b0b] to-[#b1a60a] py-6 text-white">
                <h2 class="text-2xl font-semibold">{{("Database setup")}}</h2>
                            <p class="text-sm">{{("Fill this form with valid database credentials")}}</p>
            </div>
            {{-- <div class="border-b py-4 px-4">
                <p class="text-xs text-gray-500"><strong>{{("Invalid Database Credentials")}}!! </strong>{{("Please check your database")}}
                    {{("credentials carefully")}}</p>
            </div> --}}

            <form method="POST" action="{{ route('install.db') }}" class="grid grid-cols-12 gap-4 text-start py-4 px-4">
                @csrf
                <div class="col-span-12 md:col-span-6 text-gray-400 text-sm">
                    <label for="db_host" class="text-sm font-medium">{{("Database Host")}}</label>
                                <input type="text" value="{{old('DB_HOST')}}" class="w-full px-4 py-2 text-sm border border-gray-400 border-opacity-[0.06] bg-skin-content bg-opacity-[0.06] rounded-md focus:ring-yellow-400 focus:outline-none focus:border-transparent" id="db_host" name="DB_HOST" required
                                    autocomplete="off" placeholder="example.com">
                                <input type="hidden" name="types[]" value="DB_HOST">
                                @if ($errors->has('DB_HOST'))
                              
                                <small class="text-red-500">{{$errors->first('DB_HOST')}} </small>
                                @endif
                               
                </div>

                <div class="col-span-12 md:col-span-6 text-gray-400 text-sm">
                    <label for="db_name" class="text-sm font-medium">{{("Database Name")}}</label>
                                <input type="text" value="{{old('DB_DATABASE')}}" class="w-full px-4 py-2 text-sm border border-gray-400 border-opacity-[0.06] bg-skin-content bg-opacity-[0.06] rounded-md focus:ring-yellow-400 focus:outline-none focus:border-transparent" id="db_name" name="DB_DATABASE" required
                                    autocomplete="off" placeholder="my_database">
                                <input type="hidden" name="types[]" value="DB_DATABASE">
                                @if ($errors->has('DB_DATABASE'))
                              
                                <small class="text-red-500">{{$errors->first('DB_DATABASE')}} </small>
                                @endif
                </div>

                <div class="col-span-12 md:col-span-6 text-gray-400 text-sm">
                    <label for="db_user" class="text-sm font-medium">{{("Database Username")}}</label>
                                <input type="text" value="{{old('DB_USERNAME')}}" class="w-full px-4 py-2 text-sm border border-gray-400 border-opacity-[0.06] bg-skin-content bg-opacity-[0.06] rounded-md focus:ring-yellow-400 focus:outline-none focus:border-transparent" id="db_user" name="DB_USERNAME" required
                                    autocomplete="off" placeholder="my_username">
                                <input type="hidden" name="types[]" value="DB_USERNAME">
                                @if ($errors->has('DB_USERNAME'))
                              
                                <small class="text-red-500">{{$errors->first('DB_USERNAME')}} </small>
                                @endif
                </div>

                <div class="col-span-12 md:col-span-6 text-gray-400 text-sm">
                    <label for="db_pass" class="text-sm font-medium">{{("Database Password")}}</label>
                                <input value="{{old('password')}}" type="password" class="w-full px-4 py-2 text-sm border border-gray-400 border-opacity-[0.06] bg-skin-content bg-opacity-[0.06] rounded-md focus:ring-yellow-400 focus:outline-none focus:border-transparent" id="db_pass" name="DB_PASSWORD"
                                    autocomplete="off" placeholder="Password">
                                <input type="hidden" name="types[]" value="DB_PASSWORD">
                                @if ($errors->has('DB_PASSWORD'))
                              
                                <small class="text-red-500">{{$errors->first('DB_PASSWORD')}} </small>
                                @endif
                </div>
                <div class="text-center col-span-12">
                    <button type="submit" class="group relative bg-gradient-to-r from-[#504b0b] to-[#c7bb1a] px-10 py-3 block w-fit mx-auto rounded-md text-skin-base font-semibold text-xs z-[1]">
                        <div class="absolute left-0 top-0 rounded-md opacity-0 w-full h-full bg-gradient-to-r from-[#c7bb1a] to-[#504b0b] group-hover:opacity-100 transition-opacity duration-1000 -z-[1]">
                        </div>
                        {{ ("Continue")}}
                    </button>
                </div>
            </form>
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
                            <h2 class="h3">Database setup</h2>
                            <p>Fill this form with valid database credentials</p>
                        </div>

                        @if (isset($error))
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <strong>Invalid Database Credentials!! </strong>Please check your database
                                        credentials carefully
                                    </div>
                                </div>
                            </div>
                        @endif

                        <p class="text-muted font-13">
                        <form method="POST" action="{{ route('install.db') }}">
                            @csrf
                            <div class="form-group">
                                <label for="db_host">Database Host</label>
                                <input type="text" class="form-control" id="db_host" name="DB_HOST" required
                                    autocomplete="off">
                                <input type="hidden" name="types[]" value="DB_HOST">
                            </div>
                            <div class="form-group">
                                <label for="db_name">Database Name</label>
                                <input type="text" class="form-control" id="db_name" name="DB_DATABASE" required
                                    autocomplete="off">
                                <input type="hidden" name="types[]" value="DB_DATABASE">
                            </div>
                            <div class="form-group">
                                <label for="db_user">Database Username</label>
                                <input type="text" class="form-control" id="db_user" name="DB_USERNAME" required
                                    autocomplete="off">
                                <input type="hidden" name="types[]" value="DB_USERNAME">
                            </div>
                            <div class="form-group">
                                <label for="db_pass">Database Password</label>
                                <input type="password" class="form-control" id="db_pass" name="DB_PASSWORD"
                                    autocomplete="off">
                                <input type="hidden" name="types[]" value="DB_PASSWORD">
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
