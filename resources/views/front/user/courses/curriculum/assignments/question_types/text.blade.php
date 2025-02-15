
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3">
            <span class="square"></span> {!! $question->title !!}
        </h5>
		<textarea name="question[{{ $question->id }}][answer]" id="text-answer-{{ $question->id }}" class="form-control p-3 rounded" rows="10" placeholder="..اكتب نصاً" data-assignment-id="{{$assignment->id}}" data-question-id="{{$question->id}}"></textarea>
	</div>
</div>

<script>

    document.getElementById('text-answer-{{ $question->id }}').addEventListener('blur',function(){

        const assignmentId = this.getAttribute('data-assignment-id');
        const questionId = this.getAttribute('data-question-id');
        const textAnswer = this.value;

        fetch('/user/assignment/submitAnswer' , {
            method : 'POST',
            headers : {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                assignment_id: assignmentId,
                question_id: questionId,
                answer: textAnswer
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
