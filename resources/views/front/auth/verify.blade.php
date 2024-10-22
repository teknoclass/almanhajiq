@extends('front.layouts.index')

@section('content')

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
                      <div class="mb-4 mb-lg-5">
                        <h2 class="font-bold mb-2">{{ __('confirm_account') }} </h2>
                        <h4 class="text-muted">{{ __('enter_code_received_on_email') }}</h4>
                    </div>
                      <form class="wow fadeInUp" id="form" action="{{route('user.auth.verify.verification')}}" to="back3" method="POST">
                        @csrf
                        <div class="form-group">
                          <div class="input-activate">
                            <input class="form-control" name="code_1" type="text" maxlength="1" required/>
                            <input class="form-control" name="code_2" type="text" maxlength="1" required/>
                            <input class="form-control ms-4 ms-lg-5" name="code_3" type="text" maxlength="1" required/>
                            <input class="form-control" name="code_4" type="text" maxlength="1" required/>
                            <input class="form-control" name="code_5" type="text" maxlength="1" required/>
                            <input class="form-control" name="code_6" type="text" maxlength="1" required/>
                          </div>
                        </div>
                        <div class="form-group mt-4 text-center">
                          <button class="btn btn-primary-2 rounded-pill w-100 font-medium" type="submit">{{ __('confirm') }}</button>
                        </div>
                        <div class="form-group mt-4 text-center">
                          <h4 class="text-underline text-muted pointer">
                                <span id="time"></span>

                                <a href="{{route('user.auth.verify.resend')}}" class="resend_code">
                                    {{ __('resend_code') }}
                                </a>
                            </h4>
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
        <script>
            $(".input-activate .form-control").keyup(function () {
            if (this.value.length == this.maxLength) {
                $(this).next('.form-control').focus();
            }
            });
        </script>

        <script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>

        <script>
            $(document).ready(function() {
                checkShowResendCodeLink();
            });


            function checkShowResendCodeLink() {
                $('.resend_code').hide();
                var counter = 60;
                var interval = setInterval(function() {
                    counter--;
                    // Display 'counter' wherever you want to display it.
                    if (counter <= 0) {
                        clearInterval(interval);
                        $('#time').hide();
                        $('.resend_code').show();
                        $('.resend_code').data('url', data.url_resend);
                        return;
                    } else {
                        $('#time').text('00:' + counter);
                    }
                }, 1000);
            }
        </script>
    @endpush
@endsection








{{--
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
