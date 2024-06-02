@php
    use Carbon\Carbon;
@endphp
<!-- Event Area start -->
<section class="blog-area pt-100 pb-100 rel px-lg-0 px-3" id="events">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-9">
                <div class="section-title text-center mb-60" data-aos="fade-up" data-aos-duration="1500"
                    data-aos-offset="50">
                    <span class="sub-title mb-10">Latest News & Events</span>
                    <h2>Academy News & Events</h2>
                </div>
            </div>
            <div class="col-12">
                <ul class="project-nav mb-65" data-aos="fade-up" data-aos-delay="50" data-aos-duration="1500"
                    data-aos-offset="50">
                    <li class="active" data-filter=".event">Events</li>
                    <li data-filter=".upcoming-event">Upcoming Events</li>
                    <li data-filter=".press">Press Releases</li>
                </ul>
            </div>
        </div>
        <div class="row project-active g-4">
            @foreach ($events as $event)
                <div class="col-xl-4 col-md-6 item event">
                    <div class="blog-item">
                        @php
                            $eventDate = new Carbon($event->date);
                        @endphp
                        <div class="image">
                            <span class="date">{{ $eventDate->format('d F') }}</span>
                            <img src="{{ url($event->image_card_url) ?? url(asset('metronic/assets/media/users/blank.png')) }}"
                                alt="title" />
                        </div>
                        <div class="content">
                            <ul class="blog-meta">
                                <li>
                                    <!-- <span>Discount</span> -->
                                </li>
                                <li>
                                    <i class="far fa-clock"></i>
                                    <a href="#">{{ $eventDate->format('d F, Y') }}</a>
                                </li>
                            </ul>
                            <h5>
                                <a
                                    href="{{ route('events_details', ['event' => $event->slug]) }}">{{ $event->title }}</a>
                            </h5>
                            <a class="read-more" href="{{ route('events_details', ['event' => $event->slug]) }}">
                                Read More
                                <i class="far fa-angle-double-right mirror-x-rtl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($events as $event)
                <div class="col-xl-4 col-md-6 item upcoming-event">
                    <div class="blog-item">
                        @php
                            $eventDate = new Carbon($event->date);
                        @endphp
                        <div class="image">
                            <span class="date">{{ $eventDate->format('d F') }}</span>
                            <img src="{{ url($event->image_card_url) ?? url(asset('metronic/assets/media/users/blank.png')) }}"
                                alt="title" />
                        </div>
                        <div class="content">
                            <ul class="blog-meta">
                                <li>
                                    <!-- <span>Discount</span> -->
                                </li>
                                <li>
                                    <i class="far fa-clock"></i>
                                    <a href="#">{{ $eventDate->format('d F, Y') }}</a>
                                </li>
                            </ul>
                            <h5>
                                <a
                                    href="{{ route('events_details', ['event' => $event->slug]) }}">{{ $event->title }}</a>
                            </h5>
                            <a class="read-more" href="{{ route('events_details', ['event' => $event->slug]) }}">
                                Read More
                                <i class="far fa-angle-double-right mirror-x-rtl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            @foreach ($press as $record)
                <div class="col-xl-4 col-md-6 item press">
                    <div class="blog-item">
                        <div class="image">
                            <img src="{{ url($record->image_card_url) ?? url(asset('metronic/assets/media/users/blank.png')) }}"
                                alt="title" />
                        </div>

                        <div class="content">
                            <ul class="blog-meta">
                                <li>
                                    <!-- <span>Discount</span> -->
                                </li>
                            </ul>
                            <h5>
                                <a
                                    href="{{ route('press_details', ['slug' => $record->slug]) }}">{{ $record->title }}</a>
                            </h5>
                            <a class="read-more" href="{{ route('press_details', ['slug' => $record->slug]) }}">
                                Read More
                                <i class="far fa-angle-double-right mirror-x-rtl"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Event Area end -->
