@extends('panel.layouts.index',['sub_title' =>__('students_opinions') ,'is_active'=>'students_opinions'])
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
   'title'=>__('students_opinions'),
   'link'=>route('panel.studentsOpinions.all.index'),
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
      <!--begin::Container-->
       <div class="container">
       @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('students_opinions'),])
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
                                 <label>{{__('student_name')}}
                                     ({{ __($value) }} )
                                     <span class="text-danger">*</span></label>
                                 <input type="text" name="name_{{$locale}}" class="form-control"
                                        value="{{isset($item)?@$item->translate($locale)->name:''}}" required />
                             </div>

                        <div class="form-group">
                           <label>{{__('description')}}
                              ({{ __($value) }} )
                              <span class="text-danger">*</span></label>
                           <textarea type="text" name="text_{{$locale}}"
                           id="text_{{$locale}}"
                           class="form-control tinymce" required rows="5">{{isset($item)?@$item->translate($locale)->text:''}}</textarea>
                        </div>




                        @endforeach




                        <div class="form-group">
                           <label>{{__('rate')}}
                              <span class="text-danger">*</span></label>
                           <input type="number" min="1" max="5" name="rate" required class="form-control" value="{{isset($item)?@$item->rate:''}}" />
                           <span class="d-block " role="alert">
                        {{__('rate_hint')}}
                           </span>
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

                           <a href="{{route('panel.studentsOpinions.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                       </div>

                       <!--end::Form-->
                   </div>
                  <!--end::Card-->

                   <div class="card card-custom gutter-b example example-compact">
                       <div class="card-header">
                           <h3 class="card-title"> {{__('image')}} </h3>
                       </div>
                       <!--begin::Form-->
                       <div class="card-body">
                           <div class="col-lg-12 col-xl-12 text-center">
                               <!--begin::Image input-->
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
                               <!--end::Image input-->
                               <!--end::Image input placeholder-->

                               <!--begin::Image input-->

                               <!--end::Image input-->
                           </div>
                       </div>
                       <!--end::Form-->
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
