@if (@$messages && @$messages->isNotEmpty())
    <!-- Messages Start -->
    <section class="section-padding">
        <div class="container our-message">

                <div class="title-div">
                    <div class="image">
                        <img src="{{ asset('assets/front/images/newimages/title-icon.png') }}" alt="title icons" loading="lazy"/>
                    </div>
                    <h2 class="position-relative">
                        {{ __("our_messages") }}
                    </h2>
                </div>

                <div class="row mt-5 align-items-start justify-content-center">
                    @foreach ($messages as $message)
                        <div class="col-lg-4 col-12 col-md-6">
                            <div class="content text-center">
                                <div class="about-icon mb-3">
                                    <img src="{{ imageUrl(@$message->image) }}"
                                        alt="" loading="lazy"/>
                                </div>
                                <h5 class="mb-4 font-bold text-color-primary title-sm">{{ @$message->title }}</h5>
                                <div class="mb-5">
                                    {!! @$message->description !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </div>
    </section>
    <!-- Messages End -->
@endif
