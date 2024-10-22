@extends('front.user.lecturer.layout.index' )

@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/fullcalendar.min.css') }}" />
@endpush

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('private_lessons'),
		        'link' => route('user.lecturer.private_lessons.index'),
		    ],
		    [
		        'title' => __('setting'),
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
                <form id="form" action="{{route('user.lecturer.private_lessons.settings.store')}}" to="#" method="post">
                    @csrf
                    <!--end::Row-->
                    {{-- <h2 class="font-medium text-start">{{ __('online_lessons') }}</h2> --}}
                    <div class="bg-white p-4 rounded-4">
                        <div class="row">
                            <div class="form-group col-lg-4 col-sm-12">
                                <h3>{{ __('hour_price') }}</h3>
                                <div class="input-icon left">
                                    <input name="hour_price" value="{{ @$user->hour_price }}" class="form-control group-date" type="text" placeholder="" />
                                    <div class="icon"><strong>$</strong></div>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12">
                                <h3>{{ __('minimum_students_count') }}</h3>
                                <div class="input-icon left">
                                    <input name="min_student_no" value="{{ @$user->min_student_no }}" class="form-control" type="text" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12">
                                <h3>{{ __('maximum_students_count') }}</h3>
                                <div class="input-icon left">
                                    <input name="max_student_no" value="{{ @$user->max_student_no }}" class="form-control" type="text" placeholder="" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center mt-2">
                        <button type="submit" id="btn_submit" class="btn btn-primary px-5">{{ __('save') }}</button>
                    </div>
                </form>




               {{-- @include('front.user.lecturer.categories.prices') --}}
			</div>
        </div>
	</section>

	@push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
		<script>
			$('.dropdown-menu').click(function(e) {
				e.stopPropagation()
			})
		</script>
		@endpush
	@endsection
