<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question border">

        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{!! $question->title !!}</h5>
            <div class="question-grade font-medium d-flex align-items-center">
                {{ $question->grade }}
            </div>
        </div>
		<div class="row">
            @if (@$question->quizzesQuestionsAnswers->isNotEmpty())
                @foreach ($question->quizzesQuestionsAnswers as $answer)
                <div class="col-lg-6 col-12">
                    <div class="input-question input-answer mb-3">
                        <input class="form-control rounded" type="text" value="{{ @$answer->title }}" disabled/>
                    </div>
                </div>
                @endforeach
            @endif
		</div>
	</div>
</div>
