@extends('front.layouts.index', ['is_active' => 'payment', 'sub_title' => 'الدفع'])

@section('content')

<!-- start:: section -->
      <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
          <div class="row mb-4">
            <div class="col-12">
              <div class="d-lg-flex align-items-center justify-content-between">
                <ol class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                  <li class="breadcrumb-item"><a href="#">الـدورات</a></li>
                  <li class="breadcrumb-item"><a href="#">تفاصيل الدورة</a></li>
                  <li class="breadcrumb-item active">بيانات الدفع</li>
                </ol>
              </div>
            </div>
          </div>
          <div class="row gx-lg-0">
            <div class="col-lg">
              <div class="bg-white rounded-3 p-4 mb-4">
                <div class="widget_item-cart border rounded-10 p-2 d-flex align-items-center mb-4 widget-2">
                  <div class="col-auto">
                    <div class="widget_item-image"><img src="{{ asset('assets/front/images/img-02.png') }}" alt="" loading="lazy"/></div>
                  </div>
                  <div class="col ms-3">
                    <h5 class="font-medium">اسم الدورة يكتب هنا</h5>
                    <h6 class="font-medium"><i class="circle"> </i><i class="circle"> </i><span class="me-2">مبتدئ</span></h6>
                    <h6 class="text-muted mb-1"><i class="fa-solid fa-calendar-days me-2"></i>مدة 3 شهور , 30 درس</h6>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="text-muted"> المبلغ الكلـي :</h5>
                  <h5 class="text-muted"> ٣٨٫٩٩ ر.س  </h5>
                </div>
                <hr/>
                <div class="d-flex align-items-center justify-content-between">
                  <h5 class="text-muted"> بعد التخفيـض  :</h5>
                  <h5 class="text-muted"> ٣٨٫٩٩ ر.س  </h5>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4">
                  <div class="col">
                    <h5>لديـك كوبـون تخفيض ؟</h5>
                  </div>
                  <div class="col">
                    <input class="form-control" type="text" placeholder="أدخل الكود"/>
                  </div>
                </div>
                <div class="bg-light-green rounded-3 mt-4 p-3">
                  <h5>- رسوم التسجيل في الدورة - 41 دولارًا أمريكيًا </h5>
                  <h5>- قابل للاسترداد بالكامل خلال فترة أقصاها 14 يوماً  </h5>
                </div>
              </div>
            </div>
            <div class="col-lg-1 position-relative">
              <div class="line-vertical"></div>
            </div>
            <div class="col-lg">
              <div class="card-payment">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-paypal" type="button"><img src="{{ asset('assets/front/images/svg/paypal2.svg') }}" alt="" loading="lazy"/></button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-visa" type="button"><img src="{{ asset('assets/front/images/svg/visa2.svg') }}" alt="" loading="lazy"/></button>
                  </li>
                </ul>
                <div class="tab-content p-4" id="myTabContent">
                  <div class="tab-pane fade show active" id="tab-paypal">
                    <div class="form-payment">
                      <form action="">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="اسم صاحب الحساب"/>
                        </div>
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="البريد الإلكتروني"/>
                        </div>
                        <div class="form-group mt-5 pt-5">
                          <button class="btn btn-primary w-100">تأكيد</button>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="tab-visa">
                    <div class="form-payment">
                      <form action="">
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="الاسم في البطاقـة"/>
                        </div>
                        <div class="form-group">
                          <input class="form-control" type="text" placeholder="رقم البطاقة"/>
                        </div>
                        <div class="row gx-lg-3">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <input class="form-control" type="text" placeholder="CVC"/>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <select class="selectpicker" title="اختر الشهر" data-size="5">
                                <option value="">يناير</option>
                                <option value="">فبراير</option>
                                <option value="">مارس</option>
                                <option value="">ابريل</option>
                                <option value="">مايو</option>
                                <option value="">يونيو</option>
                                <option value="">يوليو</option>
                                <option value="">اغسطس</option>
                                <option value="">سبتمبر</option>
                                <option value="">اكتوبر</option>
                                <option value="">نوفمبر</option>
                                <option value="">ديسيمبر</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <select class="selectpicker" title="اختر السنة" data-size="5">
                                <option value="">2022</option>
                                <option value="">2021</option>
                                <option value="">2020</option>
                                <option value="">2019</option>
                                <option value="">2018</option>
                                <option value="">2017</option>
                                <option value="">2016</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mt-3 mb-4">
                          <div class="rounded-pill border-2 border-primary border px-3 py-2 d-flex align-items-center justify-content-between">
                            <h4 class="font-medium"> المبلغ الكلي :</h4>
                            <h4 class="font-medium">( ٣٩٫٩٩ ر.س ) </h4>
                          </div>
                        </div>
                        <div class="form-group">
                          <button class="btn btn-primary w-100">تأكيد</button>
                        </div>
                      </form>
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
