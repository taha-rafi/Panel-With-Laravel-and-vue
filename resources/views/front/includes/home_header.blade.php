<div class="flex flex-wrap justify-between -m-6 pt-26 pb-10">
    <div class="w-full lg:w-5/12 xl:w-1/2 p-6">
        <p class="mb-3 font-heading text-gray-400 font-medium text-lg">
            {{ $frontSetting->header_sub_title }}
        </p>
        <h1 class="mb-5 font-heading text-2xl md:text-4xl xl:text-6xl text-white font-bold">
            {{ $frontSetting->header_title  }}
        </h1>
        <p class="mb-5 text-gray-200">
            {{ $frontSetting->header_description }}
        </p>
        <ul class="mb-10">
            @foreach ($frontSetting->header_features as $currentHeaderFeature)
                <li class="mb-4 flex items-center font-heading font-semibold text-base text-gray-100">
                    <img class="mr-2" src="{{ asset('front/images/check.svg') }}" alt="">
                    <p>{{ $currentHeaderFeature }}</p>
                </li>
            @endforeach
        </ul>

        <div class="flex flex-wrap -m-3 mb-10">
            @if($frontSetting->header_button1_show == 1)
            <div class="w-full lg:w-auto p-3">
                <a href="{{ $frontSetting->header_button1_url }}" class="font-heading w-full block text-center px-6 py-3 text-base text-gray-900 bg-white hover:bg-gray-100 rounded-md">
                    {{ $frontSetting->header_button1_text }}
                </a>
            </div>
            @endif
            @if($frontSetting->header_button2_show == 1)
            <div class="w-full lg:w-auto p-3">
                <a href="{{ $frontSetting->header_button2_url }}" class="font-heading w-full block text-center px-6 py-3 text-base text-white bg-transparent border border-gray-500 hover:border-gray-600 rounded-md">
                    {{ $frontSetting->header_button2_text }}
                </a>
            </div>
            @endif
        </div>
        @if($frontSetting->header_client_show == 1)
        <div class="lg:max-w-md">
            <div class="flex flex-wrap -m-3">
                <div class="w-auto p-3">
                    <img class="w-14 h-14" src="{{ $frontSetting->header_client_image_url }}" alt="">
                </div>
                <div class="flex-1 p-3">
                    <p class="mb-4 text-gray-300 text-base">
                        {{ $frontSetting->header_client_text }}
                    </p>
                    <p class="font-heading text-white text-base">
                        {{ $frontSetting->header_client_name }}
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="w-full lg:w-7/12 xl:w-1/2 p-6">
        <div class="max-w-max mx-auto">
            @include('front.includes.header_feature_lists')
        </div>
    </div>
</div>
