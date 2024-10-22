@extends('front.layouts.index', ['is_active' => 'test_courses', 'sub_title' => @$course->title])

@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/plyr.css') }}" />

    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
            background-color:grey;
        }
    </style>
@endpush


@section('content')
    @php
        $active_option = "curriculum";

        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('my_courses'),
                'link' => route('user.courses.myCourses'),
            ],
            [
                'title' => @$course->title,
                'link' => '#',
            ],
        ];
    @endphp

    @if (@$course->is_end && !@$course->is_rating)
        @include('front.user.courses.components.course_rate_modal')
    @endif

	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            @include('front.user.courses.components.registered_course_breadcrumb')

			<div class="row mb-2">

				<div class="col-lg-8">

                    @switch($item_type)
                        @case('lesson')
                            @include('front.user.courses.curriculum.lessons.partials.lesson_title_and_nav_btns')

                            @include('front.user.courses.curriculum.lessons.content')

                            @include('front.user.courses.curriculum.lessons.description')

                            @include('front.user.courses.curriculum.lessons.attachments')

                            @include('front.user.courses.curriculum.lessons.comments')
                            @break

                        @case('quiz')
                            @if (@$course_item->studentQuizResults->isNotEmpty())
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $end_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $course_item->studentQuizResults[0]->started_at)->addMinutes($course_item->time);

                                    $passed_time = $now > $end_time;

                                    $finished = @$course_item->studentQuizResults[0]->status != 'waiting';
                                @endphp
                                @if (@$finished)
                                    @include('front.user.courses.curriculum.quizzes.solution')
                                @else
                                    @include('front.user.courses.curriculum.quizzes.description')
                                @endif
                            @else
                                @include('front.user.courses.curriculum.quizzes.description')
                            @endif

                            @break

                        @case('assignment')
                            @if (@$course_item->studentAssignmentResults->isNotEmpty())
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $end_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $course_item->studentAssignmentResults[0]->started_at)->addMinutes($course_item->time);

                                    $passed_time = $now > $end_time;

                                    $finished = @$course_item->studentAssignmentResults[0]->status != 'not_submitted';
                                @endphp
                                @if (@$finished)
                                    @include('front.user.courses.curriculum.assignments.solution')
                                @else
                                    @include('front.user.courses.curriculum.assignments.description')
                                @endif
                            @else
                                @include('front.user.courses.curriculum.assignments.description')
                            @endif

                            @break

                        @case('live_lesson')
                            @include('front.user.courses.curriculum.lessons.partials.lesson_title_and_nav_btns')

                            @include('front.user.courses.curriculum.live_lessons.content')

                            @include('front.user.courses.curriculum.lessons.description')

                            @include('front.user.courses.curriculum.lessons.attachments')

                            @include('front.user.courses.curriculum.lessons.comments')
                            @break

                    @endswitch
				</div>

				@include('front.user.courses.curriculum.components.content_navigation_widget')

			</div>
		</div>
	</section>
@endsection


@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
	<script src="{{ asset('assets/front/js/plyr.polyfilled.js') }}"></script>

	<script>
		/*------------------------------------
	        player
	        --------------------------------------*/
		if ($(".player").length) {
			new Plyr(".player");
		}
	</script>
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>

    @php $item_type == 'lesson' ? $lesson_type = "normal" : $lesson_type = "live" @endphp
    <script>
        //alert("{{$item_type}}");
    </script>
    @if ($item_type == 'lesson' || ($item_type == 'live_lesson' && @$course_item->meeting == "finished"))
        @if ((@$course_item->file_type=='audio' || @$course_item->file_type=='video') && !$course_item->is_completed())
        <script>
            setTimeout(() => {
                $('#next_btn').removeClass('disabled');
                $.get("{{route('user.courses.curriculum.lesson.set.completed', ['course_id'=>@$course->id, 'id' => $course_item->id, 'type' => @$lesson_type ])}}");
            }, "{{@$course_item->duration*60000}}");
        </script>
        @else
            <script>
                $('#next_btn').click(function() {
                    $.get("{{route('user.courses.curriculum.lesson.set.completed', ['course_id'=>@$course->id, 'id' => $course_item->id, 'type' => @$lesson_type ])}}");
                });
            </script>
        @endif
    @endif

@endpush
