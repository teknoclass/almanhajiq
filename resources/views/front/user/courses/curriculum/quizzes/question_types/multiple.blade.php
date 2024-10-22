<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3">{{ $question->title }}</h5>
		<div class="d-flex flex-column item-answer">
            @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                <div class="answer-item">
                    <label for="multiple-{{ $answer->id }}" class="m-radio mb-3">
                        <input id="multiple-{{ $answer->id }}" type="radio" name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}" />
                        <span class="checkmark"></span><span class="ms-2">{{ $answer->title }}</span>
                    </label>
                </div>
            @endforeach
		</div>
	</div>
</div>
