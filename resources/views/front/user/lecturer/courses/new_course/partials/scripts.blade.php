script
<script src="{{ asset('assets/front/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"> </script>
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

  // Add question
  $(document).on('click', '.btn-add-select-qestion' , function(){
    selectanswerCount = selectQuestionsCount;
    $('.list-qestion-1').append(`
      <div class="bg-white rounded-3 widget_item-qestion mt-3">
        <div class="d-flex align-items-center widget_item-head p-3 pointer collapsed" data-bs-toggle="collapse" data-bs-target="#select-question-${selectQuestionsCount}">
          <h6 class="mx-2"> ${selectQuestionsCount} .السؤال </h6>
            <div class="widget_item-action d-flex align-items-center">
                <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
            </div>
          <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
        </div>
        <div class="widget_item-body accordion-collapse collapse" id="select-question-${selectQuestionsCount}" data-bs-parent="#accordionExamSelect">
          <div class="p-3">
            <div class="form-group">
              <input type="text" class="form-control" name="questions[]" placeholder="أدخل السؤال هنا">
            </div>
                <div class="form-group list-answer-select">
                    <div class="d-flex align-items-center mb-2 item-answer">
                        <label class="m-radio m-radio-2 mb-0 ms-2">
                            <input type="radio" name="correct_answer_${selectQuestionsCount}" value="1"/><span
                                class="checkmark"></span>
                        </label>
                        <div class="input-icon col left me-2">
                            <input class="form-control bg-light-green rounded-2" name="question_answers_${selectQuestionsCount}[]" type="text" placeholder="أدخل الإجابة 1"/>
                        </div>

                        <div class="icon">
                            <div class="widget_item-action">
                                <div class="widget_item-icon btn-remove-select-answer"><i class="fa-solid fa-trash"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="form-group">
              <div class="d-flex align-items-center justify-content-between me-4 mt-2">
                <button type="button" class="btn p-0 bg-transparent border-0 me-2 font-medium btn-add-select-answer"><i class="fa-regular fa-plus ms-1"></i> إضافة إجابة جديدة</button>
                <div class="col-lg-3 col-5">
                  <input type="text" class="form-control" name="question_${selectQuestionsCount}_mark" placeholder="{{ __('enter_mark') }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `)

    selectQuestionsCount ++
  })

  // Add Answer
  $(document).on('click', '.btn-add-select-answer' , function(){
    $(this).closest('.widget_item-qestion').find('.list-answer-select').append(`
        <div class="d-flex align-items-center mb-2 item-answer">
            <label class="m-radio m-radio-2 mb-0 ms-2">
                <input type="radio" name="correct_answer_${selectQuestionsCount}" value="${selectanswerCount}"/><span
                    class="checkmark"></span>
            </label>
            <div class="input-icon col left me-2">
                <input class="form-control bg-light-green rounded-2" type="text" name="question_answers_${selectanswerCount}[]" placeholder="أدخل الإجابة "/>
            </div>
            <div class="icon">
                <div class="widget_item-action">
                    <div class="widget_item-icon btn-remove-select-answer"><i class="fa-solid fa-trash"></i></div>
                </div>
            </div>
        </div>
    `)
  })

   // remove Answer
  $(document).on('click', '.btn-remove-select-answer' , function(){
    $(this).closest('.item-answer').remove()
  })




//   ------------   Complete Type     ------------
   var completeQuestionsCount = 2

  // Add question
  $(document).on('click', '.btn-add-complete-qestion' , function(){
    $i = 2;
    $('.list-qestion-complete').append(`
      <div class="bg-white rounded-3 widget_item-qestion mt-3">
        <div class="d-flex align-items-center widget_item-head p-3 pointer collapsed" data-bs-toggle="collapse" data-bs-target="#complete-question-${completeQuestionsCount}">
          <h6 class="mx-2"> ${$i} السؤال </h6>
            <div class="widget_item-action d-flex align-items-center">
                <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
            </div>
          <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
        </div>
        <div class="widget_item-body accordion-collapse collapse" id="complete-question-${completeQuestionsCount}" data-bs-parent="#accordionExamComplete">
          <div class="p-3">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="أدخل السؤال هنا">
            </div>
            <div class="form-group list-answer-complete">
                <div class="d-flex align-items-center mb-2 item-answer">
                    <input class="form-control bg-light-green input-tags" type="text" placeholder="أدخل الإجابة" />
                    <div class="icon">
                        <div class="widget_item-action">
                            <div class="widget_item-icon btn-remove-complete-answer"><i class="fa-solid fa-trash"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
              <div class="d-flex align-items-center justify-content-between me-4 mt-2">
                <button type="button" class="btn p-0 bg-transparent border-0 me-2 font-medium btn-add-complete-answer"><i class="fa-regular fa-plus ms-1"></i> إضافة إجابة جديدة</button>
                <div class="col-lg-3 col-5">
                  <input type="text" class="form-control" placeholder="{{ __('enter_mark') }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `)

    completeQuestionsCount ++
  })

  // Add Answer
  $(document).on('click', '.btn-add-complete-answer' , function(){
    $(this).closest('.widget_item-qestion').find('.list-answer-complete').append(`
      <div class="d-flex align-items-center mb-2 item-answer">
        <input type="text" placeholder="أدخل الإجابة" class="form-control bg-light-green">
        <div class="icon">
            <div class="widget_item-action">
                <div class="widget_item-icon btn-remove-complete-answer"><i class="fa-solid fa-trash"></i></div>
            </div>
        </div>
      </div>
    `)
  })

  // remove Answer
  $(document).on('click', '.btn-remove-complete-answer' , function(){
    $(this).closest('.item-answer').remove()
  })


// -------------------------------------------------------------




  var countQestionTask_2 = 2

  // Add question
  $(document).on('click', '.btn-add-qestion-task' , function(){
    $('.list-qestion-task').append(`
      <div class="bg-white rounded-3 widget_item-qestion mb-3">
        <div class="d-flex align-items-center widget_item-head p-3 pointer collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-qestion-${countQestionTask_2}">
            <h6 class="mx-2">${countQestionTask_2} السؤال </h6>
            <div class="widget_item-action d-flex align-items-center">
                <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
            </div>
          <div class="widget_item-chevron ms-auto"><i class="fa-regular fa-chevron-down"></i></div>
        </div>
        <div class="widget_item-body accordion-collapse collapse" id="collapse-qestion-${countQestionTask_2}" data-bs-parent="#accordionQestion">
          <div class="p-3">
            <div class="form-group">
              <input type="text" class="form-control" name="questions[]"  placeholder="أدخل السؤال هنا">
            </div>
            <div class="form-group">
              <label> الإجابة :</label>
              <div class="d-flex align-items-center">
                <label class="m-radio m-radio-2 mb-0">
                  <input type="radio" name="answer_type_${countQestionTask_2}" value="text"><span class="checkmark"></span> نصية
                </label>
                <label class="m-radio m-radio-2 mb-0 ms-5">
                  <input type="radio"name="answer_type_${countQestionTask_2}" value="file" ><span class="checkmark"></span> إرفاق ملفات
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    `)

    countQestionTask_2 ++
  })
</script>

<script src="{{ asset('assets/front/js/course_settings.js') }}"> </script>

<script>
$(document).ready(function() {

     var sectionsConfig = {
         addButtonId: 'AddSection',
         modalId: 'modalAddSection',
         formId: 'CourseSectionsForm',
         saveButtonId: 'saveCourseSection',
         apiUrl: "{{ route('user.lecturer.course.curriculum.section.set_section') }}",
         deleteUrl: "{{route('user.lecturer.course.curriculum.section.delete_section')}}",
         section: 'section',
         displayAttributes: ['id', 'title', 'is_active']
     };

     var courseSection = new PageSection(sectionsConfig, true);
     courseSection.init();


 });

 new Dropzone('.myDropzone-video', {
        url: "/file/post",
        dictDefaultMessage:`
            <span class='icon'>
            <i class="fa-solid fa-video ms-1"></i>
            </span><span class='text'>رفع فيديو</span>`,
        acceptedFiles: ".mp4"}
    );

    new Dropzone('.myDropzone-sound', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-volume ms-1"></i>
                </span><span class='text'>رفع ملف صوتي</span>`,
        acceptedFiles: ".mp3"}
    );
    new Dropzone('.myDropzone-lesson', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-download ms-1"></i>
                </span><span class='text'>إضافة مرفقات للدرس</span>`,
        acceptedFiles: ".pdf,.png"}
    );
    new Dropzone('.myDropzone-pdf', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-file-lines ms-1"></i>
                </span><span class='text'>إرفاق ملف</span>`,
        acceptedFiles: ".pdf"}
    );
    new Dropzone('.myDropzone-word', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-file-lines ms-1"></i>
                </span><span class='text'>إرفاق ملف</span>`,
        acceptedFiles: ".docx,.doc"}
    );
    new Dropzone('.myDropzone-ppt', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-file-lines ms-1"></i>
                </span><span class='text'>إرفاق ملف</span>`,
        acceptedFiles: ".pptx"}
    );

    new Dropzone('.myDropzone-image', {
        url: "/file/post",
        dictDefaultMessage: `
            <span class='icon'>
                <i class="fa-solid fa-paperclip ms-1"></i>
                </span><span class='text'>إرفاق صورة</span>`,
        acceptedFiles: ".png,.jpg,.jpeg,.svg"}
    );
</script>


