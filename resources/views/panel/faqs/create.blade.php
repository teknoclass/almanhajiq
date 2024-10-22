@extends('panel.layouts.index',['sub_title' => __('faqs') ,'is_active'=>'faqs'])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp

@php
$title_page=__('add_faq');
 if(isset($item)){
  $title_page=__('edit_faq');
  }
$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('faqs'),
'link'=>route('panel.faqs.all.index'),
],
[
'title'=>$title_page,
'link'=>'#',
],
]
@endphp
@section('title', $title_page)
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">



   <!--begin::Entry-->
   <div class="container">
      <!--begin::Container-->
       @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
      <!--begin::Form-->
      <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
         @csrf

         <div class="container">
            <div class="row">


               <div class="col-md-9">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title">
                           {{@$title_page}}
                        </h3>

                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        @foreach(locales() as $locale => $value)

                        <div class="form-group">
                           <label>{{__('faq')}}
                              ({{ __($value) }} )
                              <span class="text-danger">*</span></label>
                           <input type="text" name="title_{{$locale}}" class="form-control"
                            value="{{isset($item)?@$item->translate($locale)->title:''}}" required />
                        </div>

                        <div class="form-group">
                           <label>{{__('ans')}}
                              ({{ __($value) }} )
                              <span class="text-danger">*</span></label>
                           <textarea type="text" name="text_{{$locale}}"
                           id="text_{{$locale}}"
                           class="form-control tinymce" required rows="5">{{isset($item)?@$item->translate($locale)->text:''}}</textarea>
                        </div>


                        @endforeach



                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->

               </div>
               <div class="col-md-3">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                         <h3 class="card-title"> {{__('action')}}</h3>

                     </div>
                     <!--begin::Form-->
                     <div class="card-body d-flex align-items-center   ">


                         @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                         <a href="{{route('panel.faqs.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>


                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->


               </div>


            </div>
         </div>


      </form>
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

   @stop
