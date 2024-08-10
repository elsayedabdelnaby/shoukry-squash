@extends('layouts.app')

@section('content')
    <!-- Page Banner Start -->
    <section class="page-banner-area overlay py-170 rpy-120 rel z-1 bgs-cover text-center"
        style="background-image: url({{ $press->main_image_url ?? url(asset('public/assets/images/background/banner-two.jpg')) }})">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="banner-inner pt-70 rpt-50 text-white">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center" data-aos="fade-up" data-aos-delay="200"
                                data-aos-duration="1500" data-aos-offset="50">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('events') }}">Press</a>
                                </li>
                                <li class="breadcrumb-item active">Press Release</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-lines for-black-bg">
            <span></span><span></span> <span></span><span></span>
        </div>
    </section>
    <!-- Page Banner End -->

    <!-- Blog Details Area Start -->
    <section class="blog-details-area py-130 rpy-100 rel z-1">
        <div class="container">
            <div class="row gap-70">
                <div class="col-lg-12">
                    <div class="blog-details-image" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                        <img src="{{ url($press->image_card_url) ?? url(asset('public/metronic/assets/media/users/blank.png')) }}"
                            alt="Event Details" />
                    </div>
                    <div class="blog-details-content">
                        <ul class="blog-meta" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">

                        </ul>
                        <hr />
                        <div class="content py-10">
                            <h5>
                                <strong>{{ $press->title }}</strong>
                            </h5>
                            <p>
                                <iframe width="560" height="315" src="{{ $press->video_url }}" frameborder="0"
                                    allowfullscreen></iframe>
                            </p>
                        </div>
                        <div class="wrap my-4">
                            <h5 class="fw-700">Photo Gallery</h5>
                            <div class="gallery">

                                @foreach ($press->posters as $poster)
                                    <a href="{{ $poster->poster_url }}">
                                        <img src="{{ url($poster->poster_url) }}" alt="Gallery" />
                                        <i class="far fa-plus"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Details Area End -->
@endsection
