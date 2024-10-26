@extends('panel.layouts.index' , ['is_active'=>'add_course_requests',
'sub_title'=>__('add_course_requests')])
@section('title',  __('add_course_requests'))
@section('contion')
@php
   $title_page=__('add_course_requests');
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
<style>
   .badge-custom {
    border-radius: 0; 
    padding: 0.5em 1em; 
    display: inline-block; 
    color:white;
    border-radius: 20%;
}

</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <!--begin::Container-->
   <div class="container">
       <!--begin::Subheader-->
   @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
   <!--end::Subheader-->
      <!--begin::Card-->
      <div class="card card-custom">
         <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
               <h3 class="card-label">
                  {{@$title_page}}
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
                  <div class="col-lg-12 col-xl-12">
                     <div class="row align-items-center">


                     </div>
                  </div>
               </div>
            </div>
            <!--end::Search Form-->
            <!--end: Search Form-->
            <!--begin: Datatable-->
            <div class="row">
             <select id="status-filter" class="form-control col-3" style="width: 300px;margin:5px">
                 <option value="">{{ __('status') }}</option>
                 <option value="pending">{{ __('Under Review') }}</option>
                 <option value="acceptable">{{ __('Acceptable') }}</option>
                 <option value="unacceptable">{{ __('Unacceptable') }}</option>
             </select>
             <!-- <select id="lecturer-filter" class="form-control col-3" style="width: 300px;margin:5px">
                 <option value="">{{ __('lecturer') }}</option>
                 @foreach($lecturers as $lecturer)
                     <option value="{{$lecturer->name}}">{{$lecturer->name}}</option>
                 @endforeach
             </select>
             <select id="course-filter" class="form-control col-3" style="width: 300px;margin:5px">
                 <option value="">{{ __('course') }}</option>
                 @foreach($courses as $course)
                     <option value="{{$course->title}}">{{$course->title}}</option>
                 @endforeach
             </select> -->
             </div>
             <br>
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
@include('panel.add_course_requests.partials.scripts')
@endpush
@endsection
