@if (@$latest_courses && @$latest_courses->isNotEmpty())
    {{-- Start Latest Courses --}}
    <section id="latest-courses" class="section-padding">
        <div class="container">
            <!-- Section Title Start -->
            <h2 class="title-section">
                {{ __('latest_courses') }}
            </h2>
            <!-- Section Title End -->
            <div class="row">
                <div class="col-12">
                    <div class="categories pt-5 mb-4">
                        <div class="row">
                            @foreach($grade_levels as $level)
                            <div class="col-12 col-sm-6 col-lg-3 mb-4 mx-auto">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span>
                                            <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-0.0100098" y="0.606934" width="25" height="25"
                                                    rx="12.5" fill="#D18CF3" />
                                                <g clip-path="url(#clip0_53_164)">
                                                    <path
                                                        d="M17.59 7.58198V19.907L12.49 16.932L7.39001 19.907V7.58198C7.40772 7.22782 7.53168 6.92677 7.76189 6.67886C8.00981 6.44865 8.31085 6.32469 8.66501 6.30698H16.315C16.6692 6.32469 16.9702 6.44865 17.2181 6.67886C17.4483 6.92677 17.5723 7.22782 17.59 7.58198Z"
                                                        fill="#F1F1F1" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_53_164">
                                                        <rect width="10.5" height="13.6" fill="white"
                                                            transform="matrix(1 0 0 -1 7.23999 19.907)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        <h6>{{$level->name}}</h6>
                                        <span>
                                            <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-0.00299072" y="0.606934" width="25" height="25"
                                                    rx="12.5" fill="#D18CF3" />
                                                <g clip-path="url(#clip0_53_155)">
                                                    <path
                                                        d="M12.492 17.3569C12.2618 17.3569 12.0581 17.2772 11.8811 17.1179L6.78105 12.0179C6.62168 11.8408 6.54199 11.6371 6.54199 11.4069C6.54199 11.1767 6.62168 10.9731 6.78105 10.796C6.95814 10.6366 7.16178 10.5569 7.39199 10.5569C7.6222 10.5569 7.82585 10.6366 8.00293 10.796L12.492 15.3116L16.9811 10.796C17.1581 10.6366 17.3618 10.5569 17.592 10.5569C17.8222 10.5569 18.0258 10.6366 18.2029 10.796C18.3623 10.9731 18.442 11.1767 18.442 11.4069C18.442 11.6371 18.3623 11.8408 18.2029 12.0179L13.1029 17.1179C12.9258 17.2772 12.7222 17.3569 12.492 17.3569Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_53_155">
                                                        <rect width="12.25" height="13.6" fill="white"
                                                            transform="matrix(1 0 0 -1 6.367 19.907)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach($level->getSubChildren() as $child)
                                        <li>
                                            <a class="dropdown-item mx-1 item-categ" data-filter="{{$child->id}}">{{$child->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="row position-relative">
                        <div class="col-lg-11 mx-auto">
                            <div class="courses-content position-relative" style="min-height: 370px">
                                <div class="swiper-container swiper-filter">
                                    <div class="swiper-wrapper">
                                        @foreach ($latest_courses as $course)
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

                {{-- <div class="col-12 text-center mt-5">
                    <a href="{{ route('courses.index') }}" class="btn btn-primary px-5">
                        {{ __('All_Courses') }}
                    </a>
                </div> --}}
            </div>
        </div>
    </section>
    {{-- End Latest Courses --}}
@endif
