<div class="hidden navbar-menu fixed top-0 left-0 bottom-0 w-4/6 sm:max-w-xs z-50">
    <div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-80"></div>
    <nav class="relative z-10 px-9 py-8 bg-white h-full">
        <div class="flex flex-wrap justify-between h-full">
            <div class="w-full">
                <div class="flex items-center justify-between -m-2">
                    <div class="w-auto p-2">
                        <a class="inline-block" href="{{ route('front.index') }}">
                            <img src="{{ isset($frontSetting->header_sidebar_logo_url) ? $frontSetting->header_sidebar_logo_url : $frontSetting->header_logo_url }}" alt="">
                        </a>
                    </div>
                    <div class="w-auto p-2">
                        <a class="navbar-burger" href="#">
                            <svg width="24" height="24" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 18L18 6M6 6L18 18" stroke="#111827" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-center py-8 w-full">
                <ul>
                    <li class="mb-12">
                        <a class="font-heading font-medium text-lg text-gray-900 hover:text-gray-700" href="{{ route('front.index') }}">
                            {{ $frontSetting->home_text }}
                        </a>
                    </li>
                    <li class="mb-12">
                        <a class="font-heading font-medium text-lg text-gray-900 hover:text-gray-700" href="{{ route('front.features') }}">
                            {{ $frontSetting->features_text }}
                        </a>
                    </li>
                    <li class="mb-12">
                        <a class="font-heading font-medium text-lg text-gray-900 hover:text-gray-700" href="{{ route('front.pricing') }}">
                            {{ $frontSetting->pricing_text }}
                        </a>
                    </li>
                    <li class="mb-12">
                        <a class="font-heading font-medium text-lg text-gray-900 hover:text-gray-700" href="{{ route('front.contact') }}">
                            {{ $frontSetting->contact_text }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="flex flex-col justify-end w-full">
                <div class="flex flex-wrap">
                    @if($frontSetting->login_button_show == 1)
                    <div class="w-full">
                        <a
                            href="{{ route('main', ['path' => 'admin/login']) }}"
                            class="p-0.5 block text-center font-heading block w-full text-lg text-gray-900 font-medium rounded-10">
                            <div class="py-2 px-5 rounded-10">
                                <p>{{ $frontSetting->login_button_text }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if($frontSetting->register_button_show == 1)
                    <div class="w-full">
                        <a
                            href="{{ route('front.register') }}"
                            class="group block text-center relative p-0.5 font-heading block w-full text-lg text-gray-900 font-medium bg-gradient-cyan overflow-hidden rounded-10">
                            <div
                                class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full bg-gradient-cyan transition ease-in-out duration-500">
                            </div>
                            <div class="py-2 px-5 bg-white rounded-lg">
                                <p class="relative z-10">{{ $frontSetting->register_button_text }}</p>
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
