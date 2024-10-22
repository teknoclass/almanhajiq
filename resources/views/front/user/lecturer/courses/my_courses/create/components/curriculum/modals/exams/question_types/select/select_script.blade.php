<script>
    $(document).ready(function() {

        // Add question
        $(document).on('click', '.btn-add-new-qestion', function() {

            question_no = $(this).data('question_no');
            var buttonElement = $(this);

            var template = $('.question-template').clone().html();
            var newHtml = template.replace(/__question_no__/g, question_no);

            $('.list-qestions').append(newHtml)

            buttonElement.data('question_no', question_no + 1);

        })

        // Add Answer
        function addAnswer(questionNo, langObject) {
            
            var htmlAnswerContent = `<div class="d-flex align-items-center mb-2 item-answer">
                <label class="m-radio m-radio-2 mb-0 ms-2">
                    <input type="hidden" name="correct_answer_${questionNo}[]" value="0"/>
                    <input type="radio" name="correct_answer_${questionNo}[]" value="1"/><span class="checkmark"></span>
                </label>`;

            for (const key in langObject) {
                if (langObject.hasOwnProperty(key)) {
                    if (key == "en") {
                        var lang_name = "{{ __('translate.en') }}"
                    }
                    else if (key == "ar") {
                        var lang_name = "{{ __('translate.ar') }}"
                    }
                    htmlAnswerContent += `<div class="input-icon col left me-2">
                        <input class="form-control bg-light-green rounded-2" type="text" name="question_answers_${key}_${questionNo}[]" placeholder="{{ __('answer') }} (${lang_name})"/>
                    </div>`;
                }
            }

            htmlAnswerContent += `<div class="icon">
                    <div class="widget_item-action">
                        <div class="widget_item-icon btn-remove-select-answer"><i class="fa-solid fa-trash"></i></div>
                    </div>
                </div>
            </div>`;

            return htmlAnswerContent;
        }

        $(document).on('click', '.btn-add-select-answer', function() {
            const langObject = JSON.parse(lang);
            question_no = $(this).data('question_no');

            const html_answer_content = addAnswer(question_no, langObject);

            $(this).closest('.widget_item-qestion').find('.list-answer-select').append(html_answer_content)

        });

        // remove Answer
        $(document).on('click', '.btn-remove-select-answer', function() {
            $(this).closest('.item-answer').remove()
        })

        $(document).on('click', '.btn-remove-widget_question', function() {
            $(this).closest('.tab-content').remove()
        })
    });
</script>
