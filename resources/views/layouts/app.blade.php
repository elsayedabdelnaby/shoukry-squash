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
    <meta property="og:image" content="{{ url(asset('public/assets/images/brand/og-v2.jpg')) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="ar_AR" />
    <meta property="og:updated_time" content="123465789" />
    <meta name="google-site-verification" content="YB3qRZbDcKhU86oVCSENBt1HhuXJOun7HITs7P7c-to" />
    <link rel="shortcut icon" href="{{ url(asset('public/assets/images/brand/logo-96.png')) }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url(asset('public/assets/images/brand/logo-57.png')) }}" />
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url(asset('public/assets/images/brand/logo-60.png')) }}" />
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url(asset('public/assets/images/brand/logo-72.png')) }}" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url(asset('public/assets/images/brand/logo-76.png')) }}" />
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url(asset('public/assets/images/brand/logo-114.png')) }}" />
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url(asset('public/assets/images/brand/logo-120.png')) }}" />
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url(asset('public/assets/images/brand/logo-144.png')) }}" />
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url(asset('public/assets/images/brand/logo-152.png')) }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url(asset('public/assets/images/brand/logo-180.png')) }}" />
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ url(asset('public/assets/images/brand/logo-192.png')) }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ url(asset('public/assets/images/brand/logo-32.png')) }}" />
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ url(asset('public/assets/images/brand/logo-96.png')) }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ url(asset('public/assets/images/brand/logo-16.png')) }}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="{{ url(asset('public/assets/images/brand/logo-144.png')) }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <link rel="mask-icon" href="{{ url(asset('public/assets/images/brand/logo-144.png')) }}" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@400;500&family=Poppins:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/flaticon.min.css')) }}" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/fontawesome-5.14.0.min.css')) }}" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/bootstrap.min.css')) }}" />
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/magnific-popup.min.css')) }}" />
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/nice-select.min.css')) }}" />
    <!-- Animate -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/aos.css')) }}" />
    <!-- Slick -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/slick.min.css')) }}" />
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ url(asset('public/assets/css/style.css?v=1.0.0.3')) }}" />

    <link rel="stylesheet" href="{{ url(asset('public/assets/css/toastr.min.css')) }}" />
    @yield('head')

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "SportsOrganization",
            "name": "Shoukry Premium Squash Club",
            "description": "Shoukry Premium Squash Club, Elevate Your Game To A New Dimension and Quality Coaching You Trust",
            "image": "{{ url(asset('public/assets/images/brand/og-v2.jpg')) }}",
            "url": "https://shoukrysquashacademy.com/",
            "publisher": "Elsayed Elaraby",
            "author": "Elsayed Elaraby, +201013218568",
            "datePublished": "2024-06-06",
            "dateModified": "2024-06-06",
            "mainEntityOfPage": "Home",
            "telephone": "{{ $general_settings['phone_number'] }}",
            "logo": "{{ url(asset('public/assets/images/brand/og-v2.jpg')) }}"
        }
    </script>

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

        <!-- footer area start -->
        @include('sections.footer')
        <!-- footer area end -->

    </div>
    <!-- Jquery -->

    <script src="{{ url(asset('public/assets/js/jquery-3.6.0.min.js')) }}"></script>
    <!-- Bootstrap -->
    <script src="{{ url(asset('public/assets/js/bootstrap.min.js')) }}"></script>
    <!-- Appear Js -->
    <script src="{{ url(asset('public/assets/js/appear.min.js')) }}"></script>
    <!-- Slick -->
    <script src="{{ url(asset('public/assets/js/slick.min.js')) }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ url(asset('public/assets/js/jquery.magnific-popup.min.js')) }}"></script>
    <!-- Nice Select -->
    <script src="{{ url(asset('public/assets/js/jquery.nice-select.min.js')) }}"></script>
    <!-- Image Loader -->
    <script src="{{ url(asset('public/assets/js/imagesloaded.pkgd.min.js')) }}"></script>
    <!-- Circle Progress -->
    <script src="{{ url(asset('public/assets/js/circle-progress.min.js')) }}"></script>
    <!-- Isotope -->
    <script src="{{ url(asset('public/assets/js/isotope.pkgd.min.js')) }}"></script>
    <!--  Aos Animation -->
    <script src="{{ url(asset('public/assets/js/aos.js')) }}"></script>
    <!-- Custom script -->
    <script src="{{ url(asset('public/assets/js/script.js?v=1.0.0.3')) }}"></script>

    <script src="{{ url(asset('public/assets/js/toastr.min.js')) }}"></script>

    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    @yield('javascript')
</body>

</html>
