@if (@$services && @$services->isNotEmpty())
    <!-- How It Work End -->
    <section id="services" class="section-padding">
        <div class="container">
            <h3 class="title-section">المنهج لطلاب المدارس</h3>
            <p class="desc">نقدم لكم حلول ومناهج معتمدة وحديثة في مختلف المراحل المدرسية  التعليمية :  الابتدائي المتوسط  الاعدادي</p>
            <div class="pt-5">
                <div class="services-content row justify-content-between align-items-center">
                    <div class="services-info col-12 col-md-6 col-lg-4 mb-4">
                        <div class="">
                            @foreach ($services as $i => $service)
                                <div class=" mb-4 wow animate__fadeInRight" data-wow-delay='{{$i+1 / 2}}s'>
                                    <a href="" class="item">
                                        {{ @$service->title }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 mb-4">
                        <div class="services-image">
                            <img src="{{ imageUrl(@$settings->valueOf('image_how_its_work')) }}" alt="services-image"
                                loading="lazy" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How It Work End -->
@endif
