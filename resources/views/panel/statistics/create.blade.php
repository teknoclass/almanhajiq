@extends('panel.layouts.index',['sub_title' =>__('statistics') ,'is_active'=>'statistics'])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

   @php
       $title_page=__('add');
       if(isset($item)){
       $title_page=__('edit');
}
       $breadcrumb_links=[
       [
       'title'=>__('home'),
       'link'=>route('panel.home'),
       ],
       [
       'title'=>__('statistics'),
       'link'=>route('panel.statistics.all.index'),
       ],
       [
       'title'=>$title_page,
       'link'=>'#',
       ],
       ]
   @endphp
   @section('title', $title_page)
   <!--begin::Entry-->
   <div class="d-flex flex-column-fluid">
       <div class="container">
      <!--begin::Container-->
   @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('statistics'),])
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
                        <h3 class="card-title">
                           {{@$title_page}}
                        </h3>

                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        @foreach(locales() as $locale => $value)

                        <div class="form-group">
                           <label>{{__('title')}}
                              ({{ __($value) }} )
                              <span class="text-danger">*</span></label>
                           <input type="text" name="title_{{$locale}}" class="form-control" value="{{isset($item)?@$item->translate($locale)->title:''}}" required />
                        </div>

                        @endforeach


                        <div class="form-group">
                           <label>{{__('numbers')}}
                              <span class="text-danger">*</span></label>
                           <input type="text" name="count" class="form-control" value="{{isset($item)?@$item->count:''}}" required />

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

                         <a href="{{route('panel.statistics.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->

                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                         <h3 class="card-title"> {{__('image')}} </h3>
                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        <div class="form-group row align-items-center">
                           <div class="col-lg-12 col-xl-12 text-center">
                               <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url({{imageUrl(@$item->image)}})">
                                   <!--begin::Image preview wrapper-->
                                   <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{imageUrl(@$item->image)}})"></div>
                                   <!--end::Image preview wrapper-->

                                   <!--begin::Edit button-->
                                   <label
                                       class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                       data-kt-image-input-action="change"
                                       data-bs-toggle="tooltip"
                                       data-bs-dismiss="click"
                                       title="{{__('edit')}}">
                                       <i class="fa fa-pen fs-6"><span class="path1"></span><span
                                               class="path2"></span></i>

                                       <!--begin::Inputs-->
                                       <input type="file" class="fileupload"  accept=".png, .jpg, .jpeg"/>
                                       <input type="hidden" name="image_remove"/>
                                       <!--end::Inputs-->
                                   </label>
                                   <!--end::Edit button-->

                                   <!--begin::Cancel button-->
                                   <span
                                       class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                       data-kt-image-input-action="cancel"
                                       data-bs-toggle="tooltip"
                                       data-bs-dismiss="click"
                                       title="{{__('cancel')}}">
                                                   <i class="fa fa-ban fs-3"></i>
                                                    </span>
                                   <span
                                       class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                       data-kt-image-input-action="remove"
                                       data-bs-toggle="tooltip"
                                       data-bs-dismiss="click"
                                       title=""{{__('cancel')}}"">

                                   <i class="fa fa-ban fs-3"></i>
                                   </span>
                                   <!--end::Cancel button-->
                               </div>


                               <label class="text-center mt-3">
                                {{__('image_size')}}
                                   ({{__('image_hight')}}:65 {{__('image_size_px')}})
                                   ({{__('image_width')}}:75 {{__('image_size_px')}})

                               </label>

                           </div>
                        </div>
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
   <script src="{{asset('assets/panel/js/image-input.js')}}"></script>
   <script>
      $('.summernote').summernote({
         height: 150
      });
   </script>

   @endpush

   @stop
