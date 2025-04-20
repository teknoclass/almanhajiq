<div class="modal show" id="modalAddTasks" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button class="btn-close" onclick="closeModal()"></button>
                        <h2 class="text-center mb-4">{{ __('add_new_task') }}</h2>
                        <div class="accordion" id="accordionTask">
                            <div class="widget_item-lesson p-0 rounded-3 mb-3">
                              <!--  <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-task-1"><i
                                        class="fa-solid fa-minus"></i>
                                    <h6 class="mx-2">عنوان الواجب</h6>
                                    <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i>
                                    </div>
                                </div> -->
                                <div class="widget_item-body accordion-collapse collapse show" id="collapse-task-1"
                                    data-bs-parent="#accordionTask">
                                    <div class="py-3 px-2 px-lg-4">
                                        @php
                                            if (checkUser('lecturer') && $user_type == "lecturer") {
                                                $action_url = route('user.lecturer.course.curriculum.assignment.set_assignment');
                                                $to_url = route('user.lecturer.my_courses.create_curriculum', @$course_id);
                                            }
                                            else if (auth('admin')->user() && $user_type == "admin"){
                                                $action_url = route('panel.courses.edit.curriculum.assignment.set_assignment');
                                                $to_url = route('panel.courses.edit.curriculum.index', @$course_id);
                                            }
                                        @endphp
                                        <form id="course_task_form"
                                            action="{{ @$action_url }}"
                                            to="{{ @$to_url }}"
                                            method="POST">
                                            @csrf

                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="course_id" id="course_id"
                                                value="{{ @$course_id }}">
                                            <input type="hidden" name="course_sections_id" id="course_sections_id"
                                                value="{{ @$course_section_id }}">

                                        <div class="row">
                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group col-md-6 mt-3">
                                                    <label>{{ __('task_title') }} ({{ __($value) }})
                                                        <span class="text-danger">*</span></label>
                                                    <input class="form-control" id="title" type="text"
                                                        name="title_{{ $locale }}"
                                                        placeholder="{{ __('task_title') }} " />
                                                </div>
                                            @endforeach

                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group col-md-6 mt-3">
                                                    <label>{{ __('task_desc') }} ({{ __($value) }})
                                                        <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" rows="3" id="description" name="description_{{ $locale }}"
                                                        placeholder="{{ __('task_desc') }} "></textarea>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-4 mt-3">
                                                <label>{{ __('duration') }}
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="time"
                                                    placeholder="{{ __('duration') }}" style="direction: rtl !important;"/>
                                            </div>

                                            <div class="form-group col-md-4 mt-3">
                                                <label>{{ __('grad') }}
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="grad"
                                                    placeholder="{{ __('grad') }}" style="direction: rtl !important;"/>
                                            </div>

                                            <div class="form-group col-md-4 mt-3">
                                                <label>{{ __('pass_mark') }}
                                                    <span class="text-danger">*</span></label>
                                                <input class="form-control" type="number" name="pass_grade"
                                                    placeholder="{{ __('pass_grade') }}" style="direction: rtl !important;"/>
                                            </div>
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
                                                                    name="status" role="switch">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="accordion" id="accordionQestion">
                                                <div class="list-qestion-task">
                                                    <div class="tab-content bg-white rounded-3 widget_item-qestion mb-3">
                                                        <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse-qestion-1">
                                                            <h6 class="mx-2">1. {{ __('question') }} </h6>
                                                            <div class="widget_item-action d-flex align-items-center">
                                                                <div class="widget_item-icon btn-remove-widget_question">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </div>
                                                            </div>
                                                            <div class="widget_item-chevron ms-auto"><i
                                                                    class="fa-regular fa-chevron-down"></i></div>
                                                        </div>
                                                        <div class="widget_item-body accordion-collapse collapse show"
                                                            id="collapse-qestion-1" data-bs-parent="#accordionQestion">
                                                            <div class="p-3">
                                                                @foreach (locales() as $locale => $value)
                                                                    <div class="form-group">
                                                                        <label>{{ __('question') }} ({{ __($value) }})</label>
                                                                        <textarea class="form-control tinymce" type="text"
                                                                            name="questions_{{ $locale }}[]"
                                                                            ></textarea>
                                                                    </div>
                                                                @endforeach
                                                                <div class="form-group">
                                                                    <label> {{ __('answer') }} :</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <label class="m-radio m-radio-2 mb-0">
                                                                            <input type="radio" name="answer_type[0]"
                                                                                value="text" /><span
                                                                                class="checkmark"></span> {{ __('text1') }}
                                                                        </label>
                                                                        <label class="m-radio m-radio-2 mb-0 ms-5">
                                                                            <input type="radio" name="answer_type[0]"
                                                                                value="file" /><span
                                                                                class="checkmark"></span> {{ __("attach_files") }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group text-center mt-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col-md-6">

                                                        <button
                                                            class="btn p-0 bg-transparent border-0 me-2 font-medium  btn-add-qestion-task"
                                                            type="button"
                                                            data-question_no="2">
                                                            <i class="fa-regular fa-plus ms-1"></i>
                                                            {{ __('new_question') }}
                                                        </button>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <button class="btn btn-primary px-1 w-100 px-5 px-lg-1">
                                                            {{ __('save') }}</button>
                                                    </div>
                                                    <div class="col-md-3 ml-2">
                                                        <span
                                                            class="btn btn-outline-primary px-1 w-100"  onclick="closeModal()">{{ __('cancel') }}</span>
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


<script src="{{ asset('assets/front/js/post.js') }}"></script>
<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/front/js/summernote.min.js') }}"></script>
<script>
    $('.scroll').each(function() {
        const ps = new PerfectScrollbar($(this)[0]);
    });

    function closeModal() {
        $("#modalAddTasks").hide();
    }
</script> 
