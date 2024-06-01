@extends('layouts.app')

@section('content')
    

       <!-- Hidden Sidebar -->
       <section class="hidden-bar">
        <div class="inner-box text-center">
          <div class="cross-icon"><span class="fa fa-times"></span></div>
          <div class="title">
            <h4>Get Appointment</h4>
          </div>

          <!--Appointment Form-->
          <div class="appointment-form">
            <form method="post" action="contact.html">
              <div class="form-group">
                <input
                  type="text"
                  name="text"
                  value=""
                  placeholder="Name"
                  required
                />
              </div>
              <div class="form-group">
                <input
                  type="email"
                  name="email"
                  value=""
                  placeholder="Email Address"
                  required
                />
              </div>
              <div class="form-group">
                <textarea placeholder="Message" rows="5"></textarea>
              </div>
              <div class="form-group">
                <button type="submit" class="theme-btn style-two">
                  Submit now
                </button>
              </div>
            </form>
          </div>

          <!--Social Icons-->
          <div class="social-style-one">
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-pinterest-p"></i></a>
          </div>
        </div>
      </section>
      <!--End Hidden Sidebar -->

      <!-- Page Banner Start -->
      <section
        class="page-banner-area overlay py-170 rpy-120 rel z-1 bgs-cover text-center"
        style="background-image: url({{ asset('assets/images/background/banner-two.jpg') }})"
      >
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-10">
              <div class="banner-inner pt-70 rpt-50 text-white">
                <h3
                  class="page-title"
                  data-aos="fade-up"
                  data-aos-duration="1500"
                  data-aos-offset="50"
                >
                  Join Academy and get 50% Off
                </h3>
                <nav aria-label="breadcrumb">
                  <ol
                    class="breadcrumb justify-content-center"
                    data-aos="fade-up"
                    data-aos-delay="200"
                    data-aos-duration="1500"
                    data-aos-offset="50"
                  >
                    <li class="breadcrumb-item">
                      <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="{{ route('events') }}">Events</a>
                    </li>
                    <li class="breadcrumb-item active">Event Details</li>
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
              <div
                class="blog-details-image"
                data-aos="fade-up"
                data-aos-duration="1500"
                data-aos-offset="50"
              >
                <img
                  src="{{ $event->main_image_url ?? asset('metronic/assets/media/users/blank.png') }}"
                  alt="Event Details"
                />
              </div>
              <div class="blog-details-content">
                <ul
                  class="blog-meta"
                  data-aos="fade-up"
                  data-aos-duration="1500"
                  data-aos-offset="50"
                >
                 <!-- <li>
                    <a href="#">Industry</a>
                  </li>-->
                  <li>
                    <i class="far fa-calendar-alt"></i>
                    <a href="#">{{date('d M,Y', strtotime($event->date))}}</a>
                  </li>
                 <!-- <li>
                    <i class="far fa-comments"></i>
                    <a href="#">Comments(05)</a>
                  </li>-->
                </ul>
                <hr />
                <div class="content py-10">
                  <h5>
                    <strong>{{$event->title}}</strong>
                  </h5>
                  <p>
                  {{$event->description}}
                  </p>
                </div>
                <div class="wrap my-4">
                  <h5 class="fw-700">Photo Gallery</h5>
                  <div class="gallery">
                    
                  @foreach ($gallery as $image)
                    <a href="{{ $image->image_url }}">
                      <img
                        src="{{ $image->image_url }}"
                        alt="Gallery"
                      />
                      <i class="far fa-plus"></i>
                    </a>
                    @endforeach
                  </div>
                </div>
                <!--<div class="tag-share pt-15">
                  <div
                    class="item"
                    data-aos="fade-right"
                    data-aos-duration="1500"
                    data-aos-offset="50"
                  >
                    <b>Share : </b>
                    <div class="social-style-two">
                      <a href="#"><i class="fab fa-facebook-f"></i></a>
                      <a href="#"><i class="fab fa-twitter"></i></a>
                      <a href="#"><i class="fab fa-instagram"></i></a>
                      <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                  </div>
                </div>-->
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Blog Details Area End -->
    <!--End pagewrapper-->
    @include('sections.footer')
    <!-- footer area end -->
@endsection
