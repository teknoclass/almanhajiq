@extends('panel.layouts.index',['sub_title' =>__('notifications') ,'is_active'=>'transactios'])
@section('title',  __('transactions'))
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

@php
   $breadcrumb_links=[
   [
   'title'=>__('home') ,
   'link'=>route('panel.home'),
   ],
   [
   'title'=>__('notifications') ,
   'link'=>'#',
   ],
   ]
   @endphp



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
      @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('notifications') ,])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                      {{__('notifications')}}</h3>
               </div>
               <div class="card-toolbar">
                <a href="{{ route('panel.notifications.readAll') }}" class="btn btn-primary px-3" >{{ __('readAll') }}</a>
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
   @include('panel.notifications.partials.scripts')

   @endpush
   @endsection
