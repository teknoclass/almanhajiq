@push('front_before_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/front/js/intlTelInput.js') }}"></script>
@endpush

<div class="container mb-5 pt-10 tab" id="{{ @$tab }}">
    <div class="row">
        <div class="col-12">
            <div class="card-course prim-border shadow-sm p-3" style="max-width:700px;margin: auto;"> 
                <div class="text-center pt-10">
                    <h5 class="text-colot-primary font-bold text-center">{{ __("be_successful_register_course_now") }}</h6>
                    <img src="{{ imageUrl(@$course->welcome_text_for_registration_image) }}" alt="{{ @$course->title }}" loading="lazy"/>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        {{-- <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="text-center mb-4">
                                    <img src="{{ imageUrl(@$course->welcome_text_for_registration_image) }}"
                                        alt="" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="text-muted"> المبلغ الكلـي :</h5>
                                    <h5 class="text-color-third"> {{ @$course->getPrice() }} </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 position-relative">
                            <div class="line-vertical"></div>
                        </div> --}}
                        @if (auth('web')->check())
                            <div class="col-lg pt-lg-5">
                                <form action="">
                                    <div class="row">
                                        {{-- <div class="col-12">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="رقم البطاقة" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" placeholder="CVC" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="selectpicker" title="اختر الشهر" data-size="5">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <select class="selectpicker" title="اختر السنة" data-size="5">
                                                        <option value="1">2022</option>
                                                        <option value="2">2023</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            @if(auth('web')->user()->role != "marketer")
                                            @include('front.courses.partials.single_course_page_sections.installments-and-full-sub')
                                            @endif
                                     
                                        {{-- <div class="col-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary-2 w-100 rounded-pill"><i class="fa-solid fa-cart-shopping me-2"></i> إضافة
                                                        الى السلة</button>
                                                </div>
                                            </div> --}}
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="col-md-6 loginRegisterForm">
                                <ul class="nav nav-pills mb-3 nav-pills-login" id="pills-tab">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-login"
                                            type="button" role="tab">{{ __('login') }}</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-register"
                                            type="button" role="tab">{{ __('register_now') }}</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="tab-login">
                                        <form class="wow fadeInUp" id="form" action="{{ route('user.auth.login') }}"
                                            to="{{ url()->current() }}" method="POST">
                                            @csrf
                                            <input type="hidden" class="device_token" id="device_token"
                                                name="device_token" />
                                            <div class="form-group">
                                                <label for="email" class="form-label text-color-primary">{{ __('email') }}</label>
                                                <input id="email" type="text"
                                                    class="form-control prim-border @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}"
                                                    placeholder="{{ __('email') }}" required autocomplete="email">

                                                @error('email')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="form-label text-color-primary">{{ __('password') }}</label>
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
                                                @if (Route::has('user.auth.forget.password.get'))
                                                    <h6 class="ms-auto"><a class="text-color-third fw-semibold"
                                                            href="{{ route('user.auth.forget.password.get') }}">{{ __('did_you_forget_your_password') }} </a>
                                                    </h6>
                                                @endif
                                            </div>
                                            {{-- <div class="form-group">
                                                <h4 class="text-center mb-3"> أو</h4>
                                                <div class="text-center mb-3">
                                                    <a class="p-3" href=""><img src="{{ asset('assets/front/images/svg/facebook.svg') }}" alt="{{__('login')}}" /></a>
                                                    <a class="p-3" href=""><img src="{{ asset('assets/front/images/svg/google.svg') }}" alt="{{__('login')}}" /></a>
                                                </div>
                                            </div> --}}
                                            <div class="form-group mt-4 text-center">
                                                <button class="primary-btn p-2 w-100 font-medium" type="submit"
                                                    id="btn_submit">{{ __('login') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab-register">
                                        <form id="form_2" action="{{ route('user.auth.register.store') }}"
                                            to="{{ url()->current() }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input class="form-control prim-border" type="text" name="name"
                                                    required placeholder="{{ __('full_name') }}" value="{{ old('name') }}" />
                                                @error('name')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control prim-border" type="text" name="email"
                                                    placeholder="{{ __('email') }}" value="{{ old('email') }}" />
                                                @error('email')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">

                                                <input type="hidden" name="code_country"
                                                    value="{{ defaultCountryCode() }}" class="code_counrty">
                                                <input type="hidden" name="slug_country"
                                                    value="{{ defaultCountrySlug() }}" class="slug_country">
                                                <input type="number" minlength="10" maxlength="10" name="mobile"
                                                    required placeholder="{{ __('mobile') }}"
                                                    class="form-control mobile-number second-color h-50px"
                                                    id="phone" />
                                                @error('mobile')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control prim-border" type="password" name="password"
                                                    placeholder="{{ __('password') }}" />
                                                @error('password')
                                                    <span class="text-danger">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between">
                                                <label class="m-checkbox mb-0">
                                                    <input type="checkbox" name="agree_conditions" />
                                                    <span class="checkmark"></span>
                                                    <span class="text-muted">
                                                        {{ __('by_clicking_I_agree_to') }}
                                                        <a class="text-primary-2 font-bold text-underline" href="{{ route('pages.single', ['sulg' => 'terms_and_conditions']) }}">
                                                            {{ __('terms_and_conditions') }}
                                                        </a>
                                                    </span>
                                                    @error('agree_conditions')
                                                        <span class="text-danger">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </label>
                                            </div>
                                            {{-- <div class="form-group">
                                                    <h4 class="text-center mb-3"> أو</h4>
                                                    <div class="text-center mb-3">
                                                        <a class="p-3" href=""><img src="{{ asset('assets/front/images/svg/facebook.svg') }}" alt="" /></a>
                                                        <a class="p-3" href=""><img src="{{ asset('assets/front/images/svg/google.svg') }}" alt="" /></a>
                                                    </div>
                                                </div> --}}
                                            <div class="form-group mt-4 text-center">
                                                <button class="primary-btn p-2 w-100 font-medium" type="submit"
                                                    id="btn_submit">{{ __('create_an_account') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script>
        window.initialCountry = "{{ @$lecturer->slug_country ? @$lecturer->slug_country : defaultCountrySlug() }}"
    </script>
    @include('front.components.mobile_number_script')

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
