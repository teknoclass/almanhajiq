@php
$userAnswer = $questionGrade = $questionStatus = 0;

if (isset($student_solutions[$question->id])) {
    $userAnswer = $student_solutions[$question->id]['answer'] ?? 0;
    $questionGrade = $student_solutions[$question->id]['grade'] ?? 0;
    $questionStatus = $student_solutions[$question->id]['status'] ?? 0;
}
@endphp

<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question border border-{{ $questionStatus ? 'success' : 'danger' }}">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ $question->title }}</h5>
            <div class="question-grade font-medium d-flex align-items-center border-{{ $questionStatus ? 'success' : 'danger' }} text-{{ $questionStatus ? 'success' : 'danger' }}">
                {{ $question->grade }} / {{ $questionGrade }}
            </div>
        </div>
		<div class="d-flex flex-column item-answer">
            @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                @php
                    $cssClass = '';

                    if ($userAnswer == $answer->id) {
                        $cssClass = $answer->correct ? 'success' : 'error';
                    } elseif ($answer->correct) {
                        $cssClass = 'success';
                    }
                @endphp

                <label for="multiple-{{ $answer->id }}" class="m-radio mb-3 answer-{{ $cssClass }}">
                    <input id="multiple-{{ $answer->id }}"  disabled="disabled" type="radio" name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}" />
                    <span class="checkmark"></span><span class="ms-2">{{ $answer->title }}</span>
                </label>
            @endforeach
		</div>
	</div>
</div>
