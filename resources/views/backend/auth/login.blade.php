<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CMS</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- javascript file -->
    @yield('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="background-image: url({{ asset('bg_image/login.png') }});" class="bg-no-repeat w-full bg-cover bg-center min-h-screen">
    <main class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md mx-auto p-4  sm:p-6">
        <div style="background-image: url({{ asset('bg_image/login_frame.png') }});"
            class="mt-7 bg-skin-backend-primary border border-highlight rounded-[20px] shadow-xl bg-no-repeat w-full bg-cover bg-center">
            <div class="px-4 py-8 sm:p-12 text-center">
                <!-- Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="space-y-8">

                        {{-- Heading --}}
                        <div class="space-y-1">
                            <h2 class="flex items-center justify-center gap-2 text-[20px] font-bold">
                                <span>
                                    <img src="{{ asset('logo/ball.png') }}" alt="logo">
                                </span>
                                <span class="text-skin-hover">
                                    {{ $general->website_name ?? config('app.name', 'CMS') }}
                                </span>
                            </h2>
                            <h1 class="font-bold text-[24px] text-skin-backend-text-base">Welcome Back</h1>
                            <p class="text-[14px] text-skin-backend-text-base">Please enter your details to sign in</p>
                        </div>
                        {{-- End Heading --}}

                        <!-- Form Group -->
                        <div class="space-y-6 text-start">
                            {{-- Email --}}
                            <div class="space-y-2">
                                <x-backend.input-field type="email" name='email' id="email" :value="old('email')"
                                    class="bg-skin-backend-secondary border-1 border-opacity-50 bg-opacity-50 rounded-[4px] text-skin-backend-text-base text-opacity-50 focus:outline-none focus:ring-0 focus:border-highlight"
                                    required placeholder="Enter Email Address" />
                                @if ($errors->first('email'))
                                    <x-backend.input-error :message="$errors->first('email')" />
                                @endif
                            </div>
                            {{-- Password --}}
                            <div class="space-y-2">
                                <x-backend.input-field type="password" name='password' id="password" :value="old('password')"
                                    class="bg-skin-backend-secondary border-1 border-opacity-50 bg-opacity-50 rounded-[4px] text-skin-backend-text-base text-opacity-50 focus:outline-none focus:ring-0 focus:border-highlight"
                                    placeholder="Enter Password" />
                                    @if ($errors->first('password'))
                                        <x-backend.input-error :message="$errors->first('password')" />
                                    @endif
                            </div>  
                        </div>
                        <!-- End Form Group -->

                        <!-- Checkbox -->
                        <div class="flex justify-center md:justify-between gap-4 items-center flex-wrap">
                            <div class="flex items-center">
                                <div class="flex">
                                    <x-backend.input-checkbox id="remember-me" name="remember-me" type="checkbox"
                                        class="focus:ring-0 focus:outline-none focus:ring-inherit bg-skin-backend-secondary" />
                                </div>
                                <div>
                                    <x-backend.input-label 
                                  for="remember-me"
                                    class="text-sm !mb-0 text-skin-backend-text-base text-opacity-50"
                                    :value="__('Remember me')" 
                                    />
                                </div>
                            </div>
                            {{-- <a class="text-sm text-skin-backend-text-base text-opacity-50 decoration-2 hover:text-skin-hover transition-colors duraiton-300 font-medium inline-block mb-2 underline underline-offset-4"
                                href="#">Forgot password?</a> --}}

                        </div>

                        <!-- End Checkbox -->
                        <x-backend.button type="submit"
                            class="w-full bg-skin-backend-accent bg-opacity-100 text-skin-invert px-4 py-2.5 font-bold hover:bg-opacity-90 transition-opacity duration-300"
                            :value="__('Sign in')" />

                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </main>

</body>



</html>




</html>
