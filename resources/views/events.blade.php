@extends('layouts.app')

@section('content')
    <!-- Page Banner Start -->
    <section class="page-banner-area overlay py-170 rpy-120 rel z-1 bgs-cover text-center"
        style="background-image: url({{ url(asset('public/assets/images/background/banner-two.jpg')) }})">
        <div class="container">
            <div class="banner-inner pt-70 rpt-50 text-white">
                <h2 class="page-title" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                    News & Events
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center" data-aos="fade-up" data-aos-delay="200"
                        data-aos-duration="1500" data-aos-offset="50">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">News & Events</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="bg-lines for-black-bg">
            <span></span><span></span> <span></span><span></span>
        </div>
    </section>
    <!-- Page Banner End -->
    <!-- Blog Standard Area Start -->
    <section class="blog-standard-area py-130 rpy-100 rel z-1">
        <div class="container">
            <div class="row gap-70">
                @foreach ($events as $event)
                    <div class="col-6">
                        <div class="service-standard-wrap">
                            <div class="blog-item style-three mb-30" data-aos="fade-up" data-aos-duration="1500"
                                data-aos-offset="50">
                                <div class="image">
                                    <span class="date">{{ date('d M', strtotime($event->date)) }}</span>
                                    <img src="{{ url($event->main_image_url) ?? url(asset('public/metronic/assets/media/users/blank.png')) }}"
                                        alt="Blog" />
                                </div>
                                <div class="content">
                                    <ul class="blog-meta">
                                        <li>
                                            <i class="far fa-clock"></i>
                                            <a href="#">{{ date('d M,Y', strtotime($event->date)) }}</a>
                                        </li>
                                    </ul>
                                    <h5>
                                        <a
                                            href="{{ route('events_details', ['event' => $event->slug]) }}">{{ $event->title }}</a>
                                    </h5>
                                    <a class="read-more"
                                        href="{{ route('events_details', ['event' => $event->slug]) }}">Read
                                        More <i class="far fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-12">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
        <div class="bg-lines">
            <span></span><span></span> <span></span><span></span>
        </div>
    </section>
    <!-- Blog Standard Area End -->
@endsection
