@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])

@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row mb-4 justify-content-between align-items-center">
      <div class="col-lg-9">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
          <li class="breadcrumb-item"><a href="#">الـدورات التعليمية</a></li>
          <li class="breadcrumb-item active">اسم الدورة يكتب هنا</li>
        </ol>
      </div>
      @include('front.user.courses.components.course_dropdown')
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="row mb-3">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
              <h4 class="font-medium"><span class="square ms-2"></span> اختبار الوحدة الأولى</h4>
              <div class="result-question font-medium d-flex align-items-center"><i class="fa-solid fa-timer me-2"></i>النتيجة: 7/10</div>
            </div>
          </div>
        </div>
        <div class="row exam-question-solutions">
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="d-flex flex-column item-answer">
                <label class="m-radio mb-3">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">صح</span>
                </label>
                <label class="m-radio mb-0 answer-error">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">حطأ</span>
                </label>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="d-flex flex-column item-answer">
                <label class="m-radio mb-3 answer-success">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">صح</span>
                </label>
                <label class="m-radio mb-0">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">حطأ</span>
                </label>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="d-flex flex-column item-answer">
                <label class="m-radio mb-3 answer-success">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">صح</span>
                </label>
                <label class="m-radio mb-0">
                  <input type="radio" name="radio" disabled="disabled"/><span class="checkmark"></span><span class="me-2">حطأ</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
              <button class="btn btn-danger">إنهاء المحاولة</button>
              <div class="remaining-time font-medium d-flex align-items-center"><i class="fa-solid fa-timer ms-2"></i>                      متبقي 1:20:33</div>
            </div>
          </div>
        </div>
      </div>

      @include('front.user.courses.chapters.partials.course_widget')

    </div>
  </div>
</section>
@endsection
