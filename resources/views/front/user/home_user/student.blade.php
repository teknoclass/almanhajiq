@extends('front.layouts.index', ['sub_title' => __('home')])

@section('content')
	@php
        $is_active = "home";

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => '#',
		    ],
		];

		$widgets = [
		    // [
		    //     'title' => __('my_points'),
		    //     'route' => route('user.my_points.index'),
		    //     'icon' => 'fa-medal',
		    //     'count' => 44,
		    // ],
		    [
		        'title' => __('completed_courses'),
		        'route' => route('user.courses.completed'),
		        'icon' => 'fa-play',
		        'count' => @$user_courses_end_count,
		    ],
		    [
		        'title' => __('my_upcoming_appointments'),
		        'route' => route('user.private_lessons.index'),
		        'icon' => 'fa-calendar',
		        'count' => @$upcoming_private_lessons_count,
		    ],
		    [
		        'title' => __('my_packages'),
		        'route' => route('user.packages.index'),
		        'icon' => 'fa-calendar',
		        'count' => @$my_packages_count,
		    ],
		];
	@endphp

	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			@include('front.user.components.breadcrumb')

			<div class="row mb-3">
				@foreach ($widgets as $widget)
					@include('front.user.components.home_widget', ['widget' => $widget])
				@endforeach
			</div>

            @if (@$courses && @$courses->isNotEmpty())
			<div class="row mb-3">
                <div class="row mb-4 justify-content-between align-items-center">
                    <div class="col-7">
                      <div class="d-lg-flex align-items-center justify-content-between">
                        <h2 class="font-medium">{{ __('latest_courses') }} ({{ count(@$courses) }})</h2>
                      </div>
                    </div>
                    <div class="col-5">
                        <div class="text-end">
                            <h3 class="font-bold"><a class="text-muted" href="{{ route('user.courses.myCourses') }}">{{ __('view_all') }} <i class="fa-solid fa-chevrons-{{ app()->getlocale() == "ar" ? "left" : "right" }}"></i></a></h3>
                        </div>
                    </div>
                    {{-- <div class="col-3 mb-2 d-flex justify-content-end">
                        <a class="btn btn-primary rounded-pill" href="{{ route('user.courses.myCourses') }}">{{ __('view_all') }}</a>
                    </div> --}}
                </div>
                @foreach ($courses as $course)
                    @include('front.courses.partials.course', ['course' => $course])
                @endforeach
			</div>
            @endif

			{{-- <div class="row">
            <div class="col-12 mb-2">
            <h2 class="font-medium">آخر الدروس (2)</h2>
            </div>
            <div class="col-md-4">
            <div class="widget_item-blog mb-4">
                <div class="widget_item-image">
                <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-01.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                <div class="d-flex mb-2">
                    <div class="col">
                    <h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
                    </div>
                    <div class="col-auto">
                    <h6 class="font-medium"><i class="circle"> </i>مبتدئ</h6>
                    </div>
                </div>
                <h6 class="text-muted mb-3 py-1"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="widget_item-blog mb-4">
                <div class="widget_item-image">
                <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-02.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                <div class="d-flex mb-2">
                    <div class="col">
                    <h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
                    </div>
                    <div class="col-auto">
                    <h6 class="font-medium"><i class="circle"> </i><i class="circle"> </i>مبتدئ</h6>
                    </div>
                </div>
                <div class="bg-light-green rounded d-flex align-items-center justify-content-between px-2 py-1 mb-3">
                    <h6 class="font-medium"><i class="fa-solid fa-calendar-days me-2"></i>( رابط الجلسة القادمة ( 4\11\ 2022</h6><a href="">إضغط هنا</a>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                </div>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="widget_item-blog mb-4">
                <div class="widget_item-image">
                <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-03.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                <div class="d-flex mb-2">
                    <div class="col">
                    <h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
                    </div>
                    <div class="col-auto">
                    <h6 class="font-medium"><i class="circle"> </i>مبتدئ</h6>
                    </div>
                </div>
                <h6 class="text-muted mb-3 py-1"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
                <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                </div>
            </div>
            </div>
        </div> --}}


		</div>
	</section>
	<!-- end:: section -->
@endsection
