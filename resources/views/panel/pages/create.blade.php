@extends('panel.layouts.index',['sub_title' =>__('pages') ,'is_active'=>'pages'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
            $title_page=__('add_page');
            if(isset($item)){
            $title_page=__('edit_page');
            }

            $breadcrumb_links=[
            [
            'title'=>__('home'),
            'link'=>route('panel.home'),
            ],
            [
            'title'=>__('pages'),
             'link'=>route('panel.pages.all.index'),
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
            @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
            <!--begin::Container-->
            <!--begin::Form-->
            <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
                  url="{{url()->current()}}" class="w-100">
                @csrf
                <input type="hidden" value="{{@$item->image}}" name="image" id="image"/>

                <div class="container">
                    <div class="row">


                        <div class="col-md-9">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{$title_page}} </h3>

                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    @php
                                        $can_control_key=true;
                                        if(isset($item) && $item->can_delete==0){
                                        $can_control_key=false;
                                        }
                                    @endphp

                                        <div class="form-group">
                                            <label>{{__('page_key')}}</label>
                                            <span class="text-danger">*</span></label>
                                            <input type="text"    @if(!$can_control_key) readonly   @endif
                                                   class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                   name="sulg"
                                                   value="{{isset($item)?@$item->sulg:''}}" required/>
                                        </div>
                                        <hr>


                                    @foreach(locales() as $locale => $value)

                                        <div class="form-group">
                                            <label>{{__('title')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_{{$locale}}"
                                                   class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                   value="{{isset($item)?@$item->translate($locale)->title:''}}"
                                                   required/>
                                        </div>

                                        <div class="form-group">
                                            <label>{{__('description')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <textarea type="text"
                                                      id="text_{{$locale}}"
                                                      name="text_{{$locale}}" class="form-control tinymce" required
                                                      rows="5">{{isset($item)?@$item->translate($locale)->text:''}}</textarea>
                                        </div>

                                    @endforeach
                                    <br>
                                        <h3 class="text-center">{{__('when_founded')}}, {{__('our_vision')}} , {{__('our_exports')}}</h3>
                                    <hr>
                                    @if(isset($item) && $item->sulg == "about")
                                     <div class="form-group">
                                            <label>{{__('when_founded')}} ({{__('ar')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="when_founded_ar"
                                                   class="form-control tinymce  " required
                                                   value="{{@$settings->valueOf('when_founded_ar')}}"
                                                   >{!!@$settings->valueOf('when_founded_ar')!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                            <label>{{__('when_founded')}} ({{__('en')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="when_founded_en" required
                                                   class="form-control tinymce  "
                                                   value="{{@$settings->valueOf('when_founded_en')}}"
                                                   >{!!@$settings->valueOf('when_founded_en')!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                            <label>{{__('our_vision')}} ({{__('ar')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="our_vision_ar" required
                                                 class="form-control tinymce  "
                                                   value="{{@$settings->valueOf('our_vision_ar')}}"
                                                   >{!!@$settings->valueOf('our_vision_ar')!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                            <label>{{__('our_vision')}} ({{__('en')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="our_vision_en" required
                                                 class="form-control tinymce  "
                                                   value="{{@$settings->valueOf('our_vision_en')}}"
                                                   >{!!@$settings->valueOf('our_vision_en')!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                            <label>{{__('our_exports')}} ({{__('ar')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="our_exports_ar" required
                                                  class="form-control tinymce  "
                                                   value="{{@$settings->valueOf('our_exports_ar')}}"
                                                   >{!!@$settings->valueOf('our_exports_ar')!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                            <label>{{__('our_exports')}} ({{__('en')}}) <span class="text-danger">*</span></label>
                                            <textarea type="text" name="our_exports_en" required
                                                 class="form-control tinymce  "
                                                   value="{{@$settings->valueOf('our_exports_en')}}"
                                                   >{!!@$settings->valueOf('our_exports_en')!!}</textarea>
                                    </div>
                                        @endif

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

                                    <a href="{{route('panel.pages.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>

                                </div>

                                <!--end::Form-->
                            </div>
                            <!--end::Card-->

                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{__('image_if')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">


                                    <div class="form-group row align-items-center">
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
                                        <!--end::Form-->
                                    </div>
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
            <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
            @if( app()->isLocale('ar'))
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @else
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
            @endif


    @endpush

@stop
