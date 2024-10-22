@extends('front.layouts.index', ['is_active' => 'profile', 'sub_title' => __('profile')])

@section('content')
<!-- start:: section -->
@push('front_before_css')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
@endpush
@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
      <div class="row mb-4">
        <div class="col-12">
          <ol class="breadcrumb mb-lg-0">
            <li class="breadcrumb-item"><a href="#">{{ __('home') }}</a></li>
            <li class="breadcrumb-item active">{{ __('profile') }}</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <div class="bg-white rounded-30 p-4 box-shadow">
            <div class="row">
              <div class="col-lg-10 mx-auto">
                <form id="form" action="{{route('user.profileSettings.profile.update')}}" to="{{url()->current()}}" method="post">
                   @csrf
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group text-center">
                        <label class="uploadImg pointer" for="uploadImg">
                          <input class="hidden imgload d-none" name="file" id="uploadImg" type="file" accept="image/png, image/gif, image/jpeg"/><span class="profile-image symbol symbol-100"><img class="imgShow rounded-circle" src="{{ imageUrl(auth()->user()->image) }}" alt="{{ auth()->user()->name }}" loading="lazy"/></span>
                          <div class="overlay">
                            <div class="icon"><i class="fa-regular fa-camera"></i></div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="row gx-lg-3">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <input class="form-control" name="name" type="text" value="{{ auth()->user()->name }}" placeholder="{{ __('name') }}"/>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <div class="input-icon right">
                            <select class="form-control selectpicker" name="gender" required type="text">
                                 <option value="" disabled selected>{{__('gender')}}</option>
                                 @foreach(config('constants.gender') as $gender )
                                 <option {{ auth()->user()->gender==$gender?'selected':''}} value="{{$gender}}">
                                 {{__($gender)}}
                                 </option>
                               @endforeach
                            </select>
                          <div class="icon text-muted"><i class="fa-solid fa-mars"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row gx-lg-3">
                    <div class="col-lg-6">
                        <div class="form-group select-contry">
                           <select class="selectpicker" required name="country_id">
                              <option value="" selected disabled>
                                 {{__('country')}}
                              </option>
                              @foreach($countries as $country)
                              <option value="{{@$country->value}}" {{auth()->user()->country_id==$country->value?'selected':''}}>
                              {{@$country->name}}
                              </option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <div class="input-icon left">
                          <input class="form-control datetimepicker_1" name="dob" type="text" value="{{ auth()->user()->dob }}" placeholder="تاريخ الميلاد" autocomplete="off"/>
                          <div class="icon text-muted"><i class="fa-regular fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                    <div class="form-group select-contry">
                        <select class="selectpicker" required name="mother_lang_id">
                            <option value="" selected disabled>
                                {{__('mother_language')}}
                            </option>
                            @foreach($languages as $language)
                            <option value="{{@$language->value}}" {{auth()->user()->mother_lang_id==$language->value?'selected':''}}>
                            {{@$language->name}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $demo_emails = ['student@test.com', 'lecturer@test.com'];
                    @endphp
                  <div class="form-group">
                    @if (in_array(auth()->user()->email, @$demo_emails))
                        <input type="hidden" name="email"  value="{{auth()->user()->email}}"/>
                    @endif
                    <input class="form-control" name="email" type="text" value="{{ auth()->user()->email }}" placeholder="{{ __('email') }}"
                        {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}/>
                  </div>
                  <div class="form-group ">
                      <input type="hidden" name="code_country"
                      value="{{
                         auth()->user()->code_country?
                         auth()->user()->code_country :
                         defaultCountryCode()
                        }}"  class="code_counrty">
                      <input type="hidden" name="slug_country"
                      value="{{auth()->user()->slug_country?auth()->user()->slug_country :defaultCountrySlug()}}"  class="slug_country">
                      <input
                         type="number" minlength="10" maxlength="10" name="mobile"
                         required placeholder="{{__('enter_mobile_number')}}"
                         class="form-control  mobile-number h-50px"
                         id="phone"
                         value="{{auth()->user()->mobile}}"
                         />
                   </div>
                  {{-- <div class="form-group">
                    <div class="input-icon left">
                      <input class="form-control" name="new_password" type="password" value="" placeholder="{{ __('password') }}"/>
                      <div class="icon text-muted"><i class="fa-regular fa-pen-to-square"></i></div>
                    </div>
                  </div> --}}
                  <div class="form-group mt-4">
                    <button class="btn btn-primary w-100" type="submit">{{ __('save') }} </button>
                  </div>
                </form>
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

        window.initialCountry="{{auth()->user()->slug_country?auth()->user()->slug_country :defaultCountrySlug()}}"
    </script>
    @include('front.components.mobile_number_script')
@endpush
@endsection
