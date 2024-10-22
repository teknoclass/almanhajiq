@if (@$question)
    <?php $type = @$question->type == 'multiple' ? 'multiple' : 'short_answer'; ?>
@else
    <?php $type = 'multiple'; ?>
@endif
<div class="tab-content mb-3">
    <input type="hidden" id="question_{{ @$question_no }}_type" name="question_{{ @$question_no }}_type" value="{{ @$question ? @$question->type : 'multiple' }}">

    @include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question_types.question_type_tab', ['question_no'=>@$question_no])

    <div class="tab-pane fade {{ @$type == 'multiple' ? 'show active' : '' }}" id="tab-question-select-{{ @$question_no }}">
        <div class="accordion" id="accordionExamSelect-{{ @$question_no }}">
            <div class="list-qestion-{{ @$question_no }}">
                @include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question_types.select.select', ['question_no'=>@$question_no])
            </div>
        </div>
    </div>

    <div class="tab-pane fade {{ @$type == 'short_answer' ? 'show active' : '' }}" id="tab-question-short-answer-{{ @$question_no }}">
        <div class="accordion" id="accordionExamShortAnswer-{{ @$question_no }}">
            <div class="list-qestion-complete">
                @include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question_types.short_answer.short_answer', ['question_no'=>@$question_no])
            </div>
        </div>
    </div>
</div>
