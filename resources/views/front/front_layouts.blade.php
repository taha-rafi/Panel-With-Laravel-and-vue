<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ isset($seoDetail) ? $seoDetail->seo_title : '' }} | {{ ucwords($frontSetting->app_name)}}</title>
    <meta name="description" content="{{ isset($seoDetail) ? $seoDetail->seo_description : '' }}">
    <meta name="keywords" content="{{ isset($seoDetail) ? $seoDetail->seo_keywords : '' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta property="og:title" content="{{ isset($seoDetail) ? $seoDetail->seo_title : '' }} | {{ ucwords($frontSetting->app_name)}}">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('front.index') }}">
    <meta property="og:site_name" content="{{ ucwords($frontSetting->app_name)}}" />
    <meta property="og:description" content="{{ isset($seoDetail) ? $seoDetail->seo_description : '' }}">

    @include('front.sections.styles')

    @yield('styles')
</head>

<body class="antialiased bg-body text-body font-body">
	<div class="">
        @include('front.sections.header')

        @yield('content')

        @include('front.sections.footer')

        @include('front.sections.scripts')

        @yield('scripts')

        <script>
            "use strict";

            function changeLang(langKey) {
                art.sendXhr({
                    url: "{{route('front.change-language')}}",
                    type: "POST",
                    data: { key: langKey },
                    container: "#ajax-register-form",
                    success: function(response) {
                        if(response.status == 'success'){
                            window.location.reload();
                        }
                    }
                });
            }
        </script>
    </div>
</body>

</html>
