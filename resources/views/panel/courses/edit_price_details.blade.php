@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
    $price_details=$item->priceDetails;
        $title_page=__('add_course');
                if(isset($item)){
                $title_page=@$item->title;
                }
                $breadcrumb_links=[
                [
                'title'=>__('home'),
                'link'=>route('panel.home'),
                ],
                [
                'title'=>__('courses'),
                'link'=>route('panel.courses.all.index'),
                ],
                [
                'title'=>$title_page,
                'link'=>'#',
                ],
                ]
@endphp
@section('title', $title_page)
<!--begin::Entry-->
<div class="container">
    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
   <!--begin::Container-->
   <!--begin::Form-->
   <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
      @csrf
      <input type="hidden" value="{{@$item->image}}" name="image" id="image" />
      <div class="container">
         <div class="row">
            @include('panel.courses.partials.toolbar')
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
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group">
                              <label>
                              {{__('price')}}
                              </span>
                              <span class="text-danger"></span></label>
                              <input type="text" class="form-control "
                                 name="price"
                                 value="{{(isset($price_details) && $price_details->price!='')?$price_details->price :'' }}" />
                              <p class="mt-1">
                                 <strong >
                                 (
                             {{__('price_hint')}}
                                 )
                                 </strong>
                              </p>
                           </div>
                        </div>

                        <hr>

                        <div class="col-md-12">
                           <div class="form-group">
                              <label>
                                  {{__('discount_price')}}
                              </span>
                              <span class="text-danger"></span></label>
                              <input type="text" class="form-control"
                                 name="discount_price"
                                 min="0"
                                 value="{{(isset($price_details) && $price_details->discount_price!='')?$price_details->discount_price :"" }}" />
                           </div>
                        </div>





                     </div>
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

                      <a href="{{route('panel.courses.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
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
