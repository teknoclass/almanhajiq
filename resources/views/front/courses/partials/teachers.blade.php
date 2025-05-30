@php
    $url_lecturer = route('lecturerProfile.index', [
        'id' => @$lecturer->lecturer->id,
        'name' => mergeString(@$lecturer->name, ''),
    ]);

@endphp

<div class="col-md-6 col-lg-4 col-sm-12 ">
    <div class="courses-content">
        <div class="mb-2 mx-1 single-courses" style="min-height: 260px">
            <div class="item-courses ">
                <div class="category">
                    <div class="icon">
                        <svg width="121" height="32" viewBox="0 0 121 32" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.22609 1.78087C0.487949 1.19036 0.905503 0 1.85078 0H121V32H1.85079C0.905509 32 0.487948 30.8096 1.22609 30.2191L17.0478 17.5617C18.0486 16.7611 18.0486 15.2389 17.0478 14.4383L1.22609 1.78087Z"
                                fill="#6F2B90"></path>
                        </svg>
                    </div>
                    <span class="cate-title"> {{ $lecturer->lecturer->getRating() }} &nbsp;<span
                            class="far fa-star fa-solid" style="color: white"></span></span>
                </div>
                <div class="p-3">
                    <div class="courses-images">
                        <a href="{{ @$url_lecturer }}">
                            <img src="{{ imageUrl(@$lecturer->lecturer->image) }}"
                                alt="{{ @$lecturer->lecturer->name }}" loading="lazy" />
                        </a>
                    </div>
                    <div class="courses-content">
                        <a class="title" href="{{ @$url_lecturer }}">
                            {{ @$lecturer->lecturer->name }}
                        </a>

                        <div class="courses-meta">
                            <span class="text-color-muted">{{ @$lecturer->lecturer->lecturerSetting->position }}
                            </span>
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
                        <span class="sale-parice font-bold text-color-third">{!! @$course->getPriceDisc() !!}</span>
                    </div> --}}

                    <a href="{{ @$url_lecturer }}"
                        class="primary-btn p-1 w-100 d-block text-center border-0 rounded-0 py-2">
                        {{ __('courses') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
