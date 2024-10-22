@extends('front.layouts.index', ['is_active' => 'courses', 'sub_title' => 'الدورات التدريبية'])

@section('content')
	<!-- start:: section -->
            <section class="section wow fadeInUp" data-wow-delay="0.1s">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-12">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item"><a href="#">{{__('profile')}}</a></li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('lecturerProfile.index',['id'=>@$lecturer->id , 'name'=>mergeString(@$lecturer->name,'')]) }}">
                                        {{ @$lecturer->name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('courses') }}</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="all-data">
                                @include('front.courses.partials.all-courses')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
	<!-- end:: section -->

    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
    @endpush
@endsection
