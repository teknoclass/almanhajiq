@extends('front.layouts.index', ['is_active' => '', 'my_acitvity' => __('course_details')])

@section('content')
@php
    $active_option = "my_activity";

    $breadcrumb_links = [
        [
            'title' => __('home'),
            'link' => route('user.home.index'),
        ],
        [
            'title' => __('sons'),
            'link' => route('user.home.index'),
        ],
        [
            'title' => @$son->son->name,
            'link' => '',
        ],
        [
            'title' => __('courses_details'),
            'link' => route('user.parent.sons.courses',$son->son_id),
        ],
        [
            'title' => @$course->title,
            'link' => '#',
        ],
    ];

    $total_lessons_count = @$uncompleted_lessons_count + @$completed_lessons_count;
    $total_quizzes_count = @$uncompleted_quizzes_count + @$completed_quizzes_count;
    $total_assignments_count = @$uncompleted_assignments_count + @$completed_assignments_count;

    $total_lessons_perc = ($total_lessons_count) ? (@$completed_lessons_count / $total_lessons_count) * 100 : 0;
    $total_quizzes_perc = ($total_quizzes_count) ? (@$completed_quizzes_count / $total_quizzes_count) * 100 : 0;
    $total_assignments_perc = ($total_assignments_count) ? (@$completed_assignments_count / $total_assignments_count) * 100 : 0;
@endphp
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
       
<div class="row mb-4 justify-content-between align-items-center">
    <div class="col-lg-9">
        <ol class="breadcrumb mb-0">
            @foreach($breadcrumb_links as $sub_link)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if(@$sub_link['link']!='#')
                        <a href="{{ @$sub_link['link'] }}">{{ @$sub_link['title'] }}</a>
                    @else
                        {{ @$sub_link['title'] }}
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>


        <div class="row mb-2">
            <div class="col-12">
                <h4 class="my-2 font-medium"><span class="square me-2"></span>
                {{__('course_details')}}

                </h4>
            </div>
        </div>
        <div class="row g-lg-5">
            @if (@$total_lessons_count)
                <div class="col-lg-4 col-sm-6">
                    <div class="text-center bg-white rounded-3 py-4 mb-4 d-grid justify-content-center">
                        <div class="circleProgress_1 circleProgress mb-4"></div>
                        <h4>
                        {{__('finish')}}
                        <span class="font-semi-bold">{{ @$completed_lessons_count }} {{__('lessons_o')}}
                    </span>
                    {{__('out_of')}}
                            {{ $total_lessons_count }}</h4>
                    </div>
                </div>
            @endif
            @if (@$total_quizzes_count)
                <div class="col-lg-4 col-sm-6">
                <div class="text-center bg-white rounded-3 py-4 mb-4 d-grid justify-content-center">
                        <div class="circleProgress_2 circleProgress mb-4"></div>
                        <h4>{{__('finish')}}
                        <span class="font-semi-bold">{{ @$completed_quizzes_count }}
                         {{__('quizzes')}}
                        </span>{{__('out_of')}}
                            {{ $total_quizzes_count }}</h4>
                    </div>
                </div>
            @endif
            @if (@$total_assignments_count)
                <div class="col-lg-4 col-sm-6">
                <div class="text-center bg-white rounded-3 py-4 mb-4 d-grid justify-content-center">
                        <div class="circleProgress_3 circleProgress mb-4"></div>
                        <h4>{{__('finish')}}
                        <span class="font-semi-bold">{{ @$completed_assignments_count }}
                    {{__('assignments')}}
                    </span>{{__('out_of')}}
                            {{ $total_assignments_count }}</h4>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            @if (@$completed_lessons->isNotEmpty() || @$completed_quizzes->isNotEmpty() || @$completed_assignments->isNotEmpty())
                <div class="col-lg-6">
                    @if (@$completed_lessons->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-success">
                                    <span class="square me-2"></span>
                                    {{__('contents_have_been_completed')}}
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($completed_lessons as $lesson)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'lesson', 'id' => $lesson->id]) }}">
                                                <p class="me-2">{{ $lesson->title }}</p>
                                            </a>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                                <p class="pt-1 text--muted col-auto">
                                                    {{ changeDateFormate($lesson->learningStatus->created_at) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (@$completed_quizzes->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-success"><span class="square me-2"></span>
                                 {{__('tests_completed')}}
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($completed_quizzes as $quiz)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'quiz', 'id' => @$quiz->id]) }}">
                                                <p class="me-2">{{ @$quiz->title }}</p>
                                            </a>
                                        </div>
                                        @if (@$quiz->studentQuizResults[0]->created_at)
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                                    <p class="pt-1 text--muted col-auto">
                                                        {{ changeDateFormate(@$quiz->studentQuizResults[0]->created_at) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (@$completed_assignments->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-success"><span class="square me-2"></span>
                            {{__('assignments_delivered')}}
                            </h4>
                            </div>
                            <div class="col-12">
                                @foreach ($completed_assignments as $assignment)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'assignment', 'id' => @$assignment->id]) }}">
                                                <p class="me-2">{{ @$assignment->title }}</p>
                                            </a>
                                        </div>
                                        @if (@$assignment->studentAssignmentResults[0]->created_at)
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                                    <p class="pt-1 text--muted col-auto">
                                                        {{ changeDateFormate($assignment->studentAssignmentResults[0]->created_at) }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-1 position-relative">
                    <div class="line-vertical"></div>
                </div>
            @endif
            @if (@$uncompleted_lessons->isNotEmpty() || @$uncompleted_quizzes->isNotEmpty() || @$uncompleted_assignments->isNotEmpty())
                <div class="col-lg-5">
                    @if (@$uncompleted_lessons->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-danger"><span class="square me-2">

                                </span>
                            {{__('contents_not_finalized')}}
                            </h4>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($uncompleted_lessons as $lesson)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'lesson', 'id' => $lesson->id]) }}">
                                                <p class="me-2">{{ $lesson->title }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (@$uncompleted_quizzes->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-danger">
                                    <span class="square me-2"></span>
                                 {{__('tests_not_completed')}}
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($uncompleted_quizzes as $quiz)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'quiz', 'id' => @$quiz->id]) }}">
                                                <p class="me-2">{{ @$quiz->title }}</p>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (@$uncompleted_assignments->isNotEmpty())
                        <div class="row mb-2 border-bottom pb-2">
                            <div class="col-12">
                                <h4 class="my-2 font-medium text-danger"><span class="square me-2"></span>
                                 {{__('assignments_not_delivered')}}
                                </h4>
                            </div>
                            <div class="col-lg-12">
                                @foreach ($uncompleted_assignments as $assignment)
                                    <div class="d-flex justify-content-between mb-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <a class="d-flex align-items-center col-auto"
                                                href="{{ route('user.courses.curriculum.openByItem', ['course_id' => $course->id, 'type' => 'assignment', 'id' => $assignment->id]) }}">
                                                <p class="me-2">{{ $assignment->title }}</p>
                                            </a>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section><!-- end:: section -->



@endsection

@push('front_js')
    <script src="{{ asset('assets/front/js/jquery.circle-progress.min.js') }}"></script>
    <script>
        $(".circleProgress_1").circleProgress({
            max: 100,
            value: {{ $total_lessons_perc }},
            textFormat: "percent",
        });

        $(".circleProgress_2").circleProgress({
            max: 100,
            value: {{ $total_quizzes_perc }},
            textFormat: "percent",
        });

        $(".circleProgress_3").circleProgress({
            max: 100,
            value: {{ $total_assignments_perc }},
            textFormat: "percent",
        });
        /*------------------------------------
          rating
        --------------------------------------*/
        $('.kv-rtl-theme-default-star').rating({
            hoverOnClear: false,
            step: 1,
            containerClass: 'is-star'
        });
    </script>
@endpush