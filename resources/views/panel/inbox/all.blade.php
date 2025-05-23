@extends('panel.layouts.index',['sub_title' =>__('contact_us_message') ,'is_active'=>'inbox'])
@section('title',  __('contact_us_message'))
@section('contion')

@php
$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('contact_us_message'),
'link'=>'#',
],
]
@endphp


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
          @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('contact_us_message'),])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                      {{__('contact_us_message')}}</h3>
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
                           <div class="col-md-4 my-2 my-md-0">
                           </div>
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
        @include('panel.inbox.partials.scripts')
    @endpush

   @endsection
