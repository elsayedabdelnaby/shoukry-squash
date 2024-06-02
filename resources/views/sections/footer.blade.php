<!-- footer area start -->
<footer class="main-footer rel z-1 px-lg-0 px-3" id="footer">
    <div class="footer-top pt-80 pb-30">
        <div class="container">
            <div class="row align-items-center pb-30">
                <div class="col-xl-4 col-lg-3">
                    <div class="footer-logo mb-45 rmb-25">
                        <a href="#">
                            <img width="150" height="auto" src="{{ url(asset('assets/images/brand/logo-300.png')) }}"
                                alt="Shoukry Squash Academy" />
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-9 text-lg-end">
                    <div class="footer-clients mb-30 rmb-10">
                        <div class="clients">
                            <img src="{{ url(asset('assets/images/footer/client1.jpg')) }}" alt="Client" />
                            <img src="{{ url(asset('assets/images/footer/client2.jpg')) }}" alt="Client" />
                            <img src="{{ url(asset('assets/images/footer/client3.jpg')) }}" alt="Client" />
                        </div>
                        <h5>
                            Have Questions ? Call
                            <a
                                href="callto:+2{{ $general_settings['phone_number'] }}">+2{{ $general_settings['phone_number'] }}</a>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-widget footer-text">
                        <h5 class="footer-title">About Academy</h5>
                        <div class="text">
                            <p>
                                Elevate Your Game To A New Dimension
                            </p>
                            <a href="callto:+2{{ $general_settings['phone_number'] }}">
                                <i class="fal fa-phone-alt mirror-x-rtl"></i>
                                <span dir="ltr">+2{{ $general_settings['phone_number'] }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-sm-6">
                </div>
                <div class="col-xl-6 col-lg-8 col-sm-12">
                    <div class="footer-widget gallery-widget">
                        <h5 class="footer-title">Latest Gallery</h5>
                        <div class="gallery">
                            @foreach ($general_settings['gallery'] as $image)
                                <a href="{{ url($image->image_url) }}">
                                    <img src="{{ url($image->image_url) }}" alt="Gallery" />
                                    <i class="far fa-plus"></i>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-lines for-black-bg">
            <span></span><span></span> <span></span><span></span>
        </div>
    </div>
    <div class="footer-bottom pt-20 pb-5 rpt-25">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="copyright-text">
                        <p>
                            Copy@2024 <a href="#">Shoukry Squash Academy</a>. All Rights
                            reserved
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <ul class="footer-bottom-nav">
                        <li>
                            <a href="{{ $general_settings['facebook_page'] }}"><i class="fab fa-facebook"></i>
                                Facebook</a>
                        </li>
                        <li>
                            <a href="{{ $general_settings['instagram_page'] }}"><i class="fab fa-instagram"></i>
                                Instagram</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Scroll Top Button -->
            <button class="scroll-top scroll-to-target" data-target="html">
                <span class="far fa-angle-double-up"></span>
            </button>
        </div>
    </div>
</footer>
<!-- footer area end -->
