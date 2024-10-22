@extends('front.layouts.index', ['is_active'=>'turkish_curriculum','sub_title'=>'المناهج التركية', ])

@section('content')

<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-4">
        <div class="col-12">
          <h2 class="font-bold mb-2 mb-lg-0">المناهج التركية</h2>
        </div>
      </div>
      <div class="row mb-4">
        <div class="col-12">
          <ul class="nav nav-pills mb-3 nav-pills-courses" id="pills-tab">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-1" type="button" role="tab">المرحلة الإبتدائية</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-2" type="button" role="tab">المرحلة الإعدادية</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-3" type="button" role="tab">المرحلة الثانوية</button>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="tab-1">
              <div class="row">
                <div class="col-md-6">
                  <div class="widget_item-curricula mb-4 d-flex align-items-center">
                    <div class="widget_item-image col-auto position-relative">
                      <h3 class="font-bold widget_item-number d-inline-flex align-items-center justify-content-center bg-primary">1</h3><img src="{{ asset('assets/front/images/image-curricula.png') }}" alt=""/>
                    </div>
                    <div class="widget_item-content p-3 col dropdown">
                      <div class="d-flex align-items-center justify-content-between pointer" data-bs-toggle="dropdown">
                        <h2 class="font-bold">الصف الأول</h2><i class="fa-solid fa-chevron-down fa-xl"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة العربية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة الإنجليزية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">العلوم العامة</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الإجتماعيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget_item-curricula mb-4 d-flex align-items-center">
                    <div class="widget_item-image col-auto position-relative">
                      <h3 class="font-bold widget_item-number d-inline-flex align-items-center justify-content-center bg-primary">1</h3><img src="{{ asset('assets/front/images/image-curricula.png') }}" alt=""/>
                    </div>
                    <div class="widget_item-content p-3 col dropdown">
                      <div class="d-flex align-items-center justify-content-between pointer" data-bs-toggle="dropdown">
                        <h2 class="font-bold">الصف الأول</h2><i class="fa-solid fa-chevron-down fa-xl"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة العربية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة الإنجليزية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">العلوم العامة</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الإجتماعيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget_item-curricula mb-4 d-flex align-items-center">
                    <div class="widget_item-image col-auto position-relative">
                      <h3 class="font-bold widget_item-number d-inline-flex align-items-center justify-content-center bg-primary">1</h3><img src="{{ asset('assets/front/images/image-curricula.png') }}" alt=""/>
                    </div>
                    <div class="widget_item-content p-3 col dropdown">
                      <div class="d-flex align-items-center justify-content-between pointer" data-bs-toggle="dropdown">
                        <h2 class="font-bold">الصف الأول</h2><i class="fa-solid fa-chevron-down fa-xl"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة العربية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة الإنجليزية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">العلوم العامة</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الإجتماعيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="widget_item-curricula mb-4 d-flex align-items-center">
                    <div class="widget_item-image col-auto position-relative">
                      <h3 class="font-bold widget_item-number d-inline-flex align-items-center justify-content-center bg-primary">1</h3><img src="{{ asset('assets/front/images/image-curricula.png') }}" alt=""/>
                    </div>
                    <div class="widget_item-content p-3 col dropdown">
                      <div class="d-flex align-items-center justify-content-between pointer" data-bs-toggle="dropdown">
                        <h2 class="font-bold">الصف الأول</h2><i class="fa-solid fa-chevron-down fa-xl"></i>
                      </div>
                      <ul class="dropdown-menu">
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة العربية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">اللغة الإنجليزية</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">العلوم العامة</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الإجتماعيات</a></li>
                        <li> <a href="{{ route('turkish_curriculum.single') }}">الرياضيات</a></li>
                      </ul>
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
