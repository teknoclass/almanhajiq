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
                                                    @php
                                                        $text='';
                                                        if(isset($item)){
                                                         if(@$item->translate($locale)->for_whom_this_course){
                                                             $text=@$item->translate($locale)->for_whom_this_course;
                                                         }else{
                                                             $text=@$introductory_text_for_course_registration->translate($locale)->text;
                                                         }
                                                        }

                                                    @endphp
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{__('text')}}
                                                                ({{ __($value) }} )
                                                                <span class="text-danger">*</span></label>
                                                            <textarea type="text"
                                                                      id="for_whom_this_course_{{$locale}}"
                                                                      name="for_whom_this_course_{{$locale}}"
                                                                      class="form-control tinymce" required rows="5">{{@$text}}</textarea>
                                                        </div>
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
