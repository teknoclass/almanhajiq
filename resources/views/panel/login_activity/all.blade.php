@extends('panel.layouts.index',['sub_title' =>__('user_login_activiy') ,'is_active'=>'login_activity'])
@section('title',  __('user_login_activiy'))
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
   @php
   $breadcrumb_links=[
   [
   'title'=>__('home'),
   'link'=>route('panel.home'),
   ],
   [
   'title'=>__('user_login_activiy'),
   'link'=>'#',
   ],
   ]
   @endphp



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
      @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,
'title_page'=>__('user_login_activiy'),])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                   {{__('user_login_activiy')}}
                  </h3>
               </div>
               <div class="card-toolbar">

               </div>
            </div>
            <div class="card-body">
               <!--begin: Search Form-->
               <!--begin::Search Form-->
               <div class="mb-7">
                  <div class="row align-items-center">
                     <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">

                        </div>
                     </div>
                  </div>
               </div>
               <!--end::Search Form-->
               <!--end: Search Form-->
               <!--begin: Datatable-->
                <div class="form-group">

                    <label for="category"> {{__('choose_role')}}</label>
                    <select class="form-control" id="category">
                        @foreach($roles as  $role)
                            <option value="">{{ __('show_all') }}</option>
                            <option  value="student">{{__('student')}}</option>
                            <option  value="lecturer">{{__('lecturer')}}</option>
                            <option  value="marketer">{{__('marketer')}}</option>
                        @endforeach
                    </select>
                </div>
               <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>

                <table class="table table-bordered data-table">
                    <thead>

                    </thead>
                    <tbody>
                    </tbody>
                </table>
               <!--end: Datatable-->
            </div>
         </div>
         <!--end::Card-->
      </div>
      <!--end::Container-->
   </div>

   @push('panel_js')

   @include('panel.login_activity.partials.scripts')

   @endpush
   @endsection
