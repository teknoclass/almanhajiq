@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])


@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
  <div class="container py-lg-5 my-lg-5">
    <div class="row">
      <div class="col-lg-4 mx-auto">
        <div class="image text-center mb-5"><img src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy"/></div>
        <div class="text-center">
          <h2 class="font-bold mb-2 color-general">! أحسنت</h2>
          <h4 class="mb-4">تم حل 8 إجابة صحيحة من أصل 10 سؤال</h4>
          <h4 class="mb-4">إجتياز بنسبة    <span class="text-success">( 80% )</span></h4><a class="btn btn-primary w-100 mb-3" href="">مراجعة الحل </a><a class="btn btn-outline-primary w-100" href=""><i class="fa-solid fa-down-to-bracket me-2"></i>إصدار الشهادة </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
