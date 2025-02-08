<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"></script>
@include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question_types.select.select_script')
@include('front.user.lecturer.courses.my_courses.create.components.curriculum.modals.exams.question_types.short_answer.short_answer_script')

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

    // ------------------       Quizzes         -----------------------------------------------

    //   ------------   select Type     ------------
    var selectQuestionsCount = 2;
    var selectanswerCount = 1;
    var i = 0;
    const lang = '{!! json_encode(locales()) !!}';

    $(document).on('click', '.btn-remove-widget_question', function() {
        $(this).closest('.tab-content').remove()
    })


    var countQestionTask_2 = 2

    // Add question
    $(document).on('click', '.btn-add-qestion-task', function() {
        const langObject = JSON.parse(lang);
            let question_no = $(this).data('question_no');
            let buttonElement = $(this);

        /*
                for (const key in langObject) {
                    if (langObject.hasOwnProperty(key)) {
                        html_answer_content+= `
        */

        var html_content = ` <div class="tab-content bg-white rounded-3 widget_item-qestion mb-3">
        <div class="d-flex align-items-center widget_item-head p-3 pointer" data-bs-toggle="collapse" data-bs-target="#collapse-qestion-${question_no}">
            <h6 class="mx-2">${question_no} {{ __('question') }} </h6>
            <div class="widget_item-action d-flex align-items-center">
                <div class="widget_item-icon btn-remove-widget_question"><i class="fa-solid fa-trash"></i></div>
            </div>
          <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
        </div>
        <div class="widget_item-body accordion-collapse collapse show" id="collapse-qestion-${question_no}" data-bs-parent="#accordionQestion">
          <div class="p-3">`;

        for (const key in langObject) {
            if (langObject.hasOwnProperty(key)) {
                if (key == "en") {
                    var lang_name = "{{ __('translate.en') }}"
                }
                else if (key == "ar") {
                    var lang_name = "{{ __('translate.ar') }}"
                }
                html_content += ` <div class="form-group">
                                    <label>{{ __('question') }} ( ${ key } )</label>
                                    <textarea class="form-control tinymce" type="text"
                                        name="questions_${ key }[]"
                                        ></textarea>
                                </div>`;
            }
        }

        html_content += `<div class="form-group">
              <label> {{ __('answer') }} :</label>
              <div class="d-flex align-items-center">
                <label class="m-radio m-radio-2 mb-0">
                  <input type="radio" name="answer_type[${question_no - 1}]" checked value="text"><span class="checkmark"></span> {{ __('text1') }}
                </label>
                <label class="m-radio m-radio-2 mb-0 ms-5">
                  <input type="radio"name="answer_type[${question_no - 1}]" value="file" ><span class="checkmark"></span> {{ __("attach_files") }}
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>`;


        $('.list-qestion-task').append(html_content);
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



        buttonElement.data('question_no', question_no + 1);
    })
    const handleImageUpload = (blobInfo, success, failure) => new Promise((resolve, reject) => {
                    const formData = new FormData()
                    formData.append('image', blobInfo.blob())
                    formData.append('width', '')
                    formData.append('height', '')
                    formData.append('custome_path', $('#custome_path').val());
                    $.ajax({
                        url: '/image/upload',
                        method: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            const location = response.file_name
                            setTimeout(function () {
                                /* no matter what you upload, we will turn it into TinyMCE logo :)*/
                                success(window.base_image_url + '/' + location);
                            }, 2000);
                        },
                        error: function (jqXhr) {
                            toastr.error(window.unexpected_error);
                        }
                    });

                });
</script>

<script src="{{ asset('assets/front/js/course_settings.js') }}"></script>

@php

    if (checkUser('lecturer') && $user_type == "lecturer") {
        $set_section_url = route('user.lecturer.course.curriculum.section.set_section');
        $delete_section_url = route('user.lecturer.course.curriculum.section.delete_section');
    } elseif (auth('admin')->check() && $user_type == "admin") {
        $set_section_url = route('panel.courses.edit.curriculum.section.set_section');
        $delete_section_url = route('panel.courses.edit.curriculum.section.delete_section');
    }
@endphp
<script>
    $(document).ready(function() {

        var sectionsConfig = {
            addButtonId: 'AddSection',
            modalId: 'modalAddSection',
            formId: 'CourseSectionsForm',
            saveButtonId: 'saveCourseSection',
            apiUrl: '{{ @$set_section_url }}',
            deleteUrl: '{{ @$delete_section_url }}',
            section: 'section',
            displayAttributes: ['id', 'title', 'is_active']
        };

        var courseSection = new PageSection(sectionsConfig, true);
        courseSection.init();
    });
</script>

<script>
    $(document).ready(function() {
        $(".edit_lesson").each(function(index, element) {
            var lessonId = $(element).data('id');
            $(element).on('click', function() {
                $('#modalAddLesson' + lessonId).modal('show');
            });
        });

        $(".edit_exam").each(function(index, element) {
            var examId = $(element).data('id');
            $(element).on('click', function() {
                $('#modalAddExam' + examId).modal('show');
            });
        });

        $(".edit_task").each(function(index, element) {
            var taskId = $(element).data('id');
            $(element).on('click', function() {
                $('#modalAddTasks' + taskId).modal('show');
            });
        });
    });
</script>
