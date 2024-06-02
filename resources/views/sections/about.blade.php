<!-- About Us Area start -->
<section class="about-area pt-50 rel z-1 px-lg-0 px-3 pb-110" id="about">
    <div class="container">
        <div class="row gap-90">
            <div class="col-xl-6">
                <div class="about-image mt-55" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">
                    <img src="{{ url(asset('public/assets/images/about/about1.jpg')) }}" alt="Shoukry Squash Academy" />
                    <div class="circle-progress-wrap">
                        <div class="progress-content">
                            <h6>Members Satisfaction</h6>
                            <span class="counting">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="about-content mt-55" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                    <div class="section-title mb-25">
                        <span class="sub-title mb-10">About Academy</span>
                        <h3 class="fw-700">Academy Objectives & Mission</h3>
                    </div>
                    <div class="row gap-45 pt-15">
                        <div class="col-sm-6">
                            <div class="service-item-two">
                                <div class="icon">
                                    <img width="70" height="auto"
                                        src="{{ url(asset('public/assets/images/icons/mission.svg')) }}"
                                        alt="Shoukry Academy Mission" />
                                </div>
                                <h6>
                                    <span>Our Mission</span>
                                </h6>
                                <ul class="list-style-three">
                                    @foreach ($missions as $mission)
                                        <li class="d-flex">
                                            {{ $mission->mission }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="service-item-two">
                                <div class="icon">
                                    <img width="70" height="auto"
                                        src="{{ url(asset('public/assets/images/icons/vision.svg')) }}"
                                        alt="Shoukry Academy Mission" />
                                </div>
                                <h6>
                                    <span>Our Objectives</span>
                                </h6>
                                <ul class="list-style-three">
                                    @foreach ($objectives as $objective)
                                        <li class="d-flex">
                                            {{ $objective->objective }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Area end -->
