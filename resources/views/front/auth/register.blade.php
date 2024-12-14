@extends('front.layouts.index')

@section('content')
    @push('front_css')
        <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.css') }}">
        <script src="{{ asset('assets/front/js/intlTelInput.js') }}"></script>
    @endpush

    <!-- start:: section -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center m-1 shadow-sm overflow-hidden prim-border bg-white rounded">
                <div class="col-lg-6 col-12 order-lg-0 order-1 p-sm-0 p-lg-2">
                    <div class="m-auto w-100  text-center position-relative  login-img">
                        <img src="{{ imageUrl(@$settings->valueOf('student_reg_img')) }}" alt="{{ __('register') }}" loading="lazy" />
                        {{-- <div class="text-img-login">
                                <p>
                                    حصص مليئة بالتفاعل والأنشطة التفاعلية وهذا ما يجعل الدرس مسلياً وماتعاً.
                                </p>
                            </div> --}}
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="d-flex py-3 flex-column m-auto">
                        <div class="">
                            <div>
                                <h5 class="text-color-primary mb-3 fw-bold fs-3 text-center">{{ __('register') }}</h5>
                                <div class="d-flex p-1 signup-tab align-items-center prim-border justify-content-center gap-1 mb-4">
                                        <button class="w-100 active" id="studentBtn">{{ __('student1') }}</button>
                                        <button class="w-100" id="teacherBtn">{{ __('lecturer1') }}</button>
                                        <button class="w-100" id="marketerBtn">{{ __('marketer') }}</button>
                                        <button class="w-100" id="parentBtn">{{ __('parent') }}</button>
                                </div>
                                <h4 class="text-center mt-3 mb-4 registeration-type">
                                    {{ __('now_you_are_registering_as') }} <strong>{{ __('student1') }}</strong>
                                </h4>
                                <form class="wow fadeInUp" id="form" action="{{route('user.auth.register.store')}}"
                                    to="{{route('user.auth.verify.user')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="coupon" value="{{ request('coupon') }}" />
                                    <input type="hidden" name="role" id="selectRole" value="student" />
                                    <div class="form-group">
                                        <label class="text-color-primary fw-bold d-block"
                                            for="name">{{ __('full_name') }}</label>
                                        <input class="form-control" type="text" name="name" required
                                            placeholder="{{ __('full_name') }}" value="{{ old('name') }}" />
                                        @error('name')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="text-color-primary fw-bold d-block"
                                            for="email">{{ __('email') }}</label>
                                        <input class="form-control" type="text" name="email"
                                            placeholder="{{ __('email') }}" value="{{ old('email') }}" />
                                        @error('email')
                                            <span class="text-danger d-block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"
                                            class="d-block fw-bold text-color-primary">{{ __('mobile') }}</label>
                                        <input type="hidden" class="code_country" name="code_country" value="{{ defaultCountryCode() }}"
                                            class="code_counrty">
                                        <input type="hidden" name="slug_country" value="{{ defaultCountrySlug() }}"
                                            class="slug_country">
                                        <input type="number" minlength="10" maxlength="10" name="mobile" required
                                            placeholder="554 898 55 22"
                                            class="form-control mobile-number second-color h-50px" id="phone" />
                                        @error('mobile')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-md-12 country_col">
                                            <div class="form-group select-contry">
                                                <select class="selectpicker" required name="country_id">
                                                    <option value="" selected disabled>
                                                        {{__('country')}}
                                                    </option>
                                                    @foreach($countries as $country)
                                                    <option value="{{@$country->value}}">
                                                    {{@$country->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 d-none city_col">
                                            <div class="form-group">
                                                <input class="form-control" type="text" id="city" name="city"
                                                    placeholder="{{ __('city') }}" value="{{ old('city') }}" />
                                                @error('city')
                                                    <span class="text-danger d-block">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group select-contry d-none gender-div">
                                        <select class="form-control selectpicker" name="gender" type="text">
                                            <option value="" disabled selected>{{__('gender')}}</option>
                                            @foreach(config('constants.gender') as $gender )
                                                <option {{@$lecturer->gender==$gender?'selected':''}} value="{{$gender}}">
                                                    {{__($gender)}}
                                                </option>
                                          @endforeach
                                       </select>
                                    </div>

                                    @php 
                                    // materials
                                    $parent = App\Models\Category::select('id', 'value', 'parent', 'key')->where('key', "joining_course")->first();
                                    $materials = App\Models\Category::query()->select('id', 'value', 'parent', 'key')->where('parent', $parent->key)
                                    ->orderByDesc('created_at')->with(['translations:category_id,name,locale', 'parent'])->get();
                                    @endphp
                                    <div class="form-group select-contry d-none gender-div">
                                        <select required class="form-control selectpicker" name="material_id" type="text">
                                            <option value="" disabled readonly selected>{{__('material')}}</option>
                                            @foreach($materials as $material)
                                            <option value="{{$material->id}}">{{$material->name}}</option>
                                          @endforeach
                                       </select>
                                    </div>

                                    <div class="form-group d-none gender-div">
                                        <h3>{{ __('dob') }}</h3>
                                        <input name="dob" id="" type="date" class="form-control">
                                    </div>

                                    <div class="form-group d-none gender-div">
                                        <h3>{{ __('about') }}</h3>
                                        <textarea name="about" id="" cols="30" rows="3" class="form-control"></textarea>
                                    </div>


                                    <div class="row d-none gender-div">
                                        <div class="form-group col-lg-6">
                                            <h3>{{ __('certificate') }}</h3>
                                            <select class="selectpicker" name="certificate_id">
                                                <option value="" selected disabled>{{__('certificate')}}</option>
                                                @foreach($certificates as $certificate)
                                                <option value="{{@$certificate->value}}">
                                                        {{@$certificate->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  col-lg-6">
                                            <h3>{{ __('section') }}</h3>
                                            <select class="selectpicker" name="specialization_id">
                                                <option value="" selected disabled>{{__('section')}}</option>
                                                @foreach($specializations as $specialization)
                                                <option value="{{@$specialization->value}}">
                                                        {{@$specialization->name}}
                                                </option>
                                                @endforeach
                                            </select>
                                         </div>
                                    </div>

                                    {{-- <div class="form-group">
                                        <input class="form-control" type="text" placeholder="التخصص" />
                                    </div> --}}
                                    <div class="form-group password_div">
                                        <label for="password"
                                            class="d-block fw-bold text-color-primary">{{ __('password') }}</label>
                                        <input class="form-control" type="password" name="password"
                                            placeholder="{{ __('password') }}" />
                                        @error('password')
                                            <span class="text-danger">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group d-none gender-div">
                                        <label class="input-image-preview d-block px-3 pointer" for="id_image">
                                            <input class="input-file-image-1" type="file" name="id_image" id="id_image" accept="image/png, image/jpeg, image/jpg,application/pdf">
                                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                                            <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                                <div class="flipthis-wrapper">
                                                <span class="">{{ __('id_image') }} </span>
                                                </div>
                                                <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-group d-none gender-div">
                                        <label class="input-image-preview d-block px-3 pointer" for="job_proof_image">
                                            <input class="input-file-image-1" type="file" name="job_proof_image" id="job_proof_image" accept="image/png, image/jpeg, image/jpg,application/pdf">
                                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                                            <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                                <div class="flipthis-wrapper">
                                                <span class="">{{ __('job_proof_image') }}</span>
                                                </div>
                                                <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="form-group d-none gender-div">
                                        <label class="input-image-preview d-block px-3 pointer" for="cv_file">
                                            <input class="input-file-image-1" type="file" name="cv_file" id="cv_file" accept="image/png, image/jpeg, image/jpg,application/pdf">
                                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                                            <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                                <div class="flipthis-wrapper">
                                                <span class="">{{ __('cv_file') }}</span>
                                                </div>
                                                <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                            </span>
                                        </label>
                                    </div>


                                    <div class="form-group d-flex align-items-center justify-content-between">
                                        <label class="m-checkbox mb-0">
                                            <input type="checkbox" name="agree_conditions" />
                                            <span class="checkmark"></span>
                                            <span class="text-muted">
                                                {{ __('by_clicking_I_agree_to') }}
                                                <a class="text-color-primary font-bold text-underline"
                                                    href="{{ route('pages.single', ['sulg' => 'terms_and_conditions']) }}">
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
                            <div class="text-muted text-center mb-4">{{ __('do_you_have_an_account') }} <a
                                    class="fw-bold text-underline text-color-primary"
                                    href="{{ route('user.auth.login') }}">{{ __('login') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->
    {{-- <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-30">
                <div class="modal-body px-lg-5">
                    <div class="text-center mb-3">
                        <h2 class="font-bold">{{ __('do_you_want_to_join_us_as') }}</h2>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary-2 w-100" id="studentBtn">{{ __('student1') }}</button>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary-2 w-100" id="teacherBtn">{{ __('lecturer1') }}</button>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary-2 w-100" id="marketerBtn">{{ __('marketer') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    @push('front_js')
        <script src="{{ asset('assets/front/js/post.js') }}?v={{ getVersionAssets() }}"></script>
        <script>
            window.initialCountry = "{{ @$lecturer->slug_country ? @$lecturer->slug_country : defaultCountrySlug() }}"
        </script>
        @include('front.components.mobile_number_script')
        <script>
            // Open the modal on page load
            $(document).ready(function() {
                let teacher = "{{ __('lecturer1') }}";
                let marketer = "{{ __('marketer') }}";
                let student1 = "{{ __('student1') }}";
                let parent = "{{ __('parent') }}";
                $('#registerModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#registerModal').modal('show');

                $('#studentBtn').on('click', function() {
                    change_to_lecturer(0);
                    $('#selectRole').val('student');
                    $('#registerModal').modal('hide');
                    $('.registeration-type strong').text(student1);
                });
                $('#parentBtn').on('click', function() {
                    change_to_lecturer(0);
                    $('#selectRole').val('parent');
                    $('#registerModal').modal('hide');
                    $('.registeration-type strong').text(parent);
                });

                $('#teacherBtn').on('click', function() {
                    change_to_lecturer(1);
                    $('#selectRole').val('lecturer');
                    $('.register-img-container img').attr('src',
                        '{{ imageUrl(@$settings->valueOf('lecturer_reg_img')) }}');
                    $('.registeration-type strong').text(teacher);
                    $('#registerModal').modal('hide');
                });

                $('#marketerBtn').on('click', function()
                {
                    change_to_lecturer(0);
                    $('#selectRole').val('marketer');
                    $('.register-img-container img').attr('src',
                        '{{ imageUrl(@$settings->valueOf('marketer_reg_img')) }}');
                    $('.registeration-type strong').text(marketer);
                    $('#registerModal').modal('hide');
                });
            });

            function change_to_lecturer(chk = 1)
            {
                if(chk){ // teacher
                    $('.country_col').removeClass('col-md-12').addClass('col-md-6');
                    $('.city_col').removeClass('d-none');
                    $('.gender-div').removeClass('d-none');
                    $('.password_div').addClass('d-none');
                }else{
                    $('.city_col').addClass('d-none');
                    $('.country_col').removeClass('col-md-6').addClass('col-md-12');
                    $('.gender-div').addClass('d-none');
                    $('.password_div').removeClass('d-none');
                }
            }
        </script>
    @endpush
@endsection
