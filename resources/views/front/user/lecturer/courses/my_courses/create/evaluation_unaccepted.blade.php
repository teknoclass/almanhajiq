@extends('front.user.lecturer.layout.index')

@section('content')

	@push('front_css')
		<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
	@endpush

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

	<section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links])

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <!--begin::Card-->
                            <div class="bg-white p-4 rounded-4">
                                <div class="row">
                                    <div class="col-12 d-flex flex-column align-items-center text-center">
                                        <img class="pt-2" src="{{ asset('assets/front/images/no_content.png') }}" alt="" loading="lazy"/>
                                        <h2 class="pt-2"><strong>للأسف!</strong></h2>
                                        <p class="pt-2">تم رفض الطلب الخاص بكم للسبب التالي:</p>
                                        <strong><p class="pt-2">{{ @$evaluation->reason_unacceptable }}</p></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card-->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
