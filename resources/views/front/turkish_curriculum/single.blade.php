@extends('front.layouts.index', ['is_active'=>'turkish_curriculum','sub_title'=>'المناهج التركية', ])

@section('content')

<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-4 justify-content-between align-items-center">
        <div class="col-lg-9">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#">المناهج التركية</a></li>
            <li class="breadcrumb-item active">الرياضيات</li>
          </ol>
        </div>
        <div class="col-lg-2">
          <select class="selectpicker bg-primary rounded-pill" data-style="select-primary rounded-pill" title="الوحدة الأولى">
            <option>دروسي الخصوصية</option>
            <option>محادثاتي</option>
          </select>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-12">
          <ul class="nav nav-pills mb-3 nav-pills-courses" id="pills-tab">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab">الدورات المسجلة (3)</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab">الدورات المباشرة (4)</button>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="tab-1">
              <div class="row">
                <div class="col-lg-4">
                  <div class="widget_item-blog mb-4">
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-01.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-06.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-05.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-02.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-03.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
            <div class="tab-pane fade show" id="tab-2">
              <div class="row">
                <div class="col-lg-4">
                  <div class="widget_item-blog mb-4">
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-03.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-04.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                    <div class="widget-discount">34$</div>
                    <div class="widget_item-image">
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-05.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-02.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
                      <div class="widget_item-category">علوم الحاسوب</div><a href="#"><img src="{{ asset('assets/front/images/img-06.png') }}" alt=""/></a>
                    </div>
                    <div class="widget_item-content p-3">
                      <div class="d-flex mb-2">
                        <div class="col">
                          <h5 class="font-medium widget_item-title"><a href="#"> اسم الدورة يكتب هنا</a></h5>
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
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
