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
		        'title' => __('add_private_lessons'),
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
			<div class="g-5 gx-xxl-8 mb-4">
				<!--begin::Row-->
                <form id="form" action="{{route('user.lecturer.private_lessons.set')}}" to="{{ url()->current() }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ @$lesson->id }}">
                    <input type="hidden" name="teacher_id" value="{{ auth()->id() }}">
                    <h2 class="font-medium text-start pt-2">{{__('add_private_lessons')}}</h2>
                    <div class="bg-white rounded-4 mt-2">
                        <div class="row">
                            @foreach (locales() as $locale => $value)
                            <h3>{{__('title')}} ({{ __($value) }} )<span class="text-danger">*</span></h3>
                            <div class="col-lg-12 form-group">
                                <input type="text" class="form-control p-3" required  name="title_{{ $locale }}" placeholder="{{ __('lesson_name') }}" value="{{ @$lesson->title }}">
                            </div>
                            @endforeach
                            @foreach (locales() as $locale => $value)
                            <h3>{{__('description')}} ({{ __($value) }} )</h3>
                            <div class="col-lg-12 form-group">
                                <textarea class="form-control p-3" rows="4"  name="description_{{ $locale }}" placeholder="{{ __('about_lesson') }}">{{ @$lesson->description }}</textarea>
                            </div>
                            @endforeach
                            <div class="form-group col-6">
                                <h3>{{__('category')}}</h3>
                                <select class="selectpicker" required name="category_id" id="category_id">
                                    <option value="" selected disabled>{{__('category')}}</option>
                                    @foreach($categories as $category)
                                    <option value="{{@$category->value}}" {{ (@$category->value == @$lesson->category_id) ? 'selected' : '' }}>{{@$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if (@$settings->valueOf('offline_private_lessons'))
                            <div class="form-group col-6">
                                <h3>{{__('type')}}</h3>
                                <select class="selectpicker" required name="meeting_type" id="meeting_type">
                                    <option value="online"  {{ (@$lesson->meeting_type == 'online') ? 'selected' : '' }}>{{__('meeting_type.online')}}</option>
                                    <option value="offline" {{ (@$lesson->meeting_type == 'offline') ? 'selected' : '' }}>{{__('meeting_type.offline')}}</option>
                                    <option value="both" {{ (@$lesson->meeting_type == 'both') ? 'selected' : '' }}>{{__('meeting_type.both')}}</option>
                                </select>
                            </div>
                            @else
                                <input type="hidden" name="meeting_type" value="online">
                            @endif

                            @if (auth()->user()->can_add_half_hour==1)
                            <div class="form-group col-md-6">

                                <h3>{{ __('time_type') }}</h3>
                                <div class="form-group">
                                    <select name="time_type"
                                            class="form-control"
                                            required>
                                        <option value="" selected
                                                disabled>{{__('select_time_type')}}</option>
                                            <option value="hour" {{@$lesson->time_type=='hour' ?'selected' :''}}>{{__('hour')}} </option>
                                            <option value="half_hour" {{@$lesson->time_type=='half_hour' ?'selected' :''}}>{{__('half_hour')}} </option>
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="time_type" value="hour">
                            @endif

                            @if(@$lesson)
                            <div class="form-group col-4">
                                <h3>{{ __('start_date') }}</h3>
                                <div class="form-group">
                                    <div class="input-icon left">
                                        <input class="form-control datetimepicker_1 group-date" name="meeting_date[]" value="{{ @$lesson->meeting_date }}" required type="text" placeholder="{{ __('start_date') }}" autocomplete="off">
                                        <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <h3>{{ __('meeting.time_form') }}</h3>
                                <div class="form-group">
                                    <div class="left">
                                        <input  type="time" required
                                                class="form-control group-date"
                                                name="time_form[]"
                                                value="{{ @$lesson->time_form }}"
                                                placeholder="{{ __('meeting.time_form') }}"
                                                onfocus="this.showPicker()"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <h3>{{ __('meeting.time_to') }}</h3>
                                <div class="form-group">
                                    <div class="left">
                                        <input  type="time" required
                                                class="form-control group-date"
                                                name="time_to[]"
                                                value="{{ @$lesson->time_to }}"
                                                placeholder="{{ __('meeting.time_to') }}"
                                                onfocus="this.showPicker()"
                                        />
                                    </div>
                                </div>
                            </div>
                            @else

                            <div class="form-group col-4">
                                <button type="button" id="rowAdder" class="btn btn-primary" title="{{__('add_dates_calendar')}}">{{__('add_dates_calendar')}}</button>
                            </div>
                            <div id="newDates" class="row"></div>

                            @endif
                           {{-- <div class="form-group col-12">
                                <h3>{{ __('system_commission') }} : <span class="text-success"><strong>{{ getSystemCommission(auth()->id()) == '' ? 0 : getSystemCommission(auth()->id()) }} %</strong></span></h3>
                            </div> --}}
                            @include('front.user.lecturer.courses.new_course.components.save_button')
                        </div>
                    </div>
                </form>

				<!--end::Content-->
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

		<script src="{{ asset('assets/front/js/fullcalendar.js') }}"></script>
		<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"></script>
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
        </script>

        <script>
            $("#rowAdder").click(function () {
                newRowAdd =
                        '<div class="row" id="row">' +
                            '<div class="form-group col-4">'+
                                '<h3>{{ __('start_date') }}</h3>'+
                                '<div class="form-group">'+
                                    '<div class="input-icon left">'+
                                        '<input class="form-control datetimepicker_1 group-date" name="meeting_date[]" value="" required type="date" placeholder="{{ __('start_date') }}" autocomplete="off">'+
                                        '<div class="icon"><i class="fa-light fa-calendar"></i></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-3">'+
                                '<h3>{{ __('meeting.time_form') }}</h3>'+
                                '<div class="form-group">'+
                                    '<div class="left">'+
                                        '<input  type="time" required class="form-control group-date" name="time_form[]" value="" placeholder="{{ __('meeting.time_form') }}" onfocus="this.showPicker()"/>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-3">'+
                                '<h3>{{ __('meeting.time_to') }}</h3>'+
                                '<div class="form-group">'+
                                    '<div class="left">'+
                                        '<input  type="time" required class="form-control group-date" name="time_to[]" value="" placeholder="{{ __('meeting.time_to') }}" onfocus="this.showPicker()"/>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-2">'+
                                '<h3>&nbsp;</h3>'+
                                '<div class="form-group">'+
                                    '<div class="left">'+
                                        '<a href="javascript:;" id="DeleteRow" class="text-danger"><i class="fa-solid fa-trash fa-lg"></i></a>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                $('#newDates').append(newRowAdd);
            });

            $("body").on("click", "#DeleteRow", function () {
                $(this).parents("#row").remove();
            });
        </script>
		@endpush
	@endsection
