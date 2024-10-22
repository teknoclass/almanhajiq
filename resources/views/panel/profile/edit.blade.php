@extends('panel.layouts.index',['sub_title' => __('profile') ,'is_active'=>'profile'])
@section('title', __('profile'))
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
   @php
   $breadcrumb_links=[
   [
   'title'=> __('home'),
   'link'=>route('panel.home'),
   ],
   [
   'title'=> __('profile'),
   'link'=>'#',
   ],
   ]
   @endphp



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->
      <!--begin::Form-->
      <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
         @csrf
         <div class="container">
             @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=> __('profile'),])
            <div class="row">
               <div class="col-md-12">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title">{{__('profile')}}</h3>
                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        <ul class="nav nav-tabs nav-line-tabs gap-5  m-tabs-line--left m-tabs-line--primary mb-10" role="tablist">
                           <li class="nav-item m-tabs__item">
                              <a class="nav-link m-tabs__link active"
                                 data-bs-toggle="tab"
                              href="#m_user_profile_tab_1" role="tab">
                                 <i class="flaticon-share m--hide"></i>
                                  {{__('profile')}}
                              </a>
                           </li>
                           <li class="nav-item m-tabs__item">
                              <a class="nav-link m-tabs__link"  data-bs-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                                  {{__('password')}}
                              </a>
                           </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                           <div class="tab-pane fade show active" role="tabpanel" id="m_user_profile_tab_1">
                              <div class="kt-portlet__body">
                                 <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label"> {{__('full_name')}} </label>
                                    <div class="col-7">
                                       <input class="form-control mb-10 m-input" name="name" type="text" value="{{@$admin->name}}">
                                    </div>
                                 </div>
                                 @php
                                     $demo_emails = ['info@admin.com'];
                                 @endphp
                                 <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">{{__('email')}}</label>
                                    <div class="col-7">
                                       <input class="form-control mb-10 m-input" name="email" disabled type="text" value="{{@$admin->email}}">
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade " id="m_user_profile_tab_2" role="tabpanel">
                              <div class="kt-portlet__body">

                                 <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">{{__('new_password')}}</label>
                                    <div class="col-7">
                                       <input class="form-control mb-10 m-input" name="new_password" type="password" id="password"
                                            {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}>
                                    </div>
                                 </div>
                                 <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">{{__('new_password_confirmation')}}  </label>
                                    <div class="col-7">
                                       <input class="form-control mb-10 m-input" name="password_confirmation" type="password"
                                            {{ in_array(auth()->user()->email, @$demo_emails) ? 'disabled' : '' }}>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="kt-portlet__foot m-portlet__foot--fit">
                              <div class="kt-form__actions">
                                 <div class="row">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-7">
                                       <div class="card-body d-flex align-items-center   ">

                                           @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])



                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!--end::Card-->
               </div>
            </div>
         </div>
      </form>
   </div>

   @push('panel_js')
   <script src="{{asset('assets/panel/js/post.js')}}"></script>
   @endpush
   @stop
