@extends('front.layouts.index', ['is_active' => 'certificate', 'sub_title' => 'اصدار الشهادة'])

@section('content')
	<!-- start:: section -->
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-lg-5 my-lg-5">
          <div class="row">
            <div class="col-lg-5 mx-auto">
              <div class="image text-center mb-5"><img src="{{ asset('assets/front/images/certificate.png') }}" alt="" loading="lazy"/></div>
              <div class="text-center">
                <h1 class="font-bold mb-2 color-general">لا يمكن إصدار الشهادة</h1>
                <h4 class="mb-4">تعذر اصدار الشهادة , يبدوا انك لم تنهي جميع الدورس في منهج الدورة</h4>
                <a class="btn btn-primary w-100" href="#">رجـــوع </a>
              </div>
            </div>
          </div>
        </div>
      </section>
	<!-- end:: section -->
@endsection
