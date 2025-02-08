@php
$userAnswer = $questionGrade = null;

if($question->userAnswers != null){
    $userAnswer = $question->userAnswers->file;
    $questionGrade = $question->userAnswers->mark;
}
@endphp
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{!! $question->title !!}</h5>
            @if ($course_item->assignmentResults[0]->status != 'not_submitted' && $course_item->assignmentResults[0]->status != 'pending')
                <div class="question-grade font-medium d-flex align-items-center ">
                    {{ $questionGrade ?? 0 }}
                </div>
            @else
            <div class="question-grade font-medium d-flex align-items-center ">
                <input class="form-control me-2" id="input-{{$question->id}}" type="number" name="grade[]" step="0.1" placeholder="{{ __('enter_mark') }}" data-question-id="{{$question->id}}" data-result-id="{{$course_item->assignmentResults[0]->id}}"/>
            </div>
            @endif
        </div>
        <div class="row">
            @if (@$userAnswer)
            @php
                $extension = pathinfo($userAnswer, PATHINFO_EXTENSION);
                $assignment = CourseAssignmentUrl(@$course_id, @$userAnswer);
            @endphp
            <div class="col-auto">
                <div class="widget__item-attac">
                    <div class="widget__item-icon">
                        @if ($extension == 'pdf')
                            <a href="{{ $assignment }}" download="{{ $question->title.'.'.$extension }}">
                                <i class="fas fa-file-pdf fa-2x"></i>
                            </a>
                        @else
                            <a href="{{ $assignment }}" download="{{ $question->title.'.'.$extension }}">
                                <img src="{{ $assignment }}" alt="" loading="lazy"/>
                            </a>
                        @endif
                    </div>
                </div>


            </div>
            @endif
        </div>
	</div>
</div>



<script>

    document.getElementById('input-{{ $question->id }}').addEventListener('blur',function(){

        const resultId = this.getAttribute('data-result-id');
        const questionId = this.getAttribute('data-question-id');
        const mark = this.value;

        fetch('/user/lecturer/my-courses/submitMark' , {
            method : 'POST',
            headers : {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                result_id: resultId,
                question_id: questionId,
                mark: mark
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
