@extends('front.layouts.index', ['is_active' => 'courses', 'sub_title' => 'دورة تدريبية مباشرة'])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/star-rating.min.css') }}" />
@endpush

@section('content')
    <!-- start:: section -->
    <section class="wow fadeInUp courseFrontPage" data-wow-delay="0.1s">

        @include('front.courses.partials.single_course_page_sections.hero')
        @php
            $sections = [
                [
                    'title' => __('course_information'),
                    'tab' => 'course-information',
                    'blade' => 'course_information',
                ],
                false
                    ? [
                        'title' => __('appointments_available'),
                        'tab' => 'appointments-available',
                        'blade' => 'appointments_available',
                    ]
                    : null,
                @$course->content && @$course->content->isNotEmpty()
                    ? [
                        'title' => __('course_content'),
                        'tab' => 'course-content',
                        'blade' => 'course_content',
                    ]
                    : null,
                // @$curriculum_items && @$curriculum_items->isNotEmpty()
                //     ? [
                //         'title' => __('course_curriculum'),
                //         'tab' => 'course-curriculum',
                //         'blade' => 'course_curriculum',
                //     ]
                //     : null,
                @$course->reviews && @$course->reviews->isNotEmpty()
                    ? [
                        'title' => __('latest_reviews'),
                        'tab' => 'latest-reviews',
                        'blade' => 'latest_reviews',
                    ]
                    : null,
                    @$course->faqs && @$course->faqs->isNotEmpty()
                    ? [
                        'title' => __('faqs'),
                        'tab' => 'faqs',
                        'blade' => 'faqs',
                    ]
                    : null,
                    @$course->forWhomThisCourse && @$course->forWhomThisCourse->isNotEmpty()
                    ? [
                        'title' => __('tools_requierd'),
                        'tab' => 'tools_requierd',
                        'blade' => 'tools_requierd',
                    ]
                    : null,
                @$course->whatWillYouLearn && @$course->whatWillYouLearn->isNotEmpty()
                    ? [
                        'title' => __('what_learn'),
                        'tab' => 'what_learn',
                        'blade' => 'what_learn',
                    ]
                    : null,
                !@$course->isSubscriber() && !checkUser('lecturer') && !checkUser('marketer') && (canStudentSubscribeToCourse(@$course->id, "full") || canStudentSubscribeToCourse(@$course->id, "installment"))
                    ? [
                        'title' => __('course_registration'),
                        'tab' => 'course-registration',
                        'blade' => 'course_registration',
                    ]
                    : null,
                (($course->can_subscribe_to_session_group == 1 || $course->can_subscribe_to_session == 1) && $course->published == 1 && !@$course->isSubscriber() && (@auth('web')->user()->role != "marketer"))
               ? [
                    'title' => __('subscription_offers'),
                    'tab' => 'course-subscription-offers',
                    'blade' => 'subscription_offers',
                ] :
                null,
            
            ];

            // To eliminate the nulls from the array for the sections not included
            $sections = array_filter($sections);
        @endphp
        {{--
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs justify-content-center bg-white rounded nav-course py-2 mb-4 border-0"
                        id="myTab" role="tablist">
                        @foreach ($sections as $section)
                            <li class="nav-item">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-scroll="{{ $section['tab'] }}">{{ $section['title'] }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
         --}}
        <div class="container">
            <div class="row">
                @foreach ($sections as $section)
                    @include('front.courses.partials.single_course_page_sections.' . $section['blade'], [
                        'tab' => $section['tab'],
                    ])
                @endforeach
            </div>

            @include('front.courses.partials.single_course_page_sections.similar_courses')

            @if (@$course->is_end && !@$course->is_rating)
                @include('front.user.courses.components.course_rate_modal')
            @endif
        </div>
    </section>
    <!-- end:: section -->
@endsection

@push('front_js')
    <script src="{{ asset('assets/front/js/rating.min.js') }}"></script>

    <script>
        $('.kv-rtl-theme-default-star').rating({
            hoverOnClear: false,
            step: 1,
            containerClass: 'is-star'
        });
    </script>

    @if (checkUser('marketer'))
        <script>
            function copyText() {
                // Create a temporary textarea element
                var tempTextarea = document.createElement("textarea");

                // Set its value to the registration link
                tempTextarea.value = "{{ url()->current() }}?marketer_coupon={{ @$coupon }}";

                // Append it to the body
                document.body.appendChild(tempTextarea);

                // Select the text inside the textarea
                tempTextarea.select();

                // Copy the text inside the textarea
                document.execCommand("copy");

                // Remove the temporary textarea
                document.body.removeChild(tempTextarea);

                toastr.success("{{ __('copy_completed_successfully') }}")
            }
        </script>
    @endif
@endpush
