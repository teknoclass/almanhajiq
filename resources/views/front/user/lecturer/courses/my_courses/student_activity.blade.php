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

    @push('front_js')
    <link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}"/>
    @endpush
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
                      <h2 class="font-medium text-start mb-3">نشاط الطلاب</h2>
                      <table class="table table-cart mb-3">
                        <thead>
                          <tr>
                            <td>اسم الطالب</td>
                            <td width="40%">نسبة التفاعل</td>
                            <td>التفاصيل</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td data-title="اسم الطالب"><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">محمد أمين النصراوي</span></span></td>
                            <td data-title="النتيجة"><span class="d-flex align-items-center"><span class="text-success me-3 h6 mb-0">(96%)</span>
                                <div class="progress w-200 h-16">
                                  <div class="progress-bar pt-1 bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                </div></span></td>
                            <td data-title="مراجعة"><a class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center text-dark hover-primary" href="" data-bs-toggle="modal" data-bs-target="#Modal">تفاصيل</a></td>
                          </tr>
                          <tr>
                            <td data-title="اسم الطالب"><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">محمد أمين النصراوي</span></span></td>
                            <td data-title="النتيجة"><span class="d-flex align-items-center"><span class="text-danger me-3 h6 mb-0">(96%)</span>
                                <div class="progress w-200 h-16">
                                  <div class="progress-bar pt-1 bg-danger" role="progressbar" style="width: 55%;" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100">55%</div>
                                </div></span></td>
                            <td data-title="مراجعة"><a class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center text-dark hover-primary" href="">تفاصيل</a></td>
                          </tr>
                          <tr>
                            <td data-title="اسم الطالب"><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">محمد أمين النصراوي</span></span></td>
                            <td data-title="النتيجة"><span class="d-flex align-items-center"><span class="text-warning me-3 h6 mb-0">(96%)</span>
                                <div class="progress w-200 h-16">
                                  <div class="progress-bar pt-1 bg-warning" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                                </div></span></td>
                            <td data-title="مراجعة"><a class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center text-dark hover-primary" href="" data-bs-toggle="modal" data-bs-target="#Modal">تفاصيل</a></td>
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
			</div>
            <div class="modal fade" id="Modal">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 rounded-10">
                  <div class="modal-body p-4 scroll ps ps__rtl ps--active-y" style="max-height: 600px;">
                    <h2 class="mb-3 text-center font-bold">نشاط الطالب</h2>
                    <div class="d-lg-flex align-items-center justify-content-between">
                      <div class="col-lg-6">
                        <div class="d-flex align-items-center mb-3">
                          <div class="col-auto">
                            <div class="symbol symbol-50"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></div>
                          </div>
                          <h4 class="font-medium ms-2">أ. محمد السيلاوي</h4>
                        </div>
                      </div>
                      <div class="col-lg-5 mx-auto">
                        <div class="d-flex align-items-center">
                          <h5 class="me-3">(80%)</h5>
                          <div class="progress w-100">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="bg-light-blue rounded p-4">
                      <div class="row">
                        <div class="col-lg-4 col-sm-6">
                          <div class="text-center mb-3 mb-lg-0">
                            <div class="circleProgress_1 circleProgress mb-4"></div>
                            <h4>أكمل<span class="font-semi-bold">3 دورات </span>من أصل 5</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                          <div class="text-center mb-3 mb-lg-0">
                            <div class="circleProgress_2 circleProgress mb-4"></div>
                            <h4>أنهى<span class="font-semi-bold">3 دورات </span>من أصل 5</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                          <div class="text-center mb-3 mb-lg-0">
                            <div class="circleProgress_3 circleProgress mb-4"></div>
                            <h4>شاهد<span class="font-semi-bold">3 دورات </span>من أصل 5</h4>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row py-3">
                      <div class="col-12">
                        <h4 class="my-2 font-medium"><span class="square me-2"></span> محتويات تمت مشاهدتها</h4>
                      </div>
                      <div class="col-lg-12">
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                          <div class="col-auto">
                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                          </div>
                          <div class="col"><a class="d-flex align-items-center col-auto" href="">
                              <p class="me-2">مخططات سير العمليات ذات التفرعات</p></a></div>
                          <div class="col-auto">
                            <div class="d-flex align-items-center">
                              <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                              <p class="pt-1 text--muted col-auto">04 \ 11 \ 2021</p>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between mb-3 align-items-center">
                          <div class="col-auto">
                            <div class="icon-chevron me-1 d-flex"><i class="fa-solid fa-circle-chevron-left"></i></div>
                          </div>
                          <div class="col"><a class="d-flex align-items-center col-auto" href="">
                              <p class="me-2">مخططات سير العمليات ذات التفرعات</p></a></div>
                          <div class="col-auto">
                            <div class="d-flex align-items-center">
                              <div class="icon-clock me-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                              <p class="pt-1 text--muted col-auto">04 \ 11 \ 2021</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--end::Content-->

		</div>
	</section>

    @push('front_js')

    <script src="{{ asset('assets/front/js/jquery.circle-progress.min.js') }}"> </script>
    <script>
      $(".circleProgress_1").circleProgress({
        max: 100,
        value: 80,
        textFormat: "percent",
      });

      $(".circleProgress_2").circleProgress({
        max: 100,
        value: 30,
        textFormat: "percent",
      });

      $(".circleProgress_3").circleProgress({
        max: 100,
        value: 60,
        textFormat: "percent",
      });
    </script>
    @endpush
@endsection
