    <form id="course_exam_form" action="{{route('user.lecturer.course.quiz.set_quiz')}}" to="{{ url()->current() }}" method="POST">
        @csrf
        <h6 class="mb-2"><strong>  {{ __('add_new_exam') }}  </strong></h6>
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="course_id" id="course_id" value="1">
        <input type="hidden" name="course_sections_id" id="course_sections_id" value="{{@$course_section->id}}">
        @foreach (locales() as $locale => $value)
            <div class="form-group mt-3">
                <input class="form-control" id="title" type="text" name="title_{{ $locale }}" placeholder="{{ __('exam_title') }} "/>
            </div>
        @endforeach

        @foreach (locales() as $locale => $value)
            <div class="form-group">
                <textarea class="form-control" rows="3"  id="description" name="description_{{ $locale }}"  placeholder="{{ __('exam_desc') }} "></textarea>
            </div>
        @endforeach
        <div class="form-group">
            <input class="form-control" type="number" name="time" placeholder="{{ __('duration') }}" />
        </div>

        <div class="form-group">
            <input class="form-control" type="number" name="pass_mark" placeholder="{{ __('pass_mark') }}" />
        </div>

        <input type="hidden" id="question_type" name="type" value="multiple">

        <ul class="nav nav-tabs border-bottom-0 tab-add-course justify-content-center">
            <li class="nav-item" role="presentation">
                <button class="nav-link question_type active" data-value="multiple" data-bs-toggle="tab" data-bs-target="#tab-question-select" type="button"
                    role="tab">{{ __('multiple_select') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link question_type" data-value="descriptive" data-bs-toggle="tab" data-bs-target="#tab-question-complete" type="button"
                    role="tab">{{ __('short_answer') }}</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-question-select">
                <div class="accordion" id="accordionExamSelect">
                    <div class="list-qestion-1">
                        <div class="bg-white rounded-3 widget_item-qestion mt-3">
                            <div class="d-flex align-items-center widget_item-head p-3 pointer" data-bs-toggle="collapse"
                                data-bs-target="#select-question-1">
                                <h6 class="mx-2">1. {{ __('question') }}</h6>
                                <div class="widget_item-action d-flex align-items-center">
                                    <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                                </div>
                                <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
                            </div>
                            <div class="widget_item-body accordion-collapse collapse show" id="select-question-1"
                                data-bs-parent="#accordionExamSelect">
                                <div class="p-3">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="questions[]" placeholder="السؤال" />
                                    </div>
                                    <div class="form-group list-answer-select">
                                        <div class="d-flex align-items-center mb-2 item-answer">
                                            <label class="m-radio m-radio-2 mb-0 ms-2">
                                                <input type="radio" name="correct_answer_1" value="0"/>
                                                <span class="checkmark"></span>
                                            </label>
                                            <div class="input-icon col left me-2">
                                                <input class="form-control bg-light-green rounded-2" type="text" name="question_answers_1[]" placeholder="ادخل الاجابه "/>
                                            </div>
                                            <div class="icon">
                                                <div class="widget_item-action">
                                                    <div class="widget_item-icon btn-remove-select-answer"><i class="fa-solid fa-trash"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between ms-4 mt-2">
                                            <button class="btn p-0 bg-transparent border-0 me-2 font-medium btn-add-select-answer" type="button"><i
                                                    class="fa-regular fa-plus ms-1"></i>   {{ __('add_new_answer') }}  </button>
                                            <div class="col-lg-3 col-5">
                                                <input class="form-control" type="text" name="question_1_mark" placeholder=" {{ __('enter_mark') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="col-lg-3">

                                <button class="btn p-0 bg-transparent border-0 me-2 font-medium   btn-add-select-qestion" type="button">
                                    <i class="fa-regular fa-plus ms-1"></i>  {{ __('new_question') }}
                                </button>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-primary px-1 w-100 px-5 px-lg-1"> {{ __('save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>
