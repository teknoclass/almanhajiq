@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/plyr.css') }}"/>
@endpush


@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-4 justify-content-between align-items-center">
        <div class="col-lg-9">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="#">الـدورات التعليمية</a></li>
            <li class="breadcrumb-item active">تفاصيل الدورة</li>
          </ol>
        </div>
        @include('front.user.courses.components.course_dropdown')
      </div>
      <div class="row mb-2">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-12">
              <audio class="player" controls="">
                <source src="https://ia800905.us.archive.org/19/items/FREE_background_music_dhalius/backsound.mp3" type="audio/mp3"/>
              </audio>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-flex align-items-center border-bottom pb-3 mt-4">
                <div class="col-auto">
                  <div class="symbol symbol-60"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                </div>
                <div class="col ms-3">
                  <h4 class="font-medium">أ. محمد السيلاوي</h4>
                  <h6>مدرب معتمد , مجال التنمية البشرية</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <h4 class="mb-2 font-medium"><span class="square me-1"></span> تفاصيل الدرس</h4>
              <div class="text--muted">
                هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى هذا النص هو مثال
                لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <h4 class="mb-2 font-medium"><span class="square me-1"></span>  {{ __('attachments') }}</h4>
            </div>
            <div class="col-lg-6">
              <div class="widget__item-attac">
                <div class="widget__item-icon"><i class="fas fa-file-pdf fa-2x"></i></div>
                <div class="widget__item-content">
                  <h5 class="widget__item-title">ملف PDF - أنواع الخوارزميات</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="widget__item-attac">
                <div class="widget__item-icon"><img src="{{ asset('assets/front/images/img-01.png') }}" alt=""/></div>
                <div class="widget__item-content">
                  <h5 class="widget__item-title">مهام وواجبات عن انواع الخوارزميات</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-12">
              <h4 class="mb-2 circle-before font-medium"><span class="square me-1"></span> التعليقات</h4>
            </div>
            <div class="col-12 mb-4">
              <div class="widget__item-addComment">
                <input class="form-control" type="text" placeholder="..اكتب تعليقاً"/>
              </div>
            </div>
            <div class="col-12">
              <div class="accordion" id="accordion">
                <div class="widget__item-message bg-white p-3 rounded-2 flex-column">
                  <div class="widget__item-head toggle-message pointer" data-bs-toggle="collapse" data-bs-target="#collapse-1">
                    <div class="d-flex">
                      <div class="widget__item-image symbol symbol-50"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                      <div class="widget__item-content ms-3 border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                          <h5 class="widget__item-name font-medium mb-2">أ.علي الرحباني</h5>
                          <h6 class="widget__item-date">م 11 : 4</h6>
                        </div>
                        <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                      </div>
                    </div>
                  </div>
                  <div class="widget__item-body widget__inner accordion-collapse collapse" id="collapse-1" data-bs-parent="#accordion">
                    <div class="d-flex align-items-center justify-content-between px-2 mt-2">
                      <div class="d-flex align-items-center">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18.286" height="16" viewBox="0 0 18.286 16">
                          <path id="Icon_awesome-reply" data-name="Icon awesome-reply" d="M.3,12.613l6.286,5.428A.858.858,0,0,0,8,17.392V14.533c5.737-.066,10.286-1.215,10.286-6.652a7.3,7.3,0,0,0-2.976-5.5.636.636,0,0,0-1,.665C15.926,8.221,13.539,9.6,8,9.676V6.536a.858.858,0,0,0-1.417-.649L.3,11.316a.857.857,0,0,0,0,1.3Z" transform="translate(0 -2.25)" fill="#212F3E"></path>
                        </svg>
                        <h6 class="font-medium">3 ردود</h6>
                      </div><a class="text-dark" href=""><i class="fas fa-plus me-2"></i>اضافه رد جديد</a>
                    </div>
                    <div class="pe-4 pt-4">
                      <div class="d-flex mb-4">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <input class="form-control h-auto py-2 bg-transparent border-0 border-bottom rounded-0" type="text" placeholder=".. اكتب رد "/>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="widget__item-message bg-white p-3 rounded-2 flex-column">
                  <div class="widget__item-head toggle-message pointer" data-bs-toggle="collapse" data-bs-target="#collapse-2">
                    <div class="d-flex">
                      <div class="widget__item-image symbol symbol-50"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                      <div class="widget__item-content ms-3 border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                          <h5 class="widget__item-name font-medium mb-2">أ.علي الرحباني</h5>
                          <h6 class="widget__item-date"> 11 : 4 م</h6>
                        </div>
                        <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                      </div>
                    </div>
                  </div>
                  <div class="widget__item-body widget__inner accordion-collapse collapse" id="collapse-2" data-bs-parent="#accordion">
                    <div class="d-flex align-items-center justify-content-between px-2 mt-2">
                      <div class="d-flex align-items-center">
                        <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18.286" height="16" viewBox="0 0 18.286 16">
                          <path id="Icon_awesome-reply" data-name="Icon awesome-reply" d="M.3,12.613l6.286,5.428A.858.858,0,0,0,8,17.392V14.533c5.737-.066,10.286-1.215,10.286-6.652a7.3,7.3,0,0,0-2.976-5.5.636.636,0,0,0-1,.665C15.926,8.221,13.539,9.6,8,9.676V6.536a.858.858,0,0,0-1.417-.649L.3,11.316a.857.857,0,0,0,0,1.3Z" transform="translate(0 -2.25)" fill="#212F3E"></path>
                        </svg>
                        <h6 class="font-medium">3 ردود</h6>
                      </div><a class="text-dark" href=""><i class="fas fa-plus me-2"></i>اضافه رد جديد</a>
                    </div>
                    <div class="pe-4 pt-4">
                      <div class="d-flex mb-4">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <input class="form-control h-auto py-2 bg-transparent border-0 border-bottom rounded-0" type="text" placeholder=".. اكتب رد "/>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                      <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                        <div class="widget__item-image symbol symbol-30"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                          <div class="d-flex align-items-center justify-content-between">
                            <h6 class="widget__item-name font-medium mb-0">أ.علي الرحباني</h6>
                            <h6 class="widget__item-date"> 11 : 4 م</h6>
                          </div>
                          <h5 class="widget__item-desc text--muted">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                      </div>
                    </div>
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


@push('front_js')
    <script src="{{ asset('assets/front/js/plyr.polyfilled.js') }}"> </script>

    <script>
        /*------------------------------------
        player
        --------------------------------------*/
        if ($(".player").length) {
        new Plyr(".player");
        }
  </script>
@endpush
