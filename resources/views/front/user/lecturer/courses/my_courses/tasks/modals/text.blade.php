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
            @if ($course_item->assignmentResults[0]->status != 'not_submitted' && $course_item->assignmentResults[0]->status != 'pending')
                <div class="question-grade font-medium d-flex align-items-center ">
                    {{ $questionGrade }}
                </div>

            @else
            <div class="question-grade font-medium d-flex align-items-center ">
                <input class="form-control me-2" type="number" step="0.1" name="grade[]" placeholder="{{ __('enter_mark') }}"/>
            </div>
            @endif
        </div>
		<textarea class="form-control p-3 rounded" disabled rows="3">{{ $userAnswer }}</textarea>

	</div>
</div>
