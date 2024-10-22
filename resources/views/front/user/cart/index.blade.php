@extends('front.layouts.index', ['is_active' => 'cart', 'sub_title' => 'السلة'])

@section('content')
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<div class="row mb-lg-4">
				<div class="col-12">
					<ol class="breadcrumb mb-lg-0">
						<li class="breadcrumb-item"><a href="{{ route('user.home.index') }}">الرئيسية</a></li>
						<li class="breadcrumb-item active">الســلة</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 mb-4 mb-lg-0">
					<div class="bg-white rounded-15 py-4 px-3">
						<h4 class="font-medium text-center text-primary mb-3">تفاصيــل الطلب</h4>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<h3>عدد المنتجات</h3>
							<h3>3</h3>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<h3>المبلغ الكلي</h3>
							<h3>123$</h3>
						</div>
						<div class="d-flex align-items-center justify-content-between mb-3">
							<div class="col-6">
								<h6>لديـك كوبـون تخفيض ؟</h6>
							</div>
							<div class="col-6">
								<input class="form-control h-auto py-1 px-3" type="text" placeholder="أدخل الكود" />
							</div>
						</div>
						<hr />
						<div class="mb-3"> <a class="btn btn-primary w-100 mb-3" href="{{ route('user.payment.index') }}">دفع </a><a
								class="btn btn-primary-2 w-100" href="{{ route('courses.index') }}">أكمل تصفح الدورات </a></div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="widget_item-cart d-lg-flex align-items-center mb-3">
						<div class="widget_item-delete"><i class="fa-solid fa-trash"></i></div>
						<div class="col-auto">
							<div class="widget_item-image mb-3 mb-lg-0"><a href=""><img src="{{ asset('assets/front/images/img-04.png') }}"
										alt="" loading="lazy"/></a></div>
						</div>
						<div class="col-lg-7">
							<div class="widget_item-content px-lg-4">
								<h2 class="widget_item-title font-bold mb-1"><a href=""> اسم الدورة يكتب هنا</a></h2>
								<h5 class="mb-3 text-muted">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص في مولد
									النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى </h5>
								<h3 class="text-white font-bold rounded-pill bg-primary px-3 d-inline-block">$45</h3>
								<hr />
								<div class="d-flex">
									<div class="col-5">
										<h3>المبلغ الكلي</h3>
									</div>
									<div class="col-5">
										<h3>$90</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="widget_item-cart d-lg-flex align-items-center mb-3">
						<div class="widget_item-delete"><i class="fa-solid fa-trash"></i></div>
						<div class="col-auto">
							<div class="widget_item-image mb-3 mb-lg-0"><a href=""><img src="{{ asset('assets/front/images/img-03.png') }}"
										alt="" loading="lazy"/></a></div>
						</div>
						<div class="col-lg-7">
							<div class="widget_item-content px-lg-4">
								<h2 class="widget_item-title font-bold mb-1"><a href=""> اسم الدورة يكتب هنا</a></h2>
								<h5 class="mb-3 text-muted">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص في مولد
									النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى </h5>
								<h3 class="text-white font-bold rounded-pill bg-primary px-3 d-inline-block">$45</h3>
								<hr />
								<div class="d-flex">
									<div class="col-5">
										<h3>المبلغ الكلي</h3>
									</div>
									<div class="col-5">
										<h3>$90</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="widget_item-cart d-lg-flex align-items-center mb-3">
						<div class="widget_item-delete"><i class="fa-solid fa-trash"></i></div>
						<div class="col-auto">
							<div class="widget_item-image mb-3 mb-lg-0"><a href=""><img src="{{ asset('assets/front/images/img-02.png') }}"
										alt="" loading="lazy"/></a></div>
						</div>
						<div class="col-lg-7">
							<div class="widget_item-content px-lg-4">
								<h2 class="widget_item-title font-bold mb-1"><a href=""> اسم الدورة يكتب هنا</a></h2>
								<h5 class="mb-3 text-muted">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص في مولد
									النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى </h5>
								<h3 class="text-white font-bold rounded-pill bg-primary px-3 d-inline-block">$45</h3>
								<hr />
								<div class="d-flex">
									<div class="col-5">
										<h3>المبلغ الكلي</h3>
									</div>
									<div class="col-5">
										<h3>$90</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end:: section -->
@endsection
