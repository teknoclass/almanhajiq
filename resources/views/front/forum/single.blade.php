@extends('front.layouts.index', ['is_active'=>'forum','sub_title'=>'المنتدى ', ])

@section('content')
<div class="forum-header">
    <div class="container">
      <div class="text-center"> <img src="{{ asset('assets/front/images/logo-forum.png') }}" alt="" loading="lazy"/></div>
    </div>
</div>
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-lg-4">
        <div class="col-12">
          <div class="d-flex align-items-center">
            <h3 class="font-medium">الموضوع : </h3>
            <h3 class="font-medium text-primary px-1">هذا النص هو مثال لنص</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="widget_item-forum mb-3">
            <div class="widget_item-head d-flex align-items-center justify-content-between p-3">
              <div class="d-flex align-items-center">
                <h3 class="widget_item-title font-bold text-white">1\1\2023  ,  </h3>
                <h3 class="widget_item-title font-bold text-white"> 12:43 pm</h3>
              </div>
              <h3 class="widget_item-title font-bold text-white">#1</h3>
            </div>
            <div class="widget_item-body p-3 p-lg-4">
              <div class="row">
                <div class="col-lg-3 text-center">
                  <div class="symbol symbol-180 mb-4"><img class="rounded-30" src="{{ asset('assets/front/images/man3.png') }}" alt="" loading="lazy"/></div>
                  <h4 class="font-bold mb-2">عبد الله الهلالي</h4>
                  <h6 class="font-size-12 mb-2">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                  <h5 class="font-bold font-size-12 text-primary">90 مشاهدة ,  56  مشاركة</h5>
                </div>
                <div class="col-lg-9">
                  <h5 class="mb-3">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                  <h5 class="mb-3">إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.</h5>
                  <h5 class="mb-3">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                  <h5 class="mb-3">إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.</h5>
                </div>
              </div>
            </div>
            <div class="widget_item-footer">
              <div class="text-end">
                <button class="btn p-1 font-bold d-flex align-items-center justify-content-end ms-auto" data-bs-toggle="modal" data-bs-target="#messageModal"><i class="fa-solid fa-message-lines me-2"></i>رد</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Modal-->
  <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-30">
        <div class="modal-body p-lg-4">
          <div class="text-end mb-2">
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="">
            <div class="form-group">
              <textarea class="form-control p-3" rows="14" placeholder="أكتب الرد"></textarea>
            </div>
            <div class="form-group text-center">
              <button class="btn btn-primary font-bold">أرسل</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<!-- end:: section -->
@endsection
