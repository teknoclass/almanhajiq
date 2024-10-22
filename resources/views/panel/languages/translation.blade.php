@extends('panel.layouts.index',['sub_title' =>__('words_language') ,'is_active'=>'languages'])
@section('title', __('words_language'))
@section('contion')

@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    @php
    $title_page=__('edit');

    $breadcrumb_links=[
    [
    'title'=>__('home'),
    'link'=>route('panel.home'),
    ],
    [
    'title'=>__('words_language'),
    'link'=>'#',
    ],
    [
    'title'=>$title_page,
    'link'=>'#',
    ],
    ]
    @endphp




    <!--begin::Entry-->
    <div class="container">
        <!--begin::Container-->
    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('words_language'),])
        <!--begin::Form-->
        <form id="form" method="POST" action="{{url()->current()}}" class="w-100">
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
                                @foreach($text_data as $key => $item)
                                    <div class="form-group m-form__group row mb-5">
                                        <label class="col-3 col-form-label" readonly="readonly">
                                            @php
                                                echo str_replace("_"," ",$key);
                                            @endphp
                                        </label>
                                        <input type="hidden" value="{{@$key}}" name="keys[]" required />
                                        <div class="col-9">
                                <textarea class="form-control m-input update-text"
                                          name="values[]"
                                          data-key="{{@$key}}"
                                          data-id="{{@$item->id}}" required>{{ $text_data[$key]??"" }}</textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!--end::Form-->
                        </div>
                        <!--end::Card-->
                    </div>

                </div>
            </div>
        </form>
    </div>
    <input hidden class="btn btn-primary  font-medium align-items-center
                        justify-content-center" data-url="{{url()->current()}}" data-csrf="{{ csrf_token() }}"
            type="submit" id="btn_submit">


    @push('panel_js')
    <script src="{{asset('assets/panel/js/update.js')}}"></script>

    @endpush

    @stop
