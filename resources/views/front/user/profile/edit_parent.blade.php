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
            <li class="breadcrumb-item active">{{ __('parent_settings') }}</li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 mx-auto">
          <div class="bg-white rounded-30 p-4 box-shadow">
            <div class="row">
              <div class="col-lg-10 mx-auto">
                <form id="form" action="{{route('user.profileSettings.profile.parent.update')}}" to="{{url()->current()}}" method="post">
                   @csrf
                  
             
                   <div class="form-group ">
                      <input type="hidden" name="parent_code_country"
                      value="{{
                         auth()->user()->parent_code_country?
                         auth()->user()->parent_code_country :
                         defaultCountryCode()
                        }}"  class="code_counrty">
                      <input type="hidden" name="parent_slug_country"
                      value="{{auth()->user()->parent_slug_country?auth()->user()->parent_slug_country :defaultCountrySlug()}}"  class="parent_slug_country">
                      <input
                         type="number" minlength="10"  name="parent_mobile_number" required
                          placeholder="{{__('enter_parent_mobile_number')}}"
                         class="form-control  mobile-number h-50px"
                         id="phone"
                         value="{{auth()->user()->parent_mobile_number}}"
                         />
                   </div>
                <span style="color:cadetblue">{{__('status')}} : {{__(@getUser('web')->myParentRequest->status)}}</span>
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
