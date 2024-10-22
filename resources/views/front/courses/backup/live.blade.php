@extends('front.layouts.index', ['is_active'=>'courses','sub_title'=>'دورة تدريبية مباشرة', ])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/star-rating.min.css') }}"/>
@endpush

@section('content')
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    @auth
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
        </div>
    @else
        <div class="container">
        <div class="row mb-3">
            <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active">جميـع الإشعـارات</li>
                </ol>
                <a class="btn btn-primary rounded-pill" href="">سجّـل الآن</a>
            </div>
            </div>
        </div>
        </div>
    @endauth
    <div class="container">
      <div class="row mb-4">
        <div class="col-12">
          <div class="bg-video position-relative" style="background: url({{ asset('assets/front/images/bg-video.png') }});background-repeat: no-repeat;background-size: cover;">
            <div class="widget-discount widget-lg">34$</div>
            <div class="position-relative d-inline-block"><img class="img-video" src="{{ asset('assets/front/images/img-video.png') }}" alt=""/><a class="btn-play-video" href="https://www.youtube.com/embed/tgbNymZ7vqY" data-fancybox=""><i class="fa-solid fa-play"></i></a></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container position-sticky top-0 z-index-2">
      <div class="row">
        <div class="col-12">
          <ul class="nav nav-tabs justify-content-center bg-white rounded nav-course py-2 mb-4 border-0" id="myTab" role="tablist">
            <li class="nav-item">
              <button class="nav-link active" data-scroll="tab-1">معلومات الدورة</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-scroll="tab-2">محتوى الدورة</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-scroll="tab-3">المدرب</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-scroll="tab-4">آخر التقييمات</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-scroll="tab-5">الأسئلة الشائعة</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-scroll="tab-6">التسجيل بالدورة</button>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-1">
      <div class="row mb-4">
        <div class="col-lg-8">
          <h2 class="font-bold">اسم الدورة يكتب هنا</h2>
        </div>
        <div class="col-lg-4 text-end">
            @if (auth('web')->check())
            <button class="btn btn-primary rounded-pill" disabled>تم الإشتراك</button>
            @else
            <button class="btn btn-primary rounded-pill">إشتراك</button>
            @endif
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div class="data-rating d-flex align-items-center mb-4 mt-2 mt-lg-0"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span>
            <div class="number-rating me-1">5.0</div>
          </div>
          <h5 class="bg-white rounded p-4 lh-lg">
            هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى لقد تم توليد هذا النص من مولد العربية حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى لقد تم توليد هذا النص من مولد النص العربى حيث يمكنك أن تولد النصوص الأخرى  النص هو مثال لنص يمكن أن يستبدل بنفس المساحة، لقد تم توليد هذا النص
            من مولد النص العربى حيث يمكنك أن تولد مثل هذا النص العربي
          </h5>
        </div>
        <div class="col-lg-4">
          <div class="bg-white rounded p-4">
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/calender.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> تاريخ البدء : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>11/10/2022</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/clock.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> المدة : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>ثلاثة شهور</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/user.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted">   عدد المشتركين  : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>122</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/file.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> عدد الدروس  : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>20 درس</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/skill-level') }}.svg" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> المستوى  : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>متقدم</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/earth.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> اللغة  : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>العربية</h5>
              </div>
            </div>
            <div class="d-flex align-items-center mb-4 pb-lg-3">
              <div class="col-7">
                <div class="d-flex align-items-center">
                  <div class="me-4">
                    <div class="c-icon"><img src="{{ asset('assets/front/images/svg/user.svg') }}" alt=""/></div>
                  </div>
                  <h4 class="text-muted"> العمر  : </h4>
                </div>
              </div>
              <div class="col-5">
                <h5>10 - 17</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">ماذا سوف تتعلم من هذه الدورة ؟</h3>
            </div>
            <div class="card-body p-4">
              <div class="list-desc">
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2"><img src="{{ asset('assets/front/images/svg/check.svg') }}" alt=""/></div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2"><img src="{{ asset('assets/front/images/svg/check.svg') }}" alt=""/></div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2"><img src="{{ asset('assets/front/images/svg/check.svg') }}" alt=""/></div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2"><img src="{{ asset('assets/front/images/svg/check.svg') }}" alt=""/></div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">لمن هذه الدورة ؟ </h3>
            </div>
            <div class="card-body p-4">
              <div class="list-desc">
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2">
                    <div class="square"></div>
                  </div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2">
                    <div class="square"></div>
                  </div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2">
                    <div class="square"></div>
                  </div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2">
                    <div class="square"></div>
                  </div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <div class="col-auto me-2">
                    <div class="square"></div>
                  </div>
                  <div class="col">
                    <h5 class="font-medium">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-2">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">المواعيد المتاحة</h3>
            </div>
            <div class="card-body p-4 p-lg-5">
              <table class="table table-appointments">
                <thead>
                  <tr>
                    <td></td>
                    <td>الثلاثاء 27 أكتوبر</td>
                    <td>الأربعاء 28 أكتوبر</td>
                    <td>الخميس 29 أكتوبر</td>
                    <td>الجمعة 30 أكتوبر</td>
                    <td>السبت 31 أكتوبر</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>2:30 pm</td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                  </tr>
                  <tr>
                    <td>2:30 pm</td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                  </tr>
                  <tr>
                    <td>2:30 pm</td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                  </tr>
                  <tr>
                    <td>2:30 pm</td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                    <td>
                      <div class="item-selectClass active">إختر الصف</div>
                    </td>
                    <td>
                      <div class="item-selectClass"></div>
                    </td>
                  </tr>
                  <!--
                  <tr>
                  <td>2:30 pm</td>
                  <td>4:30 pm</td>
                  <td>5:30 pm</td>
                  <td>7:30 pm</td>
                  </tr>


                  -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-2">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">محتـوى الـدورة</h3>
            </div>
            <div class="card-body p-4">
              <div class="row gx-lg-5">
                <div class="col-lg-6">
                  <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/file-2') }}.svg" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">عنوان القسم التعليمي</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/edit.svg') }}" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">عنوان القسم التعليمي</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/user-3') }}.svg" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">الجزئية التعليمية</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/monitor.svg') }}" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">الجزئية التعليمية</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex align-items-center pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/bag.svg') }}" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">عنوان القسم التعليمي</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="d-flex align-items-center pb-4 mb-4">
                    <div class="symbol symbol-100"><img src="{{ asset('assets/front/images/svg/check-2') }}.svg" alt=""/></div>
                    <div class="me-3">
                      <h5 class="font-medium">عنوان القسم التعليمي</h5>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص  في مولد النصوص العربي حيث يمكنك أن تولد مثل هذا النص أو العديد من هذه النصوص  الأخرى</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-3">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">عن المدرب</h3>
            </div>
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg-5 mx-auto">
                  <div class="text-center">
                    <div class="symbol-120 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                  </div>
                  <div class="text-center py-3">
                    <h4 class="font-medium">أ. محمد السيلاوي</h4>
                    <h6 class="text-muted">مدرب معتمد  </h6>
                  </div>
                  <div class="d-flex align-items-center justify-content-center mb-4">
                    <div class="d-flex flex-column">
                      <h4 class="font-medium">34 </h4>
                      <h6 class="text-muted">طالب </h6>
                    </div>
                    <div class="d-flex flex-column line-vertical-left-right px-4 mx-4">
                      <h4 class="font-medium">34 </h4>
                      <h6 class="text-muted">دورة </h6>
                    </div>
                    <div class="d-flex flex-column">
                      <h4 class="font-medium">34 </h4>
                      <h6 class="text-muted">تقييم </h6>
                    </div>
                  </div>
                  <div class="bg-light-green text-center rounded p-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">تفاصيل الشهادة</h3>
            </div>
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg-10 mx-auto">
                  <div class="row align-items-center">
                    <div class="col-lg-6">
                      <h3 class="font-bold mb-1">تفاصيل الشهادة</h3>
                      <h6>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</h6>
                      <h6>يمكنك مشاركة الشهادة على</h6>
                      <ul class="social-media mt-2 social-dark py-2 px-0">
                        <li><a class="tw" href=""><i class="fa-brands fa-twitter"> </i></a></li>
                        <li><a class="fa" href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a class="yo" href=""><i class="fa-brands fa-youtube"></i></a></li>
                        <li><a class="in" href=""><i class="fa-brands fa-instagram"></i></a></li>
                      </ul>
                    </div>
                    <div class="col-lg-6">
                      <div class="text-center"><img class="rounded" src="{{ asset('assets/front/images/image-certificate.png') }}" alt=""/></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-4">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">آخر التقييمات</h3>
            </div>
            <div class="card-body p-4 position-relative">
              <div class="row">
                <div class="col-lg-9 mx-auto">
                  <div class="swiper-container swiper-ratgin">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide">
                        <div class="widget_item-rating text-center mb-4 shadow-none">
                          <div class="widget_item-image mb-3 symbol-100 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                          <div class="widget_item-content">
                            <h4 class="font-medium mb-2">يوسف كنعان أبو رحمة</h4>
                            <div class="data-rating rating-small d-flex align-items-center mb-3 justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            <div class="bg-light-green text-center rounded p-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</div>
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="widget_item-rating text-center mb-4 shadow-none">
                          <div class="widget_item-image mb-3 symbol-100 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                          <div class="widget_item-content">
                            <h4 class="font-medium mb-2">يوسف كنعان أبو رحمة</h4>
                            <div class="data-rating rating-small d-flex align-items-center mb-3 justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            <div class="bg-light-green text-center rounded p-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</div>
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="widget_item-rating text-center mb-4 shadow-none">
                          <div class="widget_item-image mb-3 symbol-100 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                          <div class="widget_item-content">
                            <h4 class="font-medium mb-2">يوسف كنعان أبو رحمة</h4>
                            <div class="data-rating rating-small d-flex align-items-center mb-3 justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            <div class="bg-light-green text-center rounded p-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</div>
                          </div>
                        </div>
                      </div>
                      <div class="swiper-slide">
                        <div class="widget_item-rating text-center mb-4 shadow-none">
                          <div class="widget_item-image mb-3 symbol-100 symbol"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt=""/></div>
                          <div class="widget_item-content">
                            <h4 class="font-medium mb-2">يوسف كنعان أبو رحمة</h4>
                            <div class="data-rating rating-small d-flex align-items-center mb-3 justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span></div>
                            <div class="bg-light-green text-center rounded p-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="swiper-action swiper-action-ratgin d-flex align-items-center justify-content-between px-lg-5">
                <div class="swiper-prev d-inline-flex align-items-center justify-content-center rounded-circle"><i class="fa-solid fa-chevron-right"></i></div>
                <div class="swiper-next d-inline-flex align-items-center justify-content-center rounded-circle"><i class="fa-solid fa-chevron-left"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-6">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">سجل الآن</h3>
            </div>
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg">
                  <div class="bg-white rounded-3 p-4 mb-4">
                    <div class="bg-light-green rounded-3 mb-4 p-3">
                      <h5>بعد عملية التسجيل ، سيتصل بك مستشارنا الأكاديمي لإنهاء عملية التسجيل.</h5>
                      <h5 class="font-medium">- رسوم التسجيل في الدورة - 41 دولارًا أمريكيًا  </h5>
                      <h5 class="font-medium">- قابل للاسترداد بالكامل خلال فترة أقصاها 14 يوماً </h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="text-muted"> المبلغ الكلـي :</h5>
                      <h5 class="text-primary"> ٣٨٫٩٩ ر.س  </h5>
                    </div>
                    <hr/>
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="text-muted"> بعد التخفيـض  :</h5>
                      <h5 class="text-primary"> ٣٨٫٩٩ ر.س  </h5>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4">
                      <div class="col">
                        <h5>لديـك كوبـون تخفيض ؟</h5>
                      </div>
                      <div class="col">
                        <input class="form-control rounded-pill" type="text" placeholder="أدخل الكود"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-1 position-relative">
                  <div class="line-vertical"></div>
                </div>
                @if (auth('web')->check())
                    <div class="col-lg pt-lg-5">
                        <form action="">
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="رقم البطاقة"/>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="CVC"/>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <select class="selectpicker" title="اختر الشهر" data-size="5">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="form-group">
                                <select class="selectpicker" title="اختر السنة" data-size="5">
                                <option value="1">2022</option>
                                <option value="2">2023</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary w-100 rounded-pill"> دفع</button>
                            </div>
                            </div>
                            <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary-2 w-100 rounded-pill"><i class="fa-solid fa-cart-shopping me-2"></i> إضافة الى السلة</button>
                            </div>
                            </div>
                        </div>
                        </form>
                    </div>
                @else
                    <div class="col-lg">
                    <ul class="nav nav-pills mb-3 nav-pills-login" id="pills-tab">
                        <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-login" type="button" role="tab">دخــول</button>
                        </li>
                        <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-register" type="button" role="tab">إشترك الآن</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="tab-login">
                        <form action="">
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="الاسم كامل"/>
                            </div>
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="البريد الإلكتروني"/>
                            </div>
                            <div class="form-group">
                            <button class="btn btn-primary w-100 rounded-pill">تأكيد</button>
                            </div>
                        </form>
                        </div>
                        <div class="tab-pane fade" id="tab-register">
                        <form action="">
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="الاسم كامل"/>
                            </div>
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="البريد الإلكتروني"/>
                            </div>
                            <div class="form-group d-flex border rounded-pill selectpicker-country">
                            <input class="form-control border-0" type="text" placeholder="رقم الجوال"/>
                            <select class="selectpicker" data-style="border-0" data-width="210px">
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='../assets/images/flag.png' /&gt;&lt;/span&gt;">Choice1</option>
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='../assets/images/flag.png' /&gt;&lt;/span&gt;">Choice1</option>
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='../assets/images/flag.png' /&gt;&lt;/span&gt;">Choice1</option>
                            </select>
                            </div>
                            <div class="form-group">
                            <input class="form-control" type="text" placeholder="كلمة المرور"/>
                            </div>
                            <div class="form-group">
                            <button class="btn btn-primary w-100 rounded-pill"> تأكيد</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5 tab" id="tab-5">
      <div class="row">
        <div class="col-12">
          <div class="card-course">
            <div class="card-header">
              <h3 class="font-medium text-center">الأسئلة الشائعة</h3>
            </div>
            <div class="card-body p-4">
              <div class="row">
                <div class="col-lg-7 mx-auto">
                  <div class="text-center mb-4"> <img src="{{ asset('assets/front/images/image-question.png') }}" alt=""/></div>
                  <div id="accordion">
                    <div class="widget__item-faq border rounded_15 p-0 mb-3 pointer px-3 px-lg-4 py-2 py-lg-3 collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-1" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16">
                          <path id="arrow_icon" data-name="arrow icon" d="M.352,23.461l15.785-7.385a.6.6,0,0,1,.726.172.619.619,0,0,1,.015.756L11.687,24.02l5.191,7.016a.62.62,0,0,1-.013.756.6.6,0,0,1-.472.229.6.6,0,0,1-.254-.057L.354,24.579a.619.619,0,0,1,0-1.118Z" transform="translate(0 -16.02)" fill="#777777"></path>
                        </svg>
                        <h4 class="pointer title collapsed">كيـف أستفيد من الموقـع ؟</h4>
                      </div>
                      <div class="collapse" id="collapse-1" data-bs-parent="#accordion">
                        <div class="pt-3 pb-2">
                          <h5>هذا النص هو هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                        </div>
                      </div>
                    </div>
                    <div class="widget__item-faq border rounded_15 p-0 mb-3 pointer px-3 px-lg-4 py-2 py-lg-3 collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-2" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16">
                          <path id="arrow_icon" data-name="arrow icon" d="M.352,23.461l15.785-7.385a.6.6,0,0,1,.726.172.619.619,0,0,1,.015.756L11.687,24.02l5.191,7.016a.62.62,0,0,1-.013.756.6.6,0,0,1-.472.229.6.6,0,0,1-.254-.057L.354,24.579a.619.619,0,0,1,0-1.118Z" transform="translate(0 -16.02)" fill="#777777"></path>
                        </svg>
                        <h4 class="pointer title collapsed">كيـف أستفيد من الموقـع ؟</h4>
                      </div>
                      <div class="collapse" id="collapse-2" data-bs-parent="#accordion">
                        <div class="pt-3 pb-2">
                          <h5>هذا النص هو هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                        </div>
                      </div>
                    </div>
                    <div class="widget__item-faq border rounded_15 p-0 mb-3 pointer px-3 px-lg-4 py-2 py-lg-3 collapsed" data-bs-toggle="collapse" data-bs-target="#collapse-3" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16">
                          <path id="arrow_icon" data-name="arrow icon" d="M.352,23.461l15.785-7.385a.6.6,0,0,1,.726.172.619.619,0,0,1,.015.756L11.687,24.02l5.191,7.016a.62.62,0,0,1-.013.756.6.6,0,0,1-.472.229.6.6,0,0,1-.254-.057L.354,24.579a.619.619,0,0,1,0-1.118Z" transform="translate(0 -16.02)" fill="#777777"></path>
                        </svg>
                        <h4 class="pointer title collapsed">كيف يمكننـي الإشتراك بالموقـع ؟</h4>
                      </div>
                      <div class="collapse" id="collapse-3" data-bs-parent="#accordion">
                        <div class="pt-3 pb-2">
                          <h5>هذا النص هو هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                        </div>
                      </div>
                    </div>
                    <div class="widget__item-faq border rounded_15 p-0 mb-3 pointer collapsed px-3 px-lg-4 py-2 py-lg-3" data-bs-toggle="collapse" data-bs-target="#collapse-4" aria-expanded="false">
                      <div class="d-flex align-items-center">
                        <svg class="me-3" xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16">
                          <path id="arrow_icon" data-name="arrow icon" d="M.352,23.461l15.785-7.385a.6.6,0,0,1,.726.172.619.619,0,0,1,.015.756L11.687,24.02l5.191,7.016a.62.62,0,0,1-.013.756.6.6,0,0,1-.472.229.6.6,0,0,1-.254-.057L.354,24.579a.619.619,0,0,1,0-1.118Z" transform="translate(0 -16.02)" fill="#777777"></path>
                        </svg>
                        <h4 class="pointer title collapsed">كيف يمكننـي الإشتراك بالموقـع ؟</h4>
                      </div>
                      <div class="collapse" id="collapse-4" data-bs-parent="#accordion">
                        <div class="pt-3 pb-2">
                          <h5>هذا النص هو هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mb-3">
        <div class="col-12">
          <h2 class="font-bold">دورات مشابهة</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="widget_item-blog mb-4">
            <div class="widget-discount">34$</div>
            <div class="widget_item-image">
              <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-01.png') }}" alt=""/></a>
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
              <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-02.png') }}" alt=""/></a>
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
              <div class="widget_item-category">علوم الحاسوب</div><a href=""><img src="{{ asset('assets/front/images/img-03.png') }}" alt=""/></a>
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
    <!-- Modal -->
  <div class="modal fade" id="ModalRating">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-10">
        <div class="modal-body p-4">
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          <h2 class="font-medium text-center my-3">تقييم الدورة</h2>
          <h5 class="text-center mb-4">هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص</h5>
          <form action="">
            <div class="form-group">
              <input class="kv-rtl-theme-default-star rating-loading" id="input-2-rtl-star-sm" name="input-2-rtl-star-sm" value="3" dir="rtl" data-size="sm"/>
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="4" placeholder="... اكتب تعليقاً"></textarea>
            </div>
            <div class="form-group">
              <button class="btn btn-primary w-100" type="submit">إرسال</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end:: section -->
@endsection

@push('front_js')
<script src="{{ asset('assets/front/js/rating.min.js') }}"> </script>

<script>
    $('.kv-rtl-theme-default-star').rating({
        hoverOnClear: false,
        step:1,
        containerClass: 'is-star'
      });
</script>
@endpush
