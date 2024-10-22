@extends('front.user.lecturer.layout.index' )

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('courses'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('ratings'),
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
				<div class="bg-white p-4 rounded-4">
					<div class="row">
						<div class="col-12">
							<h2 class="font-medium text-start mb-3">{{ __('ratings') }}</h2>
							<div class="row">
								<div class="col-12">
                                    <div class="all-data">
                                        @include('front.user.lecturer.courses.my_courses.details.ratings.partials.all')
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end::Content-->
	</section>


	@push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
	@endpush
@endsection
