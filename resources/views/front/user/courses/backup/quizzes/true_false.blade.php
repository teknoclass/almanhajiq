@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])

@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
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
          <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <div class="d-flex flex-column item-answer">
            <label class="m-radio mb-3">
              <input type="radio" name="radio"/><span class="checkmark"></span><span class="ms-2">صح</span>
            </label>
            <label class="m-radio mb-0">
              <input type="radio" name="radio"/><span class="checkmark"></span><span class="ms-2">حطأ</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3">السؤال الثاني : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <div class="d-flex flex-column item-answer">
            <label class="m-radio mb-3">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">صح</span>
            </label>
            <label class="m-radio mb-0">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">حطأ</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3">السؤال الثالث : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <div class="d-flex flex-column item-answer">
            <label class="m-radio mb-3">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">صح</span>
            </label>
            <label class="m-radio mb-0">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">حطأ</span>
            </label>
          </div>
        </div>
      </div>
      <div class="col-12 mb-3">
        <div class="bg-white rounded-2 p-3 item-question">
          <h5 class="font-medium mb-3">السؤال الرابع : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
          <div class="d-flex flex-column item-answer">
            <label class="m-radio mb-3">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">صح</span>
            </label>
            <label class="m-radio mb-0">
              <input type="radio" name="radio2"/><span class="checkmark"></span><span class="ms-2">حطأ</span>
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
</section>
@endsection
