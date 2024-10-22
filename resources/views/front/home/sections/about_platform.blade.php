@if (@$main_headers && @$main_headers->isNotEmpty())
    @php
        $main_header = @$main_headers[0];
    @endphp
    @if (@$main_header->hasValues())
        <div class="swiper-container swiper-homePage">
            <div class="swiper-wrapper">
                @foreach ($main_headers as $main_header)
                    <div class="swiper-slide position-relative">
                        <img class="bg-hero-image" src="{{ imageUrl(@$main_header->background) }}" alt="Background Hero">
                        <div class="hero-content">
                            <div class="home-content">
                                <h2 class="home-title">مرحبا بك في</h2>
                                <div class="middale-title">
                                    <img src="{{ asset('assets/front/images/newimages/image.png') }}" alt="white logo">
                                    <h2>
                                        {{ @$main_header->title }}
                                    </h2>
                                </div>
                                <div>
                                    <p class="text-white">
                                        {!! @$main_header->text !!}
                                    </p>
                                </div>
                                @if (@$main_header->link)
                                    <div class="mt-1"><a class="banerRegisterBTN font-bold"
                                            href="{{ @$main_header->link }}">{{ @$main_header->title_btn }}</a>
                                    </div>
                                @endif
                            </div>
                            <div class="hero-image">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <img src="{{ imageUrl(@$main_header->image) }}" alt="Image Hero">
                                    </div>
                                    <div class="col-8 books-animation">
                                        <img class="closed-book" src="{{asset('assets/front/images/newimages/book-group-02.webp')}}" alt="animation-image">
                                        <img class="animation-items" src="{{asset('assets/front/images/newimages/books-gruop-hero.webp')}}" alt="animation-image">
                                        <img class="animation-items multip" src="{{asset('assets/front/images/newimages/who1.svg')}}" alt="animation-image">
                                        <img class="animation-items divide" src="{{asset('assets/front/images/newimages/divide.svg')}}" alt="animation-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    @endif
@endif

@if (@$statisticsIsActive && @$statistics->isNotEmpty())
    @include('front.home.sections.statistics')
@endif
