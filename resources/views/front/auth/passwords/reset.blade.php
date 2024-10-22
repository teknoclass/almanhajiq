<!DOCTYPE html>
<html dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
@include('front.layouts.css')

<body>
	<!-- begin:: Page -->
	<div class="main-wrapper">
		<div class="mobile-menu-overlay"></div>
		<div class="loader-page"><span></span><span></span></div>

		<!-- start:: section -->
        <section class="section bg-white">
            <div class="container">
              <div class="row align-items-center">
                <div class="col-lg-6 order-1 order-lg-0">
                  <div class="text-center"> <img src="{{imageUrl(@$settings->valueOf('verification_img'))}}" alt="{{__('login')}}" loading="lazy"/></div>
                </div>
                <div class="col-lg-6">
                  <div class="row pe-lg-4">
                    <div class="col-lg-10 py-lg-5">
                      <div class="mb-4">
                        <h2 class="font-bold">{{ __('change_password') }}  </h2>
                      </div>
                      <form class="wow fadeInUp" id="form" action="{{route('user.auth.reset.password.post')}}" to="{{route('user.auth.login')}}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ @$email }}">
                        <input type="hidden" name="token" value="{{ @$token }}">

                        <div class="form-group">
                            <input class="form-control " type="password" name="password" id="password" required  placeholder="{{ __('new_password') }}" />

                            @error('password')
                                <span class="text-danger">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control " type="password" name="password_confirmation" required  placeholder="{{ __('password_confirmation') }}" />
                            {{-- @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                        </div>
                        <div class="form-group mt-4 text-center">
                          <button class="btn btn-primary-2 rounded-pill w-100 font-medium" type="submit">{{ __('confirm') }}</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- end:: section -->

	</div>
	<!-- end:: Page -->

	@include('front.layouts.scripts')
    <script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>

</body>

</html>








{{--

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
