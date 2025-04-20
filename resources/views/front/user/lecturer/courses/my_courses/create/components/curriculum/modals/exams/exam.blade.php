<div class="modal show" id="modalAddExam" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">

                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button class="btn-close" onclick="closeModal()"></button>
                        <h2 class="text-center mb-4">
                            {{ @$item ? __('edit_exam') . ': ' . @$item->title : __('add_new_exam') }}</h2>
                        <div class="accordion" id="accordionExam">
                            <div class="widget_item-lesson p-0 rounded-3 mb-3">
                                <!--  <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-exam-1">
                                    <i class="fa-solid fa-minus"></i>
                                    <h6 class="mb-2"><strong>{{ @$item ? __('edit_exam') . ': ' . @$item->title : __('add_new_exam') }}</strong></h6>
                                    <div class="widget_item-chevron ms-auto">
                                        <i class="fa-regular fa-chevron-down"></i>
                                    </div>
                                </div> -->
                                <div class="widget_item-body accordion-collapse collapse show" id="collapse-exam-1"
                                    data-bs-parent="#accordionExam">
                                    <div class="py-3 px-2 px-lg-4">
                                        @php
                                            if (checkUser('lecturer') && $user_type == 'lecturer') {
                                                $action_set_url = route(
                                                    'user.lecturer.course.curriculum.quiz.set_quiz',
                                                );
                                                $action_update_url = route(
                                                    'user.lecturer.course.curriculum.quiz.update_quiz',
                                                );
                                                $to_url = route(
                                                    'user.lecturer.my_courses.create_curriculum',
                                                    @$course_id,
                                                );
                                            } elseif (auth('admin')->user() && $user_type == 'admin') {
                                                $action_set_url = route('panel.courses.edit.curriculum.quiz.set_quiz');
                                                $action_update_url = route(
                                                    'panel.courses.edit.curriculum.quiz.update_quiz',
                                                );
                                                $to_url = route('panel.courses.edit.curriculum.index', @$course_id);
                                            }
                                        @endphp

                                        <form id="course_exam_form"
                                            action="{{ @$item ? @$action_update_url : @$action_set_url }}"
                                            to="{{ @$to_url }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" id="id"
                                                value="{{ @$item->id }}">
                                            <input type="hidden" name="course_id" id="course_id"
                                                value="{{ @$course_id }}">
                                            <input type="hidden" name="course_sections_id" id="course_sections_id"
                                                value="{{ @$course_section_id }}">
                                            <div class="row">
                                                @foreach (locales() as $locale => $value)
                                                    <div class="form-group col-md-6 mt-3">
                                                        <label>{{ __('exam_title_' . $locale) }}
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="title" type="text"
                                                            name="title_{{ $locale }}"
                                                            value="{{ @$item ? @$item->translate($locale)->title : '' }}"
                                                            placeholder="{{ __('exam_title') }}" />
                                                    </div>
                                                @endforeach

                                                @foreach (locales() as $locale => $value)
                                                    <div class="form-group col-md-6 mt-3">
                                                        <label>{{ __('exam_desc_' . $locale) }}
                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="3" id="description" name="description_{{ $locale }}"
                                                            placeholder="{{ __('exam_desc') }}">{{ @$item ? @$item->translate($locale)->description : '' }}</textarea>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-4 mt-3">
                                                    <label>{{ __('duration') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" name="time"
                                                        placeholder="{{ __('duration') }}" value="{{ @$item->time }}"
                                                        style="direction: rtl !important;" />
                                                </div>

                                                <div class="form-group col-md-4 mt-3">
                                                    <label>{{ __('grad') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="grade" placeholder="{{ __('grad') }}"
                                                        value="{{ @$item->grade }}"
                                                        style="direction: rtl !important;" />
                                                </div>

                                                <div class="form-group col-md-4 mt-3">
                                                    <label>{{ __('pass_mark') }}
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="number" step="0.1"
                                                        name="pass_mark" placeholder="{{ __('pass_mark') }}"
                                                        value="{{ @$item->pass_mark }}"
                                                        style="direction: rtl !important;" />
                                                </div>
                                            </div>

                                            <div class="row">

                                                @if (@$course_type == 'live')
                                                    <div class="form-group col-md-4 mt-3">
                                                        <label>{{ __('start_date') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="datetime-local"
                                                            name="start_date" required
                                                            placeholder="{{ __('start_date') }}"
                                                            value="{{ @$item->start_date }}"
                                                            style="direction: rtl !important;" />
                                                    </div>
                                                    <div class="form-group col-md-4 mt-3">
                                                        <label>{{ __('end_date') }}
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control" type="datetime-local"
                                                            name="end_date" placeholder="{{ __('end_date') }}"
                                                            value="{{ @$item->start_date }}"
                                                            style="direction: rtl !important;" />
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center  col-9">
                                                <div class="form-group col-12 mt-3">
                                                    <div class="d-lg-flex align-items-center justify-content-start">
                                                        <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                                                            <h7><strong> {{ __('status') }}</strong></h7>
                                                        </div>
                                                        <div class="d-flex align-items-center  col-9">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="status" role="switch"
                                                                    {{ @$item->status == 'active' ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="list-qestions">
                                                @if (@$item && count($item->quizQuestions))
                                                    @foreach (@$item->quizQuestions as $question_no => $question)
                                                        @include(
                                                            'front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question',
                                                            ['question_no' => @$question_no + 1]
                                                        )
                                                    @endforeach
                                                @else
                                                @endif
                                            </div>

                                            <div class="form-group text-center mt-0">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col-md-6">
                                                        <button
                                                            class="btn p-0 bg-transparent border-0 me-2 font-medium btn-add-new-qestion"
                                                            type="button" data-question_no={{ @$question_no + 1 }}>
                                                            <i class="fa-regular fa-plus ms-1"></i>
                                                            {{ __('new_question') }}
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button class="btn btn-primary px-1 w-100 px-5 px-lg-1">
                                                            {{ __('save') }}
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3 ml-2">
                                                        <span class="btn btn-outline-primary px-1 w-100"
                                                            onclick="closeModal()">{{ __('cancel') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="question-template" style="display: none;">
    @include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question', [
        'question_no' => '__question_no__',
        'item' => '',
        'question' => '',
    ])
</div>

<!-- End Modal-->


<script src="{{ asset('assets/front/js/post.js') }}"></script>
<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/front/js/summernote.min.js') }}"></script>
<script>
    $('.scroll').each(function() {
        const ps = new PerfectScrollbar($(this)[0]);
    });

    function closeModal() {
        $("#modalAddExam").hide();
    }
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.question_type', function() {
            var action = $(this).data('value');
            var id = $(this).data('id');
            $("#question_" + id + "_type").val(action);
        });
    });
</script>
