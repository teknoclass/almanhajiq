<!DOCTYPE html>
<html dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
@include('front.layouts.css')

<body>
    <!-- begin:: Page -->
    <div class="main-wrapper">
        <div class="mobile-menu-overlay"></div>
        <div class="loader-page"><span></span><span></span></div>

        @include('front.layouts.header')
        @include('front.blog.layout.header')

        @yield('content')

        @include('front.layouts.footer')
    </div>
    <!-- end:: Page -->

    @include('front.layouts.scripts')

    <div id="load" style="display: none;"><img id="loading-image"
            src="{{ asset('assets/front/images/ajax-loader.gif') }}" loading="lazy"/><br></div>

</body>

</html>
