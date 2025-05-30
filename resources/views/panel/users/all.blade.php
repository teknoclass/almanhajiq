@extends('panel.layouts.index',['sub_title' =>$title ,'is_active'=>'users'])
@section('title', $title)
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

   @php
   $breadcrumb_links=[
   [
    'title'=>__('home'),
   'link'=>route('panel.home'),
   ],
   [
   'title'=>$title,
   'link'=>'#',
   ],
   ]
   @endphp



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
      @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title ,])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                     {{$title}}</h3>
               </div>
               <div class="card-toolbar">
                  <!--begin::Button-->
                  <a href="{{route('panel.users.create.index')}}" class="btn btn-primary font-weight-bolder "
                  style="display: none">
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
                   <button type="button" class="btn btn-light-primary export-excel font-weight-bolder  mr-2 ml-2 ">
                     <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                           <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"></rect>
                              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"></path>
                              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"></path>
                           </g>
                        </svg>
                         <!--end::Svg Icon-->
                     </span>
                  {{__('excel_export')}}

                   </button>
                  <!--end::Button-->
               </div>
            </div>
            <div class="card-body">
               <!--begin: Search Form-->
               <!--begin::Search Form-->
           <div class="mb-7">

               </div>
               <!--end::Search Form-->
               <!--end: Search Form-->
               <!--begin: Datatable-->
                <div class="form-group" style="width: 300px;">

                    <label for="category"> {{__('choose_role')}}</label>
                    <select class="form-control" id="category">
                       <option value="">{{ __('show_all') }}</option>
                        @foreach($roles->unique('id') as  $role)
                            <option  value="student">{{__('student')}}</option>
                            <option  value="lecturer">{{__('lecturer')}}</option>
                            <option  value="marketer">{{__('marketer')}}</option>
                            <option  value="parent">{{__('parent')}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
               <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                <table class="table table-bordered data-table" id="datatable">
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
   @include('panel.users.partials.scripts')
   @endpush

   @endsection
