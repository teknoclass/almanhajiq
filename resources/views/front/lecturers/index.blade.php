@extends('front.layouts.index', ['is_active' => 'lecturers', 'sub_title' => __('lecturers')])

@section('content')
    {{-- }}<div>
        <img class="hero" src="{{ asset('assets/front/images/newimages/luicter-section.png') }}" alt="">
    </div> --}}
    <section id="lecturer" class="wow fadeInUp" data-wow-delay="0.1s">
        <div class="mb-4 mb-lg-0 filter-form-body">
            @include('front.lecturers.partials.filter')
        </div>
        <div class="container">
            <div class="section-padding">
                <div>
                    <div class="row all-data">
                        @include('front.lecturers.partials.all')
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
    @endpush
@endsection
