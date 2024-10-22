<!-- Header Section Start -->
<div class="header-section">

    <!-- Header Top Start -->
    <div class="header-top d-none d-lg-block">
        <div class="container">

            <!-- Header Top Wrapper Start -->
            <div class="header-top-wrapper">

                <!-- Header Top Medal Start -->
                <div class="header-top-medal">
                    <div class="top-info">
                        <p><i class="flaticon-phone-call"></i> <a href="https://api.whatsapp.com/send?phone={{ @$settings->valueOf('whatsapp') }}">{{ @$settings->valueOf('whatsapp') }}</a></p>
                        <p><i class="flaticon-email"></i> <a href="mailto:{{ @$settings->valueOf('email') }}">{{ @$settings->valueOf('email') }}</a></p>
                    </div>
                </div>
                <!-- Header Top Medal End -->

                <!-- Header Top Right Start -->
                <div class="header-top-right">
                    <ul class="social-media justify-content-center">
                        @foreach ($social_media as $social)
                            @if($social->getLink()!='#')
                            <li><a href="{{$social->getLink()}}" target="_blank"><i class="fa-brands {{ $social->icon}}"> </i></a></li>
                            @endif
                            @endforeach

                    </ul>
                </div>
                <!-- Header Top Right End -->

            </div>
            <!-- Header Top Wrapper End -->

        </div>
    </div>
    <!-- Header Top End -->

    <!-- Header Main Start -->
    <div class="header-main">
        <div class="container">

            <!-- Header Main Start -->
            <div class="header-main-wrapper">

                <!-- Header Logo Start -->
                <div class="header-logo">
                    <a href="{{ route('index') }}"><img src="{{ imageUrl(@$settings->valueOf('white_logo')) }}" alt="{{ @$settings->valueOf('title_' . app()->getLocale()) }}" loading="lazy"/></a>
                </div>
                <!-- Header Logo End -->

                <!-- Header Menu Start -->
                <div class="header-menu d-none d-lg-block">
                    <ul class="nav-menu">
                        @php
							$menus = [
							    [
							        'title' => __('home'),
							        'is_active' => @$is_active == 'home' ? 'active' : '',
							        'href' => route('index'),
							    ],
							    [
							        'title' => __('about_us'),
							        'is_active' => @$is_active == 'about_us' ? 'active' : '',
							        'href' => route('pages.single', ['sulg' => 'about']),
							    ],
							    [
							        'title' => __('front_header_select'),
							        'is_active' => @$is_active == 'select_section' ? 'active' : '',
							        'href' => route('courses.index'),
							        'submenu' => [
							            [
							                'title' => __('courses'),
							                'href' => route('courses.index'),
							            ],
							            [
							                'title' => 'المناهج التركية',
							                'href' => route('turkish_curriculum.index'),
							            ],
							        ],
							    ],
							    [
							        'title' => __('private_lessons'),
							        'is_active' => @$is_active == 'private_lessons' ? 'active' : '',
							        'href' => route('private_lessons.index'),
							    ],
							    [
							        'title' => __('lecturers'),
							        'is_active' => @$is_active == 'lecturers' ? 'active' : '',
							        'href' => route('lecturers.index'),
							    ],
							    [
							        'title' => __('contact_us'),
							        'is_active' => @$is_active == 'contact_us' ? 'active' : '',
							        'href' => route('contact.index'),
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
                                <ul class="sub-menu">
                                    @foreach ($menu['submenu'] as $option)
                                        <li><a href="{{ @$option['href'] }}">{{ @$option['title'] }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                        @endforeach


                    </ul>

                </div>
                <!-- Header Menu End -->

                <!-- Header Sing In & Up Start -->
                <div class="header-sign-in-up d-none d-lg-block">
                    <ul>
                        @if (auth('web')->check())

                    {{-- <li class="menu_item">
                        <a class="menu_link mx-2 text-white" href="{{ route('user.cart.index') }}">
                            <i class="fa-solid fa-cart-shopping fa-lg"></i>
                        </a>
                    </li> --}}
                    <li class="menu_item">
                        <a class="menu_link mx-3 text-white" href="" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-bell fa-lg"></i>
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

                            <li><a class="text-center d-block notify-all" href="{{ route('user.notifications.index') }}">
                                    {{ __('all_notifications') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu_item">
                        <a class="menu_link mx-3 text-white" href="{{ route('user.chat.index') }}">
                            <i class="fa-solid fa-comment-dots fa-lg"></i>
                        </a>
                    </li>


                    <li class="menu_item dropdown-profile"><a class="menu_link link-profile mx-0 text-white" href="" data-bs-toggle="dropdown">
                        <span class="symbol symbol-30">
                            <img class="rounded-circle" src="{{ imageurl(getUser()->image, '40x40') }}" alt="{{ getUser()->name }}" loading="lazy"/></span>
                        <span class="font-medium mx-2 d-none d-lg-block">{{ getUser()->name }}</span>
                        <i class="fa-regular fa-chevron-down ms-2 fa-xs"></i></a>
                        <ul class="dropdown-menu">
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
                    </li>
                    @else
                        @if (Route::has('user.auth.login'))
                            <li class="menu_item mx-3 my-2 my-lg-0">
                                <a class="sign-in" href="{{ route('user.auth.login') }}">{{ __('front_login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('user.auth.register'))
                            <li class="menu_item">
                                <a class="sign-up" href="{{ route('user.auth.register') }}">{{ __('join_us') }}</a>
                            </li>
                        @endif
                    @endif

                    </ul>
                </div>
                <!-- Header Sing In & Up End -->

                <!-- Header Mobile Toggle Start -->
                <div class="header-toggle d-lg-none">
                    <a class="menu-toggle" href="javascript:void(0)">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
                <!-- Header Mobile Toggle End -->

            </div>
            <!-- Header Main End -->

        </div>
    </div>
    <!-- Header Main End -->

</div>
<!-- Header Section End -->
/////////////////////////////////////////////////////
<!-- start:: Header -->
<header class="main-header">
	<div class="container">
		<div class="d-flex align-items-center">
			<div class="logo me-lg-4"><a href="{{ route('index') }}"><img src="{{ imageUrl(@$settings->valueOf('white_logo')) }}"
						alt="{{ @$settings->valueOf('title_' . app()->getLocale()) }}" loading="lazy"/></a></div>
			<div class="menu--mobile mx-lg-auto">
				<div class="menu-container d-flex align-items-center justify-content-between d-lg-none px-3 border-bottom py-2 mb-3">
					<div class="logo"><a href="{{ route('index') }}"><img src="{{ imageUrl(@$settings->valueOf('white_logo')) }}"
								alt="" loading="lazy"/></a></div>
					<div class="btn-close-header-mobile justify-content-end"><i class="fa-regular fa-xmark"></i></div>
				</div>
				<div class="menu-container me-auto">
					<ul class="main-menu">
						@php
							$menus = [
							    [
							        'title' => __('home'),
							        'is_active' => @$is_active == 'home' ? 'active' : '',
							        'href' => route('index'),
							    ],
							    [
							        'title' => __('about_us'),
							        'is_active' => @$is_active == 'about_us' ? 'active' : '',
							        'href' => route('pages.single', ['sulg' => 'about']),
							    ],
							    [
							        'title' => __('front_header_select'),
							        'is_active' => @$is_active == 'select_section' ? 'active' : '',
							        'href' => route('courses.index'),
							        'submenu' => [
							            [
							                'title' => __('courses'),
							                'href' => route('courses.index'),
							            ],
							            [
							                'title' => 'المناهج التركية',
							                'href' => route('turkish_curriculum.index'),
							            ],
							        ],
							    ],
							    [
							        'title' => __('private_lessons'),
							        'is_active' => @$is_active == 'private_lessons' ? 'active' : '',
							        'href' => route('private_lessons.index'),
							    ],
							    [
							        'title' => __('lecturers'),
							        'is_active' => @$is_active == 'lecturers' ? 'active' : '',
							        'href' => route('lecturers.index'),
							    ],
							    [
							        'title' => __('contact_us'),
							        'is_active' => @$is_active == 'contact_us' ? 'active' : '',
							        'href' => route('contact.index'),
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
                        <a class="menu_link mx-3 text-white" href="" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-bell fa-lg"></i>
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

                            <li><a class="text-center d-block notify-all" href="{{ route('user.notifications.index') }}">
                                    {{ __('all_notifications') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu_item">
                        <a class="menu_link mx-3 text-white" href="{{ route('user.chat.index') }}">
                            <i class="fa-solid fa-comment-dots fa-lg"></i>
                        </a>
                    </li>


                    <li class="menu_item dropdown-profile"><a class="menu_link link-profile mx-0 text-white" href="" data-bs-toggle="dropdown">
                        <span class="symbol symbol-30">
                            <img class="rounded-circle" src="{{ imageurl(getUser()->image, '40x40') }}" alt="{{ getUser()->name }}" loading="lazy"/></span>
                        <span class="font-medium mx-2 d-none d-lg-block">{{ getUser()->name }}</span>
                        <i class="fa-regular fa-chevron-down ms-2 fa-xs"></i></a>
                        <ul class="dropdown-menu">
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
                    </li>
                    @else
                        @if (Route::has('user.auth.login'))
                            <li class="menu_item mx-3 my-2 my-lg-0">
                                <a class="btn btn-outline-primary rounded-pill"
                                    href="{{ route('user.auth.login') }}">{{ __('front_login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('user.auth.register'))
                            <li class="menu_item">
                                <a class="btn btn-primary rounded-pill" href="{{ route('user.auth.register') }}">{{ __('join_us') }}</a>
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
