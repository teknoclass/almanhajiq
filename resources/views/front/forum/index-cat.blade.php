@extends('front.layouts.index', ['is_active'=>'forum','sub_title'=>'أنواع المنتدى ', ])

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
          <div class="d-lg-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
              <h2 class="font-bold">منتدى الأوائــل</h2>
              <h3>أهلاً و سهلاً بك في المنتدى </h3>
            </div><a class="btn btn-primary font-medium px-4 my-2 my-lg-0" href="{{ route('forum.single') }}"><i class="fa-regular fa-plus me-2"></i>إضافة موضوع جديد </a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="widget_item-forum mb-3">
            <div class="widget_item-head d-flex align-items-center justify-content-between collapsed p-3 pointer" data-bs-toggle="collapse" data-bs-target="#collapse-1">
              <h3 class="widget_item-title font-bold text-white">العنوان</h3><i class="fa-regular fa-chevron-down text-white"></i>
            </div>
            <div class="widget_item-body collapse" id="collapse-1">
              <div class="p-3 p-lg-4"><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a></div>
            </div>
          </div>
          <div class="widget_item-forum mb-3">
            <div class="widget_item-head d-flex align-items-center justify-content-between collapsed p-3 pointer" data-bs-toggle="collapse" data-bs-target="#collapse-2">
              <h3 class="widget_item-title font-bold text-white">العنوان</h3><i class="fa-regular fa-chevron-down text-white"></i>
            </div>
            <div class="widget_item-body collapse" id="collapse-2">
              <div class="p-3 p-lg-4"><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a></div>
            </div>
          </div>
          <div class="widget_item-forum mb-3">
            <div class="widget_item-head d-flex align-items-center justify-content-between collapsed p-3 pointer" data-bs-toggle="collapse" data-bs-target="#collapse-3">
              <h3 class="widget_item-title font-bold text-white">العنوان</h3><i class="fa-regular fa-chevron-down text-white"></i>
            </div>
            <div class="widget_item-body collapse" id="collapse-3">
              <div class="p-3 p-lg-4"><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a><a class="d-block widget_item-forumFile" href="{{ route('forum.single') }}">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="d-flex align-items-start">
                        <div class="icon me-2"><i class="fa-light fa-file-lines"></i></div>
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                          <h6 class="font-size-12">هذا النص هو مثال لنص يمكن أن يستبدل</h6>
                        </div>
                        <h6 class="font-bold text-primary ms-2">( 34 مشاهدة )</h6>
                      </div>
                    </div>
                    <div class="col-lg-4 my-2 my-lg-0">
                      <div class="d-flex align-items-center">
                        <h6 class="font-bold px-1">60 موضوع</h6>
                        <h6 class="font-bold px-1">42 مشاركة</h6>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="d-flex align-items-center">
                        <div class="d-flex flex-column">
                          <h6 class="font-bold">هذا النص هو مثال لنص </h6>
                          <h6 class="font-medium text-muted">بواسطة <span class="text-primary px-1">عبد الله </span></h6>
                          <h6 class="font-medium text-muted">1\1\2023 , 12:43 pm</h6>
                        </div><i class="fa-regular fa-arrow-left ms-4 text-primary-2"></i>
                      </div>
                    </div>
                  </div></a></div>
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
</section>
<!-- end:: section -->
@endsection
