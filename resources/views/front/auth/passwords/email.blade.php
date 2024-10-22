@extends('front.layouts.index')

@section('content')

		<!-- start:: section -->
		<section class="section bg-white">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-6 order-1 order-lg-0">
						<div class="text-center"> <img src="{{imageUrl(@$settings->valueOf('verification_img'))}}" alt="{{__('login')}}"  loading="lazy"/></div>
					</div>
					<div class="col-lg-6">
						<div class="row pe-lg-4">
							<div class="col-lg-10 py-lg-5">
								<div class="mb-4 mb-lg-5">
									<h2 class="font-bold mb-2"> {{ __('did_you_forget_your_password') }}</span></h2>
									<h4 class="text-muted">{{ __('forgot_password_subheading') }}</h4>
								</div>
								<form class="wow fadeInUp" id="form" action="{{route('user.auth.forget.password.post')}}" to="#" method="POST">
                                    @csrf
									<div class="form-group">
										<input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
											value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('email') }}">

										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="form-group mt-4 text-center">
										<button class="primary-btn p-2 w-100 font-medium" type="submit">{{ __('confirm') }}</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- end:: section -->

    @push('front_js')
    <script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>
    @endpush
@endsection
