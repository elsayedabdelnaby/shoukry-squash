<section class="contact-area bgc-lighter py-130 rpy-100 rel z-1 px-lg-0 px-3" id="contact">
    <div class="container">
        <div class="row gap-150 align-items-center">
            <div class="col-lg-6">
                <div class="contact-form-part rmb-55" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">
                    <div class="section-title mb-35">
                        <span class="sub-title mb-10">Get In Touch</span>
                        <h2>
                            HAVE QUESTIONS ? <br />
                            GET IN TOUCH!
                        </h2>
                    </div>
                    <form class="contactForm" action="{{ route('contactus') }}" method="POST" >
                    @csrf
                        <div class="row gap-20">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Full Name *"  required isDisabled="true"
                                        requiredMessage="__('dashboard.name_is_required')"  />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="phone_number" class="form-control"
                                        placeholder="Phone *" required isDisabled="true"
                                        requiredMessage="__('dashboard.phone_number_is_required')" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject *"
                                    required isDisabled="true"
                                        requiredMessage="__('dashboard.subject_is_required')"/>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" rows="4" placeholder="Message *"
                                    required isDisabled="true"
                                        requiredMessage="__('dashboard.message_is_required')"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group mb-0">
                                    <button type="submit" class="theme-btn">
                                        Send Message
                                        <i class="far fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1500" data-aos-offset="50">
                <div class="contact-image-part rel">
                    <div class="experience-years">
                        <h6 class="title">
                            Q & A <i class="far fa-arrow-right"></i>
                        </h6>
                        <h6>We Would be Happy To Help You !</h6>
                    </div>
                    <img src="{{ url(asset('assets/images/about/contact.jpg')) }}" alt="Shoukry Squash Academy" />
                </div>
            </div>
        </div>
    </div>
</section>
