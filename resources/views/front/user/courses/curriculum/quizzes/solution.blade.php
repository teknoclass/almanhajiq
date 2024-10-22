<div class="row mb-3">
    <div class="col-12 mb-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="font-medium"><span class="square ms-2 me-2"></span> {{ @$course_item->title }}</h4>
            <div class="d-flex align-items-center">
            @if ($course_item->student_status != 'waiting')
                <div class="quiz-passed font-medium me-2 d-flex align-items-center text-{{ $course_item->student_status == 'passed' ? 'success' : 'danger' }}">
                    {{ $course_item->grade }} / {{ $course_item->student_grade }}
                </div>
            @endif
            @include('front.user.courses.curriculum.components.content_navigation_buttons')
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="bg-white rounded-2 p-3 p-lg-4 border-child">
            <div class="d-flex align-items-center text-center">
                <div class="col-3 col-lg-3 border-end p-3">
                    <h5 class="text-muted">{{ __('duration') }}</h5>
                </div>
                <div class="col-3 col-lg-2 border-end p-3">
                    <h5 class="text-muted">{{ __('grad') }}</h5>
                </div>
                <div class="col-3 col-lg-2 border-end p-3">
                    <h5 class="text-muted">{{ __('pass_grade') }}</h5>
                </div>
                <div class="col-3 col-lg-5 p-3">
                    <h5 class="text-muted">{{ __('status') }}</h5>
                </div>
            </div>
            <div class="d-flex align-items-center text-center">
                <div class="col-3 col-lg-3 border-end p-3">
                    <h4 class="font-medium">{{ @$course_item->time }} {{ __('minutes') }}</h4>
                </div>
                <div class="col-3 col-lg-2 border-end p-3">
                    <h4 class="font-medium">{{ @$course_item->grade }}</h4>
                </div>
                <div class="col-3 col-lg-2 border-end p-3">
                    <h4 class="font-medium">{{ @$course_item->pass_mark }}</h4>
                </div>
                <div class="col-3 col-lg-5  p-3">
                    @if (@$course_item->student_status == 'passed')

                    <div class="d-flex align-items-center justify-content-center">
                        <h4 class="font-medium text-success me-3">
                            {{   __('passed') }}
                        </h4>
                        @if (@$course_item->quizResults[0]->result_token)
                        <button id="share_result" data-url="{{ route('show.quiz.result', ['result_token' => @$course_item->quizResults[0]->result_token]) }}"
                            class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary p-2 " target="__blank">

                            <i class="fa-solid fa-share-nodes text-white"></i>
                        </button>
                        @endif
                    </div>
                    @else
                    <h4 class="font-medium text-danger">{{ __('unfortunately_failed') }}</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($course_item->quizQuestions as $key => $question)

    @switch($question->type)
        @case(\App\Models\CourseQuizzesQuestion::$descriptive)
            @include('front.user.courses.curriculum.quizzes.solution_types.fill')
            @break

        @case(\App\Models\CourseQuizzesQuestion::$multiple)
            @include('front.user.courses.curriculum.quizzes.solution_types.multiple')
            @break

        @case(\App\Models\CourseQuizzesQuestion::$true_false)
            @include('front.user.courses.curriculum.quizzes.solution_types.true_false')
            @break

        @default

    @endswitch
@endforeach


@if (@$course_item->student_status == 'passed')
@push('front_js')
    <script>
        document.getElementById('share_result').addEventListener('click', function() {
            let url = $(this).data('url');
            navigator.clipboard.writeText(url);

            customSweetAlert(
                'success',
                "<span class='info'>{{ __('link_copied') }}! {{ __('share_link_description') }}</span>",
                ''
            );
        });
    </script>
@endpush
@endif
