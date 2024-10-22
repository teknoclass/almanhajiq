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
            @include('front.user.lecturer.layout.includes.course_breadcrumb', ['breadcrumb_links' => $breadcrumb_links])

            @if (@$item && @$item->welcome_text_for_registration && @$item->certificate_text)
                <input type="hidden" id="needToolbarConfirm" value="false">
            @else
                <input type="hidden" id="needToolbarConfirm" value="true">
            @endif
            <form id="courseForm" method="{{ isset($item) ? 'POST' : 'POST' }}" to="{{ url()->current() }}"
                url="{{ url()->current() }}" enctype="multipart/form-data" class="w-100">
                @csrf

                <input type="hidden" name="welcome_text_for_registration_image" id="image" value="{{ @$item->welcome_text_for_registration_image }}" />
                <input type="hidden" value="{{ @$item->certificate_text_image }}" name="certificate_text_image" id="image_3" />
                <input type="hidden" value="{{ @$item->faq_image }}" name="faq_image" id="image_2" />

                <div class="row">
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-body">
                            <div class="row">
                                @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')

                                @foreach (locales() as $locale => $value)
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('welcome_text') }}
                                                ({{ __($value) }})
                                                <span class="text-danger">*</span></label>
                                            <textarea type="text" id="welcome_text_for_registration_{{ $locale }}"
                                            name="welcome_text_for_registration_{{ $locale }}" class="form-control tinymce" required rows="15">{{ isset($item) ? @$item->translate($locale)->welcome_text_for_registration : '' }}{{ @$text }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group mb-10">
                                        <label>{{ __('certificate_text') }}
                                            ({{ __($value) }} )
                                            <span class="text-danger">*</span></label>
                                        <textarea type="text" id="certificate_text_{{ $locale }}" name="certificate_text_{{ $locale }}"
                                        class="form-control tinymce" required rows="15">{{ isset($item) ? @$item->translate($locale)->certificate_text : '' }}{{ @$text }}</textarea>
                                    </div>
                                @endforeach

                                <div class="col-md-6 mt-3">
                                    <div class="form-group row align-items-center">
                                        <div class="text-center">
                                            <div class="col-12">
                                                <label class="mb-3">{{ __('welcome_text_for_registration_image') }}</label>
                                            </div>
                                            <div class="image-input image-input-outline">
                                                {{-- Image preview wrapper --}}
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url({{ imageUrl(@$item->welcome_text_for_registration_image) }})"></div>

                                                <label for="preview-input-image-1" class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow" data-image-input-action="change"><i class="fa fa-pen fs-6"></i></label>
                                                <input type="file" id="preview-input-image-1" class="preview-input-image-1 d-none"
                                                    name="welcome_text_for_registration_image" accept=".png, .jpg, .jpeg"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <div class="form-group row align-items-center">
                                        <div class="text-center">
                                            <div class="col-12">
                                                <label class="mb-3">{{ __('certificate_text_image') }}</label>
                                            </div>
                                            <div class="image-input image-input-outline">
                                                {{-- Image preview wrapper --}}
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url({{ imageUrl(@$item->certificate_text_image) }})"></div>

                                                <label for="preview-input-image-2" class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow" data-image-input-action="change"><i class="fa fa-pen fs-6"></i></label>
                                                <input type="file" id="preview-input-image-2" class="preview-input-image-2 d-none"
                                                    name="certificate_text_image" accept=".png, .jpg, .jpeg"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
        @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')
	</section>
@endsection

@push('front_js')
	<script src="{{ asset('assets/front/js/post.js') }}"></script>
	<script src="{{ asset('assets/panel/js/image-input.js') }}"></script>
	<script src="{{ asset('assets/front/lecturer/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
	<script src="{{ asset('assets/front/lecturer/js/forms/editors/tinymce.js') }}?v=1"></script>
@endpush
