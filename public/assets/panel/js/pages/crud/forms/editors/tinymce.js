"use strict";
// Class definition

var KTTinymce = function () {
    // Private functions
    var demos = function () {

        tinymce.init({
            selector: '#kt-tinymce-1',
            toolbar: false,
            statusbar: false
        });

        tinymce.init({
            selector: '#kt-tinymce-2'
        });

        tinymce.init({
            selector: '#kt-tinymce-3',
            toolbar: 'advlist | autolink | link image | lists charmap | print preview',
            plugins: 'advlist autolink link image lists charmap print preview'
        });


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
            language: "ar",
            language_url: '/assets/panel/plugins/custom/tinymce/langs/ar.js',
            // path from the root of your web application — / — to the language pack(s)
            directionality: 'rtl',
            // menubar: false,
            toolbar: ['styleselect fontselect fontsizeselect ',
                'undo redo | cut copy paste | bold italic | table link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  fullscreen'],
            plugins: 'advlist autolink link image lists table charmap print preview  fullscreen',
            content_style:
                "body { color: #000; font-size: 18pt; font-family: Arial;text-align: justify }",
            forced_root_block_attrs: { style: 'text-align: justify;' }

        });



    }

    return {
        // public functions
        init: function () {
            demos();
        }
    };
}();

// Initialization
jQuery(document).ready(function () {
    KTTinymce.init();
});