@php
$userAnswer = $questionGrade = $questionStatus = 0;


if($question->userAnswer != null){
    $userAnswer = $question->userAnswer->text_answer;
    $questionGrade = $question->userAnswer->mark;
    $questionStatus = $question->userAnswer->status;
}

@endphp

<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question border border-{{ $questionStatus ? 'success' : 'danger' }}">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ Illuminate\Support\Str::limit(strip_tags($question->title), $limit = 71, $end = '...') }}</h5>
            <div class="question-grade font-medium d-flex align-items-center border-{{ $questionStatus ? 'success' : 'danger' }} text-{{ $questionStatus ? 'success' : 'danger' }}">
                {{ $question->grade }} / {{ $questionGrade }}
            </div>
        </div>
		<div class="row">
			<div class="col-lg-6 mb-3">
				<div class="input-question input-answer {{ $questionStatus ? 'success' : 'error' }}">
					<input class="form-control" type="text" value="{{ @$userAnswer }}" />
				</div>
			</div>
            @if (!$questionStatus)
			<div class="col-lg-6 col-12">
				<div class="input-question input-answer success">
					<input class="form-control" type="text" value="{{ @$question->quizzesQuestionsAnswers->first()->title }}" />
				</div>
			</div>
            @endif
		</div>
	</div>
</div>
