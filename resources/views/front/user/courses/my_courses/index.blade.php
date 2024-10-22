@extends('front.layouts.index', ['sub_title' => __('my_courses')])

@section('content')
	@php
        $is_active = "my_courses";

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => route('user.home.index'),
		    ],
		    [
		        'title' => __('my_courses'),
		        'link' => '#',
		    ],
		];
	@endphp
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			@include('front.user.components.breadcrumb')

			<div class="row mb-3 mt-3">
                <div class="row mb-4 justify-content-between align-items-center">
                    <div class="col-9">
                      <div class="d-lg-flex align-items-center justify-content-between">
                        <h2 class="font-medium">{{ __('my_courses') }} ({{ @$courses_count }})</h2>
                      </div>
                    </div>
                    {{-- <div class="col-3 mb-2 d-flex justify-content-end">
                        <a class="btn btn-primary rounded-pill" href="">{{ __('view_more') }}</a>
                    </div> --}}
                </div>
                <div class="all-data">
                    @include('front.user.courses.my_courses.partials.all')
                </div>
			</div>
		</div>
	</section>
	<!-- end:: section -->
    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
    @endpush
@endsection
