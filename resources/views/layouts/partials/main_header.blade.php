<header class="main-header">
    <div class="header-top-wrap bgc-gray rel z-1">
        <div class="container">
            <div class="header-top">
                <div class="row align-items-center">
                    <div class="col-xl-4 col-lg-5">
                        <div class="top-left text-center text-lg-start">
                            Elevate Your Game To A New Dimension!
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="top-right text-center text-lg-end">
                            <ul>
                                <li class="d-xl-block d-none">
                                    <i class="far fa-phone-alt mirror-x-rtl"></i>
                                    <a
                                        href="callto:{{ $general_settings['phone_number'] }}">{{ $general_settings['phone_number'] }}</a>
                                </li>
                                <li>
                                    <div class="social-style-one">
                                        @if ($general_settings['facebook_page'])
                                            <a href="{{ $general_settings['facebook_page'] }}"><i
                                                    class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if ($general_settings['instagram_page'])
                                            <a href="{{ $general_settings['instagram_page'] }}"><i
                                                    class="fab fa-instagram"></i></a>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Header-Upper-->
    <div class="header-upper">
        <div class="container clearfix">
            <div class="header-inner rpy-10 rel d-flex align-items-center">
                <div class="logo-outer">
                    <div class="logo">
                        <a href="#">
                            <img src="{{ asset('assets/images/brand/logo-300.png') }}" alt="Shoukry Squash Academy"
                                title="Shoukry Squash Academy" />
                        </a>
                    </div>
                </div>

                <div class="nav-outer ms-lg-auto clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-lg">
                        <div class="navbar-header py-10">
                            <div class="mobile-logo">
                                <a href="{{ route('home') }}">
                                    <img width="70" src="{{ asset('assets/images/brand/logo-300.png') }}"
                                        alt="Shoukry Squash Academy" title="Shoukry Squash Academy" />
                                </a>
                            </div>

                            <!-- Toggle Button -->
                            <button type="button" class="navbar-toggle" data-bs-toggle="collapse"
                                data-bs-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <li>
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a href="#about">About</a>
                                </li>
                                <li>
                                    <a href="#branches">Branches</a>
                                </li>
                                <li>
                                    <a href="#team">Team</a>
                                </li>
                                <li>
                                    <a href="#pricing">Packages</a>
                                </li>
                                <li>
                                    <a href="#events">Events</a>
                                </li>
                                <li>
                                    <a href="{{ route('press.index') }}">Press</a>
                                </li>
                                <li><a href="#footer">Contact us</a></li>
                            </ul>
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>

                <!-- Menu Button -->
                <div class="menu-btns ms-lg-auto">
                    <a href="#contact" class="theme-btn me-4">
                        Get In Touch
                        <i class="far fa-angle-double-right"></i>
                    </a>
                    <!-- menu sidbar -->
                    <div class="menu-sidebar">
                        <button class="bg-transparent"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Header Upper-->
</header>
