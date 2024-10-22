<!-- start:: Header -->
<header class="main-header">
    <div class="container">
        <div class="d-flex align-items-center">
            <div class="logo me-lg-4"><a href="{{ route('index') }}"><img
                        src="{{ imageUrl(@$settings->valueOf('logo')) }}"
                        alt="{{ @$settings->valueOf('title_' . app()->getLocale()) }}" loading="lazy"/></a></div>
            <div class="menu--mobile mx-lg-auto">
                <div
                    class="menu-container d-flex align-items-center justify-content-between d-lg-none px-3 border-bottom py-2 mb-3">
                    <div class="logo"><a href="{{ route('index') }}"><img
                                src="{{ imageUrl(@$settings->valueOf('logo')) }}" alt="" loading="lazy"/></a></div>
                    <div class="btn-close-header-mobile justify-content-end"><i class="fa-regular fa-xmark"></i></div>
                </div>
                <div class="menu-container">
                    <ul class="main-menu">
                        @php
                            $menus = [
                                [
                                    'title' => __('home'),
                                    'is_active' => @$is_active == 'home' ? 'active' : '',
                                    'href' => route('index'),
                                ],
                                [
                                    'title' => __('lecturers'),
                                    'is_active' => @$is_active == 'lecturers' ? 'active' : '',
                                    'href' => route('lecturers.index'),
                                ],

                                [
                                    'title' => __('courses'),
                                    'is_active' => @$is_active == 'courses' ? 'active' : '',
                                    'href' => route('courses.index'),
                                ],

                                [
                                    'title' => __('packages'),
                                    'is_active' => @$is_active == 'packages' ? 'active' : '',
                                    'href' => route('packages.index'),
                                ],

                                [
                                    'title' => __('blog'),
                                    'is_active' => @$is_active == 'blog' ? 'active' : '',
                                    'href' => route('blog.index'),
                                ],
                                [
                                    'title' => __('about_us'),
                                    'is_active' => @$is_active == 'about_us' ? 'active' : '',
                                    'href' => route('pages.single', ['sulg' => 'about']),
                                ],
                            ];
                        @endphp
                        @foreach (@$menus as $menu)
                            <li class="menu_item"><a class="menu_link {{ @$menu['is_active'] }}"
                                    href="{{ @$menu['href'] }}">{!! @$menu['title'] !!}
                                    @php
                                        if (@$menu['submenu']) {
                                            echo "<i class='fa-regular fa-chevron-down ms-2 fa-xs'></i>";
                                        }
                                    @endphp</a>
                                @if (@$menu['submenu'])
                                    <ul class="submenu">
                                        @foreach ($menu['submenu'] as $option)
                                            <li><a href="{{ @$option['href'] }}">{{ @$option['title'] }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach

                        @foreach (locales() as $key => $language)
                            @if(LaravelLocalization::getCurrentLocale() != $key)
                                <li class="menu_item">
                                    <a class="menu_link" href="{{ LaravelLocalization::getLocalizedURL($key, null, [], true) }}">{{ucfirst($key)}}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="menu-container col-auto ms-auto">
                <ul class="main-menu d-flex align-items-center p-2 p-lg-0">
                    {{-- <li class="menu_item"><a class="menu_link mx-3 text-white toggle-search"><i
								class="fa-regular fa-magnifying-glass fa-lg"></i></a>
						<div class="dropdow-search">
							<form class="d-flex align-items-center" action="">
								<div class="input-icon right col">
									<input class="form-control h-auto border-0" type="text" placeholder="{{ __('search') }}" />
									<div class="icon"><i class="fa-regular fa-magnifying-glass"></i></div>
								</div><a class="font-size-12 col-auto me-2" href="">{{ __('advanced_search') }}</a>
							</form>
						</div>
					</li> --}}
                    @if (auth('web')->check())
                        {{-- <li class="menu_item">
                        <a class="menu_link mx-2 text-white" href="{{ route('user.cart.index') }}">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        </a>
                    </li> --}}
                        <li class="menu_item">
                            <a class="menu_link mx-3 text-white" href="{{ route('user.chat.index') }}">
                                {{-- <i class="fa-solid fa-comment-dots fa-lg"></i> --}}
                                <svg width="26" height="26" viewBox="0 0 29 26" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M1 25L2.94742 19.1577C-0.533966 14.0091 0.81125 7.36537 6.09325 3.61734C11.3752 -0.129194 18.9612 0.177899 23.8372 4.33639C28.7133 8.49637 29.3724 15.221 25.3787 20.067C21.385 24.9131 13.9713 26.3812 8.04067 23.502L1 25Z"
                                        stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>
                        <li class="menu_item">
                            <div class="dropdown-notification">
                                <a class="menu_link link-notification mx-3 text-white" href="#" data-bs-toggle="dropdown">
                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9 19.6667V21C9 22.0609 9.42143 23.0783 10.1716 23.8284C10.9217 24.5786 11.9391 25 13 25C14.0609 25 15.0783 24.5786 15.8284 23.8284C16.5786 23.0783 17 22.0609 17 21V19.6667M25 5.96933C24.1254 4.067 22.8554 2.37293 21.2747 1M1 5.96933C1.8738 4.06725 3.14287 2.3732 4.72267 1M10.3333 3.66667C10.3333 2.95942 10.6143 2.28115 11.1144 1.78105C11.6145 1.28095 12.2928 1 13 1C13.7072 1 14.3855 1.28095 14.8856 1.78105C15.3857 2.28115 15.6667 2.95942 15.6667 3.66667C17.1979 4.3907 18.5032 5.51777 19.4427 6.92707C20.3823 8.33636 20.9206 9.97476 21 11.6667V15.6667C21.1003 16.4956 21.3939 17.2894 21.8571 17.9842C22.3203 18.6789 22.9401 19.2552 23.6667 19.6667H2.33333C3.05992 19.2552 3.67975 18.6789 4.14292 17.9842C4.60609 17.2894 4.89966 16.4956 5 15.6667V11.6667C5.07941 9.97476 5.61773 8.33636 6.55727 6.92707C7.4968 5.51777 8.80212 4.3907 10.3333 3.66667Z"
                                            stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    @php
                                        $count_notifications_not_show = getCountNotificationsNotShow('user');
                                    @endphp
                                    @if ($count_notifications_not_show > 0)
                                        <span class="badge">
                                            {{ $count_notifications_not_show }}
                                        </span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-notification pb-0 dropdown-menu-end mt-3">
                                    {!! getLastNotifications('user') !!}

                                    <li><a class="text-center d-block notify-all"
                                            href="{{ route('user.notifications.index') }}">
                                            {{ __('all_notifications') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu_item dropdown-profile">
                            <div class="dropdown-link">
                                <a class="menu_link link-profile mx-0 text-white" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <span class="symbol symbol-30">
                                        <img class="rounded-circle" src="{{ imageurl(getUser()->image, '40x40') }}"
                                            alt="{{ getUser()->name }}" loading="lazy"/></span>
                                    <span class="font-medium mx-2 d-none d-lg-block">{{ getUser()->name }}</span>
                                    <i class="fa-regular fa-chevron-down ms-2 fa-xs"></i></a>
                                <ul class="dropdown-menu overflow-hidden">
                                    @php
                                        if (getUser()->role == 'lecturer') {
                                            $user_menus = [
                                                [
                                                    'title' => __('home'),
                                                    'href' => route('user.lecturer.home.index'),
                                                ],
                                                [
                                                    'title' => __('my_courses'),
                                                    'href' => route('user.lecturer.my_courses.index'),
                                                ],
                                                [
                                                    'title' => __('my_settings'),
                                                    'href' => route('user.lecturer.settings.index'),
                                                ],
                                                [
                                                    'title' => __('user_menus.logout'),
                                                    'href' => route('user.auth.logout'),
                                                ],
                                            ];
                                        } elseif (getUser()->role == 'marketer' && getUser()->hasCoupon()) {
                                            $user_menus = [
                                                [
                                                    'title' => __('home'),
                                                    'href' => route('user.marketer.home.index'),
                                                ],
                                                [
                                                    'title' => __('user_menus.financial_record'),
                                                    'href' => route('user.financialRecord.index', [
                                                        'user_type' => 'marketer',
                                                    ]),
                                                ],
                                                [
                                                    'title' => __('customers'),
                                                    'href' => route('user.marketer.customers.index'),
                                                ],
                                                // [
                                                //     'title'=>__('templates'),
                                                //     'href'=>route('user.marketer.templates.index'),
                                                // ],
                                                [
                                                    'title' => __('setting'),
                                                    'href' => route('user.settings.index'),
                                                ],
                                                [
                                                    'title' => __('user_menus.logout'),
                                                    'href' => route('user.auth.logout'),
                                                ],
                                            ];
                                        } else {
                                            $user_menus = [
                                                [
                                                    'title' => __('home'),
                                                    'href' => route('user.home.index'),
                                                ],
                                                [
                                                    'title' => __('modify_my_data'),
                                                    'href' => route('user.profileSettings.profile.index'),
                                                ],
                                                [
                                                    'title' => __('setting'),
                                                    'href' => route('user.settings.index'),
                                                ],
                                                [
                                                    'title' => __('user_menus.logout'),
                                                    'href' => route('user.auth.logout'),
                                                ],
                                            ];
                                        }

                                    @endphp
                                    @foreach ($user_menus as $user_menu)
                                        <li><a class="dropdown-item text-dark" href="{{ $user_menu['href'] }}">
                                                {{ $user_menu['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @if (getUser()->role == 'student')
                            <li class="menu_item hide-sm">
                                <a class="menu_link myCourses" href="{{ route('user.courses.myCourses') }}">{{ __('my_courses') }}
                                </a>
                            </li>
                        @endif
                    @else
                        @if (Route::has('user.auth.login'))
                            <li class="menu_item mx-3 my-2 my-lg-0">
                                <a class="sign-btn font-bold"
                                    href="{{ route('user.auth.login') }}">{{ __('front_login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('user.auth.register'))
                            <li class="menu_item">
                                <a class="join-btn font-bold"
                                    href="{{ route('user.auth.register') }}">{{ __('join_us') }}</a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
            <div class="header-mobile__toolbar d-lg-none fa-lg"><i class="fa-solid fa-bars-sort"></i></div>
        </div>
    </div>
</header>
<!-- end:: Header -->
