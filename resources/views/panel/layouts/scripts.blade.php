
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('assets/panel/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/scripts.bundle.js')}}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('assets/panel/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('assets/panel/js/pages/widgets.js')}}"></script>
<!--end::Page Scripts-->

<script src="{{asset('assets/panel/js/sweetalert2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/panel/js/custom.sweet.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/panel/js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/panel/js/toastr.min.js')}}"></script>


<script>

    window.base_url = "{{env('APP_URL')}}";
    window.base_image_url = window.base_url + '/image'
    function showLoader() {
        const button = document.querySelector("#kt_page_loading_overlay");

        // Handle toggle click event
        button.addEventListener("click", function() {
            // Populate the page loading element dynamically.
            // Optionally you can skipt this part and place the HTML
            // code in the body element by refer to the above HTML code tab.
            const loadingEl = document.createElement("div");
            document.body.prepend(loadingEl);
            loadingEl.classList.add("page-loader");
            loadingEl.classList.add("flex-column");
            loadingEl.classList.add("bg-dark");
            loadingEl.classList.add("bg-opacity-25");
            loadingEl.innerHTML = `
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5"{{__('wait')}}...</span>
    `;

            // Show page loading
            KTApp.showPageLoading();

            // Hide after 3 seconds
            setTimeout(function() {
                KTApp.hidePageLoading();
                loadingEl.remove();
            }, 3000);
        });
    }


    function hideLoader() {
        var loading = new KTDialog({
            'type': 'loader',
            'placement': 'top center',
            'message': '{{__('wait')}}...'
        });
        loading.hide();
    }

    $.ajaxSetup({

        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }

    });
</script>

<script>
    $(document).on('click', '.show-submenu', function(event) {
        $(this).toggleClass('menu-item-open-dropdown menu-item-hover');
    });

    $(document).on('click', '.delete-item', function(event) {
        var delete_url = $(this).data('url');
        var delete_section=$(this).data('section');

        event.preventDefault();
        swal({
            title: '<span class="info">{{__('delete_alert')}}</span>',
            type: 'question',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: '{{__('delete')}}',
            cancelButtonText: '{{__('close')}}',
            confirmButtonColor: '#56ace0',
            allowOutsideClick: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: delete_url,
                    method: 'delete',
                    type: 'json',
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            $(delete_section).remove();
                            datatable.reload();
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

    $(document).on('click', '.delete2', function(event) {
        var delete_url = $(this).data('url');
        var that = this;

        event.preventDefault();
        swal({
            title: '<span class="info">{{__('delete_alert')}}</span>',
            type: 'question',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: '{{__('delete')}}',
            cancelButtonText: '{{__('close')}}',
            confirmButtonColor: '#56ace0',
            allowOutsideClick: false
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: delete_url,
                    method: 'delete',
                    type: 'json',
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            //$(that).closest('tr').remove();
                            datatable.ajax.reload();
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
</script>


<script>
    jQuery.extend(jQuery.validator.messages, {
      required: "{{__('validator.required')}}",
      remote: "{{__('validator.remote')}}",
      email: "{{__('validator.email')}}",
      url: "{{__('validator.url')}}",
      date: "{{__('validator.date')}}",
      dateISO: "{{__('validator.dateISO')}}",
      number: "{{__('validator.number')}}",
      digits: "{{__('validator.digits')}}.",
      creditcard: "{{__('validator.creditcard')}}",
      equalTo: "{{__('validator.equalTo')}}",
      accept: "{{__('validator.accept')}}",
      maxlength: jQuery.validator.format("{{__('validator.maxlength')}} {0} "),
      minlength: jQuery.validator.format("{{__('validator.minlength')}} {0} "),
      rangelength: jQuery.validator.format("{{__('validator.rangelength')}} {0} {{__('and')}} {1}."),
      range: jQuery.validator.format("{{__('validator.range')}} {0} {{__('and')}} {1}."),
      max: jQuery.validator.format("{{__('validator.max')}} {0}."),
      min: jQuery.validator.format("{{__('validator.min')}} {0}.")
    });

      window.are_your_sure="{{__('are_your_sure')}}";
      window.confirm_text="{{__('confirm')}}";
      window.cancel_text="{{__('cancel')}}";
      window.initialCountry="{{ defaultCountrySlug()}}";
  </script>

@if (\Session::has('error'))
    <script>
    customSweetAlert(
        'error',
        "{{__('message.the_operation_could_not_be_completed')}}",
        "{!! \Session::get('error') !!}",
        function(event) {}
    );
    </script>
@endif

@if (\Session::has('success'))
    <script>
    customSweetAlert(
        'success',
        "{{__('message.operation_accomplished_successfully')}}",
        "{!! \Session::get('sucess') !!}",
        function(event) {}
    );
    </script>
@endif

<script>
    var currentPath = window.location.pathname;
    var segments = currentPath.split('/'); // Split the path by slashes
  //  var wordBeforeLastSlash = segments[segments.length - 2];
    var wordBeforeLastSlash = segments[2];
    var lastWord = segments[segments.length - 1];
   // alert(lastWord);
    if(wordBeforeLastSlash != 'admin') {
        $('.' + wordBeforeLastSlash).parent().addClass("show");
        // $('.' + wordBeforeLastSlash + ' .menu-link').addClass("active");
        var targetScrollPosition = $('#kt_aside').find('.' + wordBeforeLastSlash).parent().offset().top-148;
        $('#kt_aside').animate({
            scrollTop: targetScrollPosition
        }, 1000);
     }

      if(wordBeforeLastSlash === 'admin') {
           var targetScrollPosition = $('#kt_aside').find('.' + lastWord).parent().offset().top-148;
          // Animate scrolling to the target position within #kt_aside
           $('#kt_aside').animate({
               scrollTop: targetScrollPosition
           }, 1000);
       }

       function read_notification(notification_id){
           $.ajax({
               url: "{{ route('panel.notifications.read',0) }}"+notification_id,
               method: 'get',
               type: 'json',
               success: function(response) {
                   $(this).hide();
                   if(response.redirect_url && response.redirect_url != 'avascript:void(0)'){
                        window.location.href = response.redirect_url;
                    }
               },
               error: function(response) {
                   errorCustomSweet();
               }
           });
       }
</script>

@stack('panel_js')
