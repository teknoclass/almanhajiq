@extends('panel.layouts.index' , ['is_active'=>'marketers_joining_requests','sub_title'=>'طلبات الانضمام كمسوق' ])
@section('contion')
@php
   $title_page='طلبات الانضمام كمسوق';
   $breadcrumb_links=[
   [
   'title'=>__('home'),
   'link'=>route('panel.home'),
   ],
   [
   'title'=>$title_page,
   'link'=>'#',
   ],
]
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

      <!--begin::Container-->
      <div class="container">
        @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('category'),])
       <!--begin::Card-->
       <div class="card card-custom">
          <div class="card-header flex-wrap border-0 pt-6 pb-0">
             <div class="card-title">
                <h3 class="card-label">
                   {{@$title_page}}
                </h3>
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
          </div>
       </div>
       <!--end::Card-->
    </div>
    <!--end::Container-->
@push('panel_js')
@include('panel.marketers_joining_requests.partials.scripts')
@endpush
@endsection
