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

	<section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links,])

            <form id="courseForm" method="{{ isset($item) ? 'POST' : 'POST' }}" to="{{ url()->current() }}"
                url="{{ url()->current() }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="row">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <!--begin::Form-->
                        <div class="card-body">
                            <div class="row">
                                <div id="kt_repeater_1" class="w-100">
                                    <div class="row">
                                        <div data-repeater-list="content_details" class="col-lg-12">
                                            @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')

                                            @php
                                                $content_details = $item->contentDetails;
                                            @endphp
                                            @if ($content_details->isNotEmpty())
                                                <input type="hidden" id="needToolbarConfirm" value="false">
                                                @foreach ($content_details as $details)
                                                    @include('front.user.lecturer.courses.my_courses.create.partials.content_details_form', ['details' => $details,])
                                                @endforeach
                                            @else
                                                <input type="hidden" id="needToolbarConfirm" value="true">
                                                @include('front.user.lecturer.courses.my_courses.create.partials.content_details_form')

                                            @endif

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <a href="javascript:;" data-repeater-create="" class="btn btn-primary rounded px-2 py-2"><i class="fa-regular fa-plus"></i> {{ __('add') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
        @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')
	</section>


@push('front_js')
	<script src="{{ asset('assets/front/js/post.js') }}"></script>
	<script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/repeater.js') }}"></script>
	<script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js') }}"></script>

	<script>
		$('.add-new-content').click(function() {
			setInterval(function() {

				var last_content = $('.widget_item-course-content').last();
				$(last_content).find(".content-icon").prop('required', true);

				$(last_content).find('.preview-content-course-icon').remove();
			}, 500);
		});
	</script>
@endpush

@endsection
