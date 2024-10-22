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
		        'title' => __('private_lessons'),
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
                <h2 class="font-medium text-start mb-3 pt-5">{{ __('student_list') }}</h2>
                <div class="bg-white p-4 rounded-4">
                    <div class="row">
                        <div class="all-data">
                            @include('front.user.lecturer.private_lessons.partials.all')
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
