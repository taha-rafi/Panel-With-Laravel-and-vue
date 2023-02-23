<div class="w-full @if(isset($divideMultiple)) sm:w-1/2 @endif p-3">
    <div
        class="mx-auto sm:w-64 p-3 bg-white transform hover:-translate-y-3 transition ease-out duration-1000 rounded-2xl">
        <div class="flex flex-wrap -m-2">
            <div class="w-auto p-2">
                <img src="{{ $headerFeature->image_url }}" alt="">
            </div>
            <div class="w-auto p-2">
                <p class="font-heading text-base text-gray-900">{{ $headerFeature->name }}</p>
                <p class="mb-2 text-sm text-gray-500">{{ $headerFeature->description }}</p>
            </div>
        </div>
    </div>
</div>
