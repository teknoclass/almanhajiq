<!--begin::Header-->
<div id="kt_header" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                <span class="svg-icon svg-icon-2x mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                            <path
                                d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('panel.home') }}" class="d-lg-none">
                <img alt="Logo" src="{{ imageUrl(getSeting('logo')) }}" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav2">
                <!--begin::Menu wrapper-->
                <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                    data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                    <!--begin::Menu-->
                    <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch"
                        id="#kt_header_menu" data-kt-menu="true">
                        <div class="menu-item me-lg-1">
                            <a class="menu-link active py-3" href="{{ route('panel.home') }}">
                                <img src="{{ imageUrl(getSeting('white_logo')) }}" style="width: 64px;" alt="">
                            </a>
                        </div>
                        <div class="menu-item me-lg-1">
                            <a class="menu-link py-3" href="{{ route('panel.home') }}">
                                <span class="menu-title font-size-h1-lg">{{ __('admin_panel') }}</span>
                            </a>
                        </div>

                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Navbar-->


            <div class="d-flex align-items-stretch flex-shrink-0">
                <div class="d-flex align-items-stretch flex-shrink-0">
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">



                        </div>
                    </div>
                </div>
            </div>







            <!--begin::Topbar-->
            <div class="d-flex align-items-stretch flex-shrink-0">
                <!--begin::Toolbar wrapper-->
                <div class="d-flex align-items-stretch flex-shrink-0">

                    <div class="d-flex align-items-center ms-1 ms-lg-3">

                        <!-- Start Language Switcher-->
                        <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px">
                            @foreach (locales() as $key => $language)
                                    @if(LaravelLocalization::getCurrentLocale() != $key)
                                        <a class="btn btn-color-gray-600 btn-active-color-primary font-18" href="{{ LaravelLocalization::getLocalizedURL($key, null, [], true) }}">{{ucfirst($key)}}</a>
                                    @endif
                                @endforeach
                        </div>
                        <!-- End Language Switcher-->


                        <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">

                            <!--begin::Svg Icon | path: icons/duotone/Code/Compiling.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="28"
                                    viewBox="0 0 24 28">
                                    <path id="Icon_ionic-md-notifications" data-name="Icon ionic-md-notifications"
                                        d="M17.625,31.375a2.82,2.82,0,0,0,2.823-2.8H14.8A2.82,2.82,0,0,0,17.625,31.375Zm9.177-8.4v-7.7a9.1,9.1,0,0,0-7.059-8.82v-.98a2.118,2.118,0,0,0-4.235,0v.98a9.1,9.1,0,0,0-7.059,8.82v7.7l-2.823,2.8v1.4h24v-1.4Z"
                                        transform="translate(-5.625 -3.375)" fill="#fff" />
                                </svg>
                                @php
                                    $count_notifications_not_show = getCountNotificationsNotShow('admin');
                                @endphp
                                @if ($count_notifications_not_show > 0)
                                    <span class="badge">
                                        {{ $count_notifications_not_show }}
                                    </span>
                                @endif
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                            <!--begin::Heading-->
                            <div class="d-flex flex-column bgi-no-repeat rounded-top"
                                style="background-image:url('assets/media/misc/pattern-1.jpg')">
                                <!--begin::Title-->
                                <h3 class="text-whitex fw-bold px-9 mt-10 mb-6">Notifications
                                    <span class="fs-8 opacity-75 ps-3">24 reports</span>
                                </h3>
                                <!--end::Title-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Tab content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                                    <!--begin::Items-->
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <!--begin::Item-->
                                        {!! getLastNotifications('admin') !!}
                                        <!--end::Item-->

                                    </div>
                                    <!--end::Items-->
                                    <!--begin::View more-->
                                    <div class="py-3 text-center border-top">
                                        @can('show_notifications')
                                            <a href="{{ route('panel.notifications.all.index') }}"
                                                class="btn btn-color-gray-600 btn-active-color-primary">{{ __('view_all') }}
                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Right-2.svg-->
                                                <span class="svg-icon svg-icon-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.5"
                                                                transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)"
                                                                x="7.5" y="7.5" width="2" height="9"
                                                                rx="1" />
                                                            <path
                                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                fill="#000000" fill-rule="nonzero"
                                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon--></a>
                                        @endcan
                                    </div>
                                    <!--end::View more-->
                                </div>
                                <!--end::Tab panel-->
                            </div>
                            <!--end::Tab content-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Notifications-->
                    <!--begin::User-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="d-flex align-items-center profile bg-statistics-7 symbol symbol-30px symbol-md-40px"
                            data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                            <img src="{{ url('assets/panel/media/avatars/150-26.jpg') }}" class="rounded-circle"
                                alt="metronic" />
                            <h5 class="text-white mb-0 ms-3"> {{ auth('admin')->user()->name }}</h5>
                        </div>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-200px"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="{{ route('index') }}" target="_blank" class="menu-link gap-3 px-5 text-dark"> <i
                                        class="fas fa-globe"></i>{{ __('view_website') }}</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="{{ route('panel.profile.index') }}" class="menu-link gap-3 px-5 text-dark"> <i
                                        class="fas fa-cog"></i>{{ __('profile') }}</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="javascript:void(0)" class="menu-link gap-3 px-5 text-danger"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('user_menus.logout') }} </a></a>

                                <form id="logout-form" action="{{ route('panel.admin.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>


                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::User -->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
