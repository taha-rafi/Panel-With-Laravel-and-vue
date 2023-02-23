<section class="overflow-hidden @if(!$showFullHeader) h-[300px] @endif" style="background: url({{ $frontSetting->header_background_image_url }}) no-repeat; background-size: cover;">
    <section class="container mx-auto">
        <div class="flex items-center justify-between px-8 py-4">
            <div class="w-auto">
                <div class="flex flex-wrap items-center">
                    <div class="w-auto mr-14">
                        <a href="{{ route('front.index') }}">
                            <img class="w-40" src="{{ $frontSetting->header_logo_url }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-auto">
                <div class="flex flex-wrap items-center">
                    <div class="w-auto hidden lg:block">
                        <ul class="flex items-center mr-10">
                            <li class="font-heading mr-9 text-white hover:text-gray-200 text-base">
                                <a href="{{ route('front.index') }}">
                                    {{ $frontSetting->home_text }}
                                </a>
                            </li>
                            <li class="font-heading mr-9 text-white hover:text-gray-200 text-base">
                                <a href="{{ route('front.features') }}">
                                    {{ $frontSetting->features_text }}
                                </a>
                            </li>
                            <li class="font-heading mr-9 text-white hover:text-gray-200 text-base">
                                <a href="{{ route('front.pricing') }}">
                                    {{ $frontSetting->pricing_text }}
                                </a>
                            </li>
                            <li class="font-heading text-white hover:text-gray-200 text-base">
                                <a href="{{ route('front.contact') }}">
                                    {{ $frontSetting->contact_text }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="w-auto hidden xl:block">
                        <div class="flex gap-2">
                            @if($frontSetting->register_button_show == 1)
                            <a href="{{ route('front.register') }}" class="group relative font-heading block py-1 px-5 text-base text-white border border-white overflow-hidden rounded-md">
                                <div
                                    class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full bg-white transition ease-in-out duration-500">
                                </div>
                                <p class="relative z-10 group-hover:text-gray-800">{{ $frontSetting->register_button_text }}</p>
                            </a>
                            @endif
                            @if($frontSetting->login_button_show == 1)
                            <a href="{{ route('main', ['path' => 'admin/login']) }}" class="group relative font-heading block py-1 px-5 text-base text-white border border-white overflow-hidden rounded-md">
                                <div
                                    class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full bg-white transition ease-in-out duration-500">
                                </div>
                                <p class="relative z-10 group-hover:text-gray-800">{{ $frontSetting->login_button_text }}</p>
                            </a>
                            @endif

                            <div class="dropdown inline-block relative">
                                <button class="bg-gray-300 text-gray-700 font-semibold py-1 px-4 rounded inline-flex items-center w-24">
									<img src="{{ $selectedLang->image_url }}" style="width: 18px" class="mr-2">
                                    <span>{{ $langKey }}</span>
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path> </svg>
                                </button>
                                <ul class="dropdown-menu absolute hidden text-gray-700 pt-1 w-24">
                                    @foreach ($allLangs as $allLang)
                                    <li>
                                        <a href="javascript:void(0);changeLang('{{ $allLang->key }}')" class="flex rounded-t bg-gray-200 hover:bg-gray-400 py-1 px-4  whitespace-no-wrap gap-1" href="#">
                                            <img src="{{ $allLang->image_url }}" style="width: 18px"> <span>{{ $allLang->key }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="w-auto lg:hidden">
                        <a href="#">
                            <svg class="navbar-burger text-gray-800" width="51" height="51" viewbox="0 0 56 56"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="56" height="56" rx="28" fill="currentColor"></rect>
                                <path d="M37 32H19M37 24H19" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @include('front.sections.header_mobile')
    </section>
    <div class="container mx-auto px-8">
        @if($showFullHeader)
            @include('front.includes.home_header')
        @else
            @include('front.includes.breadcrumb')
        @endif
    </div>
</section>
