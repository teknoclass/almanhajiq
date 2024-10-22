@extends('front.blog.layout.index', ['is_active' => 'blog', 'sub_title' => 'المقالات'])

@section('content')
    <!-- start:: section -->
    <section class="section-padding wow fadeInUp" data-wow-delay="0.1s">
        <div class="latestBlog">
            <div class="container">
                <div class="row mb-4 justify-content-between align-items-center">
                    <div class="col-lg-9">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}#">{{ __('blog') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('posts') }}</li>
                        </ol>
                    </div>
                </div>
                <div class="all-data">
                    @include('front.blog.posts.partials.all')
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
    @endpush
@endsection
