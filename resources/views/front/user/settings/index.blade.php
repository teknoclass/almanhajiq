@extends('front.layouts.index', ['is_active' => 'settings', 'sub_title' => 'الاعدادات'])

@section('content')
    <!-- start:: section -->
    <section class="wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row mb-lg-4">
                <div class="col-12">
                    <ol class="breadcrumb mb-lg-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}">{{ __('home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('setting') }}</li>
                    </ol>
                </div>
            </div>
            <div class="row my-5 py-lg-5">
                <div class="col-lg-8 mx-auto">
                    <div class="bg-white box-shadow rounded-30">
                        <div class="row gx-lg-0">
                            {{-- <div class="col-lg-4">
                <div class="nav flex-column nav-pills tabs-setting" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#v-pills-1" type="button">كلمة المــــرور</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-2" type="button">طرق الدفـع</button>
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-3" type="button">حذف الحســاب</button>
                </div>
            </div> --}}
                            @php
                                $demo_emails = ['student@test.com', 'lecturer@test.com'];
                            @endphp
                            <div class="col-lg12">
                                <div class="tab-content p-4" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-1">
                                        <h3 class="font-medium text-center mb-3">{{ __('create_new_password') }}</h3>
                                        <form class="wow fadeInUp" id="form"
                                            action="{{ route('user.profileSettings.changePassword.update') }}"
                                            to="#" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <input class="form-control " type="password" name="current_password"
                                                    required minlength="6" placeholder="{{ __('current_password') }}"
                                                    {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }} />
                                            </div>

                                            <div class="form-group">
                                                <input class="form-control " type="password" name="new_password"
                                                    id="password" required minlength="6"
                                                    placeholder="{{ __('new_password') }}"
                                                    {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }} />
                                                    <div class="d-flex gap-1 mt-1">
                                                        <span><svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M6.8175 6.75C6.99383 6.24875 7.34186 5.82608 7.79997 5.55685C8.25807 5.28762 8.79667 5.1892 9.32038 5.27903C9.84409 5.36886 10.3191 5.64114 10.6613 6.04765C11.0035 6.45415 11.1908 6.96864 11.19 7.5C11.19 9 8.94 9.75 8.94 9.75M9 12.75H9.0075M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5C4.85786 16.5 1.5 13.1421 1.5 9C1.5 4.85786 4.85786 1.5 9 1.5C13.1421 1.5 16.5 4.85786 16.5 9Z"
                                                                    stroke="#060606" stroke-opacity="0.5" stroke-width="1.33333"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <p class="text-color-muted">يجب أن تحتوي كلمة المرور علي الأقل ٨ أحرف أبجدية
                                                            و رموز و أرقام</p>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <input class="form-control " type="password"
                                                    name="new_password_confirmation" required minlength="6"
                                                    placeholder="{{ __('new_password_confirmation') }}"
                                                    {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }} />
                                            </div>

                                            <div class="form-group mt-4">
                                                @include('front.components.btn_submit', [
                                                    'btn_submit_text' => __('save'),
                                                ])
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-2">
                                        <div class="text-center">
                                            <h3 class="font-medium text-center mb-2">طرق الدفـع</h3>
                                            <h4 class="text-muted mb-4">حفظ طريقة الدفع للسهولة في المستقبل</h4>
                                            <h3 class="font-medium mb-2 mx-1">بطاقة صراف أو إئتمان</h3>
                                            <div class="d-flex align-items-center justify-content-center mb-4"><img
                                                    class="mx-1" src="assets/images/svg/paypal.svg" alt="" loading="lazy"/><img
                                                    class="mx-1" src="assets/images/svg/amex.svg" alt="" loading="lazy"/><img
                                                    class="mx-1" src="assets/images/svg/mastercard.svg"
                                                    alt="" loading="lazy"/><img class="mx-1" src="assets/images/svg/visa.svg"
                                                    alt="" loading="lazy"/></div><a class="btn btn-primary font-medium w-100"
                                                href="">إضافة بطاقة </a>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-3">
                                        <div class="text-center py-4 my-4">
                                            <h3 class="font-medium mb-1">سوف يتم حذف حسابك <span
                                                    class="text-primary">نهائياً</span></h3>
                                            <h3 class="font-medium mb-3">هل أنت متأكد أنك تريد حذف حسابك ؟</h3><a
                                                class="btn btn-primary font-medium w-100" href="">حذف الحســاب</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    @push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
    @endpush
@endsection
