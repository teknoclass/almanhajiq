@if (@$featured_courses && @$featured_courses->isNotEmpty())
    {{-- Start Latest Courses --}}
    <section id="latest-courses" class="section-padding">
        <div class="container">
            <!-- Section Title Start -->
            <h2 class="title-section">
                {{ __('featured_courses') }}
            </h2>
            <!-- Section Title End -->
            <div class="row">
                <div class="col-12">
                   

                    <div class="row position-relative">
                        <div class="col-lg-11 mx-auto">
                            <div class="courses-content position-relative" style="min-height: 370px">
                                <div class="swiper-container swiper-filter">
                                    <div class="swiper-wrapper">
                                        @foreach ($featured_courses as $course)
                                            @php
                                                $url_course = route('courses.single', [
                                                    'id' => @$course->id,
                                                    'title' => mergeString(@$course->title, ''),
                                                ]);
                                                $url_curriculum = route('user.courses.curriculum.item', [
                                                    'course_id' => @$course->id ?? 0,
                                                ]);
                                                $is_subscriber = $course->isSubscriber();
                                            @endphp
                                         
                                            <div class="swiper-slide single-courses"
                                                data-filter="{{ @$course->grade_sub_level }}">
                                                <div class="item-courses">
                                                @if(@$course->material)
                                                    <div class="category">
                                                        <div class="icon">
                                                            <svg width="121" height="32" viewBox="0 0 121 32"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M1.22609 1.78087C0.487949 1.19036 0.905503 0 1.85078 0H121V32H1.85079C0.905509 32 0.487948 30.8096 1.22609 30.2191L17.0478 17.5617C18.0486 16.7611 18.0486 15.2389 17.0478 14.4383L1.22609 1.78087Z"
                                                                    fill="#6F2B90"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="cate-title">{{ @$course->material->name }}</span>
                                                    </div>
                                                    @endif
                                                    <div class="p-3">
                                                        <div class="courses-images">
                                                            <a
                                                                href="{{ @$is_subscriber ? @$url_curriculum : @$url_course }}">
                                                                <img src="{{ imageUrl(@$course->image) }}"
                                                                    alt="{{ @$course->title }}" loading="lazy" />
                                                            </a>
                                                        </div>
                                                        <div class="courses-content">
                                                            <span class="title">
                                                                <a class=""
                                                                    href="{{ @$is_subscriber ? @$url_curriculum : @$url_course }}">{{ @$course->title }}</a>
                                                            </span>
                                                            <div class="courses-meta">
                                                                <span>{{ Illuminate\Support\Str::limit(strip_tags($course->description), $limit = 71, $end = '...') }}</span>
                                                            </div>
                                                            <div class="info">
                                                                {{-- <div class="info-item d-flex gap-2 mb-2">
                                                                    <div class="image"><img
                                                                            src="{{ asset('assets/front/images/newimages/courses-time-icon.png') }}"
                                                                            alt="time icon"></div>
                                                                    <p class="text-color-muted">
                                                                        <span class="fw-bold text-color-primary">{{ __('duration') }}:</span>
                                                                        {{ @$course->duration }}
                                                                    </p>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        {{-- <div class="courses-price flex-fill">
                                                            <span
                                                                class="sale-parice font-bold text-color-third">{!! @$course->getPriceDisc() !!}
                                                            </span>
                                                        </div> --}}
                                                        @if (@$is_subscriber)
                                                            <a href="{{ @$url_curriculum }}"
                                                                class="primary-btn p-1 w-100 d-block text-center border-0 rounded-0 py-2">
                                                                {{ __('entry_to_lessons') }}
                                                            </a>
                                                        @else
                                                            <a href="{{ @$url_course }}"
                                                                class="primary-btn p-1 w-100 d-block text-center border-0 rounded-0 py-2">
                                                                {{ __('register_now') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    {{-- End Latest Courses --}}
@endif
