<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>{{ getSeting('title_ar') . '-' . __('admin_panel') }} @yield('title') </title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{ asset('assets/panel/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset('assets/panel/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/panel/plugins/custom/prismjs/prismjs.bundle.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/panel/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    @if (app()->getlocale() == 'en')
    <link rel="stylesheet" href="{{asset('assets/panel/css/main-en.css')}}">
        <style>
            .dt-buttons.btn-group.flex-wrap{
                float: right;
            }
        </style>
    @else
        <style>
            .dt-buttons.btn-group.flex-wrap{
                float: left;
            }
        </style>
    @endif
    @stack('panel_css')
    <link href="{{ asset('assets/panel/css/custome.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ imageUrl(getSeting('logo')) }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
   .badge-custom {
    border-radius: 0; 
    padding: 0.5em 1em; 
    display: inline-block; 
    color:white;
    border-radius: 20%;
}

</style>
</head>
<!--end::Head-->
