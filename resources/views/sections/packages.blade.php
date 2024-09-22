<section class="pricing-area-three bgp-top pt-130 pb-100 rel z-1" id="pricing">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9 col-md-11">
                <div class="section-title text-center mb-85" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-offset="50">
                    <span class="sub-title mb-10">Packages</span>
                    <h2>Sign up for one of our tailored packages</h2>
                </div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center">
            @foreach ($packages as $package)
                <div class="col-xl-4 col-md-6 col-sm-10" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500"
                    data-aos-offset="50">
                    <div class="row">
                        <div class="col-12">
                            @if ($package->image_card_url)
                                <img src="{{ url($package->image_card_url) }}" />
                            @endif
                        </div>
                    </div>
                    <div class="pricing-item bg-light">
                        <h5 class="title">{{ $package->name }}</h5>
                        <div class="text">{{ $package->breif }}</div>
                        <div class="price">
                            <span class="prev"></span>{{ $package->sessions_number }}<span
                                class="next">Session</span>
                        </div>
                        <hr />
                        <a href="tel:+2{{ $general_settings['phone_number'] }}" class="theme-btn">More Details <i class="far fa-angle-double-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
