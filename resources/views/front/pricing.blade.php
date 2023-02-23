@extends('front.front_layouts')

@section('styles')
    <style>
        .hide-faq-answer {
            display: none;
        }

        .hide-faq-arrow {
            display: none;
        }
    </style>
@endsection

@section('content')

<section class="pt-24 pb-28 bg-gray-50 overflow-hidden">
    <div class="container px-4 mx-auto">
        <h2 class="mb-5 heading-text">{{ $frontSetting->price_title }}</h2>
        <p class="mb-10 subheading-text">{{ $frontSetting->price_description }}</p>
        <div class="flex justify-center mb-24">
            <span class="mr-4">{{ isset($frontSetting->pricing_monthly_text) ?  $frontSetting->pricing_monthly_text : 'Monthly' }}</span>
            <div class="flex items-center">
              <input type="checkbox" id="pricing-switch" value="1" class="hidden" checked>
              <label for="pricing-switch" id="slider" class="relative mr-4 w-8 h-4 rounded-full bg-green-900 cursor-pointer"></label>
              <label for="pricing-switch">{{ isset($frontSetting->pricing_yearly_text) ?  $frontSetting->pricing_yearly_text : 'Yearly' }}</label>
            </div>
          </div>
        <div class="mb-24 md:max-w-6xl mx-auto">
            <div class="flex flex-wrap -m-4">
                @foreach ($subscriptionPlans as $subscriptionPlan)
                    <div class="w-full md:w-1/3 p-4">
                        <div class="relative flex flex-col px-9 pt-8 pb-9 h-full bg-white bg-opacity-90 border-blueGray-100 rounded-4xl shadow-9xl backdrop-46">
                            @if($subscriptionPlan->is_popular)
                                <img class="absolute -top-11 -right-8" src="{{ $frontSetting->most_popular_image_url }}" alt="">
                            @endif
                            <div class="relative z-10">
                                <span class="mb-9 inline-block text-sm text-indigo-600 font-semibold uppercase tracking-px leading-snug">{{ $subscriptionPlan->name }}</span>
                                <h3 class="mb-1 text-4xl text-gray-900 font-bold leading-none">
                                    @if($subscriptionPlan->default == 'yes')
                                    {{ $frontSetting->pricing_free_text }}
                                    @else
                                    <span class="monthly_div">
                                        {{ \App\SuperAdmin\Classes\SuperAdminCommon::formatAmountCurrency($subscriptionPlan->monthly_price) }}/{{ $frontSetting->pricing_month_text }}
                                    </span>
                                    <span class="yearly_div" style="display: none;">
                                        {{ \App\SuperAdmin\Classes\SuperAdminCommon::formatAmountCurrency($subscriptionPlan->annual_price) }}/{{  isset($frontSetting->pricing_year_text) ?  $frontSetting->pricing_year_text : 'year' }}
                                    </span>
                                    @endif
                                </h3>
                                <p class="mb-6 text-sm text-gray-600 font-medium leading-relaxed">
                                    @if($subscriptionPlan->default == 'yes')
                                    {{ $frontSetting->pricing_no_card_text }}
                                    @else
                                    <span class="monthly_div">
                                        {{ isset($frontSetting->pricing_billed_monthly_text) ?  $frontSetting->pricing_billed_monthly_text : 'Billed Monthly' }}
                                    </span>
                                    <span class="yearly_div" style="display: none;">
                                        {{ isset($frontSetting->pricing_billed_yearly_text) ?  $frontSetting->pricing_billed_yearly_text : 'Billed Yearly' }}
                                    </span>
                                    @endif
                                </p>
                                <p class="mb-9 text-gray-600 font-medium leading-relaxed">{{ $subscriptionPlan->description }}</p>
                                <ul class="mb-10">
                                    @foreach ($subscriptionPlan->features as $subscriptionPlanFeature)
                                        <li class="mb-4 flex items-center font-heading font-semibold text-base">
                                            <img class="mr-2" src="{{ asset('front/images/check.svg') }}" alt="">
                                            <p>{{ $subscriptionPlanFeature }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('front.register') }}" class="py-4 px-10 w-full text-white font-semibold rounded-xl focus:ring focus:ring-indigo-300 bg-indigo-600 hover:bg-indigo-700 transition ease-in-out duration-200" type="button">
                                    {{ $frontSetting->pricing_get_started_button_text }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <p class="mb-4 text-sm text-gray-500 text-center font-medium leading-relaxed">{{ $frontSetting->price_card_title }}</p>
        <div class="flex flex-wrap justify-center">
            @foreach ($pricingCards as $pricingCard)
                <div class="w-auto">
                    <a href="javascript:void(0);">
                        <img src="{{ $pricingCard->logo_url }}" alt="{{ $pricingCard->name }}">
                    </a>
                </div>
            @endforeach

        </div>
    </div>
</section>

<section class="relative pt-24 pb-28 bg-blueGray-50 overflow-hidden">
    <img class="absolute bottom-0 left-1/2 transform -translate-x-1/2" src="{{ $frontSetting->faq_background_image_url }}" alt="">
    <div class="relative z-10 container px-4 mx-auto">
        <div class="md:max-w-4xl mx-auto">
            <p class="mb-7 text-sm text-indigo-600 text-center font-semibold uppercase tracking-px">{{ $frontSetting->faq_sub_title }}</p>
            <h2 class="mb-16 heading-text">{{ $frontSetting->faq_title }}</h2>
            <div class="mb-11 flex flex-wrap -m-1">
                @foreach ($allFaqs as $allFaq)
                    <div class="w-full p-1">
                        <a href="javascript: void(0);" onclick="faqSelected('{{ $allFaq->id }}')">
                            <div id="faq_div_{{ $allFaq->id }}" class="py-7 px-8 bg-white bg-opacity-60 rounded-2xl shadow-10xl faq-div @if($loop->index == 0) faq-active @else faq-in-active @endif">
                                <div class="flex flex-wrap justify-between -m-2">
                                    <div class="flex-1 p-2">
                                        <h3 id="faq_question_{{ $allFaq->id }}" class="@if($loop->index == 0) mb-4 @endif text-lg font-semibold leading-normal faq-question-div">{{ $allFaq->question }}</h3>
                                        <p id="faq_answer_{{ $allFaq->id }}" class="text-gray-600 font-medium faq-answer-div @if($loop->index != 0) hide-faq-answer @endif">{{ $allFaq->answer }}</p>
                                    </div>
                                    <div class="w-auto p-2">
                                        <svg id="faq_up_arrow_{{ $allFaq->id }}" class="relative top-1 faq-up-arrow-svg @if($loop->index != 0) hide-faq-arrow @endif" width="20" height="20" viewBox="0 0 20 20"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.16732 12.5L10.0007 6.66667L15.834 12.5" stroke="#4F46E5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                        </svg>
                                        <svg id="faq_down_arrow_{{ $allFaq->id }}" class="relative top-1 faq-down-arrow-svg @if($loop->index == 0) hide-faq-arrow @endif" width="18" height="18" viewBox="0 0 18 18"
												fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M14.25 6.75L9 12L3.75 6.75" stroke="#18181B" stroke-width="2"
													stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <p class="text-gray-600 text-center font-medium">
                <span>{{ $frontSetting->faq_still_have_question_text }}</span>
                <a class="font-semibold text-indigo-600 hover:text-indigo-700" href="{{ route('front.contact') }}">{{ $frontSetting->faq_contact_us_text }}</a>
            </p>
        </div>
    </div>
</section>

@include('front.sections.call_to_action')

@endsection

@section('scripts')
    <script>
        "use strict";

        function faqSelected(selectedId) {
            $('.faq-div').removeClass('faq-active');
            $('.faq-div').addClass('faq-in-active');

            $('#faq_div_'+selectedId).removeClass('faq-in-active');
            $('#faq_div_'+selectedId).addClass('faq-active');

            $('.faq-answer-div').addClass('hide-faq-answer');
            $('#faq_answer_'+selectedId).removeClass('hide-faq-answer');

            $('.faq-question-div').removeClass('mb-4');
            $('#faq_question_'+selectedId).addClass('mb-4');

            $('.faq-up-arrow-svg').addClass('hide-faq-arrow');
            $('.faq-down-arrow-svg').removeClass('hide-faq-arrow');
            $('#faq_down_arrow_'+selectedId).addClass('hide-faq-arrow');
            $('#faq_up_arrow_'+selectedId).removeClass('hide-faq-arrow');
        }

        $('#pricing-switch').change(function () {
            if($(this).is(':checked'))
            {
                $('.yearly_div').hide();
                $('.monthly_div').show();
            } else {
                $('.monthly_div').hide();
                $('.yearly_div').show();
            }
        });
    </script>
@endsection
