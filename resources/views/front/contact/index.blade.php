@extends('front.layouts.index', ['is_active'=>'contact','sub_title'=>__('contact_us'), ])

@section('content')
    @push('front_before_css')
    <link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
    <script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
    @endpush

	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h2 class="font-bold title-section bg-right">{{ __('contact_us') }}</h2>
					<form id="form" action="{{route('contact.store')}}" to="#" method="POST">
                        @csrf
						<div class="form-group">
							<input class="form-control" required type="text" name="name" placeholder="{{ __('full_name') }}" />
						</div>
						<div class="form-group">
							<input class="form-control" type="email" name="email" placeholder="{{ __('email') }} " required />
						</div>
						<div class="form-group d-flex border rounded-pill selectpicker-country bg-white">
                            <input type="hidden" name="code_country"  class="code_counrty form-control">
                            <input type="hidden" name="slug_country"   class="slug_country form-control">
                            <input
                                type="text" minlength="10" maxlength="10" name="mobile"
                                required placeholder="{{__('mobile')}}" min="10" 
                                class="form-control mobile-number "
                                id="phone" />

							{{-- <input class="form-control border-0" type="text" name="mobile" placeholder="رقم الجوال" />
							<select class="selectpicker" data-style="border-0" data-width="210px">
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='{{ asset('assets/front/images/flag.png') }}' /&gt;&lt;/span&gt;">Choice1</option>
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='{{ asset('assets/front/images/flag.png') }}' /&gt;&lt;/span&gt;">Choice1</option>
                                <option data-content="&lt;span&gt;&lt;span class='me-2'&gt;+972&lt;/span&gt;&lt;img class='img-flag' src='{{ asset('assets/front/images/flag.png') }}' /&gt;&lt;/span&gt;">Choice1</option>
                            </select> --}}
						</div>
						<div class="form-group">
							<input required class="form-control" type="text" name="subject" placeholder="{{ __('subject') }}" />
						</div>
						<div class="form-group">
							<textarea required class="form-control p-3" rows="4" name="text" placeholder="{{ __('message') }}"></textarea>
						</div>
						<div class="form-group mt-4">
							<button class="btn btn-primary w-100 font-medium rounded-pill" type="submit"  id="btn_submit">
                                <div class="spinner-border ml-6" style="display:none ;" role="status">
                                    <span class="sr-only">{{ __("please_wait") }}</span>
                                </div>
                                <span class="px-2">
                                    {{ __('send') }}
                                </span>
                            </button>
						</div>
					</form>
				</div>
				<div class="col-lg-5 me-auto wow fadeInUp mt-lg-5 pt-lg-5">
					<div class="bg-white rounded-15 p-3 p-lg-4 box-shadow">
						<div class="mb-3">
							<h5 class="mb-4">{{ __('contact_us_message_section') }}</h5>
                            <a class="d-flex align-items-baseline text-dark p-2" href="tel:{{ @$settings->valueOf('mobile') }}">
                                <i class="fa-solid fa-mobile-screen-button me-3 fa-xl"></i>
								<h5 class="dir-ltr">{{ @$settings->valueOf('mobile') }}</h5>
							</a>
                            <a class="d-flex align-items-baseline text-dark p-2" href="mailto:{{ @$settings->valueOf('email') }}">
                                <i class="fa-solid fa-envelope me-3 fa-xl"></i>
								<h5>{{ @$settings->valueOf('email') }}</h5>
							</a>
						</div>
						<ul class="social-media mt-2 social-dark py-2 px-4">
                            @foreach ($social_media as $social)
                            @if($social->getLink()!='#')
                            <li>
                                <a class="{{ $social->class}}" href="{{$social->getLink()}}" target="_blank">
                                    <i class="fa-brands {{ $social->icon}}"> </i></a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
					</div>
				</div>
			</div>
            @if (@$settings->valueOf('map') )
			<div class="row mt-5">
				<div class="col-12">
                    <div class="map">
                        {!! @$settings->valueOf('map') !!}
                    </div>
				</div>
			</div>
            @endif
		</div>
	</section>
	<!-- end:: section -->
@endsection

@push('front_js')
<script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>

@include('front.components.mobile_number_script')

@endpush
