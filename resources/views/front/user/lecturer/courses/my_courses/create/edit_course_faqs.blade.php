@extends('front.user.lecturer.layout.index')

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
@endpush

@section('content')

	@php
		$item = isset($item) ? $item : null;

        isset($item) ? $title_page = @$item->title : $title_page = __('add');

        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('courses'),
                'link' => route('user.lecturer.my_courses.index'),
            ],
            [
                'title' => @$title_page,
                'link' => '#',
            ],
        ];
    @endphp

    <!--begin::Entry-->
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links])

            <form id="courseForm" method="{{ isset($item) ? 'POST' : 'POST' }}" to="{{ url()->current() }}"
                url="{{ url()->current() }}" enctype="multipart/form-data" class="w-100">

                @csrf
                <input type="hidden" value="{{ @$item->image }}" name="image" id="image" />
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="row">
                            @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')
                            <div id="kt_repeater_1" class="w-100">
                                <div class=" row">

                                    <div data-repeater-list="faqs" class="col-lg-12">
                                        @php
                                            $faqs = $item->faqs;
                                        @endphp
                                        @if ($faqs->isNotEmpty())
                                            @foreach ($faqs as $faq)
                                                <input type="hidden" id="needToolbarConfirm" value="false">
                                                @include('front.user.lecturer.courses.my_courses.create.partials.faq_form', ['faq' => $faq->faq])
                                            @endforeach
                                        @else
                                            <input type="hidden" id="needToolbarConfirm" value="true">
                                            @include('front.user.lecturer.courses.my_courses.create.partials.faq_form')
                                        @endif

                                    </div>
                                </div>
                                <div class="form-group">
                                    <a href="javascript:;" data-repeater-create="" class="btn btn-primary rounded px-2 py-2"><i class="fa-regular fa-plus"></i> {{ __('add') }}</a>
                                </div>
                            </div>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Card-->

                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
        @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')
    </section>



    @push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
        <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/repeater.js') }}"></script>
        <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js') }}"></script>
    @endpush

@endsection
