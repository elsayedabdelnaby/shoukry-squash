<section class="team-area pt-130 rpt-100 pb-45 rpb-15 bgs-cover rel z-1 px-lg-0 px-3" id="team">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="section-title text-center text-white mb-60" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-offset="50">
                    <span class="sub-title mb-10">Team Members</span>
                    <h2>SSA Quality Coaching You Trust</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($coaches as $coach)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="team-member" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500"
                        data-aos-offset="50">
                        <div class="image">
                            <img src="{{ $coach->image_url }}" alt="Shoukry Squash Academy" />
                        </div>
                        <div class="content">
                            <h6>{{ $coach->name }}</h6>
                            <span class="designation">{{ $coach->title }}</span>
                            <div class="social-style-two">
                                @if ($coach->facebook_url)
                                    <a href="{{ $coach->facebook_url }}"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if ($coach->twitter_url)
                                    <a href="{{ $coach->twitter_url }}">
                                        <svg enable-background="new 0 0 1226.37 1226.37" viewBox="0 0 1226.37 1226.37"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="m727.348 519.284 446.727-519.284h-105.86l-387.893 450.887-309.809-450.887h-357.328l468.492 681.821-468.492 544.549h105.866l409.625-476.152 327.181 476.152h357.328l-485.863-707.086zm-144.998 168.544-47.468-67.894-377.686-540.24h162.604l304.797 435.991 47.468 67.894 396.2 566.721h-162.604l-323.311-462.446z">
                                            </path>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                            <g></g>
                                        </svg>
                                    </a>
                                @endif
                                @if ($coach->instagram_url)
                                    <a href="{{ $coach->instagram_url }}"><i class="fab fa-instagram"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="bg-lines for-black-bg">
        <span></span><span></span> <span></span><span></span>
    </div>
</section>
