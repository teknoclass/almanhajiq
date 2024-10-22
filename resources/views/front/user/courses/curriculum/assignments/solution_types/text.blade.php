@php
$userAnswer = $questionGrade = null;

if (isset($student_solutions[$question->id])) {
    $userAnswer = $student_solutions[$question->id]['answer'];
    $questionGrade = $student_solutions[$question->id]['grade'];
}
@endphp
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ $question->title }}</h5>
            @if ($course_item->studentAssignmentResults[0]->status != 'not_submitted' && $course_item->studentAssignmentResults[0]->status != 'pending')
                <div class="question-grade font-medium d-flex align-items-center ">
                    {{ $questionGrade ?? 0 }}
                </div>
            @endif
        </div>
        @if (@$userAnswer)
		    <textarea class="form-control p-3 rounded" rows="3" disabled>{{ $userAnswer }}</textarea>
        @else
            <p class="text-muted">لم تتم الاجابة على هذا السؤال</p>
        @endif
	</div>
</div>
