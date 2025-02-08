@php
$userAnswer = $questionGrade = null;

if($question->userAnswers != null){
    $userAnswer = $question->userAnswers->file;
    $questionGrade = $question->userAnswers->mark;
}
@endphp
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{!! $question->title !!}</h5>
            @if ($course_item->studentAssignmentResults[0]->status != 'not_submitted' && $course_item->studentAssignmentResults[0]->status != 'pending')
                <div class="question-grade font-medium d-flex align-items-center ">
                    {{ $questionGrade ?? 0 }}
                </div>
            @endif
        </div>
        <div class="row">
            @if (@$userAnswer)
                @php
                    $extension = pathinfo($userAnswer, PATHINFO_EXTENSION);
                @endphp
                <div class="col-auto">
                    <div class="widget__item-attac">
                        <div class="widget__item-icon">
                            @if ($extension == 'pdf')
                                <a href="{{ CourseAssignmentUrl(@$course->id, @$userAnswer) }}" download="{{ $question->title.'.'.$extension }}">
                                    <i class="fas fa-file-pdf fa-2x"></i>
                                </a>
                            @else
                                <a href="{{ CourseAssignmentUrl(@$course->id, @$userAnswer) }}" download="{{ $question->title.'.'.$extension }}">
                                    <img src="{{ CourseAssignmentUrl(@$course->id, @$userAnswer) }}" alt="" loading="lazy">
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted">لم تتم الاجابة على هذا السؤال</p>
            @endif
        </div>
	</div>
</div>
