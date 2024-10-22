@if (@$work_steps && @$work_steps->isNotEmpty())
    <!-- About Start -->
    <section class="section-padding">
        <div class="container">
            <div id="how-work">
                <div class="content">
                    <h3 class="text-white text-center">{{ __('why_register_platform') }}</h3>
                    <div class="row">
                        {{-- <div class="col-md-2 col-0"></div> --}}
                        <div class="col-lg-12 col-12">
                            <div class="position-relative">
                                <div id="work-box-slide" class="info">
                                    <button id="scroll-up" class="bg-transparent text-color-secondary p-1">
                                        <i class="fa-solid fa-arrow-up fa-xl"></i>
                                    </button>
                                    @foreach ($work_steps as $i => $step)
                                        <div
                                            class="widget_item-works pb-1 widget-{{ @$i + 1 }} d-flex align-items-center">
                                            <div
                                                class="widget_item-icon d-inline-flex align-items-center justify-content-center shadow-none col-auto me-3">
                                                {{ @$i + 1 }}
                                            </div>
                                            <h2 class="widget_item-title">{!! @$step->text !!}</h2>
                                        </div>
                                    @endforeach
                                    <button id="scroll-down" class="bg-transparent text-color-secondary p-1">
                                        <i class="fa-solid fa-arrow-down fa-xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2 col-0"></div> --}}
                    </div>
                </div>
            </div>
        </div>



    </section>
    <!-- About End -->

@endif
