@extends('front.layouts.index', ['is_active' => 'lecturer_profile', 'sub_title' => 'Lecturer Name'])

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}"/>
@endpush

@section('content')
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<div class="row mb-4">
				<div class="col-12">
					<ol class="breadcrumb mb-0">
						<li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
						<li class="breadcrumb-item"><a href="#">الـدورات التعليمية</a></li>
						<li class="breadcrumb-item active">بيانات المدرب</li>
					</ol>
				</div>
			</div>
			<div class="row mb-4">
				<div class="col-12">
					<div class="bg-white p-4 rounded-15">
						<div class="row">
							<div class="col-lg-3">
								<div class="bg-light-green rounded-15 px-3 py-5 text-center">
									<div class="symbol symbol-120 mb-3"><img class="rounded-circle"
											src="{{ asset('assets/front/images/avatar.png') }}" alt="" />
									</div>
									<h4 class="font-medium mb-1">أ. محمد السيلاوي</h4>
									<h6 class="text-muted mb-2">مدرب معتمد </h6>
									<div class="data-rating d-flex align-items-center justify-content-center"><span class="d-flex"
											data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
												class="far fa-star"></i><i class="far fa-star"></i></span><span class="pt-1">(4.2)</span></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="bg-light-green rounded-15 p-3 mb-3">
									<div class="mb-1">
										<h5 class="font-medium">نبذة مختصرة</h5>
										<h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن
											تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى في نفس المساحة،
											لقد هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك
											أن تولد </h6>
									</div>
									<div class="mb-1 d-flex align-items-center justify-content-between">
										<div class="d-flex flex-column">
											<h5 class="font-medium">بيانات التواصل</h5>
											<ul class="social-media social-dark">
												<li><a class="tw" href=""><i class="fa-brands fa-twitter"> </i></a></li>
												<li><a class="fa" href=""><i class="fa-brands fa-facebook-f"></i></a></li>
												<li><a class="yo" href=""><i class="fa-brands fa-youtube"></i></a></li>
												<li><a class="in" href=""><i class="fa-brands fa-instagram"></i></a></li>
											</ul>
										</div><a class="btn btn-success py-1 px-2" href="" data-bs-toggle="modal"
											data-bs-target="#ModalMessage"><i class="fa-solid fa-comment-dots me-1"></i>حجز درس خصوصي </a>
									</div>
								</div>
								<div class="row row-cols-6 row-cols-md-3 row-cols-lg-5 gx-lg-2">
									<div class="col">
										<div class="bg-light-green mb-3 text-center rounded-10 py-3">
											<h3 class="font-medium mb-2">142</h3>
											<h6>الإشتراكات</h6>
										</div>
									</div>
									<div class="col">
										<div class="bg-light-green mb-3 text-center rounded-10 py-3">
											<h3 class="font-medium mb-2">142</h3>
											<h6>الإشتراكات</h6>
										</div>
									</div>
									<div class="col">
										<div class="bg-light-green mb-3 text-center rounded-10 py-3">
											<h3 class="font-medium mb-2">142</h3>
											<h6>الإشتراكات</h6>
										</div>
									</div>
									<div class="col">
										<div class="bg-light-green mb-3 text-center rounded-10 py-3">
											<h3 class="font-medium mb-2">142</h3>
											<h6>الإشتراكات</h6>
										</div>
									</div>
									<div class="col">
										<div class="bg-light-green mb-3 text-center rounded-10 py-3">
											<h3 class="font-medium mb-2">142</h3>
											<h6>الإشتراكات</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="position-relative image-coach"><img src="{{ asset('assets/front/images/man3.png') }}"
										alt="" /><a class="btn-play-video" href="https://www.youtube.com/embed/tgbNymZ7vqY" data-fancybox=""><i
											class="fa-solid fa-play"></i></a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-12">
					<div class="row mb-4 justify-content-between align-items-center">
						<div class="col-lg-9">
							<h2 class="font-bold">الدورات (13)</h2>
						</div>
						<div class="col-lg-2">
							<select class="selectpicker rounded-pill" data-style="rounded-pill" title="عرض الكل">
								<option>دروسي الخصوصية</option>
								<option>محادثاتي</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="row">
						<div class="col-lg-4">
							<div class="widget_item-blog mb-4">
								<div class="widget-discount">34$</div>
								<div class="widget_item-image">
									<div class="widget_item-category">علوم الحاسوب</div><a href=""><img
											src="{{ asset('assets/front/images/img-01') }}.png" alt="" /></a>
								</div>
								<div class="widget_item-content p-3">
									<div class="d-flex mb-2">
										<div class="col">
											<h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
										</div>
										<div class="col-auto">
											<h6 class="font-medium"><i class="circle"> </i><i class="circle"> </i>مبتدئ</h6>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<h6 class="text-muted"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
										<h6 class="widget_item-tag">مسجّلة</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="widget_item-blog mb-4">
								<div class="widget_item-image">
									<div class="widget_item-category">علوم الحاسوب</div><a href=""><img
											src="{{ asset('assets/front/images/img-02') }}.png" alt="" /></a>
								</div>
								<div class="widget_item-content p-3">
									<div class="d-flex mb-2">
										<div class="col">
											<h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
										</div>
										<div class="col-auto">
											<h6 class="font-medium"><i class="circle"> </i><i class="circle"> </i>مبتدئ</h6>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<h6 class="text-muted"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
										<h6 class="widget_item-tag">مسجّلة</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="widget_item-blog mb-4">
								<div class="widget_item-image">
									<div class="widget_item-category">علوم الحاسوب</div><a href=""><img
											src="{{ asset('assets/front/images/img-03') }}.png" alt="" /></a>
								</div>
								<div class="widget_item-content p-3">
									<div class="d-flex mb-2">
										<div class="col">
											<h5 class="font-medium widget_item-title"><a href=""> اسم الدورة يكتب هنا</a></h5>
										</div>
										<div class="col-auto">
											<h6 class="font-medium"><i class="circle"> </i><i class="circle"> </i>مبتدئ</h6>
										</div>
									</div>
									<div class="d-flex align-items-center justify-content-between">
										<h6 class="text-muted"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
										<h6 class="widget_item-tag">مسجّلة</h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="text-center"> <a class="btn btn-primary" href="">عرض المزيد </a></div>
					</div>
				</div>
			</div>
			<div class="row mt-5 mb-4 pt-4">
				<div class="col-12">
					<h2 class="font-bold mb-3">التقييمات (27)</h2>
				</div>
				<div class="col-lg-6">
					<div class="bg-white py-2 px-3 rounded-3 d-flex align-items-start mb-3">
						<div class="col">
							<div class="d-flex align-items-center">
								<div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" />
								</div>
								<div class="ms-3">
									<h5 class="mb-2">عبدلله المقوسي</h5>
									<div class="data-rating d-flex align-items-center mb-2 rating-sm"><span class="d-flex" data-rating="3"><i
												class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
												class="far fa-star"></i><i class="far fa-star"></i></span></div>
									<h6 class="text-muted">❤ دورة أفادتني كثير و أستاذ أكثر من رائع ، مشكور و يعطيك ألف عافية </h6>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</h6>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="bg-white py-2 px-3 rounded-3 d-flex align-items-start mb-3">
						<div class="col">
							<div class="d-flex align-items-center">
								<div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" />
								</div>
								<div class="ms-3">
									<h5 class="mb-2">عبدلله المقوسي</h5>
									<div class="data-rating d-flex align-items-center mb-2 rating-sm"><span class="d-flex" data-rating="3"><i
												class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
												class="far fa-star"></i><i class="far fa-star"></i></span></div>
									<h6 class="text-muted">❤ دورة أفادتني كثير و أستاذ أكثر من رائع ، مشكور و يعطيك ألف عافية </h6>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</h6>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="bg-white py-2 px-3 rounded-3 d-flex align-items-start mb-3">
						<div class="col">
							<div class="d-flex align-items-center">
								<div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" />
								</div>
								<div class="ms-3">
									<h5 class="mb-2">عبدلله المقوسي</h5>
									<div class="data-rating d-flex align-items-center mb-2 rating-sm"><span class="d-flex" data-rating="3"><i
												class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
												class="far fa-star"></i><i class="far fa-star"></i></span></div>
									<h6 class="text-muted">❤ دورة أفادتني كثير و أستاذ أكثر من رائع ، مشكور و يعطيك ألف عافية </h6>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</h6>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="bg-white py-2 px-3 rounded-3 d-flex align-items-start mb-3">
						<div class="col">
							<div class="d-flex align-items-center">
								<div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" />
								</div>
								<div class="ms-3">
									<h5 class="mb-2">عبدلله المقوسي</h5>
									<div class="data-rating d-flex align-items-center mb-2 rating-sm"><span class="d-flex" data-rating="3"><i
												class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
												class="far fa-star"></i><i class="far fa-star"></i></span></div>
									<h6 class="text-muted">❤ دورة أفادتني كثير و أستاذ أكثر من رائع ، مشكور و يعطيك ألف عافية </h6>
								</div>
							</div>
						</div>
						<div class="col-auto">
							<h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>06 \ 12 \ 2022</h6>
						</div>
					</div>
				</div>
				<div class="col-12 mt-3">
					<div class="text-center"> <a class="btn btn-primary" href="">عرض المزيد </a></div>
				</div>
			</div>
		</div>
	</section>
	<!-- Modal -->
	<div class="modal fade" id="ModalMessage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body">
					<h2 class="font-bold mb-4 text-center">حجز درس خصوصي</h2>
					<div class="message-header d-flex align-items-center">
						<div class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" />
						</div>
						<h5 class="font-medium text-white ms-3">أ. محمد السيلاوي</h5>
					</div>
					<div class="scroll message-body">
						<div class="message-list">
							<div class="message-item sender">
								<div class="message-image symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" /></div>
								<div class="message-content">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
									النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص
									الأخرى في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،</div>
							</div>
							<div class="message-item receiver">
								<div class="message-image symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" /></div>
								<div class="message-content">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
									النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص
									الأخرى في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،</div>
							</div>
							<div class="message-item sender">
								<div class="message-image symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" /></div>
								<div class="message-content">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
									النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص
									الأخرى في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،</div>
							</div>
							<div class="message-item receiver">
								<div class="message-image symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}"
										alt="" /></div>
								<div class="message-content">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد
									النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص
									الأخرى في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى،</div>
							</div>
						</div>
					</div>
					<div class="message-footer">
						<form class="d-flex align-items-center" action="">
							<input class="form-control" placeholder="الرسالة" />
							<button class="btn p-1 text-white" type="submit"><i class="fa-solid fa-paper-plane-top"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('front_js')

<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script>
  /*------------------------------------
    PerfectScrollbar
  --------------------------------------*/
  $('.scroll').each(function () {
    const ps = new PerfectScrollbar($(this)[0]);
  });
</script>
@endpush
