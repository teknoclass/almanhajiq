@extends('front.layouts.index', ['is_active'=>'test_courses','sub_title'=>'الدورات التجريبية', ])


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
        <div class="row mb-3">
            <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="font-medium"><span class="square ms-2"></span> اختبار الوحدة الأولى</h4>
                <div class="d-flex align-items-center">
                <div class="icon-clock ms-2 d-flex"><i class="fa-regular fa-clock"></i></div>
                <p class="pt-1 text--muted col-auto">04 \ 11 \ 2021</p>
                </div>
            </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
            <div class="bg-white rounded-2 p-3 p-lg-4 border-child">
                <div class="d-flex align-items-center">
                <div class="col-3 col-lg-2 border-end p-3">
                    <h5 class="text-muted">المدة</h5>
                </div>
                <div class="col-9 col-lg-10 py-3 px-4">
                    <h4 class="font-medium">30 min</h4>
                </div>
                </div>
                <div class="d-flex align-items-center">
                <div class="col-3 col-lg-2 border-end p-3">
                    <h5 class="text-muted">عدد الأسئلة</h5>
                </div>
                <div class="col-9 col-lg-10 py-3 px-4">
                    <h4 class="font-medium">10</h4>
                </div>
                </div>
                <div class="d-flex align-items-center">
                <div class="col-3 col-lg-2 border-end p-3">
                    <h5 class="text-muted">نوع الأسئلة</h5>
                </div>
                <div class="col-9 col-lg-10 py-3 px-4">
                    <h4 class="font-medium">صح وخطأ</h4>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
            <button class="btn btn-primary font-medium">ابدأ الإختبار</button>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
            <h6 class="mb-3">هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى حيث يمكنك أن تولد مثل هذا النص</h6>
            <h6 class="mb-3">هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى حيث يمكنك أن تولد مثل هذا النص أو النصوص الأخرى يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى حيث يمكنك أن تولد مثل هذا النص</h6>
            </div>
        </div>
        </div>
        <div class="col-lg-4">
        <div class="course-content border-light-primary rounded-10 bg-white">
            <div class="course-content-body p-4">
            <div class="course-widget">
                <div class="course-widget-head d-flex align-items-center">
                <div class="icon me-2"><i class="fa-solid fa-microphone"></i></div>
                <h4 class="font-medium">الشابتر الأول : تعريف الخوارزميات</h4>
                </div>
                <ul class="course-widget-list">
                <li class="mb-2"><a href="">مخططات سير العمليات التتابعية</a>
                    <div class="progress progress-custom">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </li>
                <li class="mb-2"><a href=""> مخططات سير العمليات ذات التفرعات</a>
                    <div class="progress progress-custom">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </li>
                <li class="mb-2"><a href="">سير العمليات ذات التكرار والدوران </a>
                    <div class="progress progress-custom">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </li>
                </ul>
            </div>
            <div class="course-widget">
                <div class="course-widget-head d-flex align-items-center">
                <div class="icon me-2"><i class="fa-solid fa-microphone"></i></div>
                <h4 class="font-medium">الشابتر الأول : تعريف الخوارزميات</h4>
                </div>
                <ul class="course-widget-list">
                <li class="mb-2"><a href=""> مخططات سير العمليات ذات التفرعات</a>
                    <div class="progress progress-custom">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </li>
                <li class="mb-2"><a href="">سير العمليات ذات التكرار والدوران </a>
                    <div class="progress progress-custom">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <button class="btn bg-transparent border-0 px-0 d-inline-flex align-items-center">مشاهدة المزيد
            <div class="icon-chevron-down ms-2"><i class="fa-solid fa-chevron-down"></i></div>
        </button>
        </div>
    </div>
    </div>
</section>
@endsection
