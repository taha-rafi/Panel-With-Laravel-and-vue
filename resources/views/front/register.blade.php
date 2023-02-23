@extends('front.front_layouts')

@section('content')
<section class="relative pt-32 pb-36 bg-gradient-gray2 overflow-hidden">
    <img class="absolute top-1/2 transform -translate-y-1/2 left-0" src="{{ $frontSetting->register_background_url }}" alt="">
    <div class="relative z-10 container mx-auto px-4">
        <div class="flex flex-wrap -m-6">
            <div class="w-full md:w-1/2 p-6">
                <div class="md:max-w-xl">
                    <h2 class="mb-3 heading-text">{{ $frontSetting->register_title }}</h2>
                    <p class="mb-12 subheading-text">{{ $frontSetting->register_description }}</p>
                    {!! Form::open(['url' => '','class'=> ' ajax-form', 'id'=>'ajax-register-form', 'method' => 'POST']) !!}
                    <div>
                        <div id="alert"></div>
                    </div>
                    <div class="register-div">
                        <div class="flex flex-wrap -m-2 mb-6">
                            <div class="form-group w-full p-2">
                                <input class="form-control w-full px-5 py-3.5 text-gray-500 placeholder-gray-500 bg-white outline-none focus:ring-4 focus:ring-indigo-500 border border-gray-200 rounded-lg"
                                    type="text" placeholder="{{ $frontSetting->register_company_name_text }}" id="company_name" name="company_name">
                            </div>
                            <div class="form-group w-full p-2">
                                <input class="form-control w-full px-5 py-3.5 text-gray-500 placeholder-gray-500 bg-white outline-none focus:ring-4 focus:ring-indigo-500 border border-gray-200 rounded-lg"
                                    type="text" placeholder="{{ $frontSetting->register_email_text }}" id="company_email" name="company_email" value="{{ $actionEmail }}">
                            </div>
                            <div class="form-group w-full p-2">
                                <input class="form-control w-full px-5 py-3.5 text-gray-500 placeholder-gray-500 bg-white outline-none focus:ring-4 focus:ring-indigo-500 border border-gray-200 rounded-lg"
                                    type="password" placeholder="{{ $frontSetting->register_password_text }}" id="password" name="password">
                            </div>
                            <div class="form-group w-full p-2">
                                <input class="form-control w-full px-5 py-3.5 text-gray-500 placeholder-gray-500 bg-white outline-none focus:ring-4 focus:ring-indigo-500 border border-gray-200 rounded-lg"
                                    type="password" placeholder="{{ $frontSetting->register_confirm_password_text }}" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                        <div class="flex flex-wrap -m-1.5 mb-8">
                            <div class="flex items-center form-group w-auto p-1.5">
                                <input class="form-control w-4 h-4" type="checkbox" id="condition" name="condition">
                                <div class="flex-1 p-1.5">
                                    <p class="text-gray-500 text-sm">
                                        <a class="text-gray-900 hover:text-gray-700" href="{{ $frontSetting->register_agree_url }}" target="_blank">
                                            {{ $frontSetting->register_agree_text }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="group relative md:max-w-max">
                            <div
                                class="absolute top-0 left-0 w-full h-full bg-gradient-green opacity-0 group-hover:opacity-50 rounded-lg transition ease-out duration-300">
                            </div>
                            <button
                                class="p-1 w-full font-heading font-semibold text-xs text-gray-900 group-hover:text-white uppercase tracking-px overflow-hidden rounded-md"
                                type="submit" onclick="register();return false">
                                <div class="relative p-5 px-9 bg-gradient-green overflow-hidden rounded-md">
                                    <div
                                        class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full bg-gray-900 transition ease-in-out duration-500">
                                    </div>
                                    <p class="relative z-10">{{ $frontSetting->register_submit_button_text }}</p>
                                </div>
                            </button>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
            <div class="w-full md:w-1/2 p-6">
                <div class="md:max-w-lg ml-auto">
                    <div class="flex flex-wrap -m-6">
                        <div class="flex flex-wrap w-full lg:-m-3">
                            <div class="max-w-max mx-auto">
                                @include('front.includes.header_feature_lists')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        "use strict";

        function register() {
            art.sendXhr({
                url: "{{route('front.register.save')}}",
                type: "POST",
                file: true,
                container: "#ajax-register-form",
                disableButton: true,
                messageLocation: 'inline',
                success: function(response) {
                    if(response.status == 'success'){
                        $('.register-div').remove();
                    }
                }
            });
        }
    </script>
@endsection
