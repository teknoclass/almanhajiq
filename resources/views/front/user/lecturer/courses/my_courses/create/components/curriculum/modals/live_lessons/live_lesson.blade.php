<div class="modal show" id="modalAddLiveLesson" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="pt-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-3 py-0">
                        <button class="btn-close" onclick="closeModal()"></button>
                        <h2 class="text-center mb-3">{{ __('add_live_lesson') }}</h2>
                        <div class="accordion" id="accordionTask">
                            <div class="widget_item-lesson p-0 rounded-3 mb-3">
                                {{-- <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-task-1"><i
                                        class="fa-solid fa-minus"></i>
                                    <h6 class="mx-2"><strong>{{ __('add_new_lesson') }}</strong></h6>
                                    <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i>
                                    </div>
                                </div> --}}
                                <div class="widget_item-body accordion-collapse collapse show" id="collapse-task-1"
                                    data-bs-parent="#accordionTask">
                                    <div class="py-3 px-2 px-lg-4">
                                        @php
                                            if (checkUser('lecturer') && $user_type == "lecturer") {
                                                $action_url = route('user.lecturer.course.curriculum.live_lesson.set_live_lesson');
                                                $to_url = route('user.lecturer.my_courses.create_curriculum', @$course_id);
                                            }
                                            else if (auth('admin')->user() && $user_type == "admin"){
                                                $action_url = route('panel.courses.edit.curriculum.live_lesson.set_live_lesson');
                                                $to_url = route('panel.courses.edit.curriculum.index', @$course_id);
                                            }
                                        @endphp
                                        <form id="course_live_lesson_form"
                                            action="{{ @$action_url }}"
                                            to="{{ @$to_url }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="course_id" id="course_id"
                                                value="{{ @$course_id }}">
                                            <input type="hidden" name="course_sections_id" id="course_sections_id"
                                                value="{{ @$course_section_id }}">
                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group mt-3">
                                                    <label>{{ __('title') }} ({{ __($value) }})
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" id="title" type="text"
                                                        name="title_{{ $locale }}"
                                                        placeholder="{{ __('lesson_title') }} " />
                                                </div>
                                            @endforeach

                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group mt-3">
                                                    <label>{{ __('lesson_desc_'.$locale) }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control" rows="3" id="description" name="description_{{ $locale }}"
                                                        placeholder="{{ __('lesson_desc') }} "></textarea>
                                                </div>
                                            @endforeach
                                            <div class="row">

                                                <div class="form-group mt-3 col-12">
                                                    <label>{{ __('start_date') }}</label>
                                                    <div class="form-group">
                                                        <div class="input-icon left">
                                                            <input class="form-control datetimepicker_1 group-date" name="meeting_date" value="{{ @$lesson->meeting_date }}" required type="text" placeholder="{{ __('start_date') }}" autocomplete="off">
                                                            {{-- <div class="icon"><i class="fa-light fa-calendar"></i></div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-3 col-6">
                                                    <label>{{ __('meeting.time_form') }}</label>
                                                    <div class="form-group">
                                                        <div class="left">
                                                            <input  type="time" required
                                                                    class="form-control group-date"
                                                                    name="time_form"
                                                                    value="{{ @$lesson->time_form }}"
                                                                    placeholder="{{ __('meeting.time_form') }}"
                                                                    onfocus="this.showPicker()"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-3 col-6">
                                                    <label>{{ __('meeting.time_to') }}</label>
                                                    <div class="form-group">
                                                        <div class="left">
                                                            <input  type="time" required
                                                                    class="form-control group-date"
                                                                    name="time_to"
                                                                    value="{{ @$lesson->time_to }}"
                                                                    placeholder="{{ __('meeting.time_to') }}"
                                                                    onfocus="this.showPicker()"
                                                            />
                                                        </div>
                                                    </div>
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

                                            <div class="bg-white rounded-3 p-3 mt-3">
                                                <div class="form-group mt-3">
                                                    <label>{{ __('attachments') }}</label>
                                                    <input class="form-control" id="fileInput" type="file"
                                                        name="files[]" multiple>
                                                    <div class="row">
                                                        <div class="col-lg-5 mx-auto">
                                                            <p class="text-center text--muted">يدعم إمتدادات : jpeg, jpg, png, pdf</p>
                                                        </div>

                                                        <div id="uploadedFilesList"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group text-center mt-3">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="col-lg-3 me-3">
                                                        <button id="btn_submit" type="submit"
                                                            class="btn btn-primary px-1 w-100 btn-add-qestion-task">{{ __('save') }}</button>
                                                    </div>
                                                    <div class="col-lg-3">
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
        $("#modalAddLiveLesson").hide();
    }
    window.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
</script>

<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>

    $(".datetimepicker_1").datetimepicker({
        format: "yyyy/mm/dd",
        todayHighlight: true,
        autoclose: true,
        startView: 2,
        minView: 2,
        forceParse: 0,
        pickerPosition: "bottom-left",
    });
</script>

<script>
    // Function to handle file input change event
    document.getElementById('fileInput').addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        var files = event.target.files;
        displaySelectedFiles(files);
    }

    // Function to display selected files
    function displaySelectedFiles(files) {
        var uploadedFilesList = document.getElementById('uploadedFilesList');
        uploadedFilesList.innerHTML = ''; // Clear previous files

        for (var i = 0; i < files.length; i++) {
            var fileItemContainer = document.createElement('span');
            fileItemContainer.classList.add('m-2', 'position-relative');

            // Create image preview
            var imgPreview = document.createElement('img');

            let uploaded_img_path = URL.createObjectURL(files[i]);
            let pdf_path          = "{{ asset('assets/front/images/pdf.png') }}";
            let word_path         = "{{ asset('assets/front/images/docx.png') }}";
            let ext               = (files[i].name).split('.').pop();
            if(ext == 'pdf'){
                uploaded_img_path = pdf_path;
            }else if(ext == 'docx'){
                uploaded_img_path = word_path;
            }
            imgPreview.src = uploaded_img_path;

            imgPreview.style.maxWidth = '100px';
            imgPreview.style.maxHeight = '100px';
            fileItemContainer.appendChild(imgPreview);
            var deleteButton = document.createElement('span');
            deleteButton.innerHTML = '<i class="fas fa-times"></i>';
            deleteButton.classList.add('btn-sm', 'btn-danger', 'position-absolute', 'top-right-0',
                'start-0'); // Add styling to the button
            deleteButton.addEventListener('click', createDeleteHandler(fileItemContainer, files, i));
            fileItemContainer.appendChild(deleteButton);

            uploadedFilesList.appendChild(fileItemContainer);
        }
    }

    function createDeleteHandler(fileItemContainer, files, index) {
        return function() {
            URL.revokeObjectURL(fileItemContainer.querySelector('img').src);
            fileItemContainer.remove();
            var newFiles = new DataTransfer();

            for (var i = 0; i < files.length; i++) {
                if (i !== index) {
                    newFiles.items.add(files[i]);
                }
            }
            document.getElementById('fileInput').files = newFiles.files;
        };
    }
</script>
