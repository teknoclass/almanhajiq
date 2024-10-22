<script>
    // Add Answer
    $(document).on('click', '.btn-add-short-answer-new-answer', function() {

        const langObject = JSON.parse(lang);
        question_no = $(this).data('question_no');

        var html_answer_content = `<div class="d-flex align-items-center mb-2 item-answer">`;

        for (const key in langObject) {
            if (langObject.hasOwnProperty(key)) {
                if (key == "en") {
                    var lang_name = "{{ __('translate.en') }}"
                }
                else if (key == "ar") {
                    var lang_name = "{{ __('translate.ar') }}"
                }
                html_answer_content += `<div class="input-icon col left me-2">
                    <input class="form-control bg-light-green rounded-2" type="text" name="complete_question_answers_${key}_${question_no}[]" placeholder="{{ __('answer') }} (${lang_name})"/>
                </div>`;
            }
        }

        html_answer_content += `<div class="icon">
                <div class="widget_item-action">
                    <div class="widget_item-icon btn-remove-select-answer"><i class="fa-solid fa-trash"></i></div>
                </div>
            </div>
        </div>`;

        $(this).closest('.widget_short_answer-qestion').find('.list-answer-short_answer').append(
            html_answer_content)

    })

    // remove Answer
    $(document).on('click', '.btn-remove-short_answer-answer', function() {
        $(this).closest('.item-answer').remove()
    })
</script>
