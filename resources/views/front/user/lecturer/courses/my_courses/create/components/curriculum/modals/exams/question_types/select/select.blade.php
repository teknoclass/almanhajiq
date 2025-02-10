@php
    @$is_edit = @$question && @$question->type == 'multiple';
@endphp
<div class="bg-white rounded-3 widget_item-qestion mt-3">
    <div class="d-flex align-items-center widget_item-head p-3 pointer"
        data-bs-toggle="collapse"
        data-bs-target="#select-question-{{ @$question_no }}">
        <h6 class="mx-2">{{ @$question_no }}. {{ __('question') }}
        </h6>
        <div
            class="widget_item-action d-flex align-items-center">
            <div class="widget_item-icon btn-remove-widget_question">
                <i class="fa-solid fa-trash"></i>
            </div>
        </div>
        <div class="widget_item-chevron ms-auto">
            <i class="fa-regular fa-chevron-down"></i>
        </div>
    </div>
    <div class="widget_item-body accordion-collapse collapse show"
        id="select-question-{{ @$question_no }}"
        data-bs-parent="#accordionExamSelect-{{ @$question_no }}">
        <div class="p-3">
        <div class="row">
            @foreach (locales() as $locale => $value)

                <div class="form-group col-md-10 mb-3">
                    <label>{{ __('question') }} ({{ __($value) }})</label>
                    <textarea class="form-control tinymce2"
                        type="text"
                        name="questions_{{ $locale }}[]"
                        ></textarea>
                </div>
            @endforeach
            <div class="col-md-2">
                <input class="form-control"
                    type="number"  step="0.1"
                    name="question_{{ @$question_no }}_mark"
                    value="{{ @$is_edit ? @$question->grade : '' }}"
                    placeholder="{{ __('enter_mark') }}" />
            </div>
        </div>
            <div class="form-group list-answer-select">
                @if (@$is_edit)
                    @foreach (@$question->quizzesQuestionsAnswers as $key => $answer)
                        <div class="d-flex align-items-center mb-2 item-answer">
                            <label class="m-radio m-radio-2 mb-0 ms-2">
                                @if (!$loop->first)
                                    <input type="hidden" name="correct_answer_{{ @$question_no }}[]" value="0" />
                                @endif
                                <input type="radio" id="answer-{{ @$question_no }}"
                                    name="correct_answer_{{ @$question_no }}[]"
                                    value="1" {{ @$answer->correct == 1 ? 'checked' : '' }}/>
                                <span class="checkmark"></span>
                            </label>
                            @foreach (locales() as $locale => $value)
                                <div
                                    class="input-icon col left me-2">
                                    <input
                                        class="form-control bg-light-green rounded-2"
                                        type="text" value="{{ @$answer->translate($locale)->title }}"
                                        name="question_answers_{{ $locale }}_{{ @$question_no }}[]"
                                        placeholder="{{ __('answer') }} ({{ __($value) }})" />
                                </div>
                            @endforeach

                            <div class="icon">
                                <div
                                    class="widget_item-action">
                                    <div
                                        class="widget_item-icon btn-remove-select-answer">
                                        <i class="fa-solid fa-trash"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @else
                    <div class="d-flex align-items-center mb-2 item-answer">
                        <label class="m-radio m-radio-2 mb-0 ms-2">
                            {{-- <input type="hidden" name="correct_answer_{{ @$question_no }}[]" value="0" /> --}}
                            <input type="radio" id="answer-{{ @$question_no }}"
                                name="correct_answer_{{ @$question_no }}[]"
                                value="1" checked/>
                            <span class="checkmark"></span>
                        </label>
                        @foreach (locales() as $locale => $value)
                            <div
                                class="input-icon col left me-2">
                                <input
                                    class="form-control bg-light-green rounded-2"
                                    type="text"
                                    name="question_answers_{{ $locale }}_{{ @$question_no }}[]"
                                    placeholder="{{ __('answer') }} ({{ __($value) }}) " />
                            </div>
                        @endforeach

                        <div class="icon">
                            <div
                                class="widget_item-action">
                                <div
                                    class="widget_item-icon btn-remove-select-answer">
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
                        <button
                            class="btn p-0 bg-transparent border-0 me-2 font-medium btn-add-select-answer"
                            type="button"
                            data-question_no="{{ @$question_no }}">
                            <i
                                class="fa-regular fa-plus ms-1"></i>
                            {{ __('add_new_answer') }}
                        </button>

                    </div>
                </div>

        </div>
    </div>
</div>
