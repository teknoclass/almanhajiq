<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">

		<h5 class="font-medium mb-3">{!! $question->title !!}</h5>
		<div class="d-flex flex-column item-answer">
            @foreach($question->quizzesQuestionsAnswers as $key => $answer)
                <div class="answer-item">
                    <label for="multiple-{{ $answer->id }}" class="m-radio mb-3">
                        <input id="multiple-{{ $answer->id }}" type="radio" name="question[{{ $question->id }}][answer]" value="{{ $answer->id }}" class="answer-option" data-quiz-id="{{ $quiz->id }}" data-question-id="{{ $question->id }}" />
                        <span class="checkmark"></span><span class="ms-2">{{ $answer->title }}</span>
                    </label>
                </div>
            @endforeach
		</div>
	</div>
</div>


<script>
    document.querySelectorAll('.answer-option').forEach(option => {
        option.addEventListener('change', function () {
            const quizId = this.getAttribute('data-quiz-id');
            const questionId = this.getAttribute('data-question-id');
            const answerId = this.value;

            fetch('/user/quiz/submitAnswer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept' : 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    quiz_id: quizId,
                    question_id: questionId,
                    answer_id: answerId,
                })
            })
            .then(response => {
                if (response.ok && response.headers.get('content-type')?.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => { throw new Error(text); });
                }
            })
            .then(data => {
                console.log('Answer submitted:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });

        });
    });
</script>

