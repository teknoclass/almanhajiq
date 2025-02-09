<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3">{!! $question->title!!}</h5>
		<div class="row">
			<div class="col-lg-4">
				<div class="input-question">
					<input class="form-control rounded" id="text-answer-{{ $question->id }}" type="text" name="question[{{ $question->id }}][answer]" placeholder="إكتب هنا" value="" data-quiz-id="{{$quiz->id}}" data-question-id="{{$question->id}}"/>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

    document.getElementById('text-answer-{{ $question->id }}').addEventListener('blur',function(){

        const quizId = this.getAttribute('data-quiz-id');
        const questionId = this.getAttribute('data-question-id');
        const textAnswer = this.value;

        fetch('/user/quiz/submitAnswer' , {
            method : 'POST',
            headers : {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quiz_id: quizId,
                question_id: questionId,
                text_answer: textAnswer
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
</script>
