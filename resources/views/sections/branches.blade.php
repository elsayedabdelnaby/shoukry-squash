<section class="services-area pt-100 pb-100 rel z-1 px-lg-0 px-3" id="branches">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8">
                <div class="section-title text-center mb-60" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-offset="50">
                    <span class="sub-title mb-10">More About Academy</span>
                    <h2>Our Locations</h2>
                </div>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($branches as $branch)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1500"
                    data-aos-offset="50">
                    <div class="service-item text-start">
                        <div class="icon">
                            <img src="{{ $branch->image_url }}" alt="Shoukry Squash Academy" />
                        </div>
                        <h5>
                            <a href="#">{{ $branch->name }} </a>
                        </h5>
                        <p class="address">
                            <strong> Address : </strong>
                            <span>
                                {{ $branch->address }}
                            </span>
                        </p>
                        <p class="address">
                            <strong> Working Hours : </strong>
                            <span>
                                Daily From {{ $branch->working_from }} AM to {{ $branch->working_to }} PM.
                            </span>
                        </p>
                        {{-- <p class="address">
                            <strong> Working Days : </strong>
                            <span>
                                {{ $branch->working_days }}
                            </span>
                        </p> --}}
                        <div class="action mt-4">
                            <a href="{{ $branch->google_map }}" target="_blank" class="btn btn-sm theme-btn fw-500">
                                <i class="fa fa-location me-2"></i>
                                Open GPS Location
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
