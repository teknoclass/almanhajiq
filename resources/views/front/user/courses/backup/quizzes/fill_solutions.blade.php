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
              <h4 class="font-medium"><span class="square me-2"></span> اختبار الوحدة الأولى</h4>
              <div class="result-question font-medium d-flex align-items-center"><i class="fa-solid fa-timer me-2"></i>النتيجة: 7/10</div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer success">
                    <input class="form-control" type="text" placeholder="إكتب هنا" value="الاجابة"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer success">
                    <input class="form-control" type="text" placeholder="إكتب هنا" value="الاجابة"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer success">
                    <input class="form-control" type="text" placeholder="إكتب هنا"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer success">
                    <input class="form-control" type="text" placeholder="إكتب هنا" value="الاجابة"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer success">
                    <input class="form-control" type="text" placeholder="إكتب هنا" value="الاجابة"/>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <div class="bg-white rounded-2 p-3 item-question">
              <h5 class="font-medium mb-3">السؤال الأول : هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى؟</h5>
              <div class="row">
                <div class="col-lg-5">
                  <div class="input-question input-answer error">
                    <input class="form-control" type="text" placeholder="إكتب هنا" value="الاجابة"/>
                  </div>
                </div>
                <div class="col-lg-5 text-end ms-auto">
                  <h6 class="font-medium py-2 px-4 text-success bg-light-green-2 d-inline-block rounded-2"><span class="py-1 d-block">التّصحيح : تكتب الإجابة الصحيحة</span></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('front.user.courses.chapters.partials.course_widget')

    </div>
  </div>
</section>
@endsection
