<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>
    {{ isset($sub_title) ? $sub_title . ' | ' . @$settings->valueOf('title_' . app()->getLocale()) : @$settings->valueOf('title_' . app()->getLocale()) . '' }}
</title>
<meta property="og:title"
    content="{{ isset($sub_meta_title) ? $sub_meta_title : @$settings->valueOf('title_' . app()->getLocale()) }}" />
<meta property="og:description"
    content="{{ isset($sub_desc) ? $sub_desc : @$settings->valueOf('description_' . app()->getLocale()) }}" />
<meta property="og:image" content="{{ asset('assets/favicon.ico') }}" />
<meta name="twitter:image:src" content="{{ asset('assets/favicon.ico') }}" />
<meta name="twitter:description"
    content="{{ isset($sub_desc) ? $sub_desc : @$settings->valueOf('description_' . app()->getLocale()) }}" />
<meta name="twitter:title"
    content="{{ isset($sub_meta_title) ? $sub_meta_title : @$settings->valueOf('title_' . app()->getLocale()) }}" />
<meta name="description"
    content="{{ isset($sub_desc) ? $sub_desc : @$settings->valueOf('description_' . app()->getLocale()) }}" />
<meta name="keywords"
    content="{{ isset($sub_key_words) ? $sub_key_words : @$settings->valueOf('tags_' . app()->getLocale()) }}" />
{{--<link rel="icon" type="image/png" href="{{ asset('assets/favicon.ico') }}">--}}
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{ imageUrl(getSeting('logo')) }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@stack('front_before_css')

<link rel="stylesheet" href="{{ asset('assets/front/css/animate.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/fontawesome.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/jquery.fancybox.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-select.min.css') }}" />

@if (app()->getlocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.rtl.min.css') }}" />
@else
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" />
@endif


<link rel="stylesheet" href="{{ asset('assets/front/css/swiper.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/custome.css') }}?v={{ getVersionAssets() }}" />
<link rel="stylesheet" href="{{ asset('assets/front/css/new-style.css') }}">
<link href="{{ asset('assets/front/css/select2.min.css') }}" rel="stylesheet" />

@if (app()->getlocale() == 'en')
    <link rel="stylesheet" href="{{ asset('assets/front/css/main-en.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/new-style-en.css') }}">
@endif

{{--<link rel="stylesheet" href="{{ asset('assets/front/css/special-style.css') }}">--}}
{{--font-awesome--}}

{{--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">--}}

<style>
    /*Whatsapp floating button styles*/
    .float {
        position: fixed;
        width: 60px;
        height: 60px;
        bottom: 40px;
        background-color: #25d366;
        color: #FFF;
        border-radius: 50px;
        text-align: center;
        font-size: 30px;
        box-shadow: 2px 2px 3px #999;
        z-index: 100;
    }

    .my-float {
        margin-top: 16px;
    }
    .PaymentLogoGrid {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin: -12px;
        padding: 8px 0 0 var(--columnPaddingNormal);
    }
    .PaymentLogoGrid .PaymentLogo {
        margin: 5px;
        display: block;
    }
    .PaymentLogoGrid .PaymentLogo.fill-white path{
       fill: white;
    }
</style>
@if (app()->getlocale() == 'en')
    <style>
        .float {
            right: 40px;
        }
    </style>
@else
    <style>
        .float {
            left: 40px;
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endif

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="google-site-verification" content="googleeabb045be025670b.html" />


@stack('front_css')
