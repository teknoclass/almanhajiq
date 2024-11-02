@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('title',  __('courses'))
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

@php
   $breadcrumb_links=[
    [
    'title'=>__('home'),
    'link'=>route('panel.home'),
    ],
    [
    'title'=>__('courses'),
    'link'=>'#',
    ],
   ]
@endphp
<style>
   .badge-custom {
    border-radius: 0; 
    padding: 0.5em 1em; 
    display: inline-block; 
    color:white;
    border-radius: 20%;
}

</style>


   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
      @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                     {{__('courses')}}</h3>
               </div>
               <div class="card-toolbar">
                  <!--begin::Button-->
                  <a href="{{route('panel.courses.create.index')}}" class="btn btn-primary font-weight-bolder">
                     <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24" />
                              <circle fill="#000000" cx="9" cy="15" r="6" />
                              <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                           </g>
                        </svg>
                        <!--end::Svg Icon-->
                     </span>
                      {{__('add')}}
                  </a>
                  <!--end::Button-->
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
      @include('panel.courses.partials.scripts')
   @endpush

   @endsection
