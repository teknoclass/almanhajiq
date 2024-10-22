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




   <div class="d-flex flex-column-fluid">
      <div class="container">
          @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('contact_us_message'),])

         <div class="row w-100">
            <div class="col-md-12">
               <div class="flex-row-fluid ml-lg-8 " id="kt_inbox_view">
                  <!--begin::Card-->
                  <div class="card card-custom card-stretch">
                     <!--begin::Header-->

                     <div class="card-header align-items-center flex-wrap justify-content-between h-auto">
                        <!--begin::Left-->
                        <div class="d-flex align-items-center my-2">
                            <h3 class="card-title">
                                <a href="{{route('panel.inbox.all.index')}}" class="btn btn-clean" data-inbox="back">
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>  {{__('contact_us_message')}}
                                </a>
                            </h3>
                        </div>
                        <!--end::Left-->

                     </div>
                     <!--end::Header-->
                     <!--begin::Body-->
                     <div class="card-body ">
                        <!--begin::Header-->
                        <div class="d-flex align-items-center justify-content-between flex-wrap card-spacer-x py-5">
                           <!--begin::Title-->
                           <div class="d-flex align-items-center mr-2 py-2">
                              <div class="font-weight-bold font-size-h2 mr-3">{{@$item->subject}}</div>
                           </div>
                           <!--end::Title-->

                        </div>
                        <!--end::Header-->
                        <!--begin::Messages-->
                        <div class="mb-3">
                           <div class="cursor-pointer shadow-xs toggle-on" data-inbox="message">
                              <!--begin::Message Heading-->
                              <div class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                 <div class="d-flex align-items-center">
                                    <span class="symbol symbol-50 mr-2 ml-2">
                                        <span class="symbol-label">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2 ml-2">
                                       <div class="d-flex mb-2">
                                          <span class="font-size-lg font-weight-bolder text-dark-75 mr-2">
                                             {{@$item->name}}
                                          </span>

                                          @if($item->mobile)
                                            <a href="https://web.whatsapp.com/send?phone={{@$item->code_country}}{{@$item->mobile}}" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2 ml-2">
                                                {{@$item->code_country}}{{@$item->mobile}}
                                            </a>
                                          @endif

                                          @if($item->email)
                                            <a href="mailto:{{@$item->email}}" class="font-size-lg font-weight-bolder text-dark-75 text-hover-primary mr-2 ml-2">
                                                -&nbsp;&nbsp;&nbsp; {{@$item->email}}
                                            </a>
                                          @endif

                                          <div class="font-weight-bold text-muted">
                                             <span class="label label-success label-dot mr-2"></span>
                                             {{@$item->diffForHumans()}}
                                          </div>
                                       </div>
                                       <div class="d-flex flex-column">
                                          <div class="toggle-off-item">
                                             <span class="font-weight-bold cursor-pointer" data-toggle="dropdown">
                                                {!!@$item->text !!}
                                                 </span>
                                          </div>
                                          <div class="text-muted font-weight-bold toggle-on-item" data-inbox="toggle">
                                      </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="d-flex my-2 my-xxl-0 align-items-md-center align-items-lg-start align-items-xxl-center flex-column flex-md-row flex-lg-column flex-xxl-row">
                                    <div class="font-weight-bold text-muted mx-2">
                                       {{@$item->date()}}
                                    </div>
                                 </div>
                              </div>
                              <!--end::Message Heading-->
                           </div>
                           @php $replays=$item->replays @endphp
                           @foreach($replays as $reply)

                           <div class="cursor-pointer shadow-xs toggle-off mt-2">
                              <!--begin::Message Heading-->
                              <div class="d-flex card-spacer-x py-6 flex-column flex-md-row flex-lg-column flex-xxl-row justify-content-between">
                                 <div class="d-flex align-items-center">
                                    <span class="symbol symbol-50 mr-2 ml-2">
                                       <span class="symbol-label" style="background-image: url('{{imageUrl(getSeting('logo'))}}')"></span>
                                    </span>
                                    <div class="d-flex flex-column flex-grow-1 flex-wrap mr-2 ml-2">
                                       <div class="d-flex">
                                          <a href="#" class="font-size-lg font-weight-bolder text-dark-75 mr-2">{{@$reply->admin->name}}</a>
                                          <div class="font-weight-bold text-muted">
                                             <span class="label label-success label-dot mr-2"></span>{{@$reply->diffForHumans()}}
                                          </div>
                                       </div>
                                       <div class="d-flex flex-column">
                                          <div class="toggle-off-item mt-2">
                                             <span class="font-weight-bold cursor-pointer" data-toggle="dropdown">{!!@$reply->text!!}</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                           </div>

                           @endforeach


                        </div>
                        <!--end::Messages-->
                        <!--begin::Reply-->
                        <div class="card-spacer mb-4" id="kt_inbox_reply">
                           <div class="card card-custom shadow-sm">
                              <div class="card-body p-0">
                                 <!--begin::Form-->
                                 <form id="form" method="POST" url="{{route('panel.inbox.view.replay',[$item->id])}}" to="{{route('panel.inbox.view.replay',[$item->id])}}" class="w-100">
                                    @csrf
                                    <!--begin::Body-->
                                    <div class="d-block">
                                       <!--begin::To-->
                                       <div class="d-flex align-items-center border-bottom inbox-to px-8 min-h-50px">
                                          <div class="text-dark-50 w-75px">{{__('write_replay_to')}}:</div>
                                          <div class="d-flex align-items-center flex-grow-1">
                                             <input type="text" class="form-control border-0" name="email" value="{{@$item->email}}" />
                                          </div>

                                       </div>
                                       <!--end::To-->

                                       <!--begin::Message-->
                                       <textarea name="text" id="text" class="form-control tinymce "

                                       required rows="5"> </textarea>


                                       <!--end::Message-->
                                       <!--begin::Attachments-->

                                    </div>
                                    <!--end::Body-->
                                    <!--begin::Footer-->
                                    <div class="d-flex align-items-center justify-content-between py-5 pl-8 pr-5 border-top">
                                       <!--begin::Actions-->
                                       <div class="d-flex align-items-center mr-3">
                                          <!--begin::Send-->
                                          <div class="btn-group mr-4">

                                              @include('panel.components.btn_submit',['btn_submit_text'=>__('send')])
                                          </div>
                                          <!--end::Send-->

                                       </div>
                                       <!--end::Actions-->

                                    </div>
                                    <!--end::Footer-->
                                 </form>
                                 <!--end::Form-->
                              </div>
                           </div>
                        </div>
                        <!--end::Reply-->
                     </div>
                     <!--end::Body-->
                  </div>
                  <!--end::Card-->
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
@if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
@else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
@endif


@endpush

@endsection
