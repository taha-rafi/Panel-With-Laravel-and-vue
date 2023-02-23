@foreach ($headerFeatures as $headerFeature)
    @if($loop->index == 0)
        <div class="flex flex-wrap justify-center -m-3 mb-3">
            @include('front.includes.header_feature')
        </div>
    @else
        @if(($loop->index % 2) != 0)
        <div class="flex flex-wrap justify-center @if(!$loop->last) max-w-max @endif -m-3 mb-3 @if(($loop->iteration % 4) == 0) xl:-ml-20 @endif">
        @endif
            @include('front.includes.header_feature', ['divideMultiple' => true])
        @if(($loop->index % 2) == 0)
        </div>
        @endif
    @endif
@endforeach
