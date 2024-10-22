
    <form id="course_task_form" action="{{route('user.lecturer.course.task.set_task')}}" to="{{ url()->current() }}" method="POST">
        @csrf

        <h6 class="mb-2"><strong>إضافة واجب جديد</strong></h6>
    <h7>- عنوان الواجب</h7>
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="course_id" id="course_id" value="1">
        <input type="hidden" name="course_sections_id" id="course_sections_id" value="{{@$course_section->id}}">
        @foreach (locales() as $locale => $value)
            <div class="form-group mt-3">
                <input class="form-control" id="title" type="text" name="title_{{ $locale }}" placeholder="{{ __('task_title') }} "/>
            </div>
        @endforeach

        @foreach (locales() as $locale => $value)
            <div class="form-group">
                <textarea class="form-control" rows="3"  id="description" name="description_{{ $locale }}"  placeholder="{{ __('task_desc') }} "></textarea>
            </div>
        @endforeach
    <div class="form-group">
        <input class="form-control" type="number" name="time" placeholder="{{ __('duration') }}" />
    </div>

    <div class="form-group">
        <input class="form-control" type="number" name="grad" placeholder="{{ __('grad') }}" />
    </div>

    <div class="form-group">
        <input class="form-control" type="number" name="pass_grade" placeholder="{{ __('pass_grade') }}" />
    </div>

    <div class="d-flex align-items-center  col-9">
        <div class="form-group col-12">
            <div class="d-lg-flex align-items-center justify-content-start">
                <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                <h7><strong>  {{ __('status') }}</strong></h7>
                </div>
                <div class="d-flex align-items-center  col-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" role="switch">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="accordion" id="accordionQestion">
        <div class="list-qestion-task">
            <div class="bg-white rounded-3 widget_item-qestion mb-3">
                <div class="d-flex align-items-center widget_item-head p-3 pointer" data-bs-toggle="collapse"
                    data-bs-target="#collapse-qestion-1">
                    <h6 class="mx-2">1. السؤال </h6>
                    <div class="widget_item-action d-flex align-items-center">
                        <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                    </div>
                    <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
                </div>
                <div class="widget_item-body accordion-collapse collapse show" id="collapse-qestion-1"
                    data-bs-parent="#accordionQestion">
                    <div class="p-3">
                        <div class="form-group">
                            <input class="form-control" type="text" name="questions[]"  placeholder="أدخل السؤال هنا" />
                        </div>
                        <div class="form-group">
                            <label> الإجابة :</label>
                            <div class="d-flex align-items-center">
                                <label class="m-radio m-radio-2 mb-0">
                                    <input type="radio" name="answer_type_1" value="text" /><span class="checkmark"></span> نصية
                                </label>
                                <label class="m-radio m-radio-2 mb-0 ms-5">
                                    <input type="radio" name="answer_type_1" value="file" /><span class="checkmark"></span> إرفاق ملفات
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
            <div class="col-lg-3">

                <button class="btn p-0 bg-transparent border-0 me-2 font-medium  btn-add-qestion-task" type="button">
                                    <i class="fa-regular fa-plus ms-1"></i>  {{ __('new_question') }}
                 </button>
            </div>
            <div class="col-lg-3">
            <button class="btn btn-primary px-1 w-100 px-5 px-lg-1"> {{ __('save') }}</button>
            </div>
        </div>
    </div>
    </form>
