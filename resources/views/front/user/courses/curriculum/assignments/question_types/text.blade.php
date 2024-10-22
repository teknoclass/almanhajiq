
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
		<h5 class="font-medium mb-3">
            <span class="square"></span> {{ $question->title }}
        </h5>
		<textarea name="question[{{ $question->id }}][answer]" class="form-control p-3 rounded" rows="10" placeholder="..اكتب نصاً"></textarea>
	</div>
</div>
