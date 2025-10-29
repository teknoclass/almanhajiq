<style>
    .image-wrapper {
        position: relative;
        display: inline-block;
        margin: 5px;
    }

    .delete-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        background-color: red;
        color: #fff;
        padding: 3px 6px;
        border-radius: 50%;
        font-size: 12px;
        line-height: 1;
    }

    .delete-icon:hover {
        background-color: #bd2130;
    }

    .image-wrapper img {
        max-width: 100px;
        max-height: 100px;
    }
</style>

<div class="modal show" id="modalAddLesson" style="display: block;">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button class="btn-close" onclick="closeModal()"></button>
                        <h2 class="text-center mb-4"> {{ __('edit_lesson') }}: {{ @$item->title }}</h2>
                        <div class="accordion" id="accordionLesson">
                            <div class="widget_item-lesson p-0 rounded-3 mb-3">
                                <!--  <div class="d-flex align-items-center widget_item-head p-3 pointer"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-lesson-1"><i
                                        class="fa-solid fa-minus"></i>
                                    <h6 class="mx-2"> {{ @$item->title }}</h6>
                                    <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i>
                                    </div>
                                </div> -->
                                <div class="widget_item-body accordion-collapse collapse show" id="collapse-lesson-1"
                                    data-bs-parent="#accordionLesson">
                                    <div class="py-3 px-2 px-lg-8">
                                        @php
                                            if (checkUser('lecturer') && $user_type == 'lecturer') {
                                                $action_url = route(
                                                    'user.lecturer.course.curriculum.lesson.update_lesson',
                                                );
                                                $to_url = route(
                                                    'user.lecturer.my_courses.create_curriculum',
                                                    @$course_id,
                                                );
                                                $delete_attachment_url = route(
                                                    'user.lecturer.my_courses.delete-course-file',
                                                    ':id',
                                                );
                                            } elseif (auth('admin')->user() && $user_type == 'admin') {
                                                $action_url = route(
                                                    'panel.courses.edit.curriculum.lesson.update_lesson',
                                                );
                                                $to_url = route('panel.courses.edit.curriculum.index', @$course_id);
                                                $delete_attachment_url = route(
                                                    'panel.courses.edit.curriculum.delete-course-file',
                                                    ':id',
                                                );
                                            }
                                        @endphp
                                        <form id="course_from2" action="{{ @$action_url }}" to="{{ @$to_url }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="id" id="id"
                                                value="{{ @$item->id }}">
                                            <input type="hidden" name="course_id" id="course_id"
                                                value="{{ @$course_id }}">
                                            <input type="hidden" name="course_sections_id" id="course_sections_id"
                                                value="{{ @$course_section->id }}">

                                            <div class="row">
                                                @foreach (locales() as $locale => $value)
                                                    <div class="form-group col-md-6 mt-2">
                                                        <label>{{ __('title') }}
                                                            ({{ __($value) }})
                                                            <span class="text-danger">*</span></label>
                                                        <input class="form-control" id="title" type="text"
                                                            value=" {{ @$item->translate($locale)->title }}"
                                                            name="title_{{ $locale }}"
                                                            placeholder="{{ __('lesson_title') }} " />
                                                    </div>
                                                @endforeach

                                                @foreach (locales() as $locale => $value)
                                                    <div class="form-group col-md-6 mt-2">
                                                        <label>{{ __('lesson_desc_' . $locale) }}
                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" rows="3" id="description" name="description_{{ $locale }}"
                                                            placeholder="{{ __('lesson_desc') }} ">  {{ @$item->translate($locale)->description }} </textarea>
                                                    </div>
                                                @endforeach
                                                   <div class="form-group col-md-6 mt-2">
                                                    <label>{{ __('activeDate') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input value="{{ @$item->activeDate }}" type="datetime-local" class="form-control" rows="2" id="activeDate" name="activeDate"
                                                        placeholder="{{ __('activeDate') }} "/>
                                                </div>
                                            </div>
                                            <input type="hidden" name="file_type" id="filee_type"
                                                value="{{ @$item->file_type }}">
                                            <div class="form-group mt-3">
                                                <ul class="nav nav-pills mb-3 tab-add-course" id="pills-tab2"
                                                    role="tablist">
                                                    <li class="nav-item my-2">
                                                        <button
                                                            class="nav-link filee_type {{ @$item->file_type == 'video' ? 'active' : '' }}"
                                                            data-bs-toggle="pill" data-bs-target="#tabb-1"
                                                            data-value="video" type="button" role="tab">
                                                            <i class="fa-solid fa-video ms-1"></i> {{ __('video') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button
                                                            class="nav-link filee_type {{ @$item->file_type == 'listen' ? 'active' : '' }}"
                                                            data-bs-toggle="pill" data-bs-target="#tabb-2"
                                                            data-value="listen" type="button" role="tab">
                                                            <i class="fa-solid fa-volume ms-1"></i> {{ __('listen') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button
                                                            class="nav-link filee_type {{ @$item->file_type == 'text' ? 'active' : '' }}"
                                                            data-bs-toggle="pill" data-bs-target="#tabb-3"
                                                            data-value="text" type="button" role="tab">
                                                            <i class="fa-solid fa-align-center ms-1"></i>
                                                            {{ __('text') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button
                                                            class="nav-link filee_type {{ @$item->file_type == 'doc' ? 'active' : '' }}"
                                                            data-bs-toggle="pill" data-bs-target="#tabb-4"
                                                            data-value="doc" type="button" role="tab">
                                                            <i class="fa-solid fa-file-lines ms-1"></i>
                                                            {{ __('doc') }}
                                                        </button>
                                                    </li>
                                                    <li class="nav-item my-2">
                                                        <button
                                                            class="nav-link filee_type {{ @$item->file_type == 'image' ? 'active' : '' }}"
                                                            data-bs-toggle="pill" data-bs-target="#tabb-5"
                                                            data-value="image" type="button" role="tab">
                                                            <i class="fa-solid fa-image ms-1"></i> {{ __('image') }}
                                                        </button>
                                                    </li>
                                                </ul>

                                                <input type="hidden" name="video_type" id="videoo_type"
                                                    value="{{ @$item->storage }}">
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show {{ @$item->file_type == 'video' ? 'show active' : '' }}"
                                                        id="tabb-1" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="number"
                                                                placeholder="{{ __('duration') }}"
                                                                name="video_duration" min="1"
                                                                value="{{ @$item->duration }}">
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
                                                                    <button
                                                                        class="nav-link videoo_type {{ @$item->storage == 'upload' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-video"
                                                                        data-value="upload" type="button"
                                                                        role="tab">
                                                                        {{ __('upload_video') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type {{ @$item->storage == 'youtube' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-youtube"
                                                                        data-value="youtube" type="button"
                                                                        role="tab">
                                                                        {{ __('youtube_link') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type  {{ @$item->storage == 'vimeo_link' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-vimeo"
                                                                        data-value="vimeo_link" type="button"
                                                                        role="tab"> {{ __('vimeo_link') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type  {{ @$item->storage == 'vimeo_id' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-vimeoId"
                                                                        data-value="vimeo_vimeo_id" type="button"
                                                                        role="tab"> {{ __('vimeo_id') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type  {{ @$item->storage == 'google_drive' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-drive"
                                                                        data-value="google_drive" type="button"
                                                                        role="tab">
                                                                        {{ __('google_drive') }}</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type  {{ @$item->storage == 'external_link' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-external"
                                                                        data-value="external_link" type="button"
                                                                        role="tab">{{ __('external_link') }}
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button
                                                                        class="nav-link videoo_type  {{ @$item->storage == 'iframe' ? 'show active' : '' }}"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-iframe"
                                                                        data-value="iframe" type="button"
                                                                        role="tab">{{ __('iframe') }}</button>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade {{ @$item->storage == 'upload' ? 'show active' : '' }}"
                                                                    id="tabb-video" role="tabpanel">
                                                                    <label>{{__('Keep this empty if you dont want to edit the video')}}</label>
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
                                                                    <div class="row">
                                                                        <div class="col-lg-5 mx-auto">
                                                                            <p class="text-center text--muted">
                                                                                {{ __('current video : ') }}
                                                                                {{ @$item->file }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade {{ @$item->storage == 'youtube' ? 'show active' : '' }} tab-attac"
                                                                    id="tabb-youtube" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="youtube"
                                                                        value="{{ @$item->storage == 'youtube' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_youtube_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade {{ @$item->storage == 'vimeo_link' ? 'show active' : '' }} tab-attac"
                                                                    id="tabb-vimeo" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="vimeo_link"
                                                                        value="{{ @$item->storage == 'vimeo_link' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_vimeo_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade {{ @$item->storage == 'vimeo_id' ? 'show active' : '' }} tab-attac"
                                                                    id="tabb-vimeoId" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="vimeo_id"
                                                                        value="{{ @$item->storage == 'vimeo_id' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_vimeo_id') }}" />
                                                                </div>
                                                                <div class="tab-pane fade {{ @$item->storage == 'google_drive' ? 'show active' : '' }} tab-attac"
                                                                    id="tabb-drive" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="google_drive"
                                                                        value=" {{ @$item->storage == 'google_drive' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_google_google_drive') }}" />
                                                                </div>
                                                                <div class="tab-pane fade {{ @$item->storage == 'external_link' ? 'show active' : '' }} tab-attac"
                                                                    id="tabb-external" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="external_link"
                                                                        value=" {{ @$item->storage == 'external_link' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_external_link') }}" />
                                                                </div>
                                                                <div class="tab-pane fade{{ @$item->storage == 'iframe' ? 'show active' : '' }}  tab-attac"
                                                                    id="tabb-iframe" role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="text" name="iframe"
                                                                        value=" {{ @$item->storage == 'iframe' ? @$item->file : '' }}"
                                                                        placeholder="{{ __('enter_iframe') }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade {{ @$item->file_type == 'listen' ? 'show active' : '' }}"
                                                        id="tabb-2" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="number"
                                                                placeholder="{{ __('duration') }}"
                                                                name="listen_duration" min="1"
                                                                value="{{ @$item->duration }}">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('media_file_duration_in_minutes') }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="file"
                                                                name="listen" accept=".mp3">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('support_extensions') }}: MP3
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade tab-attac {{ @$item->file_type == 'text' ? 'show active' : '' }}"
                                                        id="tabb-3" role="tabpanel">
                                                        <textarea class="form-control" rows="5" name="text" placeholder="{{ __('write_here') }}"> {{ @$item->file }} </textarea>
                                                    </div>

                                                    <input type="hidden" name="doc_type" id="docc_type"
                                                        value="pdf">
                                                    <div class="tab-pane fade {{ @$item->file_type == 'doc' ? 'show active' : '' }}"
                                                        id="tabb-4" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <ul class="nav nav-pills mb-3 tab-add-video"
                                                                role="tablist">
                                                                <li class="nav-item">
                                                                    <button class="nav-link docc_type active"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-pdf" data-value="pdf"
                                                                        type="button" role="tab"> PDF</button>
                                                                </li>
                                                                {{-- <li class="nav-item">
                                                                    <button class="nav-link docc_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-word" data-value="word"
                                                                        type="button" role="tab"> Word</button>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <button class="nav-link docc_type"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#tabb-ppt"
                                                                        data-value="power_point" type="button"
                                                                        role="tab"> PowerPoint</button>
                                                                </li> --}}
                                                            </ul>
                                                            <div class="tab-content">
                                                                <div class="tab-pane fade show active" id="tabb-pdf"
                                                                    role="tabpanel">
                                                                    <input class="form-control bg-light-green"
                                                                        type="file" name="pdf" accept=".pdf">
                                                                </div>
                                                                {{-- <div class="tab-pane fade show" id="tabb-word"
                                                                    role="tabpanel">
                                                                    <input type="file" name="word"
                                                                        accept=".doc, .docx">
                                                                </div>
                                                                <div class="tab-pane fade show" id="tabb-ppt"
                                                                    role="tabpanel">
                                                                    <input type="file" name="power_point"
                                                                        accept=".ppt, .pptx">
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade {{ @$item->file_type == 'image' ? 'show active' : '' }}"
                                                        id="tabb-5" role="tabpanel">
                                                        <div class="bg-white rounded-3 p-3">
                                                            <input class="form-control bg-light-green" type="file"
                                                                name="image" accept=".png, .jpg, .jpeg, .svg">
                                                            <div class="row">
                                                                <div class="col-lg-5 mx-auto">
                                                                    <p class="text-center text--muted">
                                                                        {{ __('support_extensions') }}: png - jpg -
                                                                        jpeg - svg
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
                                                            <p class="text-center text--muted">يدعم إمتدادات: jpeg -
                                                                jpg - png - pdf - docx</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3 mt-2" id="uploadedFilesList">
                                                    <div id="storedImagesList" class="mt-3"></div>
                                                </div>




                                                <div class="d-lg-flex align-items-center mb-3  justify-content-start">
                                                    <div class="d-flex align-items-center mb-2 mb-lg-0 col-3">
                                                        <h7><strong>{{ __('active') }}</strong></h7>
                                                    </div>
                                                    <div class="d-flex align-items-center col-9">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="status"
                                                                {{ @$item->status == 'active' ? 'checked' : '' }}
                                                                role="switch">
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
                                                            <span class="btn btn-outline-primary px-1 w-100"
                                                                onclick="closeModal()">{{ __('cancel') }}</span>
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
                                                                    value="free"
                                                                    {{ @$item->accessibility == 'free' ? 'checked' : '' }} />
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <p class="me-3"> {{ __('free') }}</p>

                                                            <label class="m-radio m-radio-2 mb-0 ms-2 me-2">
                                                                <input type="radio" name="accessibility"
                                                                    value="paid"
                                                                    {{ @$item->accessibility == 'paid' ? 'checked' : '' }} />
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
                                                                    name="downloadable" role="switch"
                                                                    {{ @$item->downloadable == 1 ? 'checked' : '' }}>
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
            var imgPreview = document.createElement('img');

            let uploaded_img_path = URL.createObjectURL(files[i]);
            let pdf_path = "{{ asset('assets/front/images/pdf.png') }}";
            let word_path = "{{ asset('assets/front/images/docx.png') }}";
            let ext = (files[i].name).split('.').pop();
            if (ext == 'pdf') {
                uploaded_img_path = pdf_path;
            } else if (ext == 'docx') {
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

@php
    if (checkUser('lecturer') && $user_type == 'lecturer') {
    } elseif (auth('admin')->user() && $user_type == 'admin') {
    }
@endphp

<script>
    var storedImageUrls = @json($attachments->pluck('id', 'attachment')->toArray());
    var course_id = @json($course_id);
    var baseUrl = '{{ url('/') }}';

    function displayStoredImages() {
        var storedImagesList = document.getElementById('storedImagesList');

        Object.entries(storedImageUrls).forEach(([imageUrl, img_id]) => {
            var imgWrapper = document.createElement('div');
            imgWrapper.classList.add('image-wrapper');

            var imgElement = document.createElement('img');

            let uploaded_img_path = baseUrl + '/get-course-file/' + course_id + '/lesson_attachments/' +
                imageUrl;
            let pdf_path = "{{ asset('assets/front/images/pdf.png') }}";
            let word_path = "{{ asset('assets/front/images/docx.png') }}";
            let ext = (imageUrl).split('.').pop();
            if (ext == 'pdf') {
                uploaded_img_path = pdf_path;
            } else if (ext == 'docx') {
                uploaded_img_path = word_path;
            }

            imgElement.src = uploaded_img_path;

            var deleteIcon = document.createElement('span');
            deleteIcon.classList.add('delete-icon');
            deleteIcon.innerHTML = 'X';

            deleteIcon.onclick = function() {
                // Call the function to delete the image
                deleteImage(img_id, imageUrl, imgWrapper, course_id);
            };

            imgWrapper.appendChild(imgElement);
            imgWrapper.appendChild(deleteIcon);
            storedImagesList.appendChild(imgWrapper);
        });
    }

    // Function to delete an image using Ajax
    function deleteImage(img_id, imageUrl, imgWrapper, course_id) {
        var url = '{{ @$delete_attachment_url }}';
        url = url.replace(':id', img_id);
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                course_id: course_id,
            },
            success: function(response) {
                console.log('Image deleted successfully');
                imgWrapper.remove();
            },
            error: function(error) {
                // Handle error
                console.error('Error deleting image:', error);
            }
        });
    }

    displayStoredImages();
</script>
