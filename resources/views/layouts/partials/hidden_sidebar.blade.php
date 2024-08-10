<section class="hidden-bar">
    <div class="inner-box text-center">
        <div class="cross-icon"><span class="fa fa-times"></span></div>
        <div class="title">
            <h4>Get In Touch</h4>
        </div>
        <!--Appointment Form-->
        <div class="appointment-form">
            <form action="{{ route('contactus') }}" method="POST" >
                    @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name *"  required isDisabled="true"
                                        requiredMessage="__('dashboard.name_is_required')"/>
                </div>
                <div class="form-group">
                    <input type="text" name="phone_number"  placeholder="Phone *" required isDisabled="true"
                                        requiredMessage="__('dashboard.phone_number_is_required')"/>
                </div>

                <div class="form-group">
                    <input type="text" name="subject"  placeholder="Subject *" required isDisabled="true"
                                        requiredMessage="__('dashboard.subject_is_required')"/>
                </div>
                <div class="form-group">
                    <textarea name="message"  rows="4" placeholder="Message *"
                                    required isDisabled="true"
                                        requiredMessage="__('dashboard.message_is_required')"></textarea>
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
            @if ($general_settings['facebook_page'])
                <a href="{{ $general_settings['facebook_page'] }}"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if ($general_settings['instagram_page'])
                <a href="{{ $general_settings['instagram_page'] }}"><i class="fab fa-instagram"></i></a>
            @endif
        </div>
    </div>
</section>
