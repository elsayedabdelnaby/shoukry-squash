<section class="hidden-bar">
    <div class="inner-box text-center">
        <div class="cross-icon"><span class="fa fa-times"></span></div>
        <div class="title">
            <h4>Get In Touch</h4>
        </div>
        <!--Appointment Form-->
        <div class="appointment-form">
            <form method="post" action="#">
                <div class="form-group">
                    <input type="text" name="text" placeholder="Name" />
                </div>
                <div class="form-group">
                    <input type="email" name="contact" placeholder="Email Or Phone" />
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
            <a href="#">
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
            @if ($general_settings['facebook_page'])
                <a href="{{ $general_settings['facebook_page'] }}"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if ($general_settings['instagram_page'])
                <a href="{{ $general_settings['instagram_page'] }}"><i class="fab fa-instagram"></i></a>
            @endif
        </div>
    </div>
</section>
