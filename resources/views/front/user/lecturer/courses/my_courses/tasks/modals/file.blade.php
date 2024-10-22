@php
$userAnswer = $questionGrade = null;

if (isset($student_solutions[$question->id])) {
    $userAnswer = $student_solutions[$question->id]['answer'];
    $questionGrade = $student_solutions[$question->id]['grade'];
    $files = json_decode($userAnswer, true);
}
@endphp
<div class="col-12 mb-3">
	<div class="bg-white rounded-2 p-3 item-question">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="font-medium"><span class="square"></span>{{ $question->title }}</h5>
            @if ($course_item->assignmentResults[0]->status != 'not_submitted' && $course_item->assignmentResults[0]->status != 'pending')
                <div class="question-grade font-medium d-flex align-items-center ">
                    {{ $questionGrade ?? 0 }}
                </div>
            @else
            <div class="question-grade font-medium d-flex align-items-center ">
                <input class="form-control me-2" type="number" name="grade[]" step="0.1" placeholder="{{ __('enter_mark') }}"/>
            </div>
            @endif
        </div>
        <div class="row">
            @if (@$files)
            @foreach ($files as $file)
            @php
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $assignment = CourseAssignmentUrl(@$course_id, @$file);
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
            @endforeach
            @endif
        </div>
	</div>
</div>
