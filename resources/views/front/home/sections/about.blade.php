<section class="about-section section-padding">
    <div class="container">
        <h2 class="title-section mb-4">من نحن؟</h2>
        <div class="row">
            <div class="col-12 col-md-6 col-xl-4 mb-4">
                <div class="item">
                    <div class="image">
                        <img src="{{ asset('assets/front/images/newimages/formkit_time.svg') }}" alt="icon">
                    </div>

                    <div class="info col-6 mx-auto">
                        <h6 class="title"> {{__('when_founded')}}</h6>
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
                        <img src="{{ asset('assets/front/images/newimages/fluent_stream-output-20-filled.svg') }}" alt="icon">
                    </div>

                    <div class="info col-6 mx-auto">
                        <h6 class="title">{{__('our_exports')}}</h6>

                        @if(!@$settings->valueOf('our_exports_'.app()->getLocale()))
                        <p>
                            للمدونات التعليمية، وقراءة الكتب ، الفيديوهات التعليمية والمتنوعة ، والأستماع...
                            للمدونات التعليمية، وقراءة الكتب ، الفيديوهات التعليمية والمتنوعة ، والأستماع...
                            للمدونات التعليمية، وقراءة الكتب ، الفيديوهات التعليمية والمتنوعة ، والأستماع...
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
