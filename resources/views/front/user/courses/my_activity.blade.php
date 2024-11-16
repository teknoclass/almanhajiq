@extends('front.layouts.index', ['is_active' => '', 'my_acitvity' => 'نشاطي في الدورة'])

@section('content')
    @php
        $active_option = "my_activity";

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

        $total_lessons_count = @$uncompleted_lessons_count + @$completed_lessons_count;
        $total_quizzes_count = @$uncompleted_quizzes_count + @$completed_quizzes_count;
        $total_assignments_count = @$uncompleted_assignments_count + @$completed_assignments_count;

        $total_lessons_perc     = ($total_lessons_count) ? (@$completed_lessons_count / $total_lessons_count) * 100 : 0;
        $total_quizzes_perc     = ($total_quizzes_count) ? (@$completed_quizzes_count / $total_quizzes_count) * 100 : 0;
        $total_assignments_perc = ($total_assignments_count) ? (@$completed_assignments_count / $total_assignments_count) * 100 : 0;
    @endphp
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            @include('front.user.courses.components.registered_course_breadcrumb')

			<div class="row mb-2">
				<div class="col-12">
					<h4 class="my-2 font-medium"><span class="square me-2"></span> نشاطي في الدورة</h4>
				</div>
			</div>
			<div class="row g-lg-5">
                @if (@$total_lessons_count)
				<div class="col-lg-4 col-sm-6">
					<div class="text-center bg-white rounded-3 py-4 mb-4">
						<div class="circleProgress_1 circleProgress mb-4"></div>
						<h4>أنهى<span class="font-semi-bold">{{ @$completed_lessons_count }} دروس </span>من أصل {{ $total_lessons_count }}</h4>
					</div>
				</div>
                @endif
                @if (@$total_quizzes_count)
				<div class="col-lg-4 col-sm-6">
					<div class="text-center bg-white rounded-3 py-4 mb-4">
						<div class="circleProgress_2 circleProgress mb-4"></div>
						<h4>أنهى<span class="font-semi-bold">{{ @$completed_quizzes_count }} امتحانات </span>من أصل {{ $total_quizzes_count }}</h4>
					</div>
				</div>
                @endif
                @if (@$total_assignments_count)
				<div class="col-lg-4 col-sm-6">
					<div class="text-center bg-white rounded-3 py-4 mb-4">
						<div class="circleProgress_3 circleProgress mb-4"></div>
						<h4>أنهى<span class="font-semi-bold">{{ @$completed_assignments_count }} واجبات </span>من أصل {{ $total_assignments_count }}</h4>
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
							<h4 class="my-2 font-medium text-success"><span class="square me-2"></span> محتويات تم الانتهاء منها</h4>
						</div>
						<div class="col-lg-12">
                            @foreach ($completed_lessons as $lesson)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if(@$lesson->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'lesson', 'id'=> @$lesson->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$lesson->itemable->title }}</p>
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                            <p class="pt-1 text--muted col-auto">{{ changeDateFormate($lesson->lessonStatus->created_at) }}</p>
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
							<h4 class="my-2 font-medium text-success"><span class="square me-2"></span> إختبارات تم انهائهـا</h4>
						</div>
						<div class="col-lg-12">
                            @foreach ($completed_quizzes as $quiz)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if(@$quiz->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'quiz', 'id' => @$quiz->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$quiz->itemable->title }}</p>
                                        </a>
                                    </div>
                                    @if (@$quiz->itemable->studentQuizResults[0]->created_at)
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                            <p class="pt-1 text--muted col-auto">{{ changeDateFormate(@$quiz->itemable->studentQuizResults[0]->created_at) }}</p>
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
							<h4 class="my-2 font-medium text-success"><span class="square me-2"></span> مهام تم تسليمها</h4>
						</div>
						<div class="col-12">
                            @foreach ($completed_assignments as $assignment)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if(@$assignment->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'assignment', 'id'=>@$assignment->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$assignment->itemable->title }}</p>
                                        </a>
                                    </div>
                                    @if (@$assignment->itemable->studentAssignmentResults[0]->created_at)
                                    <div class="col-auto">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                                            <p class="pt-1 text--muted col-auto">{{ changeDateFormate($assignment->itemable->studentAssignmentResults[0]->created_at) }}</p>
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
							<h4 class="my-2 font-medium text-danger"><span class="square me-2"></span> محتويات لم يتم الانتهاء منها</h4>
						</div>
						<div class="col-lg-12">
                            @foreach ($uncompleted_lessons as $lesson)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if(@$lesson->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'lesson', 'id'=> @$lesson->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$lesson->itemable->title }}</p>
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
							<h4 class="my-2 font-medium text-danger"><span class="square me-2"></span> إختبارات لم يتم انهائهـا</h4>
						</div>
						<div class="col-lg-12">
                            @foreach ($uncompleted_quizzes as $quiz)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if(@$quiz->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'quiz', 'id'=>@$quiz->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$quiz->itemable->title }}</p>
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
							<h4 class="my-2 font-medium text-danger"><span class="square me-2"></span> واجبات لم يتم تسليمها</h4>
						</div>
						<div class="col-lg-12">
                            @foreach ($uncompleted_assignments as $assignment)
                                <div class="d-flex justify-content-between mb-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                                    </div>
                                    <div class="col">
                                        <a class="d-flex align-items-center col-auto" @if($assignment->itemable) href="{{ route('user.courses.curriculum.openByItem', ['course_id'=>$course->id, 'type' => 'assignment', 'id'=>$assignment->itemable->id]) }}" @endif>
                                            <p class="ms-2">{{ @$assignment->itemable->title }}</p>
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

    @if (@$course->is_end && !@$course->is_rating)
        @include('front.user.courses.components.course_rate_modal')
    @endif

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
