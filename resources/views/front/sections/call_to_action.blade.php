<section class="relative bg-gray-100 pt-24 pb-32 overflow-hidden">
    <div class="container mx-auto px-8">
        <h2 class="mb-5 heading-text">{{ $frontSetting->call_to_action_title }}</h2>
        <p class="mb-11 subheading-text">{{ $frontSetting->call_to_action_description }}</p>
        <div class="flex flex-wrap justify-center max-w-4xl mx-auto mb-12 divide-y md:divide-y-0 md:divide-x">
            @foreach ($frontSetting->call_to_action_widgets as $callToActionWidget)
                <div class="w-full md:w-1/3 p-11 md:py-0">
                    <div class="flex flex-wrap -m-1.5">
                        <div class="w-auto px-1.5">
                            <svg class="relative top-1" width="24" height="24" viewbox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="11.25" stroke="#18181B" stroke-width="1.5"></circle>
                                <path d="M7.41357 12.6552L10.0343 15.2758L16.586 8.72412" stroke="#18181B"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <div class="flex-1 px-1.5">
                            <p class="font-heading font-bold text-2xl text-gray-900">{{ $callToActionWidget['value'] }}</p>
                            <p class="text-gray-600 text-base">{{ $callToActionWidget['title'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! Form::open(['url' => '','class'=> ' ajax-form', 'id'=>'callToAction', 'method' => 'POST']) !!}
            <div class="form-group max-w-lg mx-auto mb-7">
                <div
                    class="p-0.5 border max-w-lg mx-auto bg-gradient-cyan focus-within:ring focus-within:ring-indigo-400 overflow-hidden rounded-xl">
                        <div class="p-0.5 flex flex-col md:flex-row bg-white overflow-hidden rounded-lg">
                            <input
                                class="form-control block flex-1 px-5 py-4 md:py-0 text-base text-gray-500 bg-transparent outline-none placeholder-gray-500 rounded-tl-xl rounded-bl-xl"
                                type="text" placeholder="{{ $frontSetting->call_to_action_email_text }}" id="action_email" name="action_email">
                            <button
                                class="group relative font-heading font-semibold w-full md:w-auto py-5 px-8 text-xs text-white bg-gray-900 hover:bg-gray-800 uppercase overflow-hidden rounded-md tracking-px" type="submit" onclick="callToAction();return false">
                                <div
                                    class="absolute top-0 left-0 transform -translate-y-full group-hover:-translate-y-0 h-full w-full transition ease-in-out duration-500 bg-gradient-cyan">
                                </div>
                                <p class="relative z-10">{{ $frontSetting->call_to_action_submit_button_text }}</p>
                            </button>
                        </div>
                </div>
            </div>
        {{Form::close()}}
        <div class="flex flex-wrap justify-center items-center -m-1">
            <div class="w-auto p-1">
                <svg width="18" height="18" viewbox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 8.25V9H12.75V8.25H12ZM6 8.25H5.25V9H6V8.25ZM9.75 11.25C9.75 10.8358 9.41421 10.5 9 10.5C8.58579 10.5 8.25 10.8358 8.25 11.25H9.75ZM8.25 12.75C8.25 13.1642 8.58579 13.5 9 13.5C9.41421 13.5 9.75 13.1642 9.75 12.75H8.25ZM4.5 9H13.5V7.5H4.5V9ZM14.25 9.75V14.25H15.75V9.75H14.25ZM13.5 15H4.5V16.5H13.5V15ZM3.75 14.25V9.75H2.25V14.25H3.75ZM4.5 15C4.08579 15 3.75 14.6642 3.75 14.25H2.25C2.25 15.4926 3.25736 16.5 4.5 16.5V15ZM14.25 14.25C14.25 14.6642 13.9142 15 13.5 15V16.5C14.7426 16.5 15.75 15.4926 15.75 14.25H14.25ZM13.5 9C13.9142 9 14.25 9.33579 14.25 9.75H15.75C15.75 8.50736 14.7426 7.5 13.5 7.5V9ZM4.5 7.5C3.25736 7.5 2.25 8.50736 2.25 9.75H3.75C3.75 9.33579 4.08579 9 4.5 9V7.5ZM11.25 5.25V8.25H12.75V5.25H11.25ZM12 7.5H6V9H12V7.5ZM6.75 8.25V5.25H5.25V8.25H6.75ZM9 3C10.2426 3 11.25 4.00736 11.25 5.25H12.75C12.75 3.17893 11.0711 1.5 9 1.5V3ZM9 1.5C6.92893 1.5 5.25 3.17893 5.25 5.25H6.75C6.75 4.00736 7.75736 3 9 3V1.5ZM8.25 11.25V12.75H9.75V11.25H8.25Z"
                        fill="#A1A1AA"></path>
                </svg>
            </div>
            <div class="w-auto p-1">
                <p class="text-gray-500 text-sm text-center">{{ $frontSetting->call_to_action_no_email_sell_text }}</p>
            </div>
        </div>
    </div>
</section>
