@extends('front.user.lecturer.layout.index' )

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => 'الدورات',
		        'link' => '#',
		    ],
		    [
		        'title' => 'دوراتي',
		        'link' => route('user.lecturer.my_courses.index'),
		    ],
		    [
		        'title' => 'دورة برمجة',
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
                        <div class="row">
                            <div class="col-4 mb-5">
                            <h2 class="font-medium text-start mb-3">الشهادات</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mb-5">
                            <label class="m-checkbox checkbox-2 mb-0">
                                <input class="checkAll" type="checkbox" name="checkbox"/><span class="checkmark"></span> تحديد الكل
                            </label>
                            </div>
                        </div>
                      </div>
                      <div class="row mb-5">
                        <div class="col-12">
                          <div class="bg-light-green px-3 py-2 mb-3 rounded-3 d-flex justify-content-between align-items-center">
                            <h5>لقد قمت بتحديد 4 طلاب لإصدار شهاداتهم</h5><a class="btn btn-primary py-2 col-auto" href="">إصدار شهادة</a>
                          </div>
                        </div>
                      </div>
                      <table class="table table-cart mb-3">
                        <thead>
                          <tr>
                            <td>اسم الطالب</td>
                            <td>التفاصيل</td>
                            <td width="30%">إصدار شهادة</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td data-title="اسم الطالب"><span class="d-flex align-items-center">
                                <label class="m-checkbox checkbox-2 mb-0 me-3">
                                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span>
                                </label><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">محمد أمين النصراوي</span></span></td>
                            <td data-title="النتيجة"><span class="d-flex align-items-center"><span class="text-success me-4 h6 mb-0">(96%)</span><a class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center text-dark hover-primary" href="">تفاصيل</a></span></td>
                            <td data-title="مراجعة">
                                <span>
                                    <a href="#" class="btn btn-outline btn-outline-primary btn-active-light-primary rounded p-2">إصدار شهادة</a>
                                    <span class="text-success ms-2"><i class="fa-regular fa-lg fa-check text-success"></i>
                                    </span>
                                </span>
                            </td>
                          </tr>
                          <tr>
                            <td data-title="اسم الطالب"><span class="d-flex align-items-center">
                                <label class="m-checkbox checkbox-2 mb-0 me-3">
                                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span>
                                </label><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">محمد أمين النصراوي</span></span></td>
                            <td data-title="النتيجة"><span class="d-flex align-items-center"><span class="text-success me-4 h6 mb-0">(96%)</span><a class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center text-dark hover-primary" href="">تفاصيل</a></span></td>
                            <td data-title="مراجعة">
                                <span>
                                    <a href="#" class="btn btn-outline btn-outline-primary btn-active-light-primary rounded p-2">إصدار شهادة</a>
                                </span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <ul class="pagination mt-3">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                      </ul>
                    </div>
                  </div>
            </div>
			<!--begin::Content-->
        </div>

    </section>

    @push('front_js')
    <script>
      $(".checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
      });
    </script>
    @endpush
@endsection
