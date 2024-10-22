@extends('front.layouts.index', ['is_active'=>'teachers','sub_title'=>'المدربين', ])

@section('content')
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="card slide-search">
            <div class="card-body">
              <div class="mb-4">
                <div class="input-icon right">
                  <input class="form-control" type="text" placeholder="بحث"/>
                  <div class="icon">  <i class="fa-regular fa-magnifying-glass fa-lg"></i></div>
                </div>
              </div>
              <div class="mb-4">
                <h6 class="font-medium mb-2">جنس المدرب</h6>
                <label class="m-checkbox mb-0 d-block">
                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>ذكر</span>
                </label>
                <label class="m-checkbox mb-0 d-block">
                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>أنثى</span>
                </label>
              </div>
              <div class="mb-4">
                <h6 class="font-medium mb-2">عمر المدرب</h6>
                <label class="m-checkbox mb-0 d-block">
                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>(24-30) سنة</span>
                </label>
                <label class="m-checkbox mb-0 d-block">
                  <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>أنثى</span>
                </label>
              </div>
              <div class="mb-4">
                <div id="collapse">
                  <div class="collapse-filter mb-4">
                    <div class="collapse-head collapsed d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#collapse-1">
                      <div class="collapse-title"> التقييمات</div>
                      <div class="collapse-icon"><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div class="accordion-collapse collapse" id="collapse-1">
                      <div class="px-3 py-2">
                        <label class="m-checkbox mb-0 d-block">
                          <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>(24-30) سنة</span>
                        </label>
                        <label class="m-checkbox mb-0 d-block">
                          <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>أنثى</span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="collapse-filter mb-4">
                    <div class="collapse-head collapsed d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#collapse-2">
                      <div class="collapse-title"> الدولة</div>
                      <div class="collapse-icon"><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div class="accordion-collapse collapse" id="collapse-2">
                      <div class="px-3 py-2">
                        <label class="m-checkbox mb-0 d-block">
                          <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>(24-30) سنة</span>
                        </label>
                        <label class="m-checkbox mb-0 d-block">
                          <input type="checkbox" name="checkbox"/><span class="checkmark"></span><span>أنثى</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="row">
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
            <div class="col-lg-4 mb-4">
              <div class="widget_item-teacher h-100 text-center bg-white">
                <div class="widget_item-image">
                  <div class="widget_item-overlay d-flex align-items-end justify-content-center"><a href=""> <i class="fa-brands fa-facebook"></i></a><a href=""> <i class="fa-brands fa-twitter"></i></a><a href=""> <i class="fa-solid fa-phone"></i></a></div><a href=""><img src="{{ asset('assets/front/images/man2.png') }}" alt=""/></a>
                </div>
                <div class="widget_item-content p-3">
                  <h4 class="font-medium widget_item-title mb-2"><a href="{{ route('lecturerProfile.index') }}"> اسم المدرب/ المدرب </a></h4>
                  <div class="data-rating d-flex align-items-center rating-sm justify-content-center"><span class="d-flex" data-rating="3"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span>(2.4)</span></div>
                  <h5 class="text-muted widget_item-jop">تخصص المدرب</h5>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end:: section -->
@endsection
