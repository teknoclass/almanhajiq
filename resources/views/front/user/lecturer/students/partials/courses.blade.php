@extends('front.user.lecturer.layout.index' )

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('students'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('my_students'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('courses'),
		        'link' => '#',
		    ],
		];
	@endphp
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<!--begin::breadcrumb-->
			@include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
			<!--end::breadcrumb-->

			<!--begin::Content-->
			<div class="row g-5 gx-xxl-8 mb-4">
                <h2 class="font-medium text-start pt-4">{{ __('student_list') }}</h2>
                <div class="bg-white p-4 rounded-4">
                    <div class="row">
                        <div class="all-data">
                            <?php $it_is_user_course = true ?>
                            @include('front.user.lecturer.courses.my_courses.partials.all-student-courses')
                        </div>
                    </div>
                </div>
			</div>
			<!--end::Content-->
		</div>
	</section>


	@push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
	@endpush
@endsection
