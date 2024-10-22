@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/dropzone.min.css') }}"/>
@endpush


@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row mb-4 justify-content-between align-items-center">
      <div class="col-12">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
          <li class="breadcrumb-item"><a href="#">الـدورات التعليمية</a></li>
          <li class="breadcrumb-item active">اسم الدورة يكتب هنا</li>
        </ol>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
          <h4 class="font-medium"><span class="square me-2"></span> اختبار الوحدة الأولى</h4>
          <div class="remaining-time font-medium d-flex align-items-center"><i class="fa-solid fa-timer me-2"></i>                      متبقي 1:20:33</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3"><span class="square"></span> السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <textarea class="form-control p-3 rounded" rows="10" placeholder="..اكتب نصاً"></textarea>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3"><span class="square"></span> السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <div class="dropzone myDropzone-1"></div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3"><span class="square"></span> السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <textarea class="form-control p-3 rounded" rows="10" placeholder="..اكتب نصاً"></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-between">
          <button class="btn btn-danger">إنهاء المحاولة</button>
          <div class="remaining-time font-medium d-flex align-items-center"><i class="fa-solid fa-timer me-2"></i>                      متبقي 1:20:33</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


@push('front_js')
<script src="{{ asset('assets/front/js/dropzone.min.js') }}"> </script>
<script>
  /*------------------------------------
    Dropzone
  --------------------------------------*/
    if ($(".myDropzone-1").length > 0) {
      var myDropzone = new Dropzone(".myDropzone-1", {
        url: "/file/post",  dictDefaultMessage: `
          <span class='icon me-2'><i class="fa-solid fa-arrow-down-to-line"></i></span><span class='text'>إرفـاق ملفـات</span>`
          ,acceptedFiles: 'image/*'}
        );
    }
</script>
@endpush
