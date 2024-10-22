'use strict';

// Class definition
//var KTImageInputDemo = function () {
    // Private functions
 //   var initDemos = function () {
        // Example 1
      //  var avatar1 = new KTImageInput('kt_image_1');

        // Example 2
      //  var avatar2 = new KTImageInput('kt_image_2');

        // Example 3
       // var avatar3 = new KTImageInput('kt_image_3');

        // Example 4
      //  var avatar4 = new KTImageInput('kt_image_4');


        $('.fileupload').change(function () {
            $('.btn_submit').prop('disabled', true);
            if ($(this).val() !== '') {
                var formData = new FormData();
                var width = $('#widthImage').val();
                var height = $('#heightImage').val();
                var custome_path = $('#customePath').val();
                formData.append('width', width);
                formData.append('height', height);
                formData.append('custome_path', custome_path);
                formData.append('image', $(this)[0].files[0]);
                $.ajax({
                    url: '/image/upload',
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        if (res.status) {
                            if (res.file_name !== undefined && res.file_name !== '') {
                                $('#image').val(res.file_name);
                            }
                        } else {
                            swal(
                                'Unknown Error Occurred',
                                res.message,
                                'error'
                            )
                            console.log(res.message);
                        }
                        $('.btn_submit').prop('disabled', false);
                    },

                    error: function (data) {
                        swal(
                            'Unknown Error Occurred',
                            '',
                            'error'
                        )
                        console.log(data);
                        $('.btn_submit').prop('disabled', false);

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });



        $('.file_another_upload').change(function () {
            $('.btn_submit').prop('disabled', true);

            if ($(this).val() !== '') {
                var formData = new FormData();
                var width = $('#widthImage').val();
                var height = $('#heightImage').val();
                formData.append('width', width);
                formData.append('height', height);
                formData.append('image', $(this)[0].files[0]);
                $.ajax({
                    url: '/image/upload',
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        if (res.status) {
                            if (res.file_name !== undefined && res.file_name !== '') {
                                $('#image_2').val(res.file_name);
                            }
                        } else {
                            swal(
                                'Unknown Error Occurred',
                                res.message,
                                'error'
                            )
                        }
                        $('.btn_submit').prop('disabled', false);
                    },

                    error: function () {
                        swal(
                            'Unknown Error Occurred',
                            '',
                            'error'
                        )
                        $('.btn_submit').prop('disabled', false);

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $('.file_another_upload_2').change(function () {
            $('.btn_submit').prop('disabled', true);

            if ($(this).val() !== '') {
                var formData = new FormData();
                var width = $('#widthImage').val();
                var height = $('#heightImage').val();
                formData.append('width', width);
                formData.append('height', height);
                formData.append('image', $(this)[0].files[0]);
                $.ajax({
                    url: '/image/upload',
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        if (res.status) {
                            if (res.file_name !== undefined && res.file_name !== '') {
                                $('#image_3').val(res.file_name);
                            }
                        } else {
                            swal(
                                'Unknown Error Occurred',
                                res.message,
                                'error'
                            )
                        }
                        $('.btn_submit').prop('disabled', false);
                    },

                    error: function () {
                        swal(
                            'Unknown Error Occurred',
                            '',
                            'error'
                        )
                        $('.btn_submit').prop('disabled', false);

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        $('.file_another_upload_3').change(function () {
            $('.btn_submit').prop('disabled', true);

            if ($(this).val() !== '') {
                var formData = new FormData();
                var width = $('#widthImage').val();
                var height = $('#heightImage').val();
                formData.append('width', width);
                formData.append('height', height);
                formData.append('image', $(this)[0].files[0]);
                $.ajax({
                    url: '/image/upload',
                    type: 'POST',
                    data: formData,
                    success: function (res) {
                        if (res.status) {
                            if (res.file_name !== undefined && res.file_name !== '') {
                                $('#image_4').val(res.file_name);
                            }
                        } else {
                            swal(
                                'Unknown Error Occurred',
                                res.message,
                                'error'
                            )
                        }
                        $('.btn_submit').prop('disabled', false);
                    },

                    error: function () {
                        swal(
                            'Unknown Error Occurred',
                            '',
                            'error'
                        )
                        $('.btn_submit').prop('disabled', false);

                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });

        function handleImageUpload(inputSelector, targetInputSelector, widthInputSelector, heightInputSelector) {
            $(inputSelector).change(function () {
                $('.btn_submit').prop('disabled', true);

                if ($(this).val() !== '') {
                    var formData = new FormData();
                    var width = $(widthInputSelector).val();
                    var height = $(heightInputSelector).val();
                    formData.append('width', width);
                    formData.append('height', height);
                    formData.append('image', $(this)[0].files[0]);

                    $.ajax({
                        url: '/image/upload',
                        type: 'POST',
                        data: formData,
                        success: function (res) {
                            if (res.status) {
                                if (res.file_name !== undefined && res.file_name !== '') {
                                    $(targetInputSelector).val(res.file_name);
                                }
                            } else {
                                swal('Unknown Error Occurred', res.message, 'error');
                            }
                            $('.btn_submit').prop('disabled', false);
                        },
                        error: function () {
                            swal('Unknown Error Occurred', '', 'error');
                            $('.btn_submit').prop('disabled', false);
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });
        }

   // }

   /* return {
        // public functions
        init: function () {
            initDemos();
        }
    };
}();

//KTUtil.ready(function () {
   // KTImageInputDemo.init();
//);*/
