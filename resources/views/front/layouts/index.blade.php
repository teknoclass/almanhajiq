<!DOCTYPE html>
<html dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    @include('front.layouts.css')
</head>

<body>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="mobile-menu-overlay"></div>
        <div class="loader-page"><span></span><span></span></div>

        @include('front.layouts.header')
        @include('front.layouts.social-media')
        <main id="main-content">
            @yield('content')
        </main>

        @include('front.layouts.footer')
    </div>
    <!-- end:: Page -->

    @include('front.layouts.scripts')

    <div id="load" style="display: none;"><img id="loading-image"
            src="{{ asset('assets/front/images/ajax-loader.gif') }}" loading="lazy"/><br></div>

</body>

</html>
