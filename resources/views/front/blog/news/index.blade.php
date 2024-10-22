@extends('front.blog.layout.index', ['is_active' => 'blog_news', 'sub_title' => 'أخبار المدونة'])

@section('content')
    <!-- start:: section -->
    <section>
        <div class="hero-section wow position-relative fadeInUp" data-wow-delay="0.1s"
            style="background-image: url('{{ asset('assets/front/images/newimages/news-hero-image.png') }}')">
            <div class="news-hero-text">
                <span class="text-danger fw-bold fs-6">الأحدث:</span>
                هذا النص هو مثال لنص يمكن ان يستبدل في نفس المساحة. اخر وقد تم انشائه عن طريق مولد النص العربي ,
                هذا النص هو مثال لنص يمكن عن طريق مولد النص العربي ,
            </div>
        </div>
        <div class="latestBlog section-padding">
            <div class="container">
                {{-- <div class="row mb-4 justify-content-between align-items-center">
                    <div class="col-lg-9">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">المدونة</a></li>
                            <li class="breadcrumb-item active">الأخبار </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">
                        <select class="selectpicker bg-primary rounded-pill" data-style="select-primary rounded-pill"
                            title="الأحدث">
                            <option>الاقدم</option>
                        </select>
                    </div>
                </div> --}}
                <div class="all-data">
                    @include('front.blog.news.partials.all')
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
    @endpush
@endsection
