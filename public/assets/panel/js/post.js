var form = $('#form');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
$.extend($.validator.messages, {
    required: "هذا الحقل مطلوب",
    remote: "يرجى التأكد  من هذا الحقل للمتابعة",
    email: "رجاء إدخال عنوان بريد إلكتروني صحيح",
    url: "رجاء إدخال عنوان موقع إلكتروني صحيح",
    date: "رجاء إدخال تاريخ صحيح",
    dateISO: "رجاء إدخال تاريخ صحيح (ISO)",
    number: "رجاء إدخال عدد بطريقة صحيحة",
    digits: "رجاء إدخال أرقام فقط",
    creditcard: "رجاء إدخال رقم بطاقة ائتمان صحيح",
    equalTo: "رجاء إدخال نفس القيمة",
    extension: "رجاء إدخال ملف بامتداد موافق عليه",
    maxlength: $.validator.format("الحد الأقصى لعدد الحروف هو {0}"),
    minlength: $.validator.format("الحد الأدنى لعدد الحروف هو {0}"),
    rangelength: $.validator.format("عدد الحروف يجب أن يكون بين {0} و {1}"),
    range: $.validator.format("رجاء إدخال عدد قيمته بين {0} و {1}"),
    max: $.validator.format("رجاء إدخال عدد أقل من أو يساوي {0}"),
    min: $.validator.format("رجاء إدخال عدد أكبر من أو يساوي {0}")
});

form.validate({
    rules: {
        password: {
            minlength: 6
        },
        password_confirmation: {
            minlength: 6,
            equalTo: "#password"
        }
    },
    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();

        // if (tinymce.editors.length > 0) {
        //     tinymce.editors.forEach(
        //         editor =>
        //             editor.setContent(editor.getContent())
        //     );
        // }


        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });


        if (window.is_all_images_uploaded) {


            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(form[0]);
            var url = form.attr('action');
            var redirectUrl = form.attr('to');
            var repeater = $('#m_repeater_1');
            var _method = form.attr('method');
            if (window.images !== undefined && window.images !== null) { formData.append('images', JSON.stringify(window.images)); }
            if (window.videos !== undefined && window.videos !== null) { formData.append('videos', JSON.stringify(window.videos)); }
            if (window.repeater) { formData.append('list', JSON.stringify(repeater.repeaterVal()[''])); }
            if (window.template_texts !== undefined && window.template_texts !== null) { formData.append('template_texts', JSON.stringify(window.template_texts)); }



            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        if (window.location.href.indexOf("create") > -1) {
                            $('#form')[0].reset();
                        }

                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (response.redirect_url) {
                                    // showLoader();
                                    $('#load').show();
                                    window.location = response.redirect_url;
                                } else {
                                    showLoader();
                                    window.location = redirectUrl;
                                }
                            }
                        );

                    } else {
                        customSweetAlert(
                            'error',
                            response.message,
                            response.errors_object
                        );
                    }
                },
                error: function(jqXhr) {
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    getErrors(jqXhr, '/panel/login');
                }
            });
        } else {
            customSweetAlert(
                'warning',
                'الرجاء الإنتظار حتى يتم رفع الصور',
                ''
            );
        }
    }
});



function getErrors(jqXhr, path) {
    //    hideLoader();
    switch (jqXhr.status) {
        case 401:
            $(location).prop('pathname', path);
            break;
        case 400:
            customSweetAlert(
                'error',
                jqXhr.responseJSON.message,
                ''
            );
            break;
        case 422:
            (function($) {
                var $errors = jqXhr.responseJSON.errors;
                var errorsHtml = '<ul style="list-style-type: none">';
                $.each($errors, function(key, value) {
                    errorsHtml += '<li style="font-family: \'Droid.Arabic.Kufi\' !important">' + value[0] + '</li>';
                });
                errorsHtml += '</ul>';
                customSweetAlert(
                    'error',
                    'حدثت الأخطاء التالية',
                    errorsHtml
                );
            })(jQuery);

            break;
        default:
            errorCustomSweet();
            break;
    }
    return false;
}


$(document).on('click', '.confirm-category', function(event) {
    var url = $(this).data('url');
    var id = $(this).data('id');
    var row = $(this).data('row');
    event.preventDefault();
    swal({
        title: "<span class='info'>" + window.are_your_sure + "</span>",
        type: 'question',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: window.confirm_text + "",
        cancelButtonText: window.cancel_text + "",
        confirmButtonColor: '#56ace0',
        allowOutsideClick: false
    }).then(function(result) {
        if (result.value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                type: 'json',
                data: { id: id },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        $('#' + row).css('display', 'none');
                    } else {
                        customSweetAlert(
                            'error',
                            response.message,
                            response.errors_object
                        );

                    }
                },
                error: function(response) {
                    errorCustomSweet();
                }
            });
        }
    });
});
$(document).ready(function() {
    // Initialize Select2 on all select elements
    $('select').select2({
        // Add any configuration options here if needed
        placeholder: "Select an option",
        allowClear: true
    });
});
