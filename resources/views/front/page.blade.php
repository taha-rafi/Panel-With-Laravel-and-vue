@extends('front.front_layouts')

@section('content')

    <section class="relative pt-24 pb-20 overflow-hidden border-b">
        <div class="container mx-auto px-4 mb-12">
        @if($isErrorPage)
            <div class="max-w-4xl text-center mx-auto mb-36">
                <h2 class="font-heading font-bold text-15xl xl:text-200 text-transparent bg-clip-text bg-gradient-green">404</h2>
                <p class="relative xl:left-10 font-heading font-semibold text-lg text-gray-900 uppercase tracking-widest xl:tracking-70">Error</p>
            </div>
            <div class="md:max-w-xl text-center mx-auto">
                <h2 class="mb-5 font-heading font-bold text-6xl sm:text-8xl xl:text-10xl text-gray-900">Page not found</h2>
                <p class="mb-10 text-gray-600 text-lg">Try something different or go back to the homepage.</p>
                <div class="p-px md:max-w-max mx-auto bg-gradient-cyan rounded-full">
                <a href="{{ route('front.index') }}" class="group relative font-heading py-5 px-6 block w-full text-xs text-gray-900 font-semibold uppercase tracking-px bg-white overflow-hidden rounded-full">
                    <div class="absolute top-0 left-0 transform -translate-x-full group-hover:-translate-x-0 h-full w-full transition ease-in-out duration-500 bg-gradient-cyan"></div>
                    <p class="relative z-10">Go back to Homepage</p>
                </a>
                </div>
            </div>
        @else
        <div class="container mx-auto px-4 mb-12">
            {!! $frontPageDetails->page_content !!}
        </div>
        @endif
    </section>

    @include('front.sections.call_to_action')
@endsection
