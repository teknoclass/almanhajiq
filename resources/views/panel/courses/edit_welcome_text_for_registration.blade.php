@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
  $title_page=__('add');
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
];
@endphp
    @section('title', $title_page)

<!--begin::Entry-->
<div class="container">
    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
<!--begin::Container-->
<!--begin::Form-->
<form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
   url="{{url()->current()}}" enctype="multipart/form-data" class="w-100">
   <input type="hidden" name="welcome_text_for_registration_image" id="image" value="{{@$item->welcome_text_for_registration_image}}" />
    <input type="hidden" value="{{@$item->certificate_text_image}}" name="certificate_text_image" id="image_3"/>
    <input type="hidden" value="{{@$item->faq_image}}" name="faq_image" id="image_2"/>
   @csrf
   <div class="container">
      <div class="row">
         @include('panel.courses.partials.toolbar')
         <div class="col-md-12">
            <div class="row">
               <div class="col-md-9">
                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title">{{__('edit_text')}} </h3>
                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        <div class="row">
                           @foreach(locales() as $locale => $value)

                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>{{__('certificate_template')}}
                                 </label>
                                <select id="certificate_template_id" name="certificate_template_id"
                                        class="form-control mb-5"
                                        required>
                                    <option value="" selected disabled>{{__('template_select')}}</option>
                                    @foreach($certificate_templates as $template)
                                        <option
                                            value="{{@$template->id}}" {{@$item->certificate_template_id==$template->id ?'selected' :''}}>{{@$template->name}} </option>
                                    @endforeach
                                </select>
                              </div>
                           </div>

                           <div class="col-md-12">
                              <div class="form-group">
                                 <label>{{__('welcome_text')}}
                                     ({{ __($value) }} )
                                 <span class="text-danger">*</span></label>
                                 <textarea type="text"
                                 id="welcome_text_for_registration_{{$locale}}"
                                 name="welcome_text_for_registration_{{$locale}}"
                                 class="form-control tinymce" required rows="5">{{isset($item)?@$item->translate($locale)->welcome_text_for_registration:''}}{{@$text}}</textarea>
                              </div>
                           </div>


                                <div class="form-group mb-10">
                                    <label>{{__('certificate_text')}}
                                        ({{ __($value) }} )
                                        <span class="text-danger">*</span></label>
                                    <textarea type="text"
                                              id="certificate_text_{{$locale}}"
                                              name="certificate_text_{{$locale}}"
                                              class="form-control tinymce" required rows="5">{{isset($item)?@$item->translate($locale)->certificate_text:''}}{{@$text}}</textarea>
                                </div>
                           @endforeach
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


                  <!--begin::Card-->
                  <div class="card card-custom gutter-b example example-compact">
                     <div class="card-header">
                        <h3 class="card-title"> {{__('welcome_image')}} </h3>
                     </div>
                     <!--begin::Form-->
                     <div class="card-body">
                        <div class="form-group row align-items-center">
                           <div class="col-lg-12 col-xl-12 text-center">
                               <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url({{imageUrl(@$item->welcome_text_for_registration_image)}})">
                                   <!--begin::Image preview wrapper-->
                                   <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{imageUrl(@$item->welcome_text_for_registration_image)}})"></div>
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
                                       <input type="file" class="fileupload" accept=".png, .jpg, .jpeg"/>
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
                           </div>
                        </div>
                     </div>
                     <!--end::Form-->
                  </div>
                   <div class="card card-custom gutter-b example example-compact">
                       <div class="card-header">
                           <h3 class="card-title"> {{__('cert_image')}} </h3>
                       </div>
                       <!--begin::Form-->
                       <div class="card-body">
                           <div class="form-group row align-items-center">
                               <div class="col-lg-12 col-xl-12 text-center">
                                   <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url({{imageUrl(@$item->certificate_text_image)}})">
                                       <!--begin::Image preview wrapper-->
                                       <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url({{imageUrl(@$item->certificate_text_image)}})"></div>
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
                                           <input type="file" class="file_another_upload_2" accept=".png, .jpg, .jpeg"/>
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
                               </div>
                           </div>
                       </div>
                       <!--end::Form-->
                   </div>
                   <div class="card card-custom gutter-b example example-compact">
                       <div class="card-header">
                           <h3 class="card-title"> {{__('faq_image')}} </h3>
                       </div>
                       <!--begin::Form-->
                       <div class="card-body">
                           <div class="form-group row align-items-center">
                               <div class="col-lg-12 col-xl-12 text-center">
                                   <div class="image-input image-input-outline" data-kt-image-input="true"
                                        style="background-image: url({{imageUrl(@$item->faq_image)}})">
                                       <!--begin::Image preview wrapper-->
                                       <div class="image-input-wrapper w-125px h-125px"
                                            style="background-image: url({{imageUrl(@$item->faq_image)}})"></div>
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
                                           <input type="file" class="file_another_upload" accept=".png, .jpg, .jpeg"/>
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
                               </div>
                           </div>
                       </div>
                       <!--end::Form-->
                   </div>
                  <!--end::Card-->

                </div>
            </div>
         </div>
      </div>
</form>
</div>
@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script src="{{asset('assets/panel/js/image-input.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
@if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
@else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
@endif

@endpush
@stop
