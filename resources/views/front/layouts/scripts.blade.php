
<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/front/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/front/js/swiper.min.js') }}"></script>
<script src="{{ asset('assets/front/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/front/js/function.js') }}"></script>
<script src="{{ asset('assets/front/js/select2.min.js') }}"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
    integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
</script>

<script src="{{ asset('assets/front/js/jqueryValidate.min.js') }}"></script>
<script src="{{ asset('assets/front/js/sweetalert2.min.js') }}"></script>
@if (app()->isLocale('ar'))
    <script src="{{ asset('assets/front/js/custom.sweet.js') }}"></script>
@else
    <script src="{{ asset('assets/front/js/custom_en.sweet.js') }}"></script>
@endif
<script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>

<!-- New JS -->
{{-- <script src="{{ asset('assets/front/js/plugins.min.js') }}"></script> --}}
<script src="{{ asset('assets/front/js/main.js') }}"></script>

@stack('front_js_befor')

@if (\Session::has('error'))
    <script>
        customSweetAlert(
            'error',
            "{{ __('error') }}",
            "{!! \Session::get('error') !!}",
            function(event) {}
        );
    </script>
@endif

@if (\Session::has('info'))
    <script>
        customSweetAlert(
            'info',
            "{{ __('front.alert_info') }}",
            "{!! \Session::get('info') !!}",
            function(event) {}
        );
    </script>
@endif

<script>
    $(window).on('popstate', function() {
        location.reload(true);
    });

    $(document).on('click', '.show-alert', function() {
        var msg = $(this).data('msg');
        var alert_type = $(this).data('alert_type');

        customSweetAlert(
            alert_type,
            "",
            msg,
            function(event) {}
        );


    });
</script>

<script>
    jQuery.extend(jQuery.validator.messages, {
        required: "{{ __('validator.required') }}",
        remote: "{{ __('validator.remote') }}",
        email: "{{ __('validator.email') }}",
        url: "{{ __('validator.url') }}",
        date: "{{ __('validator.date') }}",
        dateISO: "{{ __('validator.dateISO') }}",
        number: "{{ __('validator.number') }}",
        digits: "{{ __('validator.digits') }}.",
        creditcard: "{{ __('validator.creditcard') }}",
        equalTo: "{{ __('validator.equalTo') }}",
        accept: "{{ __('validator.accept') }}",
        maxlength: jQuery.validator.format("{{ __('validator.maxlength') }} {0} "),
        minlength: jQuery.validator.format("{{ __('validator.minlength') }} {0} "),
        rangelength: jQuery.validator.format(
            "{{ __('validator.rangelength') }} {0} {{ __('and') }} {1}."),
        range: jQuery.validator.format("{{ __('validator.range') }} {0} {{ __('and') }} {1}."),
        max: jQuery.validator.format("{{ __('validator.max') }} {0}."),
        min: jQuery.validator.format("{{ __('validator.min') }} {0}.")
    });

    window.are_your_sure = "{{ __('are_your_sure') }}";
    window.confirm_text = "{{ __('confirm') }}";
    window.cancel_text = "{{ __('cancel') }}";
    window.initialCountry = "{{ defaultCountrySlug() }}";
</script>



{{-- Firebase --}}
<script src="https://www.gstatic.com/firebasejs/10.3.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging-compat.js" type="text/javascript"></script>
<script src="https://www.gstatic.com/firebasejs/10.3.1/firebase-firestore-compat.js" type="text/javascript"></script>
<script src="https://www.gstatic.com/firebasejs/10.3.1/firebase-functions-compat.js" type="text/javascript"></script>


<script>
    const firebaseConfig = {
        apiKey: "AIzaSyCV40NBKT5wBipNfY3Lmmd7KyPdOcD7vfA",
        authDomain: "laravel-chat-7638b.firebaseapp.com",
        databaseURL: "https://laravel-chat-7638b-default-rtdb.firebaseio.com",
        projectId: "laravel-chat-7638b",
        storageBucket: "laravel-chat-7638b.appspot.com",
        messagingSenderId: "355479155427",
        appId: "1:355479155427:web:75bf251a49566a0bcc8bd6"
    };

    // Initialize Firebase
    const app = firebase.initializeApp(firebaseConfig);

    function read_notification(notification_id){
        $.ajax({
            url: "{{ route('user.notifications.read',0) }}"+notification_id,
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

@stack('front_js')
