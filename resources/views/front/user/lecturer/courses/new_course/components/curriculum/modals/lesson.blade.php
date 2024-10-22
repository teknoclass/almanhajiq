    <form id="course_from" action="{{route('user.lecturer.course.lesson.set_lesson')}}" to="{{ url()->current() }}" method="POST" enctype="multipart/form-data">
        @csrf
    <h6 class="mb-2"><strong>  {{ __('add_new_lesson') }}  </strong></h6>
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="course_id" id="course_id" value="1">
    <input type="hidden" name="course_sections_id" id="course_sections_id" value="{{@$course_section->id}}">
    @foreach (locales() as $locale => $value)
        <div class="form-group mt-3">
            <input class="form-control" id="title" type="text" name="title_{{ $locale }}" placeholder="{{ __('lesson_title') }} "/>
        </div>
    @endforeach

    @foreach (locales() as $locale => $value)
        <div class="form-group">
            <textarea class="form-control" rows="3"  id="description" name="description_{{ $locale }}"  placeholder="{{ __('lesson_desc') }} "></textarea>
        </div>
    @endforeach
    <input type="hidden" name="file_type" id="file_type" value="video">
    <div class="form-group">
        <ul class="nav nav-pills mb-3 tab-add-course" id="pills-tab" role="tablist">
            <li class="nav-item my-2">
                <button class="nav-link file_type active" data-bs-toggle="pill" data-bs-target="#tab-1" data-value="video" type="button" role="tab">
                    <i class="fa-solid fa-video ms-1"></i> {{ __('video') }}
                </button>
            </li>
            <li class="nav-item my-2">
                <button class="nav-link file_type" data-bs-toggle="pill" data-bs-target="#tab-2" data-value="listen" type="button" role="tab">
                    <i class="fa-solid fa-volume ms-1"></i> {{ __('listen') }}
                </button>
            </li>
            <li class="nav-item my-2">
                <button class="nav-link file_type" data-bs-toggle="pill" data-bs-target="#tab-3"  data-value="text"  type="button" role="tab">
                    <i class="fa-solid fa-align-center ms-1"></i> {{ __('text') }}
                </button>
            </li>
            <li class="nav-item my-2">
                <button class="nav-link file_type" data-bs-toggle="pill" data-bs-target="#tab-4"  data-value="doc"  type="button" role="tab">
                    <i class="fa-solid fa-file-lines ms-1"></i> {{ __('doc') }}
                </button>
            </li>
            <li class="nav-item my-2">
                <button class="nav-link file_type" data-bs-toggle="pill" data-bs-target="#tab-5"  data-value="image" type="button" role="tab">
                    <i class="fa-solid fa-image ms-1"></i> {{ __('image') }}
                </button>
            </li>
        </ul>

        <input type="hidden" name="video_type" id="video_type" value="upload">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                <div class="bg-white rounded-3 p-3">
                    <ul class="nav nav-pills mb-3 tab-add-video" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link video_type active" data-bs-toggle="pill" data-bs-target="#tab-video" data-value="upload" type="button"
                                role="tab"> {{ __('upload_video') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link video_type" data-bs-toggle="pill" data-bs-target="#tab-youtube" data-value="youtube" type="button"
                                role="tab"> {{ __('youtube_link') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link video_type" data-bs-toggle="pill" data-bs-target="#tab-vimeo" data-value="vimeo_link" type="button"
                                role="tab"> {{ __('vimeo_link') }} </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link video_type" data-bs-toggle="pill" data-bs-target="#tab-drive" data-value="drive_link" type="button"
                                role="tab"> {{ __('drive_link') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link video_type" data-bs-toggle="pill" data-bs-target="#tab-external" data-value="external_link" type="button"
                                role="tab">{{ __('external_link') }}  </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link video_type" data-bs-toggle="pill" data-bs-target="#tab-iframe" data-value="iframe" type="button"
                                role="tab">{{ __('iframe') }}</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-video" role="tabpanel">
                            <input class="form-control bg-light-green" type="file" name="upload" placeholder="{{ __('enter_youtube_link') }}" />
                            <div class="row">
                                <div class="col-lg-5 mx-auto">
                                    <p class="text-center text--muted">
                                        :{{ __('support_extensions') }}  MP4
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade tab-attac" id="tab-youtube" role="tabpanel">
                            <input class="form-control bg-light-green" type="text" name="youtube" placeholder="{{ __('enter_youtube_link') }}" />
                        </div>
                        <div class="tab-pane fade tab-attac" id="tab-vimeo" role="tabpanel">
                            <input class="form-control bg-light-green" type="text" name="vimeo_link" placeholder="{{ __('enter_vimeo_link') }}" />
                        </div>
                        <div class="tab-pane fade tab-attac" id="tab-drive" role="tabpanel">
                            <input class="form-control bg-light-green" type="text" name="drive_link" placeholder="{{ __('enter_google_drive_link') }}" />
                        </div>
                        <div class="tab-pane fade tab-attac" id="tab-external" role="tabpanel">
                            <input class="form-control bg-light-green" type="text" name="external_link" placeholder="{{ __('enter_external_link') }}" />
                        </div>
                        <div class="tab-pane fade tab-attac" id="tab-iframe" role="tabpanel">
                            <input class="form-control bg-light-green" type="text" name="iframe" placeholder="{{ __('enter_iframe') }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">
                <div class="bg-white rounded-3 p-3">
                <input type="file" name="listen" accept=".mp3">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <p class="text-center text--muted">
                                : {{ __('support_extensions') }}  MP3
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade tab-attac" id="tab-3" role="tabpanel">
                <textarea class="form-control" rows="5" name="text" placeholder="{{ __('write_here') }}"></textarea>
            </div>

            <input type="hidden" name="doc_type" id="doc_type" value="pdf">
            <div class="tab-pane fade" id="tab-4" role="tabpanel">
                <div class="bg-white rounded-3 p-3">
                    <ul class="nav nav-pills mb-3 tab-add-video" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link doc_type active" data-bs-toggle="pill" data-bs-target="#tab-pdf" data-value="pdf" type="button"
                                role="tab"> PDF</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link doc_type" data-bs-toggle="pill" data-bs-target="#tab-word" data-value="word" type="button"
                                role="tab"> Word</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link doc_type" data-bs-toggle="pill" data-bs-target="#tab-ppt" data-value="power_point"  type="button"
                                role="tab"> PowerPoint</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pdf" role="tabpanel">
                            <input type="file" name="pdf" accept=".pdf">
                        </div>
                        <div class="tab-pane fade show" id="tab-word" role="tabpanel">
                            <input type="file" name="word" accept=".doc, .docx">
                        </div>
                        <div class="tab-pane fade show" id="tab-ppt" role="tabpanel">
                            <input type="file" name="power_point" accept=".ppt, .pptx">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-5" role="tabpanel">
                <div class="bg-white rounded-3 p-3">
                    <input type="file" name="image" accept=".png, .jpg, .jpeg, .svg">
                    <div class="row">
                        <div class="col-lg-5 mx-auto">
                            <p class="text-center text--muted">
                                : {{ __('support_extensions') }} png, jpg, jpeg, svg
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="bg-white rounded-3 p-3">
            <div class="myDropzone-lesson dropzone dropzone-course bg-transparent border-0"></div>
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    <p class="text-center text--muted">: {{ __('support_extensions') }}  PDF و PNG
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12">
            <div class="d-lg-flex align-items-center justify-content-start">
                <div class="d-flex align-items-center mb-2 mb-lg-0  col-3">
                <h7><strong>  {{ __('accessibility') }} </strong></h7>
                </div>
                <div class="d-flex align-items-center col-9">
                    <label class="m-radio m-radio-2 mb-0 me-2">
                        <input type="radio" name="accessibility"  value="free"/>
                        <span class="checkmark"></span>
                    </label>
                    <p class="me-3"> {{ __('free') }}</p>

                    <label class="m-radio m-radio-2 mb-0 ms-2 me-2">
                        <input type="radio" name="accessibility" value="paid"/>
                        <span class="checkmark"></span>
                    </label>
                    <p class="me-3"> {{ __('paid') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12">
            <div class="d-lg-flex align-items-center justify-content-start">
                <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                <h7><strong>  {{ __('downloadable') }}</strong></h7>
                </div>
                <div class="d-flex align-items-center  col-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="downloadable" role="switch">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-12">
            <div class="d-lg-flex align-items-center justify-content-start">
                <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                <h7><strong>{{ __('active') }}</strong></h7>
                </div>
                <div class="d-flex align-items-center col-9">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" role="switch">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group text-center mt-3">
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-lg-3 me-3">
                <button id="btn_submit" type="submit" class="btn btn-primary px-1 w-100 btn-add-qestion-task">{{ __('save') }}</button>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-outline-primary px-1 w-100">{{ __('cancel') }}</button>
            </div>
        </div>
    </div>

    </form>
