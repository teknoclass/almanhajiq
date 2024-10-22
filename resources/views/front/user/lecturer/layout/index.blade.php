<!DOCTYPE html>
<html dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
	@include('front.layouts.css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/lecturer_styles.css') }}"/>
</head>

<body>
	<div class="main-wrapper">
		<div class="mobile-menu-overlay"></div>
		<div class="loader-page"><span></span><span></span></div>

        <!-- start:: Header -->
	    @include('front.layouts.header')
        <!-- end:: Header -->

        <!-- start:: section -->
		<div class="panel d-lg-flex">

            <!-- start:: Sidebar -->
            @include('front.user.lecturer.layout.includes.sidebar')
            <!-- end:: Sidebar -->

            <!-- start:: Content -->
            <div class="col-lg-8 col-xl-8">
                <div class="content ps-lg-4 pe-lg-5">
	                 @yield('content')
                </div>
            </div>
            <!-- end:: Content -->
		</div>
        <!-- end:: section -->

		<!-- start:: footer -->
	    @include('front.layouts.footer')
        <!-- end:: footer -->
	</div>

    <div id="load" style="display: none;" ><img id="loading-image" src="{{ asset('assets/front/images/ajax-loader.gif') }}" loading="lazy"/><br></div>

	@include('front.layouts.scripts')

    <script>
        $('.menu-toggle').click(function (e) {
          e.preventDefault();
          $(this).closest('.main-menu__item').find('.menu-submenu').slideToggle(300)
        });
        $('.toggle-side-nav').click(function (e) {
          $('.main-aside').toggleClass('main-aside-active')
        });

      </script>
</body>

</html>
