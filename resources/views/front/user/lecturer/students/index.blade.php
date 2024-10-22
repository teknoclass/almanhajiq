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
		];


		$statistics = [
		    [
		        'title' => __('student_count'),
		        'currency' => "",
		        'icon' => "user",
		        'value' => @$total_student_no,
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
				<!--begin::Row-->
				<div class="row gy-5 g-lg-3 mb-4">
                    @foreach ($statistics as $i => $statistic)
                    @include('front.components.lecturer_statistic_card', ['statistic' => $statistic, 'i' =>$i])
                    @endforeach
				</div>
				<!--end::Row-->

                <form id="form" action="{{route('user.lecturer.students.filter')}}" to="#" method="post">
                    @csrf
                    <h2 class="font-medium text-start mb-3 pt-5">{{ __('filter_students') }}</h2>
                    <div class="bg-white p-4 mt-0 rounded-4">
                        <div class="row">
                            {{-- <div class="form-group col-4">
                                <h3>{{ __('from') }}</h3>
                                <div class="input-icon left">
                                    <input name="date_from" value="{{ @$search_query['date_from'] }}" class="form-control datetimepicker_1 group-date" type="text" placeholder="" />
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <h3>{{ __('to') }}</h3>
                                <div class="input-icon left">
                                    <input name="date_to" value="{{ @$search_query['date_to'] }}" class="form-control datetimepicker_1 group-date" type="text" placeholder="" />
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div> --}}
                            <div class="form-group col-4">
                                <h3>{{ __('name') }}</h3>
                                <input type="text" name="name" value="{{ @$search_query['name'] }}" class="form-control form-control-lg form-control-solid px-15 rounded-pill" placeholder="">
                            </div>
                            {{-- <div class="form-group col-4">
                                <h3>{{ __('email') }}</h3>
                                <input type="text" name="email" value="{{ @$search_query['email'] }}" class="form-control form-control-lg form-control-solid px-15 rounded-pill" placeholder="">
                            </div> --}}
                            {{-- <div class="form-group col-4">
                                <h3>{{ __('type') }}</h3>
                                <select class="selectpicker" name="type" value="{{ @$search_query['type'] }}" title=" ">
                                    <option value="course">{{ __('one_course') }}</option>
                                    <option value="lesson">{{ __('lesson') }}</option>
                                </select>
                            </div> --}}
                            <div class="form-group col-4 d-flex">
                                <div class="d-flex align-items-center mt-auto w-100">
                                    <button type="submit" class="btn btn-primary px-4  w-100">{{ __('search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

				<h2 class="font-medium text-start mb-3 pt-5">{{ __('student_list') }}</h2>
				<div class="bg-white p-4 mt-0 rounded-4">
					<div class="row">
						<div class="col-12">
                            <div class="all-data">
                                @include('front.user.lecturer.students.partials.all')
                            </div>
						</div>
					</div>
				</div>
			</div>
			<!--end::Content-->
		</div>
	</section>

    <!-- Start Modal-->
    <div class="modal fade" id="joinSession" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>إنضمام إلى الجلسة</strong></h2>
                <div class="form-group">
                    <label class="mb-2">URL</label>
                    <input class="form-control" type="text"/>
                </div>
                <div class="form-group">
                    <label class="mb-2">كلمة المرور (اختياري)</label>
                    <input class="form-control" type="text"/>
                    <label class="mt-2 text-muted">يمكنك استخدام رابط زوم أو أي رابط آخر</label>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary px-5">إنضمام</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->

    <!-- Start Modal-->
    <div class="modal fade" id="createSession" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>إنشاء رابط الجلسة</strong></h2>
                <div class="form-group">
                    <label class="mb-2">URL</label>
                    <input class="form-control" type="text"/>
                </div>
                <div class="form-group">
                    <label class="mb-2">كلمة المرور (اختياري)</label>
                    <input class="form-control" type="text"/>
                    <label class="mt-2 text-muted">يمكنك استخدام رابط زوم أو أي رابط آخر</label>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary px-5">إنشاء</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->

    <!-- Start Modal-->
    <div class="modal fade" id="contactStudent" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
            <div class="modal-body px-5 py-4">
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                <h2 class="text-center mb-4"><strong>معلومات التواصل مع الطالب</strong></h2>
                <div class="pb-3 pt-lg-5">
                    <div class="text-center">
                        <div class="symbol-120 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/>
                        </div>
                    </div>
                    <div class="text-center py-3">
                        <h4 class="font-medium">أ. محمد السيلاوي</h4>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <h3>البريد الالكتروني:</h3>
                    </div>
                    <div class="d-flex align-items-center">
                        <p>alawael@gmail.com</p>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <h3>الهاتف:</h3>
                    </div>
                    <div class="d-flex align-items-center">
                        <p>0123456789</p>
                    </div>
                </div>

                <div class="d-lg-flex align-items-center mt-4" style="justify-content: space-evenly;">
                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                        <div class="form-group text-center">
                            <button class="btn btn-success px-5">إرسال رسالة</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-group text-center">
                            <button class="btn btn-danger px-5">إغلاق</button>
                        </div>
                    </div>
                </div>


            </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->


	@push('front_js')
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
