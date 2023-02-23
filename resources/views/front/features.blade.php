@extends('front.front_layouts')

@section('content')

@foreach ($allFeatures as $allFeature)
<section class="relative pt-24 pb-20 overflow-hidden border-b">
    <div class="container mx-auto px-4 mb-12">
        <h2 class="mb-6 heading-text">
            {{ $allFeature->title }}
        </h2>
        <p class="mb-16 subheading-text">
            {{ $allFeature->description }}
        </p>
        <div class="flex flex-wrap -m-8">
            @foreach ($allFeature->features as $innerFeature)
            <div class="w-full md:w-1/3 p-8">
                <div class="group">
                    <div class="mb-9 overflow-hidden rounded-2xl">
                        <img class="transform hover:scale-110 w-full transition ease-out duration-500"
                            src="{{ $innerFeature['image_url'] }}" alt="">
                    </div>
                    <h3 class="mb-4 font-heading font-bold text-gray-900 text-xl group-hover:underline">{{ $innerFeature['title'] }}</h3>
                    <p class="mb-5 text-gray-600 text-base">{{ $innerFeature['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endforeach



@include('front.sections.call_to_action')

@endsection
