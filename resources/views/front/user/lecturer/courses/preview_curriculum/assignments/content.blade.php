<div class="row mb-3">
	<div class="col-12">
		<div class="d-flex align-items-center justify-content-between">
			<h4 class="font-medium"><span class="square ms-2"></span> {{ @$course_item->title }}</h4>
			<div class="d-flex align-items-center">
				@include('front.user.lecturer.courses.preview_curriculum.components.content_navigation_buttons')
			</div>
		</div>
	</div>
</div>
<div class="row mb-4">
	<div class="col-12">
		<div class="bg-white rounded-2 p-3 p-lg-4 border-child">
			<div class="d-flex align-items-center">
				<div class="col-3 col-lg-2 border-end p-3">
					<h5 class="text-muted">المدة</h5>
				</div>
				<div class="col-9 col-lg-10 py-3 px-4">
					<h4 class="font-medium">{{ @$course_item->time }} min</h4>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<div class="col-3 col-lg-2 border-end p-3">
					<h5 class="text-muted">عدد الأسئلة</h5>
				</div>
				<div class="col-9 col-lg-10 py-3 px-4">
					<h4 class="font-medium">{{ @$course_item->assignment_questions_count }}</h4>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<div class="col-3 col-lg-2 border-end p-3">
					<h5 class="text-muted">علامة النجاح</h5>
				</div>
				<div class="col-9 col-lg-10 py-3 px-4">
					<h4 class="font-medium">{{ @$course_item->pass_grade }}</h4>
				</div>
			</div>
			<div class="d-flex align-items-center">
				<div class="col-3 col-lg-2 border-end p-3">
					<h5 class="text-muted">{{ __('description_title') }}</h5>
				</div>
				<div class="col-9 col-lg-10 py-3 px-4">
					<h4 class="">{{ @$course_item->description }}</h4>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mb-3">
	@foreach ($course_item->assignmentQuestions as $key => $question)
		@switch($question->type)
			@case(\App\Models\CourseAssignmentQuestions::$text)
				@include('front.user.lecturer.courses.preview_curriculum.assignments.questions.text')
			@break

			@case(\App\Models\CourseAssignmentQuestions::$file)
				@include('front.user.lecturer.courses.preview_curriculum.assignments.questions.file')
			@break

			@default
		@endswitch
	@endforeach
</div>
