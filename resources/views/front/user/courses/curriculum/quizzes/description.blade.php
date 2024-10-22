<div class="row mb-3">
    <div class="col-12">
    <div class="d-flex align-items-center justify-content-between">
        <h4 class="font-medium"><span class="square ms-2"></span> {{ @$course_item->title }}</h4>
        <div class="d-flex align-items-center">
        @include('front.user.courses.curriculum.components.content_navigation_buttons')

        @if (@$finished)
        <div class="quiz-passed font-medium d-flex align-items-center text-{{ $course_item->student_status == 'passed' ? 'success' : 'danger' }}">
            {{ __('result') }}: {{ $course_item->student_grade }}
        </div>
        @endif
        </div>
    </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
    <div class="bg-white rounded-2 p-3 p-lg-4 border-child">
        <div class="d-flex align-items-center">
        <div class="col-3 col-lg-2 border-end p-3">
            <h5 class="text-muted">{{ __('duration') }}</h5>
        </div>
        <div class="col-9 col-lg-10 py-3 px-4">
            <h4 class="font-medium">{{ @$course_item->time }} {{ __('minutes') }}</h4>
        </div>
        </div>
        <div class="d-flex align-items-center">
        <div class="col-3 col-lg-2 border-end p-3">
            <h5 class="text-muted">{{ __("questions_no") }}</h5>
        </div>
        <div class="col-9 col-lg-10 py-3 px-4">
            <h4 class="font-medium">{{ @$course_item->quiz_questions_count }}</h4>
        </div>
        </div>
        <div class="d-flex align-items-center">
        <div class="col-3 col-lg-2 border-end p-3">
            <h5 class="text-muted">{{ __('pass_grade') }}</h5>
        </div>
        <div class="col-9 col-lg-10 py-3 px-4">
            <h4 class="font-medium">{{ @$course_item->pass_mark }}</h4>
        </div>
        </div>
    </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12" style="display:{{ @$course->is_delete == 1 ? 'none' : 'block'}}">
        @php
        if ($course_item->studentQuizResults->isNotEmpty() && !@$passed_time)
            $btn_text = __('continue_quiz');
        else if ($course_item->studentQuizResults->isNotEmpty() && @$passed_time)
            $btn_text = __('quiz_result');
        else
            $btn_text = __('start_quiz');

        $btn_link = route('user.courses.curriculum.quiz.start', ['course_id' => @$course->id, 'id' => @$course_item->id]);
        @endphp
        <a href="{{ $btn_link }}" class="btn btn-primary font-medium">{{ $btn_text }}</a>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
    <h6 class="mb-3">{{ @$course_item->description }}</h6>
    </div>
</div>
