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
							<h2 class="font-medium text-start mb-3">التقييمات</h2>
							<div class="py-2">
                                @for ($i = 0; $i < 5; $i++)

								<div class="bg-light-green py-2 px-3 rounded-3 d-flex align-items-start mb-3">
									<div class="col">
										<div class="d-flex align-items-center">
											<div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></div>
											<div class="ms-3">
												<h5 class="mb-2">عبدلله المقوسي</h5>
												<div class="data-rating d-flex align-items-center mb-2 rating-sm">
                                                    <span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                                                    </span>
                                                </div>
												<h6 class="text-muted">❤ دورة أفادتني كثير و أستاذ أكثر من رائع ، مشكور و يعطيك ألف عافية </h6>
											</div>
										</div>
									</div>
									<div class="col-auto">
										<h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="#" class="btn btn-outline btn-outline-success btn-active-light-success rounded p-2">نشر</a>
                                            </div>
                                            <div class="col-6">
                                                <a href="#" class="btn btn-outline btn-outline-danger btn-active-light-danger rounded p-2">حذف</a>
                                            </div>

                                        </div>

									</div>
								</div>
                                @endfor
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--end::Content-->
		</div>
	</section>
@endsection
