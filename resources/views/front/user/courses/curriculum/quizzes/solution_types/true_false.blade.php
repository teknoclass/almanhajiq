<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ $question->title }}</h5>
            <div class="question-grade font-medium d-flex align-items-center border-{{ $questionStatus ? 'success' : 'danger' }} text-{{ $questionStatus ? 'success' : 'danger' }}">
                {{ $question->grade }} / {{ $questionGrade }}
            </div>
        </div>
		<div class="d-flex flex-column item-answer">
            @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                <label for="TF-{{ $answer->id }}" class="m-radio mb-3 answer-{{ $loop->first ? 'success' : 'error' }}">
                    <input id="TF-{{ $answer->id }}"  disabled="disabled" type="radio" name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}" />
                    <span class="checkmark"></span><span class="ms-2">{{ $answer->title }}</span>
                </label>
            @endforeach
		</div>
	</div>
</div>
