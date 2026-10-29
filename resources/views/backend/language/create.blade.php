@extends('backend.admin.layouts.app')

@section('content')
    <!-- content header -->
    <section class="content-header flex justify-between sm:px-3 md:px-section md:py-4">
        <div>
            <h2 class="text-skin-header font-medium"><a
                    href="{{ route('admin.dashboard') }}">{{ translation('Dashboard') }}</a> / <a
                    href="{{ route('admin.language.index') }}">{{ translation('Language Setup') }}</a></h2>
        </div>
    </section>
    <section class="space-y-4 2xl:container 2xl:mx-auto">
        <section class="md:mx-section space-y-4 px-4 py-5 rounded-md  duration-500 ">

            <form action="{{ route('admin.language.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- coupon Settup -->
                <div class="rounded-md border shadow-md bg-skin-backend-content">
                    <!-- coupon setup haeder -->
                    <div>
                        <h1 class="font-semibold w-full py-3 px-4 border-b text-sm text-skin-backend-heading"><i class="fa-regular fa-comment-dots"></i>
                            {{ translation('Language Setup') }}</h1>
                    </div>
                    <!-- coupon setup body -->
                    <div class="flex-1 px-4 space-y-2 text-skin-backend-base mt-2">
                        <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                            <div>
                                <label for="language-name" class="text-medium text-skin-header">{{translation("Language Name")}}</label>
                                <input type="text" id="language-name" required name="name"
                                    class="w-full rounded-md bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                                    placeholder="language Name">
                            </div>
                        </div>
                        <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                            <div>
                                <label for="language-code" class="text-medium text-skin-header">{{translation("Language Code")}}</label>
                                <input type="text" id="language-code" required name="code"
                                    class="w-full rounded-md bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                                    placeholder="language code">
                            </div>
                        </div>
                        <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                            <div>
                                <label for="is_rtl" class="text-medium text-skin-header">{{translation("Is RTL")}}</label>
                                <select name="is_rtl" id=""
                                    class="ddss-select-with-search form-group focus:border:gray-400 border-gray-300 focus:outline-none focus:ring-0 rounded-md w-full">
                                    <option value="0">{{translation("No")}}</option>
                                    <option value="1">{{translation("Yes")}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex justify-end gap-2 p-4">
                        <a href="{{ route('admin.language.index') }}"
                            class="px-4 py-2 bg-skin-backend-highlight bg-opacity-80 text-skin-backend-heading font-medium rounded-md text-sm hover:bg-opacity-100 transition-colors">{{ translation('Back') }}</a>
                        <button type="submit"
                            class="px-4 py-2 bg-skin-backend-button text-white font-medium rounded-md text-sm hover:bg-skin-backend-button-hover transition-colors">{{ translation('Submit') }}</button>
                    </div>
                </div>
            </form>
        </section>

    </section>
    {{-- <section class="space-y-4">
        <section class="md:mx-section space-y-4 px-4 py-5 rounded-md  duration-500 ">
            <form action="{{ route('admin.language.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rounded-md border shadow-md">
                    <!-- language setup body -->
                    <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                        <div>
                            <label for="language-name"
                                class="text-medium text-skin-header">{{ translation('Language Name') }}</label>
                            <input type="text" id="language-name" required name="name"
                                class="w-full rounded-md bg-skin-backend-highlight border border-gray-200 focus:border-gray-200 focus:ring-0"
                                placeholder="language Name">
                        </div>
                    </div>
                    <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                        <div>
                            <label for="language-code"
                                class="text-medium text-skin-header">{{ translation('Language Code') }}</label>
                            <input type="text" id="language-code" required name="code"
                                class="w-full rounded-md border border-gray-200 focus:border-gray-200 focus:ring-0"
                                placeholder="language code">
                        </div>
                    </div>
                    <div class="flex-1 px-4 space-y-2 text-skin-base w-1/2 mt-2">
                        <div>
                            <label for="is_rtl" class="text-medium text-skin-header">{{ translation('Is RTL') }}</label>
                            <select name="is_rtl" id=""
                                class="ddss-select-with-search form-group focus:border:gray-400 border-gray-300 focus:outline-none focus:ring-0 rounded-md w-full">
                                <option value="0">{{ translation('No') }}</option>
                                <option value="1">{{ translation('Yes') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-end gap-2">
                        <a href="{{ route('admin.language.index') }}"
                            class="px-4 py-2 bg-gray-100 text-skin-header font-medium rounded-md text-sm hover:bg-gray-200 transition-colors">{{ translation('Back') }}</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md text-sm hover:bg-skin-button transition-colors">{{ translation('Submit') }}</button>
                    </div>
                </div>
            </form>
            
        </section>

    </section> --}}
@endsection
