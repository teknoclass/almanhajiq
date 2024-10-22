@extends('panel.layouts.index',['sub_title' =>__('withdrawal_requests') ,'is_active'=>'withdrawal_requests'])
@section('title',  __('withdrawal_requests'))
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
    $breadcrumb_links=[
    [
    'title'=>__('home')  ,
    'link'=>route('panel.home'),
    ],
    [
    'title'=>__('withdrawal_requests')  ,
    'link'=>route('panel.withdrawalRequests.all.index'),
    ],
    [
    'title'=>__('withdrawal_request_details')  ,
    'link'=>"#",
    ],
    ]
@endphp
<!--begin::Subheader-->
<div class="subheader py-2 py-lg-6 subheader-transparent" id="kt_subheader">
   <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
   @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('withdrawal_requests'),])

      <!--begin::Info-->
      <div class="d-flex align-items-center flex-wrap mr-1">
         <!--begin::Mobile Toggle-->
         <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
         <span></span>
         </button>
         <!--end::Mobile Toggle-->
         <!--begin::Page Heading-->

         <!--end::Page Heading-->
      </div>
      <!--end::Info-->
      <!--begin::Toolbar-->
      <div class="d-flex align-items-center">
      </div>
      <!--end::Toolbar-->
   </div>
</div>
<!--end::Subheader-->
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
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
                     <h3 class="card-title">{{__('withdrawal_request_details')}} </h3>
                     <div class="card-toolbar">
                     </div>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body">
                     <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
                        </p>
                        @endif
                        @endforeach
                     </div>
                     <fieldset class="scheduler-border">
                        <legend class="scheduler-borderL">
                            {{__('withdrawal_request_details')}}
                        </legend>
                        <div class="table-responsive">
                           @php
                           $items=[
                           [
                           'class'=>'text-danger',
                           'title'=>__('withdrawal_request.id'),
                           'value'=>@$item->id .' # ',
                           ],
                           [
                           'class'=>'text-success',
                           'title'=>__('withdrawal_request.data'),
                           'value'=>changeDateFormate(@$item->created_at),
                           ],
                           [
                           'class'=>'text-primary',
                           'title'=>__('status'),
                           'value'=>__('withdrawal_request_status.'.@$item->status),
                           ],
                           [
                           'class'=>'text-danger',
                            'title'=>__('amount'),
                           'value'=>@$item->amount  .' '. __('currency'),
                           ],
                           [
                           'class'=>'text-success',
                           'title'=>__('withdrawal_request.method'),
                           'value'=>__('withdrawal_method.'.@$item->withdrawal_method),
                           ],
                           [
                           'class'=>'text-primary',
                           'title'=>__('details'),
                           'value'=>@$item->details ,
                           ],
                           ];
                           @endphp
                           <table class="table ">
                              @foreach($items as $data_item)
                              <tr class="font-weight font-size-lg">
                                 <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
                                    <span class="navi-icon mr-2">
                                    <i class="fa fa-genderless {{@$data_item['class']}} font-size-h2"></i>
                                    </span>
                                    {{$data_item['title']}}
                                 </td>
                                 <td class="no-top-border pt-7">
                                    {{@$data_item['value']}}
                                 </td>
                              </tr>
                              @endforeach
                           </table>
                        </div>
                     </fieldset>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                <!--begin::Form-->
                <div class="card-body">
                   <fieldset class="scheduler-border">
                      <legend class="scheduler-borderL">
                          {{__('bank_account_data_if_any')}}
                      </legend>
                      <div class="table-responsive">
                         @php
                         $items=[
                         [
                         'class'=>'text-danger',
                         'title'=>__('bank'),
                         'value'=>@$user_details->bank->name,
                         ],
                         [
                        'class'=>'text-success',
                        'title'=>__('name_in_bank'),
                        'value'=>@$user_details->name_in_bank ,
                         ],
                         [
                         'class'=>'text-primary',
                         'title'=>__('iban'),
                         'value'=>@$user_details->iban ,
                         ],
                         [
                         'class'=>'text-danger',
                         'title'=>__('account_num'),
                         'value'=>@$user_details->account_num ,
                         ],
                         ];
                         @endphp
                         <table class="table ">
                            @foreach($items as $data_item)
                            <tr class="font-weight font-size-lg">
                               <td class="border-top-0 pl-0 pl-md-5 pt-7 d-flex align-items-center">
                                  <span class="navi-icon mr-2">
                                  <i class="fa fa-genderless {{@$data_item['class']}} font-size-h2"></i>
                                  </span>
                                  {{$data_item['title']}}
                               </td>
                               <td class="no-top-border pt-7">
                                  {{@$data_item['value']}}
                               </td>
                            </tr>
                            @endforeach
                         </table>
                      </div>
                   </fieldset>
                </div>
                <!--end::Form-->
             </div>
             <!--end::Card-->
            </div>
            @if(in_array($item->status,['pending','underway']))
            <div class="col-md-3">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                      <h3 class="card-title"> {{__('action')}}</h3>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body d-flex">
                      @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])
                  <a href="{{ url()->previous() }}"  class="btn btn-secondary ml-2 mr-2">
                     {{__('cancel')}}</a>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                     <h3 class="card-title"> {{__('status')}}  </h3>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body">
                     <select class="form-control " name="status" id="status">
                     @foreach(config('constants.withdrawal_requests_status') as $status)
                     @if($status['is_show'])
                     <option value="{{@$status['key']}}" {{@$item->status==@$status['key'] ?'selected' :''}}
                     {{!in_array(@$item->status,$status['change_allowed_when'])?'disabled':''}} >
                     {{__('withdrawal_request_status.'.@$status['key']) }}
                     </option>
                     @endif
                     @endforeach
                     </select>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
            @endif
         </div>
      </div>
   </form>
</div>
@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script src="{{asset('assets/panel/js/image-input.js')}}"></script>
@endpush
@stop
