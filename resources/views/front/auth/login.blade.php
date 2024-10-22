@extends('front.layouts.index')

@section('content')
    <!-- start:: section -->
    <section class="section-padding">
        <div class="container">

                <div
                    class="d-flex flex-wrap justify-content-center p-2 prim-border shadow-sm rounded overflow-hidden bg-white align-items-center">
                    <div class="col-md-6 order-1 order-lg-0 login-img">
                        <div class="text-center position-relative ">
                            <img src="{{ imageUrl(@$settings->valueOf('login_image')) }}" alt="{{ __('login') }}" loading="lazy"/>
                            {{-- <div class="text-img-login">
                                    <h5>تدريس أكاديمي</h5>
                                    <p>
                                        حصص مليئة بالتفاعل والأنشطة التفاعلية وهذا ما يجعل الدرس مسلياً وماتعاً.
                                    </p>
                                </div> --}}
                        </div>
                    </div>
                    <div class="col-12 p-2 col-md-6">
                        <div class="text-center">
                            <h5 class="text-color-primary mb-2 fw-bold fs-3 text-center">{{ __('login') }}</h5>
                            <div class="">
                                {{-- <div class="nav-login d-flex align-items-center mb-4">
                                    <div class="nav-item"><a class="nav-link active"
                                            href="{{ route('user.auth.login') }}">تسجيـل الدخـول</a></div>
                                    <div class="nav-item"><a class="nav-link" href="{{ route('user.auth.register') }}">إنشاء
                                            حساب</a></div>
                                </div> --}}
                                <form class="wow fadeInUp" id="form" action="{{ route('user.auth.login') }}"
                                    to="back" to2="{{ route('user.home.index') }}" method="POST">
                                    @csrf
                                    <input type="hidden" class="device_token" id="device_token" name="device_token" />
                                    <div class="form-group">

                                        <input id="email" type="text"
                                            class="form-control prim-border @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="{{ __('email') }}"
                                            required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password"
                                            class="form-control prim-border @error('password') is-invalid @enderror"
                                            name="password" placeholder="{{ __('password') }}" required
                                            autocomplete="current-password">

                                        @error('password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group d-flex align-items-center justify-content-between">
                                        <label class="m-checkbox mb-0">
                                            <input type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }} /><span
                                                class="checkmark"></span><span>{{ __('remember_me') }}</span>
                                        </label>
                                        @if (Route::has('user.auth.forget.password.get'))
                                            <h6><a class="text-underline text-color-primary"
                                                    href="{{ route('user.auth.forget.password.get') }}">
                                                    {{ __('did_you_forget_your_password') }}
                                                </a>
                                            </h6>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h4 class="text-center mb-3"> أو</h4>
                                        <div class="text-center mb-3">
                                            {{-- <a class="p-3" href=""><img src="{{ asset('assets/front/images/svg/facebook.svg') }}" alt="{{__('login')}}" /></a> --}}
                                            <a class="p-3" href="{{ route('login.google') }}"><img
                                                    src="{{ asset('assets/front/images/svg/google.svg') }}"
                                                    alt="{{ __('login') }}" loading="lazy"/></a>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 text-center">
                                        <button class="primary-btn py-2 rounded w-100 font-medium" type="submit"
                                            id="btn_submit">{{ __('login') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="text-muted text-center mb-4">{{ __('you_do_not_have_an_account') }} <a
                                    class="font-bold text-color-primary"
                                    href="{{ route('user.auth.register') }}">{{ __('join_now') }} </a>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </section>
    <!-- end:: section -->

    @push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}?v={{ getVersionAssets() }}"></script>


        {{-- FireBase --}}
        <script>
            const messaging = firebase.messaging();


            function retreiveToken() {
                $('#load').show();
                // messaging
                // .requestPermission()
                // .then(function() {
                // 	return messaging.getToken()
                // })
                // .then(function(response) {
                // 	$('#device_token').val(response);
                // }).catch(function(error) {});

                messaging.getToken({
                    vapidKey: '{{ env('FIREBASE_VAPID_KEY') }}'
                }).then((currentToken) => {
                    if (currentToken) {
                        $('#device_token').val(currentToken);
                        console.log(currentToken);
                    } else {
                        alert('Something went wrong!');
                    }
                }).catch((err) => {
                    console.log(err.message);
                });

                $('#load').hide();
            }

            $(document).ready(function() {
                retreiveToken();
            });
        </script>
    @endpush
@endsection
