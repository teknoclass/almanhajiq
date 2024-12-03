<!-- start:: footer -->
<footer class="main-footer" style="background-color:var(--primary-color) !important;color: white;">
    <div class="footer-top">
        <div class="container">
            <div class="row pt-8 mb-2 mb-lg-5">

                <div class="col-4 col-md-2 mb-4 mx-auto">
                    <div class="text-center mx-auto">

                        <img class="footer-logo" src="{{ asset('assets/logo.png') }}"
                            loading="lazy" />

                    </div>
                </div>
                <div class="col-12 col-md-10 mb-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center m-auto col-4 col-md-2">
                                <div class="mb-5">
                                    {{-- <img class="footer-logo" src="{{ imageUrl(@$settings->valueOf('white_logo')) }}"
                                        alt="{{ @$settings->valueOf('title_' . app()->getLocale()) }}" loading="lazy" /> --}}
                                    <img class="footer-logo"
                                        src="{{ asset('assets/logo.png') }}"
                                        alt="{{ @$settings->valueOf('title_' . app()->getLocale()) }}" loading="lazy" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <ul
                                class="link-footer d-flex align-items-center flex-wrap justify-content-center mb-3 gap-3 font-bold">
                                @if (@$settings->valueOf('forum_status'))
                                    <!--<li><a href="{{ route('forum.categorized') }}">{{ __('forum') }}</a></li>-->
                                @endif
                                </li>
                                {{-- <li><a href="{{ route('pages.single', ['sulg' => 'about']) }}">{{ __('how_we_work') }}</a></li> --}}
                                <li><a class="fs-4" href="{{ route('courses.index') }}">{{ __('courses') }}</a></li>
                                <li><a class="fs-4" href="{{ route('contact.index') }}">{{ __('contact_us') }}</a>
                                </li>
                                <li><a class="fs-4" href="{{ route('lecturers.index') }}">{{ __('teachers') }}</a>
                                </li>
                                @if (@$settings->valueOf('blog_status'))
                                    <li><a class="fs-4" href="{{ route('blog.index') }}">{{ __('blog') }}</a>
                                    </li>
                                @endif
                                <li><a class="fs-4" href="{{ route('faqs.index') }}">{{ __('faqs') }}</a></li>
                            </ul>
                        </div>
                        <div class="col-12">
                            {{-- Start Social Media Links --}}
                            <h6 class="text-center fs-6 mb-1">{{ __('follow_us_on') }}</h6>
                            <ul class="social-media justify-content-center">
                                @foreach ($social_media as $social)
                                    @if ($social->getLink() != '#')
                                        <li><a href="{{ $social->getLink() }}" target="_blank"><i
                                                    class="fa-brands {{ $social->icon }}"> </i></a></li>
                                    @endif
                                @endforeach
                            </ul>
                            {{-- End Social Media Links --}}
                        </div>
                        {{--
                        <div class="col-lg-4">
                            <address class="mb-2">
                                <span><i class="fa-solid fa-location-dot fa-lg"></i></span>
                                {{ __('address') }} : {{ @$settings->valueOf('address') }}
                            </address>
                            <p class="mb-2">
                                <span><i class="fa-regular fa-envelope fa-lg"></i></span>
                                {{ __('email') }} : {{ @$settings->valueOf('email') }}
                            </p>
                            <p class="mb-2">
                                <span><i class="fa-solid fa-phone fa-lg"></i></span>
                                {{ __('phone') }} : {{ @$settings->valueOf('mobile') }}
                            </p>
                            {{-- Remove Whatsapp Links --}}
                        {{-- <a class="btn btn-outline-white px-3 py-2"
                            href="https://api.whatsapp.com/send?phone={{ @$settings->valueOf('whatsapp') }}"
                            target="_blank"> <i
                            class="fa-brands fa-whatsapp me-2"></i>{{ __('contact_us_via_whatsApp') }}
                            </a> --}}
                        {{-- Remove Whatsapp Links
                            <div class="app-links">
                                <h6 class="font-bold mb-lg-4 mt-3 mt-lg-0 mb-2">{{ __('join_us_via_apps') }}</h6>
                                <div class="d-flex gap-4">
                                    <a href="">
                                        <img src="{{ asset('assets/front/images/app-store.png') }}" alt="" loading="lazy"/>
                                    </a>
                                    <a href="">
                                        <img src="{{ asset('assets/front/images/google-play.png') }}" alt="" loading="lazy"/>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-lg-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom  pt-5">
        <div class="container">
            <div class="row border-top pt-3 justify-content-center">
                <div class="col-md-6 col-12 mb-3 ">
                    <ul
                        class="link-footer d-flex align-items-center gap-4 justify-content-center justify-content-lg-start font-bold">
                        @foreach ($pages as $page)
                            <li><a class="" href="{{ route('pages.single', ['sulg' => $page->sulg]) }}">
                                    {{ $page->title }}
                                </a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <p class="text-md-end text-center">
                        {{ @$settings->valueOf('copyright_' . app()->getLocale()) }}
                    </p>
                </div>


            </div>
        </div>
    </div>
</footer>
<!-- end:: footer -->
