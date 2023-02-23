@extends('front.front_layouts')

@section('content')

<section class="relative pt-24 pb-36 bg-white overflow-hidden">
    <img class="absolute bottom-0 left-1/2 transform -translate-x-1/2"
        src="flaro-assets/images/contact/gradient.svg" alt="">
    <div class="relative z-10 container px-4 mx-auto">
        <h2 class="mb-5 heading-text">
            {{ $frontSetting->contact_title }}
        </h2>
        <p class="mb-20 subheading-text">
            {{ $frontSetting->contact_description }}
        </p>
        <div class="flex flex-wrap -m-3">
            <div class="w-full md:w-1/3 p-3">
                <div
                    class="p-11 h-full text-center bg-white bg-opacity-90 border border-blueGray-100 rounded-xl shadow-11xl">
                    <div class="mb-6 relative mx-auto w-16 h-16 bg-indigo-600 rounded-full">
                        <div class="absolute left-1/2 top-1/2 transform -translate-y-1/2 -translate-x-1/2">
                            <svg width="32" height="33" viewBox="0 0 32 33" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 11.1666L14.5208 18.1805C15.4165 18.7776 16.5835 18.7776 17.4792 18.1805L28 11.1666M6.66667 25.8333H25.3333C26.8061 25.8333 28 24.6394 28 23.1666V9.83329C28 8.36053 26.8061 7.16663 25.3333 7.16663H6.66667C5.19391 7.16663 4 8.36053 4 9.83329V23.1666C4 24.6394 5.19391 25.8333 6.66667 25.8333Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-3 text-xl font-bold font-heading leading-snug">{{ $frontSetting->contact_email_text }}</h3>
                    <p class="font-medium leading-relaxed">{{ $frontSetting->contact_email }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-3">
                <div
                    class="p-11 h-full text-center bg-white bg-opacity-90 border border-blueGray-100 rounded-xl shadow-11xl">
                    <div
                        class="mb-6 relative mx-auto w-16 h-16 bg-white border border-blueGray-200 rounded-full">
                        <div class="absolute left-1/2 top-1/2 transform -translate-y-1/2 -translate-x-1/2">
                            <svg width="32" height="33" viewBox="0 0 32 33" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 7.16667C4 5.69391 5.19391 4.5 6.66667 4.5H11.039C11.6129 4.5 12.1224 4.86724 12.3039 5.4117L14.301 11.4029C14.5108 12.0324 14.2258 12.7204 13.6324 13.0172L10.6227 14.522C12.0923 17.7816 14.7184 20.4077 17.978 21.8773L19.4828 18.8676C19.7796 18.2742 20.4676 17.9892 21.0971 18.199L27.0883 20.1961C27.6328 20.3776 28 20.8871 28 21.461V25.8333C28 27.3061 26.8061 28.5 25.3333 28.5H24C12.9543 28.5 4 19.5457 4 8.5V7.16667Z"
                                    stroke="#4F46E5" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-3 text-xl font-bold font-heading leading-snug">{{ $frontSetting->contact_phone_text }}</h3>
                    <p class="font-medium leading-relaxed">{{ $frontSetting->contact_phone }}</p>
                </div>
            </div>
            <div class="w-full md:w-1/3 p-3">
                <div
                    class="p-11 h-full text-center bg-white bg-opacity-90 border border-blueGray-100 rounded-xl shadow-11xl">
                    <div
                        class="mb-6 relative mx-auto w-16 h-16 bg-white border border-blueGray-200 rounded-full">
                        <div class="absolute left-1/2 top-1/2 transform -translate-y-1/2 -translate-x-1/2">
                            <svg width="32" height="33" viewBox="0 0 32 33" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M23.5431 22.7091C22.1797 24.0725 19.192 27.0602 17.4133 28.8389C16.6323 29.62 15.3693 29.6203 14.5883 28.8392C12.8393 27.0903 9.91373 24.1647 8.45818 22.7091C4.29259 18.5435 4.29259 11.7898 8.45818 7.62419C12.6238 3.4586 19.3775 3.4586 23.5431 7.62419C27.7087 11.7898 27.7087 18.5435 23.5431 22.7091Z"
                                    stroke="#4F46E5" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                                <path
                                    d="M20.0007 15.1667C20.0007 17.3758 18.2098 19.1667 16.0007 19.1667C13.7915 19.1667 12.0007 17.3758 12.0007 15.1667C12.0007 12.9575 13.7915 11.1667 16.0007 11.1667C18.2098 11.1667 20.0007 12.9575 20.0007 15.1667Z"
                                    stroke="#4F46E5" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="mb-3 text-xl font-bold font-heading leading-snug">{{ $frontSetting->contact_address_text }}</h3>
                    <p class="font-medium max-w-xs mx-auto leading-relaxed">
                        {{ $frontSetting->contact_address }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="relative pt-28 pb-36 bg-gray-100 overflow-hidden">
    <div class="relative z-10 container px-4 mx-auto">
        <p class="mb-6 text-sm text-indigo-600 text-center font-semibold uppercase tracking-px">{{ $frontSetting->contact_form_description }}</p>
        <h2 class="mb-14 heading-text">
            {{ $frontSetting->contact_form_title }}
        </h2>

        {!! Form::open(['url' => '','class'=> 'ajax-form px-11 pt-9 pb-11 bg-white bg-opacity-80 md:max-w-xl mx-auto rounded-4xl shadow-12xl backdrop-46', 'id'=>'ajax-contact-form', 'method' => 'POST']) !!}
            <h3 class="mb-8 text-xl text-center font-semibold leading-normal md:max-w-sm mx-auto">
                {{ $frontSetting->contact_form_heading }}
            </h3>
            <div>
                <div id="alert">
                </div>
            </div>
            <div class="contact-us-div">
                <div class="form-group block mb-4">
                    <input
                        class="form-control px-4 py-3 w-full text-gray-500 font-medium placeholder-gray-500 bg-white bg-opacity-50 outline-none border border-blueGray-200 rounded-lg focus:ring focus:ring-indigo-300"
                        name="name" id="name" type="text" placeholder="{{ $frontSetting->contact_form_name_text }}">
                </div>
                <div class="form-group block mb-4">
                    <input
                        class="form-control px-4 py-3 w-full text-gray-500 font-medium placeholder-gray-500 bg-white bg-opacity-50 outline-none border border-blueGray-200 rounded-lg focus:ring focus:ring-indigo-300"
                        name="email" id="email" type="text" placeholder="{{ $frontSetting->contact_form_email_text }}">
                </div>
                <div class="form-group block mb-4">
                    <textarea
                        class="form-control p-4 w-full h-48 font-medium text-gray-500 placeholder-gray-500 bg-white bg-opacity-50 outline-none border border-blueGray-200 resize-none rounded-lg focus:ring focus:ring-indigo-300"
                        name="message" id="message" placeholder="{{ $frontSetting->contact_form_message_text }}"></textarea>
                </div>
                <button
                    class="py-4 px-9 w-full text-white font-semibold border border-indigo-700 rounded-xl shadow-4xl focus:ring focus:ring-indigo-300 bg-indigo-600 hover:bg-indigo-700 transition ease-in-out duration-200"
                    type="submit" onclick="updateContactForm();return false">
                    {{ $frontSetting->contact_form_send_message_text }}
                </button>
            </div>
        {{Form::close()}}
    </div>
    <img class="absolute bottom-0 w-full object-cover transform hover:translate-y-4 transition ease-in-out duration-1000"
        style="height: 502px;" src="{{ $frontSetting->contact_form_background_image_url }}" alt="">
</section>

@include('front.sections.call_to_action')

@endsection


@section('scripts')

    <script>
        "use strict";

        function updateContactForm() {
            art.sendXhr({
                url: '{{route('front.submit-contact-form')}}',
                type: "POST",
                file: true,
                container: "#ajax-contact-form",
                disableButton: true,
                messageLocation: 'inline',
                success: function(response) {
                    if(response.status == 'success'){
                        $('.contact-us-div').remove();
                    }
                }
            });
        }
    </script>
@endsection
