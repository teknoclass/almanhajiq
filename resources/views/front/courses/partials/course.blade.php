@php
    $url_course = route('courses.single', ['id' => @$course->id, 'title' => mergeString(@$course->title, '')]);
    $url_curriculum = route('user.courses.curriculum.item', ['course_id' => @$course->id ?? 0]);
    $is_subscriber = $course->isSubscriber();
@endphp
<div class="col-md-6 col-lg-4 col-sm-12 ">
    <div class="courses-content">
        <div class="mb-2  single-courses" style="min-height: 260px">
            <div class="item-courses {{ @$course->is_delete == 1 ? 'deletedCourse' : '' }}">

                @if(@$course->material)
                <div class="category">
                    <div class="icon">
                        <svg width="121" height="32" viewBox="0 0 121 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.22609 1.78087C0.487949 1.19036 0.905503 0 1.85078 0H121V32H1.85079C0.905509 32 0.487948 30.8096 1.22609 30.2191L17.0478 17.5617C18.0486 16.7611 18.0486 15.2389 17.0478 14.4383L1.22609 1.78087Z"
                                fill="#6F2B90"></path>
                        </svg>
                    </div>
                    <span class="cate-title">{{ @$course->material->name ?? ''}}</span>
                </div>
                @endif
                <div class="p-3">
                    <div class="courses-images ">
                        <a href="{{ @$is_subscriber ? @$url_curriculum : @$url_course }}">
                            <img src="{{ imageUrl(@$course->image) }}" alt="{{ @$course->title }}" loading="lazy" />
                        </a>
                    </div>
                    <div class="courses-content">
                        <br>
                    <p class="text-color-muted">
                        <a class="title  " style="font-size: 17px;"
                            href="{{ @$is_subscriber ? @$url_curriculum : @$url_course }}">{{ @$course->title }}
                            @if ($course->is_delete == 1)
                                <span class="fs-6 text-danger">{{ __('deleted_course') }}</span>
                            @endif
                        </a>
                    </p>

                        <div class="courses-meta">
                            <span
                                class="text-color-muted">{{ Illuminate\Support\Str::limit(strip_tags($course->description), $limit = 71, $end = '...') }}
                            </span>
                        </div>
                        <p class="text-color-muted" style="font-size: 13px;">
                            <span class="fw-bold text-color-primary">{{ __('grade_level') }}:</span>
                            {{@App\Models\Category::find(@$course->grade_level_id)->name ?? ""}}
                        </p>

                        <p class="text-color-muted" style="font-size: 13px;">
                            <span class="fw-bold text-color-primary">{{ __('grade_sub_level_id') }}:</span>
                            {{@App\Models\Category::find(@$course->grade_sub_level)->name ?? ""}}
                        </p>

                        <div class="info">

                            <div class="info-item d-flex gap-2 mb-2">
                               {{--<div class="image"><img
                                        src="{{ asset('assets/front/images/newimages/courses-time-icon.png') }}"
                                        alt="time icon"></div>--}}
                                <p class="text-color-muted">
                                    <span class="fw-bold text-color-primary">{{ __('type') }}:</span>
                                    {{ __(@$course->type) }}
                                </p><br>
                                <p class="text-color-muted">
                                    <span class="fw-bold text-color-primary">{{ __('price') }}:</span>
                                    {!! @$course->getPriceDisc() !!}
                                </p>
                            </div>

                        </div>
                        <div class="info">

                            <div class="info-item d-flex gap-2 mb-2">

                                <p class="text-color-muted">
                                    <span class="fw-bold text-color-primary">{{ __('subscription_end_date') }}:</span>
                                    @if ($course->subscription_end_date != null)
                                        {{$course->subscription_end_date}}
                                    @else
                                        {{__('no_date')}}
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="">
                  {{--  <div class="courses-price flex-fill">
                        <span class="sale-parice font-bold text-color-third">{!! @$course->getPriceDisc() !!}</span>
                    </div> --}}
                    @if(@auth('web')->user()->role != "marketer")
                        @if (@$is_subscriber || in_array($course->id, studentSubscriptionCoursessIds()) || in_array($course->id, studentInstallmentsCoursessIds()))
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

                    @else
                        <a href="{{ @$url_course }}"
                            class="primary-btn p-1 w-100 d-block text-center border-0 rounded-0 py-2">
                            {{ __('view') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
