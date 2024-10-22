@extends('front.user.lecturer.layout.index' )

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('private_lessons'),
		        'link' => route('user.lecturer.private_lessons.index'),
		    ],
		    [
		        'title' => __('lessons_list'),
		        'link' => '#',
		    ],
		];



		$statistics = [
		    [
		        'title' => __('pending_private_lessons'),
		        'currency' => "",
		        'icon' => "play",
		        'value' => @$totalPendingCourses,
                'type' => '',
		    ],
		    [
		        'title' => __('total_private_lessons'),
		        'currency' => "",
		        'icon' => "star",
		        'value' => @$totalLessons,
                'type' => '',
		    ],
            [
		        'title' => __('number_of_students'),
		        'currency' => "",
		        'icon' => "grad_hat",
		        'value' => @$totalStudents,
                'type' => '',
		    ],
            [
		        'title' => __('total_earnings'),
		        'currency' => __('currency'),
		        'icon' => "dollar",
		        'value' => @$totalEarningsAllTime,
                'type' => '',
		    ],

		];
	@endphp
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<!--begin::breadcrumb-->
			@include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
			<!--end::breadcrumb-->

			<!--begin::Content-->
			<div class="g-5 gx-xxl-8 mb-4 mt-1">
				<!--begin::Statistics-->
				<div class="row gy-5 g-lg-3 mb-4">
                    @foreach ($statistics as $i => $statistic)
                    @include('front.components.lecturer_statistic_card', ['statistic' => $statistic, 'i' =>$i])
                    @endforeach
				</div>
				<!--end::Statistics-->

                <form action="{{route('user.lecturer.private_lessons.filter')}}" to="#" method="post">
                    @csrf
                    <h2 class="font-medium text-start mb-3 pt-5">{{ __('filter_private_lessons') }}</h2>
                    <div class="bg-white p-4 mt-0 rounded-4">
                        <div class="row">
                            <div class="form-group col-md-4 col-6">
                                <h3>{{__('from')}}</h3>
                                <div class="input-icon left">
                                    <input name="date_from" value="{{ @$search_query['date_from'] }}" class="form-control datetimepicker_1 group-date" type="text" placeholder=""  autocomplete="off"/>
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-md-4 col-6">
                                <h3>{{__('to')}}</h3>
                                <div class="input-icon left">
                                    <input name="date_to" value="{{ @$search_query['date_to'] }}" class="form-control datetimepicker_1 group-date" type="text" placeholder=""  autocomplete="off"/>
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div>
                           {{-- <div class="form-group col-md-4 col-6">
                                <h3>{{__('category')}}</h3>
                                <select class="selectpicker" name="category_id" value="{{ @$search_query['category_id'] }}" id="category_id">
                                    <option  selected disabled>{{__('category')}}</option>
                                    @foreach($categories as $category)
                                    <option value="{{@$category->value}}">{{@$category->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group col-md-4 col-6">
                                <h3>{{ __('student1') }}</h3>
                                <select class="selectpicker" name="student_id" value="{{ @$search_query['student_id'] }}" id="category_id">
                                    <option  selected disabled>{{__('student')}}</option>
                                    @foreach($students as $student)
                                    <option value="{{@$student->id}}">{{@$student->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-6">
                                <h3>{{ __('status') }}</h3>
                                <select class="selectpicker" name="status" value="{{ @$search_query['status'] }}" title=" ">
                                    <option value="pending">{{ __('not_booked') }}</option>
                                    <option value="acceptable">{{ __('booked') }}</option>
                                    <option value="unacceptable">{{ __('canceled') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-6 d-flex">
                                <div class="d-flex align-items-center mt-auto w-100">
                                    <button type="submit" class="btn btn-primary px-4  w-100">{{ __('search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row text-start mb-3 pt-5 justify-content-between align-items-center">
                    <div class="col-9">
                      <div class="d-lg-flex align-items-center justify-content-between">
                        @if (@$type == 'upcoming')
                            <h2 class="font-medium">{{ __('my_upcoming_appointments') }}</h2>
                        @elseif (@$type == 'finished')
                            <h2 class="font-medium">{{ __('my_finished_appointments') }}</h2>
                        @endif
                      </div>
                    </div>
                    <div class="col-3 mb-2 d-flex justify-content-end">
                        @if (@$type == 'upcoming')
                            <a class="btn btn-primary rounded-pill" href="{{ route('user.lecturer.private_lessons.index', ['type' => 'finished']) }}">{{ __('my_finished_appointments') }}</a>
                        @elseif (@$type == 'finished')
                            <a class="btn btn-primary rounded-pill" href="{{ route('user.lecturer.private_lessons.index') }}">{{ __('my_upcoming_appointments') }}</a>
                        @endif
                    </div>
                </div>
				{{-- <h2 class="font-medium text-start mb-3 pt-5">{{ __('private_lessons_list') }}</h2> --}}
				<div class="bg-white p-4 mt-0 rounded-4">
					<div class="row">
						<div class="col-12">
                            <div class="all-data">
                                @include('front.user.lecturer.private_lessons.partials.all')
                            </div>
						</div>
					</div>
				</div>
			</div>
			<!--end::Content-->
		</div>
	</section>


	@push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
        <script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"> </script>
		<script>
            $(".datetimepicker_1").datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0,
            pickerPosition: "bottom-left",
            });

			$('.dropdown-menu').click(function(e) {
				e.stopPropagation()
			})
		</script>
	@endpush
@endsection
