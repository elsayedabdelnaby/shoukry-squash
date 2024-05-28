<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Prevent Indexing Design Template , Backend Developer Should have remove the following 2 lines -->
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="noindex, nofollow" />
    <!-- Title -->
    <title> @yield('title') </title>
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description')" />
    <meta property="og:title" content="@yield('meta_title')" />
    <meta property="og:description" content="@yield('meta_description')" />
    <meta property="og:image" content="{{ asset('assets/images/brand/og-v2.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_AR" />
    <meta property="og:updated_time" content="123465789" />
    <link rel="shortcut icon" href="{{ asset('./assets/images/brand/logo-96.png') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/brand/logo-57.png') }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/brand/logo-60.png') }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/brand/logo-72.png') }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/brand/logo-76.png') }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/brand/logo-114.png') }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('./assets/images/brand/logo-120.png') }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('./assets/images/brand/logo-144.png') }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('./assets/images/brand/logo-152.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('./assets/images/brand/logo-180.png') }}" />
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('./assets/images/brand/logo-192.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('./assets/images/brand/logo-32.png') }}" />
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('./assets/images/brand/logo-96.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('./assets/images/brand/logo-16.png') }}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="{{ asset('./assets/images/brand/logo-144.png') }}" />
    <link rel="mask-icon" href="{{ asset('./assets/images/brand/logo-144.png') }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.min.css') }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-5.14.0.min.css') }}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}" />
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}" />
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}" />
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=1.0.0.3') }}" />
    @yield('head')
</head>

<body>
    <div class="page-wrapper">
        <!-- Preloader -->
        <div class="preloader">
            <div class="custom-loader"></div>
        </div>

        <!-- main header -->
        @include('layouts.partials.main_header')
        <!-- End main header -->

        <!--Form Back Drop-->
        <div class="form-back-drop"></div>
        <!-- End Form Back Drop -->

        <!-- Hidden Sidebar -->
        @include('layouts.partials.hidden_sidebar')
        <!-- End Hidden Sidebar -->

        @yield('content')

    </div>
    <!-- Jquery -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Appear Js -->
    <script src="{{ asset('assets/js/appear.min.js') }}"></script>
    <!-- Slick -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Nice Select -->
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- Image Loader -->
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- Circle Progress -->
    <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>
    <!-- Isotope -->
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <!--  Aos Animation -->
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ asset('assets/js/script.js?v=1.0.0.3') }}"></script>
    @yield('javascript')
</body>

</html>
