@extends('front.user.lecturer.layout.index')

@section('content')
    @push('front_css')
        <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/front/css/summernote.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}" />
    @endpush

    @php
        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('courses'),
                'link' => route('user.lecturer.my_courses.index'),
            ],
            [
                'title' => @$course->title,
                'link' => '#',
            ],
        ];

        if (Str::contains(Request::url(), 'admin')) {
            $user_type = "admin";
        }
        else if (Str::contains(Request::url(), 'lecturer')) {
            $user_type = "lecturer";
        }
    @endphp

    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <!--begin::breadcrumb-->
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links, 'item' => @$course])
            <!--end::breadcrumb-->

            <!--begin::Content-->
            <div class="row g-5 gx-xxl-8 mb-4">
                <div class="bg-white p-4 rounded-4">

                    <div class="row">
                        <div class="col-12">
                            @include('front.user.lecturer.courses.my_courses.create.partials.toolbar', ['item' => @$course])
                            <div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
                                <div class="bg-white px-3 rounded-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="font-medium mb-3">
                                                {{ __('course_curriculum') }}
                                                <a href="{{ route('user.lecturer.course.curriculum.preview_curriculum.item', @$course->id) }}" target="__blank"><i class="fas fa-eye text-muted fa-xs ms-2"></i></a>
                                            </h2>
                                            <div class="row mb-4">
                                                <div class="col-12">
                                                    <div class="bg-light-green p-3 p-lg-4 rounded-2">
                                                        <div class="row gx-lg-3">
                                                            <?php $col_lg_w = @$course->type == 'recorded' ? 3 : 2; ?>
                                                                @if(@$course->type != 'live')
                                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                                <div class="widget_item-add bg-white rounded-2 d-flex align-items-center justify-content-center pointer"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalAddSection"
                                                                    id="AddSection">
                                                                    <h4>
                                                                        <i class="fa-regular fa-plus ms-1"></i>
                                                                        {{ __('add_section') }}
                                                                    </h4>
                                                                </div>

                                                            </div>
                                                            <div class="col-lg-{{ @$col_lg_w }} col-md-4 col-sm-6">
                                                                <div class="widget_item-add outer_modal_lesson bg-white rounded-2 d-flex align-items-center justify-content-center pointer"
                                                                    data-course_id="{{ @$course->id }}"
                                                                     data-course_type="{{ @$course->type }}"
                                                                     data-section_id="" data-type="add">
                                                                    <h4>
                                                                        <i class="fa-regular fa-plus ms-1"></i>
                                                                        {{ __('add_lesson') }}
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                                @endif
                                                            <div class="col-lg-{{ @$col_lg_w }} col-md-4 col-sm-6">
                                                                <div class="widget_item-add outer_modal_quiz bg-white rounded-2 d-flex align-items-center justify-content-center pointer"
                                                                    data-course_id="{{ @$course->id }}"
                                                                     data-course_type="{{ @$course->type }}"
                                                                     data-section_id="" data-type="add">
                                                                    <h4>
                                                                        <i class="fa-regular fa-plus ms-1"></i>
                                                                        {{ __('add_quiz') }}
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-{{ @$col_lg_w }} col-md-4 col-sm-6">
                                                                <div class="widget_item-add outer_modal_assignment bg-white rounded-2 d-flex align-items-center justify-content-center pointer"
                                                                    data-course_id="{{ @$course->id }}"
                                                                     data-course_type="{{ @$course->type }}"
                                                                     data-section_id="" data-type="add">
                                                                    <h4>
                                                                        <i class="fa-regular fa-plus ms-1"></i>
                                                                        {{ __('add_task') }}
                                                                    </h4>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="mt-4 col-12  list-add-section">
                                                    @include('front.user.lecturer.courses.my_courses.create.components.curriculum.sections')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Start Modals-->
                                @include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.section_modal')

                                <div id="targetDiv">
                                </div>

                                <!-- End Modals-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
        @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal', ['item' => @$course])
        <input type="hidden" id="needToolbarConfirm" value="false">
    </section>

    @push('front_js')
        @include('front.user.lecturer.courses.my_courses.create.partials.curriculum_scripts')

        <script>
            window.add_lesson = {!! json_encode(__('add_lesson')) !!};
            window.add__live_lesson = {!! json_encode(__('add_live_lesson')) !!};
            window.add_quiz = {!! json_encode(__('add_quiz')) !!};
            window.add_task = {!! json_encode(__('add_task')) !!};
            window.section_name = {!! json_encode(__('section_name')) !!};
        </script>

        <script src="{{ asset('assets/front/js/post.js') }}"></script>
        <script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/front/js/summernote.min.js') }}"></script>
        <script>
            $(document).on('click', '.action_btn', function(e) {
                e.preventDefault();
                var section = $(this).data('section');
                var action = $(this).data('action')
                $('#' + action + '_' + section).css('display', 'block');
                $('#' + action + '_' + section).siblings().hide();
            });

            $('.scroll').each(function() {
                const ps = new PerfectScrollbar($(this)[0]);
            });
        </script>


        <script>
            window.base_image_url = "{{ env('APP_URL') }}/image";

            $(document).ready(function() {
                // Close modal if clicked outside of it
                $(document).on('click', '.outer_modal_lesson', function(e) {
                    var course_id = $(this).data('course_id');
                    var course_type = $(this).data('course_type');
                    var section_id = $(this).data('section_id');
                    var type = $(this).data('type');
                    var item_id = $(this).data('id');
                    $('#load').show();
                    $.ajax({
                        url: "{{ route('user.lecturer.course.curriculum.get_lesson_modal') }}", // Use the new endpoint
                        method: "GET",
                        data: {
                            course_id: course_id,
                            course_type: course_type,
                            section_id: section_id,
                            type: type,
                            item_id: item_id
                        },
                        success: function(response) {
                            $('#load').hide();
                            $("#targetDiv").html(response.content);
                            showMyModal();

                        },
                        error: function() {
                            $('#load').hide();
                            console.error("Failed to fetch lesson modal.");
                        }
                    });
                });

                function showMyModal() {
                    // Assuming your modal has an ID, e.g., #myModal
                    $("#modalAddLesson").show();
                }

                $(document).on('click', '.outer_modal_quiz', function(e) {
                    var course_id = $(this).data('course_id');
                    var course_type = $(this).data('course_type');

                    var section_id = $(this).data('section_id');
                    var type = $(this).data('type');
                    var item_id = $(this).data('id');
                    $('#load').show();
                    $.ajax({
                        url: "{{ route('user.lecturer.course.curriculum.get_task_modal') }}",
                        method: "GET",
                        data: {
                            course_id: course_id,
                            course_type: course_type,
                            section_id: section_id,
                            type: type,
                            item_id: item_id
                        },
                        success: function(response) {
                            $('#load').hide();
                            $("#targetDiv").html(response.content);
                            tinymce.init({
                                init_instance_callback: function (editor) {
                                    editor.on('blur', function (e) {
                                        $('#' + e.target.id).val(e.target.getContent());
                                        e.target.setContent(e.target.getContent());
                                    });
                                    editor.on('SetContent', function (e) {
                                        // console.log(e.content);
                                    });
                                },

                                selector: '.tinymce',
                                images_upload_handler: handleImageUpload,
                                images_upload_url: 'image/upload',
                                relative_urls: false,
                                remove_script_host: false,
                                convert_urls: false,
                                language: "ar",
                                language_url: '/assets/panel/plugins/custom/tinymce/langs/ar.js',
                                // path from the root of your web application — / — to the language pack(s)
                                directionality: 'rtl',
                                // menubar: false,
                                toolbar: ['styleselect fontselect fontsizeselect ',
                                    'undo redo | cut copy paste | bold italic | table link image media | alignleft aligncenter alignright alignjustify',
                                    'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  fullscreen '],
                                plugins: 'advlist autolink link image lists table charmap print preview  fullscreen media',
                                content_style:
                                    "body { color: #000; font-size: 18pt; font-family: Arial;text-align: justify }",
                                forced_root_block_attrs: { style: 'text-align: justify;' }

                            });
                            showExamModal();
                        },
                        error: function() {
                            $('#load').hide();
                            console.error("Failed to fetch lesson modal.");
                        }
                    });
                });

                function showExamModal() {
                    // Assuming your modal has an ID, e.g., #myModal
                    $("#modalAddExam").show();
                }


                $(document).on('click', '.outer_modal_assignment', function(e) {
                    var course_id = $(this).data('course_id');
                    var course_type = $(this).data('course_type');

                    var section_id = $(this).data('section_id');
                    var type = $(this).data('type');
                    var item_id = $(this).data('id');
                    $('#load').show();
                    $.ajax({
                        url: "{{ route('user.lecturer.course.curriculum.get_exam_modal') }}", // Use the new endpoint
                        method: "GET",
                        data: {
                            course_id: course_id,
                            course_type: course_type,
                            section_id: section_id,
                            type: type,
                            item_id: item_id
                        },
                        success: function(response) {
                            $('#load').hide();
                            $("#targetDiv").html(response.content);
                            tinymce.init({
                                init_instance_callback: function (editor) {
                                    editor.on('blur', function (e) {
                                        $('#' + e.target.id).val(e.target.getContent());
                                        e.target.setContent(e.target.getContent());
                                    });
                                    editor.on('SetContent', function (e) {
                                        // console.log(e.content);
                                    });
                                },

                                selector: '.tinymce',
                                images_upload_handler: handleImageUpload,
                                images_upload_url: 'image/upload',
                                relative_urls: false,
                                remove_script_host: false,
                                convert_urls: false,
                                language: "ar",
                                language_url: '/assets/panel/plugins/custom/tinymce/langs/ar.js',
                                // path from the root of your web application — / — to the language pack(s)
                                directionality: 'rtl',
                                // menubar: false,
                                toolbar: ['styleselect fontselect fontsizeselect ',
                                    'undo redo | cut copy paste | bold italic | table link image media | alignleft aligncenter alignright alignjustify',
                                    'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  fullscreen '],
                                plugins: 'advlist autolink link image lists table charmap print preview  fullscreen media',
                                content_style:
                                    "body { color: #000; font-size: 18pt; font-family: Arial;text-align: justify }",
                                forced_root_block_attrs: { style: 'text-align: justify;' }

                            });
                            showTaskModal();
                        },
                        error: function() {
                            $('#load').hide();
                            console.error("Failed to fetch lesson modal.");
                        }
                    });
                });

                const handleImageUpload = (blobInfo, success, failure) => new Promise((resolve, reject) => {
                    const formData = new FormData()
                    formData.append('image', blobInfo.blob())
                    formData.append('width', '')
                    formData.append('height', '')
                    formData.append('custome_path', $('#custome_path').val());
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                    $.ajax({
                        url: '/image/upload',
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            const location = response.file_name
                            console.log(window.base_image_url);
                            setTimeout(function () {
                                /* no matter what you upload, we will turn it into TinyMCE logo :)*/
                                success(window.base_image_url + '/' + location);
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", xhr);
                            console.error("Status:", status);
                            console.error("Error Message:", error);
                            console.error("Response Text:", xhr.responseText); // To log the full response
                        }
                    });

                });
                function showTaskModal() {
                    // Assuming your modal has an ID, e.g., #myModal
                    $("#modalAddTasks").show();
                }





            });
        </script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.question_type', function() {
                    var action = $(this).data('value');
                    var id = $(this).data('id');
                    $("#question_" + id + "_type").val(action);
                });


                $(".input-file-image-1").on('change', function() {
                    var $this = $(this)
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        var fileName = this.files[0].name;
                        reader.onload = function(e) {
                            $($this).closest('.input-image-preview').addClass('uploaded')
                            $($this).closest('.input-image-preview').find('.img-show').text(fileName)
                                .fadeIn();
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                $(".input-file-image-1").on('change', function() {
                    var $this = $(this)
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        var fileName = this.files[0].name;
                        reader.onload = function(e) {
                            $($this).closest('.input-image-preview').addClass('uploaded')
                            $($this).closest('.input-image-preview').find('.img-show').text(fileName)
                                .fadeIn();
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Input image 2
                $(".input-file-image-2").on('change', function() {
                    var $this = $(this)
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            console.log($(this))
                            $($this).closest('.input-image-preview').addClass('uploaded')
                            $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target
                                .result).fadeIn();
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
                // // Input image 3
                $(".input-file-image-3").on('change', function() {
                    var $this = $(this)
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            console.log($(this))
                            $($this).closest('.input-image-preview').addClass('uploaded')
                            $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target
                                .result).fadeIn();
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });


            });
        </script>
        <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>

    @endpush
@endsection
