@push('front_before_css')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
@endpush
@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row">

        <div class="col-lg-12 mx-auto">
            <form id="form" action="{{route('user.profileSettings.profile.update')}}" to="{{ url()->current() }}" method="post">
               @csrf
                <div class="row">
                    <div class="col-12">
                       <div class="form-group text-center">
                          <label class="uploadImg pointer" for="uploadImg">
                             <input class="hidden imgload d-none" name="file" id="uploadImg" type="file" accept="image/png, image/jpeg, image/jpg, image/webp, application/pdf" /><span class="profile-image">
                             <img class="imgShow rounded-circle" src="{{imageUrl(@$lecturer->image)}}" alt="{{@$lecturer->name}}" loading="lazy"/>
                             </span>
                             <div class="overlay">
                                <div class="icon"><i class="fa-regular fa-camera"></i></div>
                             </div>
                          </label>
                       </div>
                    </div>
                </div>
                <div class="row gx-lg-3 mt-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h3>{{ __('trainer_name') }}</h3>
                            <input class="form-control" name="name"  placeholder="{{ __('trainer_name') }}" required type="text" value="{{@$lecturer->name}}" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h3>{{ __('gender') }}</h3>
                           <select class="form-control selectpicker" name="gender" required type="text">
                                <option value="" disabled selected>{{__('gender')}}</option>
                                @foreach(config('constants.gender') as $gender )
                                <option {{@$lecturer->gender==$gender?'selected':''}} value="{{$gender}}">
                                {{__($gender)}}
                                </option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group select-contry">
                            <h3>{{ __('country') }}</h3>
                           <select class="selectpicker" required name="country_id">
                              <option value="" selected disabled>
                                 {{__('country')}}
                              </option>
                              @foreach($countries as $country)
                              <option value="{{@$country->value}}" {{@$lecturer->country_id==$country->value?'selected':''}}>
                              {{@$country->name}}
                              </option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group select-contry">
                            <h3>{{ __('mother_language') }}</h3>
                           <select class="selectpicker" required name="mother_lang_id">
                              <option value="" selected disabled>
                                 {{__('mother_language')}}
                              </option>
                              @foreach($languages as $language)
                              <option value="{{@$language->value}}" {{@$lecturer->mother_lang_id==$language->value?'selected':''}}>
                              {{@$language->name}}
                              </option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-auto mb-auto">
                       <div class="form-group">
                        <h3>{{ __('city') }}</h3>
                          <input class="form-control" type="text" name="city" required value="{{@$lecturer->city}}" placeholder="{{__('city')}}" />
                       </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-icon left">
                                <h3>{{ __('date_of_birth') }}</h3>
                                <input class="form-control datetimepicker_1 group-date" name="dob" value="{{@$lecturer->dob}}" required type="text" placeholder="{{ __('date_of_birth') }}" autocomplete="off">
                                <div class="icon"><i class="fa-light fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group ">
                            <h3>{{ __('mobile') }}</h3>
                            <input type="hidden" name="code_country"
                            value="{{
                               @$lecturer->code_country?
                               @$lecturer->code_country :
                               defaultCountryCode()
                              }}"  class="code_counrty">
                            <input type="hidden" name="slug_country"
                            value="{{@$lecturer->slug_country?@$lecturer->slug_country :defaultCountrySlug()}}"  class="slug_country">
                            <input
                               type="number" minlength="10" maxlength="10" name="mobile"
                               required placeholder="{{__('enter_mobile_number')}}"
                               class="form-control  mobile-number h-50px"
                               id="phone"
                               value="{{@$lecturer->mobile}}"
                               />
                         </div>
                    </div>
                    @php
                        $demo_emails = ['student@test.com', 'lecturer@test.com'];
                    @endphp
                    <div class="form-group col-lg-6">
                        <h3>{{ __('email') }}</h3>
                        @if (in_array(auth()->user()->email, @$demo_emails))
                            <input type="hidden" name="email"  value="{{@$lecturer->email}}"/>
                        @endif
                        <input class="form-control" type="text" name="email"  value="{{@$lecturer->email}}" placeholder="{{__('email')}}"
                            {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}/>
                    </div>
                    {{-- <div class="form-group col-lg-6">
                        <div class="input-icon left">
                            <input class="form-control" name="new_password" placeholder="{{ __('password') }}" type="password" value=""/>
                            <div class="icon text-muted"><i class="fa-regular fa-pen-to-square"></i></div>
                        </div>
                    </div> --}}
                </div>

                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
    </div>
</div>

<div class="row g-5 gx-xxl-8 mt-5 mb-4">
    <div class="bg-white p-4 rounded-4">
        <h3 class="font-medium text-center mb-3">{{ __("create_new_password") }}</h3>
        <form class="wow fadeInUp" id="form_2" action="{{route('user.profileSettings.changePassword.update')}}" to="#" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-lg-4">
                    <input class="form-control " type="password" name="current_password" required minlength="6" placeholder="{{__('current_password')}}"
                        {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}/>
                </div>

                <div class="form-group col-lg-4">
                    <input class="form-control " type="password" name="new_password" id="password" required minlength="6" placeholder="{{__('new_password')}}"
                        {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}/>
                </div>
                <div class="form-group col-lg-4">
                    <input class="form-control " type="password" name="new_password_confirmation" required minlength="6" placeholder="{{__('new_password_confirmation')}}"
                        {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}/>
                </div>
            </div>

            @include('front.user.lecturer.courses.new_course.components.save_button')
        </form>
    </div>
</div>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"> </script>
    <script>
        $(".datetimepicker_1").datetimepicker({
            format: "yyyy/mm/dd",
            todayHighlight: true,
            autoclose: true,
            startView: 2,
            minView: 2,
            forceParse: 0,
            pickerPosition: "bottom-left",
        });

        window.initialCountry="{{@$lecturer->slug_country?@$lecturer->slug_country :defaultCountrySlug()}}"

    </script>
    @include('front.components.mobile_number_script')
@endpush
