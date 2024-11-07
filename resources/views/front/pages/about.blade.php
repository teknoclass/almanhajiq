@extends('front.layouts.index', ['is_active' => 'page', 'sub_title' => @$item->title])

@section('content')
    <!-- start:: section -->
    <section id="about-us" class="wow fadeInUp" data-wow-delay="0.1s">
        <div class="hero-about section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="text">
                            <h3 class="title">{{ @$item->title }}</h3>
                            <p>
                                {!! @$item->text !!}
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-4">
                        <img class="image" src="{{ imageUrl(@$item->image) }}" alt="{{ @$item->title }}" loading="lazy" />
                    </div>
                </div>
            </div>
        </div>

        <section class="about-section section-padding">
            <div class="container">
                <h2 class="title-section mb-5 text-center"> {{__('about_us')}}</h2>
                <div class="row">
                    <div class="col-12 col-md-6 col-xl-4 mb-4">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('assets/front/images/newimages/formkit_time.svg') }}" alt="icon">
                            </div>
                            <div class="info col-6 mx-auto">
                                <h6 class="title">  {{__('when_founded')}}</h6>
                                @if(!@$settings->valueOf('when_founded_'.app()->getLocale()))
                                <p>
                                    تأسس منصة المنهج لطلاب المداؤس في العراق عام 2018, برؤية
                                    جديدة لشمولية التعليم
                                </p>
                                @else
                                {!! @$settings->valueOf('when_founded_'.app()->getLocale()) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 mb-4">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('assets/front/images/newimages/icons_lamp-light.svg') }}" alt="icon">
                            </div>
                            <div class="info col-6 mx-auto">
                                <h6 class="title">{{__('our_vision')}}</h6>
                                @if(!@$settings->valueOf('our_vision_'.app()->getLocale()))
                                <p>
                                    جعل عملية التعليم أسهل عن طريق جعلها رقمية و توحيد المناهج في منصة واحدة شاملة.
                                </p>
                                @else
                                {!! @$settings->valueOf('our_vision_'.app()->getLocale()) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-4 mb-4">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('assets/front/images/newimages/fluent_stream-output-20-filled.svg') }}"
                                    alt="icon">
                            </div>
                            <div class="info col-6 mx-auto">
                                <h6 class="title">{{__('our_exports')}}</h6>
                                @if(!@$settings->valueOf('our_exports_'.app()->getLocale()))
                                <p>
                                    للمدونات التعليمية، وقراءة الكتب ، الفيديوهات التعليمية والمتنوعة ، والأستماع...
                                </p>
                                @else
                                {!! @$settings->valueOf('our_exports_'.app()->getLocale()) !!}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if (@$partners && @$partners->isNotEmpty())
        <section class="section-padding founders">
            <div class="container">
                <h3 class="text-black mb-4">المؤسسون</h3>
                <div class="swiper-container">
                    <div class="swiper-wrapper">

                    @foreach ($partners as $partner)
                        <div class="swiper-slide">
                            <div class="img-founder">
                                <img src="{{ imageUrl(@$partner->image) }}" alt="founder-img">
                            </div>
                            <div class="info">
                                <h5 class="job-title">{{ @$partner->title }}</h5>

                            </div>
                        </div>
                     @endforeach
                    </div>
                </div>
            </div>
        </section>
        @endif
        <div>

            @include('front.home.sections.teams')

        </div>
    </section><!-- end:: section -->
@endsection
