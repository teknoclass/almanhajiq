@if (@$partners && @$partners->isNotEmpty())
    <!-- Brand Logo Start -->
    <section class="section-padding mb-5">
        <div class="container">

            <!-- Brand Logo Wrapper Start -->
            <div class="">

                <!-- Section Title Start -->
                    <h2 class="position-relative mb-4">
                        {{ __('our_partners') }}
                    </h2>

                <!-- Section Title End -->

                <!-- Brand Logo Start -->
                <div class="brand-logo position-relative brand-active">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($partners as $partner)
                                <!-- Single Brand Start -->
                                <div class="single-brand swiper-slide">
                                    <div class="brand-item">
                                        <div class="image">
                                            <a href="{{ @$partner->link }}" target="_blank">
                                                <img src="{{ imageUrl(@$partner->image) }}"
                                                    alt="{{ @$partner->title }}" loading="lazy"/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Brand End -->
                            @endforeach
                        </div>
                    </div>

                </div>
                <!-- Brand Logo End -->

            </div>
            <!-- Brand Logo Wrapper End -->

        </div>
    </section>
    <!-- Brand Logo End -->

@endif
