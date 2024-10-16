<!DOCTYPE html>
<html lang="vi">

<head>
    <title>{{ $titleSeo }}</title>
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="canonical" href="{{ $canonical_url ?? url()->full() }}">
    <meta name="theme-color" content="#76b900">
    <meta name="keywords" content="{{ $keywordSeo }}">
    <meta name="description" content="{{ $descriptionSeo }}">
    <meta property="og:url" content="{{ $canonical_url ?? url()->full() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $titleSeo }}">
    <meta property="og:description" content="{{ $descriptionSeo }}">
    <meta property="og:image" content="{{ asset($globalFavi[0]->image) }}">
    <meta name="author" content="cnttshop">

    <link rel="apple-touch-icon" href="{{ asset($globalFavi[0]->image) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($globalFavi[0]->image) }}">

    <link rel="stylesheet" href="{{asset('cntt/css/templatemo.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/slick.min.css')}}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="{{asset('cntt/css/fontawesome.min.css')}}">
    <!-- Thẻ tiếp thị -->
    @if(isset($globalHeaderTags))
        @foreach($globalHeaderTags as $tag)
            {!! $tag->content !!}
        @endforeach
    @endif
    <!-- Load map styles -->
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" /> -->
    <link rel="stylesheet" href="{{asset('cntt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/social.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('css')

</head>

<body>
    <div id="app">
        @include('cntt.components.header')
        <main>
            @yield('content')
        </main>
        @include('cntt.components.contact-icon')
        @include('cntt.components.footer')
    </div>

    <!-- Start Script -->
    <script src="{{asset('cntt/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cntt/js/templatemo.js')}}"></script>
    <script src="{{asset('cntt/js/custom.js')}}"></script>
    <script src="{{asset('cntt/js/homepage.js')}}"></script>
    <script src="{{asset('cntt/js/slick.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('js')
    <!-- End Script -->

</body>

</html>
