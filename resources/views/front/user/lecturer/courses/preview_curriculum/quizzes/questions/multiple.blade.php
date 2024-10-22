
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question border">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ $question->title }}</h5>
            <div class="question-grade font-medium d-flex align-items-center">
                {{ $question->grade }}
            </div>
        </div>
		<div class="d-flex flex-column item-answer">
            @foreach($question->quizzesQuestionsAnswers as $key => $answer)
            @php
                $cssClass = $answer->correct ? 'answer-success' : '';
            @endphp

                <label for="multiple-{{ $answer->id }}" class="m-radio mb-3 {{ $cssClass }}">
                    <input id="multiple-{{ $answer->id }}"  disabled="disabled" type="radio" />
                    <span class="checkmark"></span><span class="ms-2">{{ $answer->title }}</span>
                </label>
            @endforeach
		</div>
	</div>
</div>
