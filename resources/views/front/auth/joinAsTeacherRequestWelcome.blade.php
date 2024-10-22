@extends('front.layouts.index', ['sub_title' => __('home')])

@section('content')

	<section class="section wow fadeInUp" data-wow-delay="0.1s"
		style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mx-auto">
					<div class="bg-white rounded-30 p-4 box-shadow">
						<div class="row">
                            <div class="col-lg-10 mx-auto">
                                <div class="row gx-lg-3">
                                    <div class="col-12 d-flex flex-column align-items-center text-center">
                                        <img class="pt-2" src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy">
                                        <h2 class="pt-2"><strong>{{ __('thank_you') }}</strong></h2>
                                        <p class="pt-2">{{ __('request_received_successfully') }}</p>
                                        <p class="pt-2">{{ __('and_We_will_mail_you_with_your_login_credintials_after_admin_confirmation') }}</p>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    @push('front_js')
    <script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>
    @endpush


@endsection
