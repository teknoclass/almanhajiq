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
        <div class="col-lg-6 me-auto">
          <div class="input-icon right">
            <input class="form-control" type="text" placeholder="إبحـــث هنـــا"/>
            <div class="icon text-primary"><i class="fa-regular fa-magnifying-glass"></i></div>
          </div>
        </div>
        <div class="col-auto my-2 my-lg-0"><a class="btn btn-primary font-medium px-4" href="{{ route('forum.single') }}"><i class="fa-regular fa-plus me-2"></i>إضافة موضوع جديد </a></div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="widget_item-forum mb-3">
            <div class="widget_item-head d-flex align-items-center justify-content-between p-3">
              <h3 class="widget_item-title font-bold text-white">العنوان / كاتب الموضوع</h3>
              <select class="selectpicker rounded-pill bg-transparent border-0" data-style="bg-transparent border-0 text-white icon-dropdown-white rounded-pill" title="اَخر مشاركة" data-width="200px">
                <option>1</option>
                <option>2</option>
              </select>
            </div>
            <div class="widget_item-body">
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
