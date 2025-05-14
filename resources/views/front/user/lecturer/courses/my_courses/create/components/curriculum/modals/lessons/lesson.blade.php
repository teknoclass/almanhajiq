
<div class="modal show" id="modalAddLesson" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button class="btn-close" onclick="closeModal()"></button>
                        <h2 class="text-center mb-4">{{ __('add_new_lesson') }}</h2>
                        <div class="accordion" id="accordionLesson">
                            <div class="widget_item-lesson p-0 rounded-3 mb-3">
                               <!-- <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-lesson-1">
                                    <i class="fa-solid fa-minus"></i>
                                    <h6 class="mx-2"><strong> {{ __('add_new_lesson') }} </strong></h6>
                                    <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i>
                                    </div>
                                </div> -->
                                <div class="widget_item-body accordion-collapse collapse show" id="collapse-lesson-1"
                                    data-bs-parent="#accordionLesson">
                                    <div class="py-3 px-2 px-lg-8">
                                        @php
                                            if (checkUser('lecturer') && $user_type == "lecturer") {
                                                $action_url = route('user.lecturer.course.curriculum.lesson.set_lesson');
                                                $to_url = route('user.lecturer.my_courses.create_curriculum', @$course_id);
                                            }
                                            else if (auth('admin')->user() && $user_type == "admin"){
                                                $action_url = route('panel.courses.edit.curriculum.lesson.set_lesson');
                                                $to_url = route('panel.courses.edit.curriculum.index', @$course_id);
                                            }
                                        @endphp
                                        <form id="course_from"
                                            action="{{ @$action_url }}"
                                            to="{{ @$to_url }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id">
                                            <input type="hidden" name="course_id" id="course_id"
                                                value="{{ @$course_id }}">
                                            <input type="hidden" name="course_sections_id" id="course_sections_id"
                                                value="{{ @$course_section_id }}">
                                        <div class="row">
                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group col-md-6 mt-2">
                                                    <label>{{ __('title') }} ({{ __($value) }})
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" id="title" type="text"
                                                        name="title_{{ $locale }}"
                                                        placeholder="{{ __('lesson_title') }} " />
                                                </div>
                                            @endforeach

                                            @foreach (locales() as $locale => $value)
                                                <div class="form-group col-md-6 mt-2">
                                                    <label>{{ __('lesson_desc_'.$locale) }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control" rows="2" id="description" name="description_{{ $locale }}"
                                                        placeholder="{{ __('lesson_desc') }} "></textarea>
                                                </div>
                                            @endforeach
                                        </div>

                                            <input type="hidden" name="file_type" id="file1_type" value="video">
                                            <div class="form-group mt-2">
                                                <ul class="nav nav-pills mb-2 tab-add-course" id="pills-tab"
                                                    role="tablist">
                                                    <li class="nav-item my-2">
                                                        <button class="nav-link file1_type active" data-bs-toggle="pill"
                                                            data-bs-target="#tab-11" data-value="video" type="button"
                                                            role="tab">
                                                            <i class="fa-solid fa-video ms-1"></i> {{ __('video') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button class="nav-link file1_type" data-bs-toggle="pill"
                                                            data-bs-target="#tab-22" data-value="listen" type="button"
                                                            role="tab">
                                                            <i class="fa-solid fa-volume ms-1"></i> {{ __('listen') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button class="nav-link file1_type" data-bs-toggle="pill"
                                                            data-bs-target="#tab-33" data-value="text" type="button"
                                                            role="tab">
                                                            <i class="fa-solid fa-align-center ms-1"></i>
                                                            {{ __('text') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button class="nav-link file1_type" data-bs-toggle="pill"
                                                            data-bs-target="#tab-44" data-value="doc" type="button"
                                                            role="tab">
                                                            <i class="fa-solid fa-file-lines ms-1"></i>
                                                            {{ __('doc') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button class="nav-link file1_type" data-bs-toggle="pill"
                                                            data-bs-target="#tab-55" data-value="image" type="button"
                                                            role="tab">
                                                            <i class="fa-solid fa-image ms-1"></i> {{ __('image') }}
                                                        </button>
                                                    </li>
                                                </ul>

                                                <input type="hidden" name="video_type" id="video1_type"
                                                    value="upload">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="tab-11"
                                                        role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="number" placeholder="{{__('duration')}}" name="video_duration" min="1">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('media_file_duration_in_minutes') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-white rounded-3 p-3">
                                                            <ul class="nav nav-pills mb-3 tab-add-video"
                                                                role="tablist">
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type active"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-video"
                                                                        data-value="upload" type="button"
                                                                        role="tab">
                                                                        {{ __('upload_video') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-youtube"
                                                                        data-value="youtube" type="button"
                                                                        role="tab">
                                                                        {{ __('youtube_link') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-vimeo"
                                                                        data-value="vimeo_link" type="button"
                                                                        role="tab"> {{ __('vimeo_link') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-vimeoId"
                                                                        data-value="vimeo_id" type="button"
                                                                        role="tab"> {{ __('vimeo_id') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-drive"
                                                                        data-value="google_drive" type="button"
                                                                        role="tab">
                                                                        {{ __('google_drive') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-external"
                                                                        data-value="external_link" type="button"
                                                                        role="tab">{{ __('external_link') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link video1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-iframe"
                                                                        data-value="iframe" type="button"
                                                                        role="tab">{{ __('iframe') }}</button>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade show active" id="tab1-video"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="file" name="upload"
                                                                        placeholder="{{ __('enter_youtube_link') }}" />
                                                                    <div class="row">
                                                                        <div class="col-lg-5 mx-auto">
                                                                            <p class="text-center text--muted">
                                                                                {{ __('support_extensions') }}: MP4
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade tab-attac" id="tab1-youtube"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="youtube"
                                                                        placeholder="{{ __('enter_youtube_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade tab-attac" id="tab1-vimeo"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="vimeo_link"
                                                                        placeholder="{{ __('enter_vimeo_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade tab-attac" id="tab1-vimeoId"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="vimeo_id"
                                                                        placeholder="{{ __('enter_vimeo_id') }}" />
                                                                </div>
                                                                <div class="tab-pane fade tab-attac" id="tab1-drive"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="google_drive"
                                                                        placeholder="{{ __('enter_google_google_drive') }}" />
                                                                </div>
                                                                <div class="tab-pane fade tab-attac"
                                                                    id="tab1-external" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="external_link"
                                                                        placeholder="{{ __('enter_external_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade tab-attac" id="tab1-iframe"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="iframe"
                                                                        placeholder="{{ __('enter_iframe') }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-22" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="number" placeholder="{{__('duration')}}" name="listen_duration" min="1">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('media_file_duration_in_minutes') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="file" name="listen" accept=".mp3">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('support_extensions') }}: MP3
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade tab-attac" id="tab-33"
                                                        role="tabpanel">
                                                        <textarea class="form-control" rows="5" name="text" placeholder="{{ __('write_here') }}"></textarea>
                                                    </div>

                                                    <input type="hidden" name="doc_type" id="doc1_type"
                                                        value="pdf">
                                                    <div class="tab-pane fade" id="tab-44" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <ul class="nav nav-pills mb-3 tab-add-video"
                                                                role="tablist">
                                                                <li class="nav-item">
                                                                    <button class="nav-link doc1_type active"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-pdf" data-value="pdf"
                                                                        type="button" role="tab"> PDF</button>
                                                                </li>
                                                                {{-- <li class="nav-item">
                                                                    <button class="nav-link doc1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-word" data-value="word"
                                                                        type="button" role="tab"> Word</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link doc1_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tab1-ppt"
                                                                        data-value="power_point" type="button"
                                                                        role="tab"> PowerPoint</button>
                                                                </li> --}}
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade show active" id="tab1-pdf"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green" type="file" name="pdf"
                                                                        accept=".pdf">
                                                                </div>
                                                                {{-- <div class="tab-pane fade show" id="tab1-word"
                                                                    role="tabpanel">
                                                                    <input type="file" name="word"
                                                                        accept=".doc, .docx">
                                                                </div>
                                                                <div class="tab-pane fade show" id="tab1-ppt"
                                                                    role="tabpanel">
                                                                    <input type="file" name="power_point"
                                                                        accept=".ppt, .pptx">
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tab-55" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="file" name="image"
                                                                accept=".png, .jpg, .jpeg, .svg">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('support_extensions') }}: png - jpg - jpeg - svg
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="row mx-0 bg-white rounded-3 mt-2">
                                                <div class="form-group col-md-5 mt-2">
                                                    <label>{{ __('attachments') }}</label>
                                                    <input class="form-control" id="fileInput" type="file"
                                                        name="files[]" multiple>

                                                    <div class="row">
                                                        <div class="col-12 mx-auto">
                                                            <p class="text-center text--muted">يدعم إمتدادات: jpeg - jpg - png - pdf - docx</p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-3 mt-2" id="uploadedFilesList"></div>


                                                <div class="d-lg-flex align-items-center mb-3  justify-content-start">
                                                    <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                                                        <h7><strong>{{ __('active') }}</strong></h7>
                                                    </div>
                                                    <div class="d-flex align-items-center col-9">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status" role="switch">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-4 mt-2 divSubmit">
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
                                            </div>

                                            {{-- <div class="row">
                                                <div class="form-group col-12">
                                                    <div class="d-lg-flex align-items-center justify-content-start">
                                                        <div class="d-flex align-items-center mb-2 mb-lg-0  col-3">
                                                            <h7><strong> {{ __('accessibility') }} </strong></h7>
                                                        </div>
                                                        <div class="d-flex align-items-center col-9">
                                                            <label class="m-radio m-radio-2 mb-0 me-2">
                                                                <input type="radio" name="accessibility"
                                                                    value="free" />
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p class="me-3"> {{ __('free') }}</p>

                                                            <label class="m-radio m-radio-2 mb-0 ms-2 me-2">
                                                                <input type="radio" name="accessibility"
                                                                    value="paid" />
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p class="me-3"> {{ __('paid') }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div> --}}

                                            {{-- <div class="row">
                                                <div class="form-group col-12">
                                                    <div class="d-lg-flex align-items-center justify-content-start">
                                                        <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                                                            <h7><strong> {{ __('downloadable') }}</strong></h7>
                                                        </div>
                                                        <div class="d-flex align-items-center  col-9">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="downloadable" role="switch">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}









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
        $("#modalAddLesson").hide();
    }
</script>

<script>
    $(document).ready(function() {

        $('.file_type').click(function() {

            var action = $(this).data('value');
            $("#file_type").val(action);

        });

        $('.video_type').click(function() {
            var action = $(this).data('value');
            $("#video_type").val(action);
        });


        $('.file1_type').click(function() {
            var action = $(this).data('value');
            $("#file1_type").val(action);
        });

        $('.video1_type').click(function() {
            var action = $(this).data('value');
            $("#video1_type").val(action);
        });



        $('.filee_type').click(function() {
            var action = $(this).data('value');
            $("#filee_type").val(action);
        });

        $('.videoo_type').click(function() {
            var action = $(this).data('value');
            $("#videoo_type").val(action);
        });

        $('.docc_type').click(function() {
            var action = $(this).data('value');
            $("#docc_type").val(action);
        });

        $('.doc_type').click(function() {
            var action = $(this).data('value');
            $("#doc_type").val(action);
        });

        $('.doc1_type').click(function() {
            var action = $(this).data('value');
            $("#doc1_type").val(action);
        });
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
            var imgPreview        = document.createElement('img');
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
            // imgPreview.src = URL.createObjectURL(files[i]);
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
