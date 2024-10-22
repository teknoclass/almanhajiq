@if (@$teams && @$teams->isNotEmpty())
    <!-- How It Work End -->
    <section class="section-padding wow fadeInUp our-team">
        <div class="container">

            <h2 class="mb-5 text-black">
                {{ __('our_teams') }}
            </h2>
            <div class="swiper-teams">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($teams as $team)
                            <div class="swiper-slide">
                                <div class="">
                                    <div class="team-item p-2 text-center">
                                        <img class="img-team" src="{{ imageUrl(@$team->image) }}" alt="founder-name"
                                            loading="lazy" />
                                        <div class="info text-center">
                                            <h3 class="text-black my-2">{{ @$team->name }}</h3>
                                            <h6 class="text-black">{{ @$team->job }}</h6>
                                            {{-- <p class="text-muted">
                                                {!! @$team->description !!}
                                            </p> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How It Work End -->
@endif
