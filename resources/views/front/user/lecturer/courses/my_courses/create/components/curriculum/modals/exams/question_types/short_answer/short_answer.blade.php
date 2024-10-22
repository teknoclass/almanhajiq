@php
    @$is_edit = @$question && @$question->type == 'descriptive';
@endphp
<div class="bg-white rounded-3 widget_short_answer-qestion mt-3">
    <div class="d-flex align-items-center widget_item-head p-3 pointer"
        data-bs-toggle="collapse"
        data-bs-target="#collapse-short-answer-question-{{ @$question_no }}">
        <h6 class="mx-2">{{ @$question_no }}. {{ __('question') }} </h6>
        <div class="widget_item-action d-flex align-items-center">
            <div class="widget_item-icon btn-remove-widget_question"><i class="fa-solid fa-trash"></i></div>
        </div>
        <div class="widget_item-chevron ms-auto">
            <i class="fa-regular fa-chevron-down"></i>
        </div>
    </div>
    <div class="widget_item-body accordion-collapse collapse show"
        id="collapse-short-answer-question-{{ @$question_no }}"
        data-bs-parent="#accordionExamShortAnswer-{{ @$question_no }}">
        <div class="p-3">

            <div class="row">
                @foreach (locales() as $locale => $value)
                    <div class="form-group col-md-10 mb-3">
                        <input class="form-control"
                            type="text" value="{{ @$is_edit ? @$question->translate($locale)->title : '' }}"
                            name="complete_questions_{{ $locale }}[]"
                            placeholder="{{ __('question') }} ({{ __($value) }})" />
                    </div>
                @endforeach

                <div class="form-group col-md-2">
                    <input class="form-control"
                        type="number" step="0.1"
                        name="complete_question_{{ @$question_no }}_mark" step="0.1"
                        value="{{ @$is_edit ? @$question->grade : '' }}"
                        placeholder="{{ __('enter_mark') }}" />
                </div>
            </div>

            <div class="form-group list-answer-short_answer">
                @if (@$is_edit)
                    @foreach (@$question->quizzesQuestionsAnswers as $key => $answer)
                        <div class="d-flex align-items-center mb-2 item-answer">

                            @foreach (locales() as $locale => $value)
                                <div class="input-icon col left me-2">
                                    <input
                                        class="form-control bg-light-green rounded-2"
                                        type="text" value="{{ @$answer->translate($locale)->title }}"
                                        name="complete_question_answers_{{ $locale }}_{{ @$question_no }}[]"
                                        placeholder="{{ __('answer') }}  ({{ __($value) }})" />
                                </div>
                            @endforeach
                            <div class="icon">
                                <div class="widget_item-action">
                                    <div class="widget_item-icon btn-remove-short_answer-answer">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                <div class="d-flex align-items-center mb-2 item-answer">
                    @foreach (locales() as $locale => $value)
                        <div class="input-icon col left me-2">
                            <input
                                class="form-control bg-light-green rounded-2"
                                type="text"
                                name="complete_question_answers_{{ $locale }}_{{ @$question_no }}[]"
                                placeholder="{{ __('answer') }}  ({{ __($value) }})" />
                        </div>
                    @endforeach

                    <div class="icon">
                        <div class="widget_item-action">
                            <div class="widget_item-icon btn-remove-short_answer-answer">
                                <i class="fa-solid fa-trash"></i>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="form-group">
                <div
                    class="d-flex align-items-center justify-content-between ms-4 mt-2">
                    <button class="btn-add-short-answer-new-answer btn p-0 bg-transparent border-0 me-2 font-medium "
                        type="button"
                        data-question_no="{{ @$question_no }}">
                        <i class="fa-regular fa-plus ms-1"></i>
                        {{ __('add_new_answer') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
