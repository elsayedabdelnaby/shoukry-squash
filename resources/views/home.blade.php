@extends('layouts.app')

@section('content')
    <!-- Slider Section Start -->
    <section class="main-slider-area rel z-1">
        <div class="main-slider-active">
            <div class="slider-item" style="background-image: url({{ url(asset('public/assets/images/slider/bg-main.jpg')) }})">
                <div class="container">
                    <div class="slide-content" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                        <span class="sub-title"> Shoukry Premium Squash Club </span>
                        <h1>Elevate Your Game To A New Dimension</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="dot-wrap">
            <div class="container rel">
                <div class="main-slider-dots"></div>
            </div>
        </div>
    </section>
    <!-- Slider Section End -->
    <!-- About Us Area start -->
    @include('sections.about')
    <!-- About Us Area end -->
    <!-- CTA Counter Area start -->
    @include('sections.statistics')
    <!-- CTA Counter Area end -->
    <!-- Branches start -->
    @include('sections.branches')
    <!-- Branches end -->
    <!-- Team Area start -->
    @include('sections.teams')
    <!-- Team Area end -->
    <!-- Pricing Package Area start -->
    @include('sections.packages')
    <!-- Pricing Package Area end -->
    <!-- Events start -->
    @include('sections.events')
    <!-- Events end -->
    <!-- Contact Us start -->
    @include('sections.contact_us')
    <!-- Contact Us end -->
@endsection
