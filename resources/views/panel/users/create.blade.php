@extends('panel.layouts.index',['sub_title' =>__('users') ,'is_active'=>'users'])
@section('title', __('users'))
@section('contion')
@push('panel_css')
<link rel="stylesheet" href="{{asset('assets/front/css/intlTelInput.css')}}">
<script src="{{asset('assets/front/js/intlTelInput.js')}}"></script>
@endpush

@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

   @php
   $title_page=__('add') ;
   if(isset($item)){
   $title_page=__('edit') ;
   }

   $breadcrumb_links=[
   [
   'title'=>__('home') ,
   'link'=>route('panel.home'),
   ],
   [
   'title'=>__('users') ,
   'link'=>route('panel.users.all.index'),
   ],
   [
   'title'=>$title_page,
   'link'=>'#',
   ],
   ];

   @endphp




   <!--begin::Entry-->
   <div class="container">
   @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('users') ,])
      <!--begin::Container-->

      <!--begin::Form-->
      <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
         @csrf
         <input type="hidden" value="{{@$item->image}}" name="image" id="image" />
         <div class="container">
            <div class="row">


               <div class="col-md-9">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title">
                           {{@$title_page}}
                        </h3>

                     </div>
                     <!--begin::Form-->
                     <div class="card-body">

                        <div class="row">

                           <div class="col-md-6">
                              <div class="form-group">
                                 <label>{{ __('name') }}
                                    <span class="text-danger">*</span></label>
                                 <input type="text" name="name" class="form-control" value="{{isset($item)?@$item->name:''}}" required />
                              </div>
                           </div>

                           <div class="col-md-6">

                              <div class="form-group">
                                 <label>{{__('gender')}}
                                    <span class="text-danger"></span></label>
                                 <select id="gender" name="gender" class="form-control">
                                    <option value="" selected disabled>{{__('gender_select')}} </option>
                                    @foreach(config('constants.gender') as $gender)
                                    <option value="{{$gender}}" {{@$item->gender==$gender ?'selected' :''}}>
                                       {{__($gender)}}
                                    </option>
                                    @endforeach

                                 </select>

                              </div>


                           </div>

                           <div class="col-md-6">

                              <div class="form-group">
                                 <label>{{__('email')}}
                                    <span class="text-danger">*</span></label>
                                 <input type="text" name="email" class="form-control" value="{{isset($item)?@$item->email:''}}" required />
                              </div>

                           </div>

                           <div class="col-md-6">
                              <div class="">
                                 <label>{{__('mobile')}}
                                    <span class="text-danger"></span></label>

                                  <div class="">
                           <input type="hidden" name="code_country" class="code_country"   value="{{@$item->code_country}}">
                           <input type="hidden" name="slug_country"   value="{{@$item->slug_country}}"
                             class="slug_country">
                           <input style="padding-left: 50px;"
                              type="number" minlength="10" maxlength="10" name="mobile"
                              required placeholder="{{__('enter_mobile_number')}}"
                              class="form-control mobile-number"
                              id="phone"
                              value="{{@$item->mobile}}"
                              />
                        </div>


                              </div>
                           </div>


                           <div class="col-md-6">

                              <div class="form-group">
                                 <label>{{__('country')}}
                                    <span class="text-danger"></span></label>
                                 <select id="country_id" name="country_id" class="form-control">
                                    <option value="" selected disabled>{{__('country_select')}}</option>
                                    @foreach($countries as $country)
                                    <option value="{{@$country->value}}" {{@$item->country_id==$country->value ?'selected' :''}}>{{@$country->name}} </option>
                                    @endforeach

                                 </select>

                              </div>


                           </div>


                           <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        {{__('mother_language')}} <span class="text-danger"></span>
                                    </label>
                                    <select id="mother_lang_id" name="mother_lang_id" class="form-control">
                                        <option value="" selected disabled>{{__('mother_lang_select')}}</option>
                                        @foreach($languages as $language)
                                        <option value="{{@$language->value}}" {{@$item->mother_lang_id==$language->value ?'selected' :''}}>{{@$language->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                           <div class="col-md-6">

                              <div class="form-group">
                                 <label>{{__('city')}}
                                    <span class="text-danger"></span></label>
                                 <input type="text" name="city" class="form-control" value="{{isset($item)?@$item->city:''}}" />
                              </div>

                           </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <label class="font-weight-bolder mb-2">{{__('date_of_birth')}}</label>
                                 <br>
                                 <div class="input-group ">
                                     <input type="date"
                                            class="form-control"
                                            name="dob"
                                            value="{{(isset($item) && $item->dob!='')?$item->dob : date('Y-m-d') }}"
                                            autocomplete="off"
                                     />
                                 </div>
                              </div>
                           </div>



                        </div>








                        <div class="form-group">
                           <label>{{__('user_role')}}
                              <span class="text-danger">*</span></label>
                           <select id="role" name="role" class="form-control" required>
                              <option value="" selected disabled>{{__('role_select')}}</option>
                              @foreach(config('constants.users_type') as $user_type)
                              <option value="{{$user_type['key']}}" {{isset($item)?
                                 (@$item->role==$user_type['key'] ?'selected' :''):
                                 ($user_type['is_default']?'selected':'')}}>
                                 {{$user_type['name']}}
                              </option>
                              @endforeach

                           </select>

                        </div>


                        {{-- <div class="form-group lecturer_fields">
                                 <label>{{__('about_trainer')}}
                                    <span class="text-danger"></span></label>
                                    <textarea class="form-control tinymce"
                                     name="about_lecturer"
                                     id="about_lecturer"
                                     >{{@$item->about_lecturer}}</textarea>

                        </div> --}}


                        <div class="form-group m-form__group row lecturer_fields mt-2">
                            <label for="example-text-input" class="col-3 col-form-label">{{ __('belongs_to_awael') }}</label>
                            <div class="col-7">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input type="hidden" name="belongs_to_awael" value="0">
                                    <span class="switch">
                                        <label>
                                            <input class="form-check-input " type="checkbox" {{ @$item->belongs_to_awael ? 'checked' : ''}} name="belongs_to_awael" value="1">
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group lecturer_fields">
                            <label for="system_commission">{{__('system_commission')}} (%)</label>
                            <input type="number" name="system_commission"
                                   class="form-control mb-2 d-flex align-items-center justify-content-between"
                                   value="{{ @$item->system_commission }}"
                                   id="system_commission" placeholder=""/>
                            <span class="d-block mb-3 " role="alert">
                                <strong>
                                    {{__('add_user_system_commission_text')}}
                                </strong>
                            </span>
                        </div>

                        <div class="form-group lecturer_fields">
                            <label for="system_commission_reason">{{__('system_commission_reason')}}</label>
                            <input type="text" name="system_commission_reason"
                                   class="form-control mb-2 d-flex align-items-center justify-content-between"
                                   value="{{ @$item->system_commission_reason }}"
                                   id="system_commission_reason" placeholder=""/>
                            <span class="d-block mb-3 " role="alert">
                                <strong>
                                    {{__('add_user_system_commission_reason_text')}}
                                </strong>
                            </span>
                        </div>

                        <div class="form-group lecturer_fields">
                            <span class="d-block mt-10 " role="alert">
                                <strong>
                                    {{__('private_lessons')}}
                                </strong>
                            </span>
                        </div>

                        <div class="form-group lecturer_fields">
                            <label for="hour_price">{{__('hour_price')}}</label>
                            <input type="number" name="hour_price"
                                   class="form-control mb-2 d-flex align-items-center justify-content-between"
                                   value="{{ @$item->hour_price }}"
                                   required id="hour_price" placeholder=""/>
                        </div>

                        <div class="form-group lecturer_fields">
                            <label for="can_add_half_hour">{{__('can_add_half_hour')}}</label>
                            <select id="type" name="can_add_half_hour" class="form-control mb-5  rounded-pill"
                                    required onchange="if($(this).val()==1) { $('.half_hour_div').removeClass('d-none'); } else { $('.half_hour_div').addClass('d-none'); }">
                                <option value="0" selected>{{__('no')}} </option>
                                <option value="1" {{@$item->can_add_half_hour==1 ?'selected' :''}}>{{__('yes')}} </option>
                            </select>
                        </div>

{{--                        <div class="form-group lecturer_fields half_hour_div {{@$item->can_add_half_hour!=1 ?'d-none' :''}}">--}}
{{--                            <label for="half_hour_price">{{__('half_hour_price')}}</label>--}}
{{--                            <input type="text" name="half_hour_price"--}}
{{--                                   class="form-control mb-2 d-flex align-items-center justify-content-between  rounded-pill"--}}
{{--                                   value="{{ @$item->half_hour_price }}"--}}
{{--                                   required id="half_hour_price" placeholder=""/>--}}
{{--                        </div>--}}

                        <div class="form-group lecturer_fields">
                            <label for="min_student_no">{{__('minimum_students_count')}}</label>
                            <input type="number" name="min_student_no"
                                   class="form-control mb-2 d-flex align-items-center justify-content-between"
                                   value="{{ @$item->min_student_no }}"
                                   required id="min_student_no" placeholder=""/>
                        </div>

                        <div class="form-group lecturer_fields">
                            <label for="max_student_no">{{__('maximum_students_count')}}</label>
                            <input type="number" name="max_student_no"
                                   class="form-control mb-2 d-flex align-items-center justify-content-between"
                                   value="{{ @$item->max_student_no }}"
                                   required id="max_student_no" placeholder=""/>
                        </div>

   
                        <div class="form-group lecturer_fields">
                           <label>{{__('material')}}
                                 <span class="text-danger">*</span></label>
                           <select id="material_id" name="material_id"
                                    class="form-control mb-5"
                                    required>
                                 <option value="" selected
                                       disabled>{{__('material_select')}}</option>
                                       @foreach($materials as $material)
                                       <option @if(isset($item) && $item->material_id == $material->id) selected @endif value="{{$material->id}}">{{$material->name}}</option>
                                       @endforeach
                           </select>
                        </div>
                                        



                        {{-- <div class="form-group lecturer_fields">
                           <label>{{__('id_image')}}
                              <span class="text-danger"></span></label>
                           <input type="file" name="id_image" class="form-control mb-3" value="" />
                           @if(@$item->id_image!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->id_image)}}" target="_blank">
                             <b> {{__('id_image')}}</b>
                              </a>
                           @endif
                        </div>

                        <div class="form-group lecturer_fields">
                           <label>{{__('job_proof_image')}}
                               <span class="text-danger"></span></label>
                           <input type="file" name="job_proof_image" class="form-control mb-3" value="" />
                           @if(@$item->job_proof_image!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->job_proof_image)}}" target="_blank">
                             <b> {{__('job_proof_image')}}</b>
                              </a>
                           @endif
                        </div>


                        <div class="form-group lecturer_fields">
                           <label>{{__('cv_file')}}
                              <span class="text-danger"></span></label>
                           <input type="file" name="cv_file" class="form-control mb-3" value="" />
                           @if(@$item->cv_file!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->cv_file)}}" target="_blank">
                             <b> {{__('cv_file')}}</b>
                              </a>
                           @endif
                        </div> --}}





                        <div class="form-group">
                           <label>{{__('password')}}
                              @if(!isset($item))
                              <span class="text-danger">*</span>
                              @endif
                           </label>
                           <input type="password" name="password" class="form-control" @if(!isset($item)) required @endif />
                           @if(isset($item))
                           <span class="d-block " role="alert">
                              <strong>
                              {{__('password_hint')}}
                              </strong>
                           </span>
                           @endif
                        </div>









                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->

               </div>
               <div class="col-md-3">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title"> {{__('action')}}</h3>

                     </div>
                     <!--begin::Form-->
                     <div class="card-body d-flex align-items-center   ">

                         @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                         <a href="{{route('panel.users.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->

                  <!--begin::Card-->
                   <div class="card card-custom gutter-b example example-compact">
                       <div class="card-header">
                           <h3 class="card-title"> {{__('image')}} </h3>
                       </div>
                       <!--begin::Form-->
                       <div class="card-body">
                           <div class="form-group row align-items-center">
                               <div class="col-lg-12 col-xl-12 text-center">
                                   <!--begin::Image input-->
                                   <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url({{imageUrl(@$item->image)}})">
                                       <!--begin::Image preview wrapper-->
                                       <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url({{imageUrl(@$item->image)}})"></div>
                                       <!--end::Image preview wrapper-->

                                       <!--begin::Edit button-->
                                       <label
                                           class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                           data-kt-image-input-action="change"
                                           data-bs-toggle="tooltip"
                                           data-bs-dismiss="click"
                                           title="{{__('edit')}}">
                                           <i class="fa fa-pen fs-6"><span class="path1"></span><span
                                                   class="path2"></span></i>

                                           <!--begin::Inputs-->
                                           <input type="file" class="fileupload" accept=".png, .jpg, .jpeg .webp"/>
                                           <input type="hidden" name="image_remove"/>
                                           <!--end::Inputs-->
                                       </label>
                                       <!--end::Edit button-->

                                       <!--begin::Cancel button-->
                                       <span
                                           class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                           data-kt-image-input-action="cancel"
                                           data-bs-toggle="tooltip"
                                           data-bs-dismiss="click"
                                           title="{{__('cancel')}}">
                                                   <i class="fa fa-ban fs-3"></i>
                                                    </span>
                                       <span
                                           class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                           data-kt-image-input-action="remove"
                                           data-bs-toggle="tooltip"
                                           data-bs-dismiss="click"
                                           title=""{{__('cancel')}}"">

                                       <i class="fa fa-ban fs-3"></i>
                                       </span>
                                       <!--end::Cancel button-->
                                   </div>
                                   <!--end::Image input-->
                                   <!--end::Image input placeholder-->

                                   <!--begin::Image input-->

                                   <!--end::Image input-->
                               </div>
                               <!--end::Form-->
                           </div>
                       </div>
                       <!--end::Form-->
                   </div>
                  <!--end::Card-->








               </div>


            </div>
         </div>


      </form>
   </div>
   @push('panel_js')
   <script src="{{asset('assets/panel/js/post.js')}}"></script>
   <script src="{{asset('assets/panel/js/image-input.js')}}"></script>
   <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
   <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
    @if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
    @else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
    @endif

   <script>
      $(document).ready(function() {
         checkRole($('#role').val());
      });

      $(document).on("change", "#role", function() {
         checkRole($(this).val());
      });

      function checkRole(role) {
         $('.lecturer_fields').hide();
         $('.stdeunt_fields').hide();
         if (role == 'lecturer') {
            $('.lecturer_fields').show();
         } else if (role == 'student') {
            $('.stdeunt_fields').show();
         }

      }

      window.initialCountry="{{@$item->slug_country?@$item->slug_country :defaultCountrySlug()}}"

      $( document ).ready(function() {
         var input = document.querySelector("#phone")
         input.val("{{@$item->mobile}}");
      });
   </script>

     @include('panel.components.mobile_number_script')

<script>
     $( document ).ready(function() {
         setTimeout(function(){
            $("#phone").val("{{@$item->mobile}}");
         },1000)
 
      });
   </script>
   @endpush

   @stop
