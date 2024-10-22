<!DOCTYPE html>

<html lang="{{ app()->isLocale('ar') ? 'ar' : 'en' }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

@include('panel.layouts.css')


<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading">

    @include('panel.layouts.header')


    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            @include('panel.layouts.menu')
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <!--end::Header-->
                <!--begin::Content-->
                @yield('contion')
                <!--end::Content-->
            </div>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Main-->
    @include('panel.layouts.footer')
    <!--end::Footer-->





    <div id="load" style="display: none;">
        <img id="loading-image" src="{{ asset('assets/panel/media/ajax-loader.gif') }}" />
    </div>

    <!--begin::Page loading(append to body)-->
    <div class="page-loader flex-column bg-dark bg-opacity-25">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">{{ __('wait') }}....</span>
    </div>
    <!--end::Page loading-->

    @include('panel.layouts.scripts')


</body>


</html>
