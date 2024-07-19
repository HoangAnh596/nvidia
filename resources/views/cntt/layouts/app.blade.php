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
    <meta property="og:image" content="{{ asset($favi[0]->image) }}">
    <meta name="author" content="cnttshop">

    <link rel="apple-touch-icon" href="{{ asset($favi[0]->image) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset($favi[0]->image) }}">

    <link rel="stylesheet" href="{{asset('cntt/css/templatemo.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/slick.min.css')}}">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="{{asset('cntt/css/fontawesome.min.css')}}">

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <link rel="stylesheet" href="{{asset('cntt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('cntt/css/home.css')}}">
    @yield('css')

</head>

<body>
    <div id="app">
        @include('cntt.components.header')
        <main>
            @yield('content')
        </main>
        @include('cntt.components.footer')
    </div>

    <!-- Start Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{asset('cntt/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('cntt/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('cntt/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('cntt/js/templatemo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="{{asset('cntt/js/custom.js')}}"></script>
    <script src="{{asset('cntt/js/slick.min.js')}}"></script>
    @yield('js')
    <!-- End Script -->

</body>

</html>
