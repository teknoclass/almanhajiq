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

            <input type="hidden" id="needToolbarConfirm" value="false">
            <form id="courseForm" method="{{ isset($item) ? 'POST' : 'POST' }}" to="#" url="{{ url()->current() }}"
                enctype="multipart/form-data" class="w-100">
                <input type="hidden" name="welcome_text_for_registration_image" id="image"
                    value="{{ @$item->welcome_text_for_registration_image }}" />
                <input type="hidden" value="{{ @$item->certificate_text_image }}" name="certificate_text_image" id="image_3" />
                <input type="hidden" value="{{ @$item->faq_image }}" name="faq_image" id="image_2" />
                @csrf
                <div class="container">
                    <div class="row">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b example example-compact">
                            <div class="card-body">
                                <div class="row">
                                    @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')
                                    <div class="form-group mb-10">
                                        <div class="form-group">
                                            <label>{{ __('price') }}</label>
                                            <input type="text" class="form-control " name="price"
                                                value="{{ isset($item->priceDetails->price) && $item->priceDetails->price != '' ? $item->priceDetails->price : 0 }}" />
                                            <p class="mt-1">
                                                <strong>( {{ __('price_hint') }} )</strong>
                                            </p>
                                        </div>
                                    </div>


                                    <div class="form-group mb-10">
                                        <div class="form-group">
                                            <label>{{ __('discount_price') }} <span class="text-danger"></span></label>
                                            <input type="text" class="form-control " name="discount_price" id="discount_price" min="0"
                                                value="{{ isset($item->priceDetails->discount_price) && $item->priceDetails->discount_price != '' ? $item->priceDetails->discount_price : 0 }} " />

                                        </div>
                                    </div>

                                    {{--<div class="form-group mb-10">
                                        <div class="form-group">
                                            <label>
                                                {{ __('system_commission') }}:
                                                <span class="text-success">
                                                    <strong>{{ getSystemCommission(@$item->user_id) == '' ? 0 : getSystemCommission(@$item->user_id) }}%</strong>
                                                </span>
                                            </label>
                                        </div>
                                    </div>--}}

                                </div>
                            </div>
                        </div>
                        @include('front.user.lecturer.courses.new_course.components.save_button')
                    </div>
                </div>
            </form>
        </div>
        @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')
    </section>

@push('front_js')
	<script src="{{ asset('assets/front/js/post.js') }}"></script>
	<script src="{{ asset('assets/panel/js/image-input.js') }}"></script>


	<script>
		document.getElementById('discount_price').addEventListener('input', function() {
			var price = parseFloat(document.getElementById('price').value);
			var discountedPrice = parseFloat(this.value);
			// التحقق مما إذا كانت القيمة المخفضة أكبر من السعر وتعديلها إذا كان ذلك صحيحًا
			if (discountedPrice > price) {
				this.value = price - 1;
			}
		});
	</script>
@endpush
@endsection
