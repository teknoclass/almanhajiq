var form = $('#form'); // login , ...
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
form.validate({
    rules: {
        name: {
            required: true,
            maxlength: 255
        },
        email: {
            required: true,
            maxlength: 255,
            email: true
        },
        password: {
            minlength: 6
        },
        password_confirmation: {
            minlength: 6,
            equalTo: "#password"
        },
        mobile: {
            required: true,
            digits: true,
            maxlength: 20
        },
        subject: {
            required: true,
            maxlength: 255
        },
        text: {
            required: true
        }
    },
    messages: {
        name: {
            required: 'الرجاء إدخال الاسم',
            maxlength: 'يجب ألا يتجاوز الاسم 255 حروف'
        },
        email: {
            required: 'الرجاء إدخال البريد الإلكتروني',
            email: 'الرجاء إدخال عنوان بريد إلكتروني صالح',
            maxlength: 'يجب ألا يتجاوز البريد الإلكتروني 255 حروف'
        },
        mobile: {
            required: 'الرجاء إدخال رقم الجوال',
            digits: 'الرجاء إدخال أرقام فقط',
            maxlength: 'يجب ألا يتجاوز رقم الجوال 20 رقماً'
        },
        subject: {
            required: 'الرجاء إدخال الموضوع',
            maxlength: 'يجب ألا يتجاوز الموضوع 255 حروف'
        },
        text: {
            required: 'الرجاء إدخال الرسالة'
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
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });


        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(form[0]);
            var url = form.attr('action');
            var redirectUrl = form.attr('to');
            var _method = form.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();

                    if (response.status) {
                        $('#form')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,

                            function(event) {
                                if (redirectUrl == 'back3' && history.length) {
                                    $('#load').show();
                                    if (getCookie('back_url')) {
                                        window.location = getCookie('back_url');
                                    } else {
                                        window.location = "user/home";
                                    }
                                } else if (redirectUrl == 'back2') {
                                    $('#load').show();
                                    if (getCookie('back_url')) {
                                        window.location = getCookie('back_url');
                                    } else {
                                        window.location = "user/home";
                                    }
                                } else if (redirectUrl == 'back') {
                                    $('#load').show();
                                    if (getCookie('back_url')) {
                                        window.location = getCookie('back_url');
                                    } else {
                                        window.location = "user/home";
                                    }
                                } else if (response.redirect_url) {
                                    $('#load').show();
                                    window.location = response.redirect_url;
                                } else {
                                    $('#load').show();
                                    window.location = redirectUrl;;
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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




$(".confirm-post").each(function(index) {
    $(this).on("click", function() {
        var url = $(this).data('url');
        var id = $(this).data('id');
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
                            $("#row_" + id).remove();
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
});


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

$(document).on('click', '.confirm-free-registeration', function(event) {
    var url = $(this).data('url');
    var id = $(this).data('id');
    var marketer_coupon = $(this).data('marketer_coupon');
    var redirectUrl = $(this).data('to');
    var submit_free_reg_btn = $('#submit_free_reg_btn');
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
            // $(submit_free_reg_btn).attr("disabled", true);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'post',
                type: 'json',
                data: { id, marketer_coupon },
                success: function(response) {
                    $(submit_free_reg_btn).attr("disabled", false);
                    if (response.status) {
                        if(!response.payment)
                        {
                            toastr.success(response.message);
                        }
                        if (response.redirect_url) {
                            $('#load').show();
                            window.location = response.redirect_url;
                        } else if (redirectUrl != '#' && redirectUrl != 'close_model') {
                            $('#load').show();
                            window.location = redirectUrl;
                        }
                    } else {
                        $(submit_free_reg_btn).attr("disabled", false);
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

var courseForm = $('#courseForm');
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

courseForm.validate({
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
            $(save_btn).find('.load').show();
            var formData = new FormData(courseForm[0]);
            var url = courseForm.attr('action');
            var redirectUrl = courseForm.attr('to');
            var repeater = $('#m_repeater_1');
            var _method = courseForm.attr('method');
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
                    $(save_btn).find('.load').hide();
                    if (response.status) {
                        if (window.location.href.indexOf("create") > -1) {
                            $('#courseForm')[0].reset();
                        }
                        $('#needToolbarConfirm').val('false');


                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            // function (event) {
                            //     window.location = redirectUrl;
                            // }
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
                    $(save_btn).find('.load').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

$(".confirm-course-toolbar-navigation").each(function(index) {
    $(this).on("click", function(e) {
        href = $(this).attr('href');
        e.preventDefault();
        submitted = $('#needToolbarConfirm').val() || 'true';
        // console.log(submitted);

        if (submitted == 'true') {
            swal({
                title: "<span class='info'>لم تقم بادخال أي محتوى! " + window.are_your_sure + "</span>",
                type: 'question',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: window.confirm_text + "",
                cancelButtonText: window.cancel_text + "",
                confirmButtonColor: '#56ace0',
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    window.location.href = href;
                }
            });
        } else {
            // console.log('here');
            window.location.href = href;
        }
    });
});

// form 2

var form_2 = $('#form_2');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
form_2.validate({
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
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(form_2[0]);
            var url = form_2.attr('action');
            var redirectUrl = form_2.attr('to');
            var close_model = form_2.data('close_model');
            var _method = form_2.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#form_2')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (typeof response.redirect_url !== 'undefined') {
                                    if (response.redirect_url != '' &&
                                        response.redirect_url != 'undefined') {
                                        window.location = response.redirect_url;
                                    }
                                }

                                if (redirectUrl != '#' && redirectUrl != 'close_model') {
                                    $('#load').show();
                                    window.location = redirectUrl;
                                }

                                if (redirectUrl == 'close_model') {
                                    $(close_model).modal('hide');
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
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

/* start  store category pricing form code */

$('.form_category').each(function(e) {
    $(this).on('submit', function(e) {
        e.preventDefault(); // Prevent form submission
        var formId = $(this).attr('type');
        var form = $("#form_category_" + formId);
        var formData = new FormData(form[0]);
        var url = form.attr('action');
        var redirectUrl = form.attr('to');
        var close_model = form.data('close_model');
        var _method = form.attr('method');
        // $('#load').show();
        $.ajax({
            url: url,
            method: _method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#load').hide();
                //  $(save_btn).attr("disabled", false);
                //  $(save_btn).find('.spinner-border').hide();
                if (response.status) {

                    customSweetAlert(
                        'success',
                        response.message,
                        response.item,
                        function(event) {
                            if (typeof response.redirect_url !== 'undefined') {
                                if (response.redirect_url != '' &&
                                    response.redirect_url != 'undefined') {
                                    window.location = response.redirect_url;
                                }
                            }

                            if (redirectUrl != '#' && redirectUrl != 'close_model') {
                                $('#load').show();
                                window.location = redirectUrl;
                            }

                            if (redirectUrl == 'close_model') {
                                $(close_model).modal('hide');
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
                //     $(save_btn).attr("disabled", false);
                //      $(save_btn).find('.spinner-border').hide();
                setCookie('back_url', window.location.href, 1);
                getErrors(jqXhr, '/login');
            }
        });
    });
});

/* end store category pricing form code */

$(document).on('click', '.reset-form-and-show-modal', function(event) {
    var form_name = $(this).data('form');
    var modal_name = $(this).data('modal');
    $('#' + form_name)[0].reset();
    $('#' + modal_name).modal('show');
});


function getErrors(jqXhr, path) {
    // $('#load').hide();
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


var chatForm = $('#chatForm');
var chat_save_btn = $('#chat_save_btn');
chatForm.validate({
    rules: {
        body: {
            required: true,
            maxlength: 255,
            minlength: 1,
        }
    },
    messages: {
        body: {
            required: 'الرجاء إدخال الرسالة',
            maxlength: 'يجب ألا يتجاوز الاسم 255 حروف',
            minlength: 'يجب ألا يقل الاسم عن حرف واحد'
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

        $(chat_save_btn).attr("disabled", true);
        var formData = new FormData(chatForm[0]);
        var url = chatForm.attr('action');
        var _method = chatForm.attr('method');
        // $('#load').show();

        $.ajax({

            url: url,
            method: _method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $(chat_save_btn).attr("disabled", false);
                if (response.status) {
                    $('#chatForm')[0].reset();
                    messageBody = `

                    <div class="message-item sender">
                        <div class="message-image symbol symbol-40"><img class="rounded-circle" src="${response.messageData.sender_image}" alt=""></div>
                        <div class="message-content">${response.messageData.message}</div>
                    </div>
                    `;

                    $('.message-list').append(messageBody);
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
                $(chat_save_btn).attr("disabled", false);
                setCookie('back_url', window.location.href, 1);
                getErrors(jqXhr, '/login');
            }
        });
    }
});

$('.submitForm').click(function(e) {
    e.preventDefault();

    var form = $(this).closest('form')[0];
    var formData = new FormData(form);
    var url = $(form).attr('action');
    var redirectUrl = $(form).attr('to');
    var _method = $(form).attr('method');
    // $('#load').show();
    $.ajax({
        url: url,
        method: _method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#load').hide();
            if (response.status) {
                form.reset();
                customSweetAlert(
                    'success',
                    response.message,
                    response.item,
                    function(event) {
                        if (redirectUrl != '#') {
                            $('#load').show();
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
            console.log('jqXhr');
            setCookie('back_url', window.location.href, 1);
            getErrors(jqXhr, '/login');
        }
    });
});


/* join as teacher request form */

var form5 = $('#form_5');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
form5.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(form5[0]);
            var url = form5.attr('action');
            var redirectUrl = form5.attr('to');
            var _method = form5.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#form_5')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
                                    location.reload();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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


var course_from2 = $('#course_from2');
var save_btn = $('#btn_submit');
window.is_a2_images_uploaded = true;
course_from2.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_from2[0]);
            var url = course_from2.attr('action');
            var redirectUrl = course_from2.attr('to');
            var _method = course_from2.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_from2')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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




var course_from11 = $('#course_from11');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_from11.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_from11[0]);
            var url = course_from11.attr('action');
            var redirectUrl = course_from11.attr('to');
            var _method = course_from11.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_from11')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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


var course_from = $('#course_from');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_from.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_from[0]);
            var url = course_from.attr('action');
            var redirectUrl = course_from.attr('to');
            var _method = course_from.attr('method');

            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_from')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

var course_live_lesson_form = $('#course_live_lesson_form');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_live_lesson_form.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_live_lesson_form[0]);
            var url = course_live_lesson_form.attr('action');
            var redirectUrl = course_live_lesson_form.attr('to');
            var _method = course_live_lesson_form.attr('method');

            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_live_lesson_form')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

var task_correct_form = $('#task_correct_form');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
task_correct_form.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(task_correct_form[0]);
            var url = task_correct_form.attr('action');
            var redirectUrl = task_correct_form.attr('to');
            var _method = task_correct_form.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#task_correct_form')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

var course_exam_form = $('#course_exam_form');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_exam_form.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_exam_form[0]);
            var url = course_exam_form.attr('action');
            var redirectUrl = course_exam_form.attr('to');
            var _method = course_exam_form.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_exam_form')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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



var course_task_form = $('#course_task_form');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_task_form.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_task_form[0]);
            var url = course_task_form.attr('action');
            var redirectUrl = course_task_form.attr('to');
            var _method = course_task_form.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_task_form')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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

var course_task_form2 = $('#course_task_form2');
var save_btn = $('#btn_submit');
window.is_all_images_uploaded = true;
course_task_form2.validate({

    highlight: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        jQuery(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    submitHandler: function(f, e) {
        e.preventDefault();
        $('.summernote').each(function() {
            $(this).summernote("code", $(this).summernote('code').replace(/(<div)/igm, '<p').replace(/<\/div>/igm, '</p>').replace(/<p><\/p>/igm, ''));
        });

        if (window.is_all_images_uploaded) {
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            var formData = new FormData(course_task_form2[0]);
            var url = course_task_form2.attr('action');
            var redirectUrl = course_task_form2.attr('to');
            var _method = course_task_form2.attr('method');
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#course_task_form2')[0].reset();
                        customSweetAlert(
                            'success',
                            response.message,
                            response.item,
                            function(event) {
                                if (redirectUrl != '#') {
                                    $('#load').show();
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
                    console.log('jqXhr');
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    setCookie('back_url', window.location.href, 1);
                    getErrors(jqXhr, '/login');
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




/* end join as teacher request form*/



function readImageURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(input).closest('.image-input').find('.image-input-wrapper').css('background-image', `url('${e.target.result}')`);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$(".preview-input-image-1").on('change', function() {
    readImageURL(this);
});

$(".preview-input-image-2").on('change', function() {
    readImageURL(this);
});

$(".preview-input-image-3").on('change', function() {
    readImageURL(this);
});

$(".preview-input-image-4").on('change', function() {
    readImageURL(this);
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}