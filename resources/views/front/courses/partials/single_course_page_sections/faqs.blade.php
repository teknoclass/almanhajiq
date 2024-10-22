@if (@$course->faqs->isNotEmpty())
    {{-- Start Faqs Section --}}
    <div class="col-12 col-lg-8  mb-4 tab" id="{{ @$tab }}">
        <div class="row">
            <div class="col-12">
                <div class="py-3 p-1 pt-10">
                    <div class="">
                        <h2 class="text-color-primary font-bold mb-4">{{ __('faqs') }}</h2>
                    </div>
                    <div class="card-body pt-4 pb-4">
                        <div class="">
                                {{-- <div class="text-center mb-4">
                                    <img src="{{ imageUrl(@$course->faq_image) }}" alt="" loading="lazy" />
                                </div> --}}
                                <div id="accordion">
                                    @foreach (@$course->faqs as $i => $faq)
                                        <div class="widget__item-faq card-course p-0 mb-3 pointer px-3 px-lg-4 py-2 py-lg-3 collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#collapse-{{ $i }}"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center">
                                                <h4 class="pointer title collapsed flex-fill">{{ @$faq->faq->title }}
                                                </h4>
                                                <svg width="22" height="12" viewBox="0 0 22 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L11 11L21 1" stroke="#001D1E" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <div class="collapse" id="collapse-{{ $i }}"
                                                data-bs-parent="#accordion">
                                                <div class="pt-3 pb-2">
                                                    <h5>{{ @$faq->faq->text }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Faqs Section --}}
@endif
