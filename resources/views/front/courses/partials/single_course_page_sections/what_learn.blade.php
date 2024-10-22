@if (@$course->whatWillYouLearn->isNotEmpty())
    <div class="container mb-5">
        <div class="row gap-5 gap-lg-0">
            <div class="col-12 col-lg-7">
                <div class="card-course">
                    <div class="">
                        <h5 class="text-colot-primary font-bold">{{ __('what_will_you_learn') }}؟</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="list-desc">
                            @foreach ($course->whatWillYouLearn as $item)
                                <div class="d-flex align-items-center">
                                    {{-- <div class="col-auto me-2"><img
                                            src="{{ asset('assets/front/images/svg/check.svg') }}" alt="" />
                                    </div> --}}
                                    <div class="col">
                                        <h5 class="font-medium">{{ @$item->title }}</h5>
                                        <ul class="tools-list">
                                            <li class="text-muted">
                                                {{ @$item->description }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5">
                @include('front.courses.partials.single_course_page_sections.about_lecturer')
            </div>
        </div>
    </div>
@endif
