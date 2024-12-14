@extends('panel.layouts.index',['sub_title' =>__('transactions') ,'is_active'=>'lecturers_profits'])
@section('title',  __('lecturers_profits'))
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

@php
   $breadcrumb_links=[
   [
   'title'=>__('home') ,
   'link'=>route('panel.home'),
   ],
   [
   'title'=>__('lecturers_profits') ,
   'link'=>'#',
   ],
   ]
   @endphp



   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
      <!--begin::Container-->

      <!--begin::Container-->
      <div class="container">
      @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('lecturers_profits') ,])
         <!--begin::Card-->
         <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
               <div class="card-title">
                  <h3 class="card-label">
                      {{__('lecturers_profits')}}</h3>
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
               <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                <table class="table table-bordered data-table">
                    <thead>
                     
                    </thead>
                  
                    </tbody>
                </table>
               <!--end: Datatable-->
            </div>
         </div>
         <!--end::Card-->
      </div>
      <!--end::Container-->
   </div>
   <!-- Modal -->
<div class="modal fade" id="lecturerTransactionsModal" tabindex="-1" aria-labelledby="lecturerTransactionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lecturerTransactionsModalLabel">{{__('details')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="transactionsTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{__('description')}}</th>
                            <th>{{__('amount')}}</th>
                            <th>{{__('type')}}</th>
                            <th>{{__('date')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

   @push('panel_js')
   @include('panel.lecturers_profits.partials.scripts')
   @endpush
   @endsection
