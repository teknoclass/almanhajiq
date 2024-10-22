$(document).ready(function () {
    // AJAX setup for CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Publish button action
    $('#publish-button').on('click', function (event) {
        event.preventDefault(); // Prevent default anchor behavior

        var form = $('#form');
        var button = $(this);
        var url = button.data('url');

        // Get translations from data attribute
        var translations = JSON.parse(button.attr('data-translations'));

        // Check if the table has any session rows
        var sessionRowCount = $('#planContainer tbody tr').length;

        if (sessionRowCount === 0) {
            // Display a validation error message for empty sessions
            customSweetAlert('error', translations.add_session_error, '');
            return; // Prevent form submission
        }

        if (form.valid()) {
            var formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                            if (response.item) {
                                button.text('Unpublish');
                                $('#sessionInputsContainer').find('input, select, textarea, button').prop('disabled', true);
                                $('#planContainer').find('input, select, button').prop('disabled', true);
                                button.removeClass('btn-success').addClass('btn-danger');
                                $('#addGroup').css('display', 'block');
                                $('#generate_btn').css('display', 'none');
                                $('#add_lesson').css('display', 'none');
                                location.reload();
                            }
                        },
                        error: function (xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        } else {
            // Show a message for form validation errors
            customSweetAlert('error', translations.form_submit_error, '');
        }
    });

    // Unpublish button action
    $('#unpublish-button').on('click', function (event) {
        event.preventDefault(); // Prevent default anchor behavior

        var button = $(this);
        var url = button.data('url');

        $.ajax({
            url: url,
            type: 'GET',
            success: function (response) {
                button.text('Publish');
                $('#sessionInputsContainer').find('input, select, textarea, button').prop('disabled', false);
                $('#planContainer').find('input, select, button').prop('disabled', false);
                button.removeClass('btn-danger').addClass('btn-success');
                $('#addGroup').css('display', 'none');
                $('#generate_btn').css('display', 'block');
                $('#add_lesson').css('display', 'block');
                location.reload();
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});
