<!DOCTYPE html>
<html dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    @include('front.layouts.css')
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1293280041932806');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1293280041932806&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
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
