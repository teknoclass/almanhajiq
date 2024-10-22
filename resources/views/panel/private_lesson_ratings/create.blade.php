@extends('panel.layouts.index',['sub_title' =>__('private_lessons_rating') ,'is_active'=>'posts'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp

        @php
            $title_page=__('edit_private_lessons_rating');

           $breadcrumb_links=[
           [
           'title'=>__('home'),
           'link'=>route('panel.home'),
           ],
            [
           'title'=>__('private_lessons_rating'),
           'link'=>route('panel.PrivateLessonRatings.all.index'),
                    ],
           [
           'title'=>$title_page,
           'link'=>'#',
           ],
           ]
        @endphp
    @section('title', $title_page)
        <!--begin::Entry-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
                                    <h3 class="card-title">{{$title_page}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">


                                        <div class="form-group">
                                            <label>{{__('description')}}

                                                <span class="text-danger">*</span></label>
                                            <textarea type="text"
                                                      id="text"
                                                      name="comment_text" class="form-control tinymce"
                                                      required rows="5"
                                            >{{isset($item)?@$item->comment_text:''}}</textarea>
                                        </div>


                                        <hr>

                                    <div class="form-group col-3">
                                        <label>{{__('rate')}}
                                            <span class="text-danger">*</span></label>
                                        <input type="number" min="1" max="5" name="rate"
                                               required class="form-control directionAlign"
                                               value="{{isset($item)?@$item->rate:''}}" />
                                        <span class="d-block mt-2" role="alert">
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
                                <div class="card-body  d-flex align-items-center">
                                    @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                                    <a href="{{route('panel.PrivateLessonRatings.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
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
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/tagify.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
            <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
            @if( app()->isLocale('ar'))
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @else
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
            @endif
    @endpush
@stop
