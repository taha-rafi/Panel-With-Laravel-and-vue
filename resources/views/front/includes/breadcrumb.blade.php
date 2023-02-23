<div class="flex flex-col justify-center mt-18">
    <h1 class="heading-text text-white text-center">{{ $breadcrumbTitle }}</h1>
    <p class="flex text-white justify-center gap-4 mt-2">
        <a href="{{ route('front.index') }}">{{ $frontSetting->home_text }}</a>
        <a href="#">/</a>
        <a href="#">{{ $breadcrumbTitle }}</a>
    </p>
</div>
