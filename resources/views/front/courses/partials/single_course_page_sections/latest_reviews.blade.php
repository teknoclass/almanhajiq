@if (@$course->reviews->isNotEmpty())
    <div class="container mb-5 tab" id="{{ @$tab }}">
        <div class="row">
            <div class="col-12">
                <div class="card-course">
                    <div class="text-center">
                        <h5 class="text-colot-primary font-bold">{{ __('latest_reviews') }}</h5>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="row">
                            <div class="col-lg-9 mx-auto">
                                <div class="swiper-container swiper-rating">
                                    <div class="swiper-wrapper">
                                        @foreach (@$course->reviews as $review)
                                            <div class="swiper-slide">
                                                <div class="widget_item-rating text-center mb-4 shadow-none">
                                                    <div class="widget_item-image mb-3">
                                                        <img class="rounded-circle user-review-image"
                                                            src="{{ imageUrl(@$review->user->image) }}"
                                                            alt="{{ @$review->user->name }}" loading="lazy"/>
                                                    </div>
                                                    <div class="widget_item-content">
                                                        <h4 class="font-medium mb-2">{{ @$review->user->name }}</h4>
                                                        <div
                                                            class="data-rating rating-small d-flex align-items-center mb-3 justify-content-center">
                                                            <span class="d-flex" data-rating="{{ @$review->rate }}">
                                                                <i class="far fa-star"></i><i class="far fa-star"></i><i
                                                                    class="far fa-star"></i><i
                                                                    class="far fa-star"></i><i class="far fa-star"></i>
                                                            </span>
                                                        </div>
                                                        <div class="bg-light-green text-center rounded p-4">
                                                            {{ @$review->comment_text }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="swiper-action swiper-action-rating d-flex align-items-center justify-content-between px-lg-5">
                            <div
                                class="swiper-prev d-inline-flex align-items-center justify-content-center rounded-circle">
                                <i class="fa-solid fa-chevron-{{ app()->getlocale() == 'ar' ? 'right' : 'left' }} "></i>
                            </div>
                            <div
                                class="swiper-next d-inline-flex align-items-center justify-content-center rounded-circle">
                                <i class="fa-solid fa-chevron-{{ app()->getlocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
