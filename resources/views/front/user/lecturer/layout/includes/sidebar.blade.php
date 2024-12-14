@php
    $cursor_dir = app()->getlocale() == 'ar' ? 'left' : 'right';
@endphp
<div class="col-lg-auto">
    <div class="panel-sidebar h-100">
        <button class="aside_mobile_close state-success m-3 toggle-side-nav rounded p-2 d-lg-none"><i
                class="fa-solid fa-sliders fa-xl"></i></button>
        <div class="main-aside">
            <button class="aside_mobile_close toggle-side-nav m-2 p-3 fs-4 rounded d-lg-none"><i
                    class="fa fa-times"></i></button>
            <div class="main-aside-menu-wrapper">
                <div class="main-aside-menu scroll">
                    <div class="pt-4 pb-3 pt-lg-5">
                        <div class="text-start px-4">
                            {{-- <button class="btn p-0">
                                <svg id="svgexport-7_79_" data-name="svgexport-7 (79)" xmlns="http://www.w3.org/2000/svg" width="23.768"
                                    height="23.76" viewBox="0 0 23.768 23.76">
                                    <g id="ARROW_48" data-name="ARROW 48" transform="translate(0 0)">
                                        <path id="Path_1703" data-name="Path 1703"
                                            d="M14.45,16.287A1.114,1.114,0,0,0,13.335,17.4v2.715a1.576,1.576,0,0,1-1.574,1.574H3.973A1.576,1.576,0,0,1,2.4,20.117V3.963A1.576,1.576,0,0,1,3.973,2.389h7.789a1.576,1.576,0,0,1,1.574,1.574V6.31a1.114,1.114,0,0,0,2.229,0V3.963a3.808,3.808,0,0,0-3.8-3.8H3.973a3.808,3.808,0,0,0-3.8,3.8V20.117a3.808,3.808,0,0,0,3.8,3.8h7.789a3.808,3.808,0,0,0,3.8-3.8V17.4A1.114,1.114,0,0,0,14.45,16.287Z"
                                            transform="translate(-0.17 -0.16)" fill="red" />
                                        <path id="Path_1704" data-name="Path 1704"
                                            d="M212.512,150.442l-3.966-3.963a1.115,1.115,0,0,0-1.56-.015,1.134,1.134,0,0,0,0,1.609l2.065,2.066h-9.659a1.114,1.114,0,0,0,0,2.229h9.659l-2.085,2.085a1.115,1.115,0,0,0,1.576,1.577l3.968-3.966a1.145,1.145,0,0,0,0-1.621Z"
                                            transform="translate(-189.081 -139.374)" fill="red" />
                                    </g>
                                </svg>
                            </button> --}}
                        </div>
                        <div class="text-center">
                            <div class="symbol-120 symbol"><img class="rounded-circle"
                                    src="{{ imageUrl(auth()->user()->image) }}" alt="" loading="lazy"/>
                            </div>
                        </div>
                        <div class="text-center py-3">
                            <h4 class="font-medium">{{ auth()->user()->name }}</h4>
                            <h6 class="text-muted">{{ optional(auth()->user()->lecturerSetting)->position }}</h6>
                        </div>
                        <div class="d-flex align-items-center text-center justify-content-center mb-4">
                            <div class="d-flex flex-column">
                                <h4 class="font-medium">{{ auth()->user()->RelatedStudents()->count() }} </h4>
                                <h6 class="text-muted">{{ __('student1') }} </h6>
                            </div>
                            <div class="d-flex flex-column line-vertical-left-right px-4 mx-4">
                                <h4 class="font-medium">{{ auth()->user()->LecturerCoursesCount() }}</h4>
                                <h6 class="text-muted">{{ __('course1') }} </h6>
                            </div>
                            <div class="d-flex flex-column">
                                <h4 class="font-medium">({{ auth()->user()->getRating() }}/5)</h4>
                                <h6 class="text-muted">{{ __('rating') }} </h6>
                            </div>
                        </div>
                    </div>
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="{{ route('user.lecturer.home.index') }}">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-01.svg') }}" alt="" loading="lazy"/>
                                </span>
                                <span class="main-menu__link-text">{{ __('dashboard') }}</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold gap-2">
                                    <i class="fa-solid fa-circle"></i>
                                    {{ __('course_section') }}
                                </span>
                            </a>
                        </li>

                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-02.svg') }}" alt="" loading="lazy"/>
                                </span>
                                <span class="main-menu__link-text">{{ __('courses') }}</span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{ @$cursor_dir }}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link"
                                            href="{{ route('user.lecturer.my_courses.index') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('my_courses') }}</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link"
                                            href="{{ route('user.lecturer.my_courses.create') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('add_new_course') }}</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link"
                                            href="{{ route('user.lecturer.my_courses.my_live_lessons') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('my_live_lessons') }}</span>
                                        </a>
                                    </li>     <li class="main-menu__item">
                                        <a class="main-menu__link"
                                            href="{{ route('user.lecturer.course.curriculum.live_lesson.requests.request') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('live_lessons_requests') }}</span>
                                        </a>
                                    </li>


                                    {{-- <li class="main-menu__item">
                                        <a class="main-menu__link" href="{{ route('user.lecturer.my_courses.student_activity') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('student_activity') }}</span>
                                        </a>
                                    </li> --}}

                                </ul>
                            </div>
                        </li>





                        {{-- <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-03.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">الاختبارات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">قائمة الاختبارات</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">اختبار جديد</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">نتائج الاختبارات</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}




                        {{-- <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-04.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">الشهادات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">قالب الشهادة</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">شهادات الطلاب</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">منح شهادة</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}





                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-05.svg') }}" alt="" loading="lazy"/>
                                </span>
                                <span class="main-menu__link-text">{{ __('students') }} </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{ @$cursor_dir }}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="{{ route('user.lecturer.students.index') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('my_students') }}</span>
                                        </a>
                                    </li>
                                    {{-- <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">إضافة طالب جديد</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">تسجيل طالب في دورة</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </div>
                        </li>
                        {{-- <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-06.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">حزم الدورات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">قائمة الحزم</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">إضافة حزمة جديدة</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <li class="main-menu__item">
    <a class="main-menu__link menu-toggle" href="javascript:;">
        <span class="main-menu__link-icon">
            <img src="{{ asset('assets/front/images/panel/icon-07.svg') }}" alt="" loading="lazy"/>
        </span>
        <span class="main-menu__link-text">{{ __('private_lessons') }}</span>
        <span class="main-menu__ver-arrow">
            <i class="fa-regular fa-chevron-{{ @$cursor_dir }}"></i>
        </span>
    </a>
    <div class="menu-submenu">
        <ul class="menu-subnav">
            <li class="main-menu__item">
                <a class="main-menu__link" href="{{ route('user.lecturer.private_lessons.index') }}">
                    <div class="main-menu__icon">
                        <i class="fa-solid fa-circle"></i>
                    </div>
                    <span class="main-menu__link-text">{{ __('lessons_list') }}</span>
                </a>
            </li>
          {{--  <li class="main-menu__item">
                <a class="main-menu__link" href="{{ route('user.private_lessons.request') }}">
                    <div class="main-menu__icon">
                        <i class="fa-solid fa-circle"></i>
                    </div>
                    <span class="main-menu__link-text">{{ __('my_live_lessons_requests') }}</span>
                </a>
            </li> --}}
            <!-- Uncomment the following block if needed in the future -->
            <!-- 
            <li class="main-menu__item">
                <a class="main-menu__link" href="{{ route('user.lecturer.private_lessons.create.index') }}">
                    <div class="main-menu__icon">
                        <i class="fa-solid fa-circle"></i>
                    </div>
                    <span class="main-menu__link-text">{{ __('add_private_lessons') }}</span>
                </a>
            </li>
            -->
        </ul>
    </div>
</li>



{{--                                    --}}{{-- <li class="main-menu__item">--}}
{{--                                        <a class="main-menu__link" href="">--}}
{{--                                            <div class="main-menu__icon">--}}
{{--                                                <i class="fa-solid fa-circle"></i>--}}
{{--                                            </div>--}}
{{--                                            <span class="main-menu__link-text">الإحصائيات</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="main-menu__item">--}}
{{--                                        <a class="main-menu__link"--}}
{{--                                            href="{{ route('user.lecturer.private_lessons.settings.index') }}">--}}
{{--                                            <div class="main-menu__icon">--}}
{{--                                                <i class="fa-solid fa-circle"></i>--}}
{{--                                            </div>--}}
{{--                                            <span class="main-menu__link-text">{{ __('setting') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li> --}}

{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </li>--}}
                    </ul>
                    {{-- <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold"> <i class="fa-solid fa-circle me-2"></i> المتجر الإلكتروني
                                </span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-08.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">المنتجات</span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-09.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">إضافة منتج جديد</span>
                            </a>
                        </li>
                    </ul> --}}
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold gap-2">
                                    <i class="fa-solid fa-circle"></i>
                                    {{ __('reports') }} </span>
                            </a>
                        </li>
                        {{-- <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-10.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">التقارير التعليمية </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">تقارير الدورات</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">تقارير تقدم الطلاب</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-03.svg') }}" alt="" loading="lazy"/>
                                </span>
                                <span class="main-menu__link-text">{{ __('financial_reports') }} </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{ @$cursor_dir }}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    {{-- <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">تقارير الدورات</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">تقارير المنتجات</span>
                                        </a>
                                    </li> --}}
                                    <li class="main-menu__item">
                                        <a class="main-menu__link"
                                            href="{{ route('user.lecturer.financialRecord.index') }}">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">{{ __('lecturer_earnings') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    {{-- <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold"> <i class="fa-solid fa-circle me-2"></i> الترويج </span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-12.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">الكوبونات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">قائمة الكوبونات</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">كوبون جديد</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-13.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">النقاط والمكافئات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">السجل</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">الحالة</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">الإعدادات</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold"> <i class="fa-solid fa-circle me-2"></i> الرسائل والإشعارات
                                </span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-14.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">الرسائل</span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link menu-toggle" href="javascript:;">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-15.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">لوحة الإشعارات </span>
                                <span class="main-menu__ver-arrow">
                                    <i class="fa-regular fa-chevron-{{@$cursor_dir}}"></i>
                                </span>
                            </a>
                            <div class="menu-submenu">
                                <ul class="menu-subnav">
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">كافة الإشعارات</span>
                                        </a>
                                    </li>
                                    <li class="main-menu__item">
                                        <a class="main-menu__link" href="">
                                            <div class="main-menu__icon">
                                                <i class="fa-solid fa-circle"></i>
                                            </div>
                                            <span class="main-menu__link-text">إشعار جديد</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold"> <i class="fa-solid fa-circle me-2"></i> المنتديات </span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-16.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">مواضيعي</span>
                            </a>
                        </li>
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-09.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">موضوع جديد</span>
                            </a>
                        </li>
                    </ul> --}}
                    <ul class="main-menu__nav">
                        <li class="main-menu__item">
                            <a class="main-menu__link main-menu__title bg-white">
                                <span class="main-menu__link-text font-bold gap-2">
                                    <i class="fa-solid fa-circle"></i>
                                    {{ __('lecturer_settings') }}
                                </span>
                            </a>
                        </li>
                        {{-- <li class="main-menu__item">
                            <a class="main-menu__link" href="">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-16.svg') }}" alt="">
                                </span>
                                <span class="main-menu__link-text">الملف الشخصي</span>
                            </a>
                        </li> --}}
                        <li class="main-menu__item">
                            <a class="main-menu__link" href="{{ route('user.lecturer.settings.index') }}">
                                <span class="main-menu__link-icon">
                                    <img src="{{ asset('assets/front/images/panel/icon-09.svg') }}" alt="" loading="lazy"/>
                                </span>
                                <span class="main-menu__link-text">{{ __('my_settings') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
