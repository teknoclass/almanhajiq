@extends('panel.layouts.index',['sub_title' =>__('grade_levels') ,'is_active'=>request('parent')])
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

   @php
   $item = isset($item) ? $item: null;
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
   'title'=>__('grade_levels'),
   'link'=>route('panel.grade_levels.all.index'),
   ],
   [
   'title'=>@$title_page,
   'link'=>'#',
   ],
   ];
   @endphp
    @section('title', $title_page)



   <!--begin::Entry-->

      <!--begin::Container-->

      <!--begin::Form-->
      <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
         @csrf
         <input type="hidden" value="{{@$item->image}}" name="image" id="image" />
         <div class="container">
             @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
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
                              <input type="text" name="name_{{$locale}}" class="form-control mb-10 d-flex align-items-center justify-content-between" value="{{isset($item)?@$item->translate($locale)->name:''}}" required />
                        </div>

                        @endforeach


                        <div class="form-group ">
                           <label>{{ __('order') }}
                              <span class="text-danger">*</span></label>
                           <select id="order" name="order" class="form-control" required>
                              <option value="" selected disabled>{{ __('level_select') }}</option>
                              @foreach (App\Models\Category::where('key','grade_levels')->whereNull('parent')->orderBy('id','desc')->get() as $key=>$order)
                              @php ++$key; @endphp
                                    <option value="{{$key}}" @if(isset($item) && $key == $item->order) selected @endif >{{$key}}</option>
                              @endforeach
                           </select>
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

                         <a href="{{route('panel.grade_levels.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>


                     </div>

                     <!--end::Form-->
                  </div>
                  <!--end::Card-->

                  @if(request('parent')=='blog_categories' || request('parent')=='course_categories')
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

                           </div>
                        </div>
                     </div>
                     <!--end::Form-->
                  </div>
                  <!--end::Card-->
                  @endif








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
   <script>
            $(document).ready(function() {
                $('#grade_level_id').change(function() {
                    let id = $(this).val();
                    $('#sub_level_id').prop('disabled', !id);
                    $('#sub_level_id').empty().append('<option selected readonly disabled value="">{{__('grade_sub_level')}}</option>');

                        if (id) {
                            $.ajax({
                                url: `/get-sub-levels/${id}`,
                                type: 'GET',
                                success: function(response) {
                                    $('#sub_level_id').empty();

                                    response.forEach(function(response) {
                                        $('#sub_level_id').append(`<option value="${response.id}">${response.name}</option>`);
                                    });
                                }
                            });
                        }
                    });
                });

             
            </script>
   @endpush

   @stop
