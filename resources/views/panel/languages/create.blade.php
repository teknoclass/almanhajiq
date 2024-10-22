@extends('panel.layouts.index',['sub_title' => __('languages') ,'is_active'=>'languages'])
@section('contion')


@php
$item = isset($item) ? $item: null;
@endphp

@php
$title_page=__('add_language');
if(isset($item)){
$title_page=__('edit_language');
}

$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('languages'),
'link'=>route('panel.languages.all.index'),
],
[
'title'=>$title_page,
'link'=>'#',
],
]
@endphp
@section('title', $title_page)
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">


    <div class="container">
    <!--begin::Entry-->

        <!--begin::Container-->
    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page])
        <!--begin::Form-->
        <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
            @csrf


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

                                <div class="form-group">
                                    <label>{{__('name')}}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{isset($item)?@$item->title:''}}" required />
                                </div>





                                <div class="form-group">
                                    <label>{{__('lang')}}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="lang" class="form-control" value="{{isset($item)?@$item->lang:''}}" required />
                                </div>




                                <div class="form-group">
                                    <label for="exampleInputPassword1">

                                        {{__('languages_default')}}
                                        <span class="text-danger">*</span></label>

                                    <div class="form-check">
                                        <input class="form-check-input" {{@$item->is_default==1 ?'checked' :''}} value="1" type="radio" name="is_default" id="is_default1" value="1">
                                        <label class="form-check-label" for="is_default1">
                                            {{__('yes')}}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" {{isset($item)? (@$item->is_default==0 ?'checked' :''):'checked'}} value="0" type="radio" name="is_default" id="is_default2" value="0">
                                        <label class="form-check-label" for="is_default2">
                                            {{__('no')}}
                                        </label>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">
                                     {{__('is_rtl')}}
                                        <span class="text-danger">*</span></label>

                                    <div class="form-check">
                                        <input class="form-check-input" {{@$item->is_rtl==1 ?'checked' :''}} value="1" type="radio" name="is_rtl" id="is_rtl1" value="1">
                                        <label class="form-check-label" for="is_rtl1">
                                            {{__('yes')}}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" {{isset($item)? (@$item->is_rtl==0 ?'checked' :''):'checked'}} value="0" type="radio" name="is_rtl" id="is_rtl2" value="0">
                                        <label class="form-check-label" for="is_rtl2">
                                            {{__('no')}}
                                        </label>
                                    </div>

                                </div>



                            </div>

                            <!--end::Card-->
                        </div>
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

                                <a href="{{route('panel.languages.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>


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

    @endpush

    @stop
