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
        });
    }

    function clearForm() {
        $('#' + config.formId)[0].reset();
        $('[name="id"]').val('');
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

        var newRowHTML = `

            <div id="${config.section}_${item.id}" class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="circle bg-dark ms-2 me-2"></div>
                        <h5 class="cursor-pointer">
                            ${item.name}
                        </h5>
                    </div>
                    <div class="d-flex align-items-center ms-lg-auto">
                        <div class="widget_item-action d-flex align-items-center">
                            ${editButton}

                            <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                                    data-url="${config.deleteUrl}"
                                    data-id="${item.id}" data-is_relpad_page="true"
                                    data-row="${config.section}_${item.id}">
                                <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                            </button>
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
                        function(event) {}
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