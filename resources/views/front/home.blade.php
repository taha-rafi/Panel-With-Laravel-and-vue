@extends('front.front_layouts')

@section('styles')
    <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}">
@endsection

@section('content')

{{-- Clients - Start --}}
<section class="pt-14 pb-14 bg-gray-100 overflow-hidden">
    <div class="container mx-auto px-4">
        <h4 class="client-heading">{{ $frontSetting->client_title }}</h4>
        <div class="flex flex-wrap justify-center -m-10">
            @foreach ($frontClients as $frontClient)
                <div class="w-auto p-10">
                    <img src="{{ $frontClient->logo_url }}" alt="{{ $frontClient->name }}">
                </div>
            @endforeach
        </div>
    </div>
</section>
{{-- Clients - End --}}

{{-- Features - Start --}}
@foreach ($allHomePageFeatures as $allHomePageFeature)
<section class="relative py-20 overflow-hidden">
    <div class="container mx-auto px-8">
        <div class="flex @if($loop->even) flex-wrap md:flex-row-reverse @else flex-wrap @endif -m-6">
            <div class="w-full lg:w-1/2 p-6">
                <div class="lg:max-w-lg">
                    <h2 class="feature-heading">{{ $allHomePageFeature->title }}</h2>
                    <p class="feature-description">{{ $allHomePageFeature->description }}</p>
                    <ul>
                        @foreach ($allHomePageFeature->features as $allFeaturePoint)
                            <li class="feature-list-item">
                                <img class="mr-2" src="{{ asset('front/images/check.svg') }}" alt="">
                                <p>{{ $allFeaturePoint }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="w-full lg:w-1/2 p-6">
                <div class="@if($loop->odd) mx-auto @else text-left  @endif max-w-lg h-96 rounded-3xl">
                    <img class="relative mx-auto" src="{{ $allHomePageFeature->image_url }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach
{{-- Features - End --}}

{{-- Features Lists - Start --}}
<section class="relative mt-20 pt-20 pb-32 bg-gradient-cyan2 overflow-hidden">
    <div class="container mx-auto px-8">
        <div class="mb-16 mx-auto">
            <h2 class="mb-5 heading-text">{{ $frontSetting->feature_description }}</h2>
            <p class="subheading-text">{{ $frontSetting->feature_title }}</p>
        </div>
        <div class="flex flex-wrap justify-center -m-2 mb-7">
            @foreach ($frontSetting->home_feature_points as $homeFeaturePoint)
                <div class="w-auto p-2">
                    <div
                        class="font-heading flex items-center font-semibold px-4 py-2.5 text-lg text-gray-900 bg-white rounded-full">
                        <div class="mr-3 w-3.5 h-3.5 bg-gradient-cyan rounded-full"></div>
                        <p>{{ $homeFeaturePoint }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
{{-- Features Lists - End --}}

{{-- Testimonials - Start --}}
<section class="relative pt-24 pb-32 overflow-hidden">
    <div class="container mx-auto px-8">
        <h2 class="mb-5 heading-text">{{ $frontSetting->testimonial_title }}</h2>
        <p class="mb-16 subheading-text">{{ $frontSetting->testimonial_description }}</p>
        <div class="flex flex-wrap -m-5">
            @foreach ($frontTestimonials as $frontTestimonial)
                <div class="w-full md:w-1/3 p-5">
                    <div
                        class="h-full p-0.5 bg-gradient-cyan transform hover:-translate-y-3 rounded-10 transition ease-out duration-1000">
                        <div class="h-full px-7 py-8 bg-white rounded-lg">
                            <img class="mb-8 h-12" src="{{ $frontTestimonial->image_url }}" alt="">
                            <p class="mb-8 text-base text-gray-900">{{ $frontTestimonial->comment }}</p>
                            <h3 class="mb-1.5 font-heading font-bold text-lg text-gray-900">{{ $frontTestimonial->name }}</h3>
                            <div class="flex mb-3">
                                @include('front.includes.rating', ['rating' => $frontTestimonial->rating])
                              </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
{{-- Testimonials - End --}}

@include('front.sections.call_to_action')

@endsection
