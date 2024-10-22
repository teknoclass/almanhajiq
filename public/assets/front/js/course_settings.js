function PageSection(sectionConfig, enableEdit) {

    var config = sectionConfig;
    var isEditEnabled = enableEdit;

    function openModal() {
        $('#' + config.modalId).modal('show');
    }

    function populateFormData(data) {

        $.each(data, function(key, value) {
            var element = $('#' + key)
            if (element.is('input') || element.is('textarea')) {
                element.val(value);
            }

            if(key == "is_active") {
                if(value == 1 ){
                    element.prop('checked', true);
                }
            }
        });
    }

    function clearForm() {
        $('#' + config.formId)[0].reset();
        $('[title="id"]').val('');
    }

    function generateRowHTML(item) {

        var rowContent = '';
        var editButton = '';

        if (isEditEnabled) {

            config.displayAttributes.forEach(function(attribute) {
                rowContent += ` data-${attribute}="${item[attribute]}" `;
            });

            editButton = `
                <div class="widget_item-icon edit-${config.section}" data-bs-toggle="modal" data-bs-target="#${config.modalId}"
                    ${rowContent}>
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>`;
        }

        var newRowHTML = `<div class="accordion list-add-section" id="accordionSection_${item.id}">
        <div id="section_${item.id}" class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
        <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center collapsed pointer" data-bs-toggle="collapse" data-bs-target="#collapse-section-${item.id}">
            <div class="d-flex align-items-center">
            <div class="circle bg-dark ms-2"></div>
            <h5>اسم القسم / ${item.title}</h5>
            <div class="widget_item-action d-flex align-items-center">

               <div class="widget_item-icon edit-section"
                    data-bs-toggle="modal"
                    data-bs-target="#modalAddSection"
                    data-id="${item.id}"
                    data-title="${item.title}"
                    data-is_active="${item.is_active}">
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>
                <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                data-url="{{route('user.lecturer.course.curriculum.section.delete_section')}}"
                data-id="${item.id}" data-is_relpad_page="true"
                data-row="accordionSection_${item.id}">
                 <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
               </button>
            </div>
            </div>
            <div class="d-flex align-items-center ms-lg-auto">
            <div class="widget_item-chevron me-2"><i class="fa-regular fa-chevron-down"></i></div>
            </div>
        </div>
        <div class="widget_item-body accordion-collapse collapse" id="collapse-section-${item.id}" data-bs-parent="#accordionSection_${item.id}">
            <div class="row my-3">
            <div class="col-lg-4">
                <button class="btn btn-primary-2 w-100 mb-2 mb-lg-0 outer_modal_lesson" data-course_id="${item.course_id}" data-section_id="${item.id}" data-type="add">أضف درس</button>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary-2 w-100 mb-2 mb-lg-0 outer_modal_assignment" data-course_id="${item.course_id}}" data-section_id="${item.id}" data-type="add">أضف مهمة</button>
            </div>
            <div class="col-lg-4">
                <button class="btn btn-primary-2 w-100 outer_modal_quiz" data-course_id="${item.course_id}" data-section_id="${item.id}" data-type="add">أضف اختبار</button>
            </div>
            </div>
            <div class="row">
            </div>
        </div>
        </div>

</div>

        `;

        return newRowHTML;
    }

    function appendNewRow(item) {

        newRowHTML = generateRowHTML(item);
        $('.list-add-' + config.section).append(newRowHTML);
    }

    function saveForm(formData) {
        $.ajax({
            type: 'POST',
            url: config.apiUrl,
            data: formData,
            success: function(response) {
                clearForm();
                $('#' + config.modalId).modal('hide');
                if (response.status) {
                    clearForm();
                    customSweetAlert(
                        'success',
                        response.message,
                        response.item,
                        function (event) {}
                    );
                    if (response.type == 'edit') {
                        var editedRow = $('.edit-' + config.section).filter('[data-id="' + response.new_item.id + '"]').closest('.widget_item-section');
                        var newRowHTML = generateRowHTML(response.new_item);
                        editedRow.replaceWith(newRowHTML);
                    } else {
                        appendNewRow(response.new_item);
                    }
                } else {
                    customSweetAlert(
                        'error',
                        response.message,
                        response.errors_object
                    );
                }
            },
            error: function(jqXhr) {
                console.log('jqXhr');
                $(save_btn).attr("disabled", false);
                $(save_btn).find('.spinner-border').hide();
                getErrors(jqXhr, '/login');
            }
        });
    }

    function init() {
      //  alert( config.section);
        $('#' + config.addButtonId).click(function() {
            clearForm();
            openModal();
        });

        $(document).on('click', '.edit-' + config.section, function() {
            var sectionData = $(this).data();
            populateFormData(sectionData);
            openModal();
        });

        $('#' + config.saveButtonId).click(function(event) {
            event.preventDefault();
            var formData = $('#' + config.formId).serialize();
            saveForm(formData);
        });
    }

    return {
        init: init
    };
}
