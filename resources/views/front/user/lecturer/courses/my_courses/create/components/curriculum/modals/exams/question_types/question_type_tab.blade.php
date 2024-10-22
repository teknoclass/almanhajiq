@if (@$question)
    <?php $type = @$question->type == 'multiple' ? 'multiple' : 'short_answer'; ?>
@else
    <?php $type = 'multiple'; ?>
@endif

<ul class="nav nav-tabs border-bottom-0 tab-add-course justify-content-center">
    <li class="nav-item" role="presentation">
        <button class="nav-link question_type {{ @$type == 'multiple' ? 'active' : '' }}"
            data-value="multiple" data-bs-toggle="tab"
            data-bs-target="#tab-question-select-{{ @$question_no }}" data-id="{{ @$question_no }}"
            type="button"
            role="tab">{{ __('multiple_select') }}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link question_type {{ @$type == 'short_answer' ? 'active' : '' }}"
            data-value="descriptive" data-bs-toggle="tab"
            data-bs-target="#tab-question-short-answer-{{ @$question_no }}" data-id="{{ @$question_no }}"
            type="button"
            role="tab">{{ __('short_answer') }}</button>
    </li>
</ul>
