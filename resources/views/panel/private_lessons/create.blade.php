@extends('panel.layouts.index',['sub_title' =>__('private_lessons') ,'is_active'=>'privateLessons'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp

        @php
            $title_page=__('add_private_lessons');
            if(isset($item)){
            $title_page=__('edit_private_lessons');
                       }
           $breadcrumb_links=[
           [
           'title'=>__('home'),
           'link'=>route('panel.home'),
           ],
            [
           'title'=>__('private_lessons'),
           'link'=>route('panel.privateLessons.all.index'),
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
                                    @foreach(locales() as $locale => $value)
                                        <div class="form-group">
                                            <label>{{__('title')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_{{$locale}}" class="form-control"
                                                   value="{{isset($item)?@$item->translate($locale)->title:''}}"
                                                   required
                                            />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label>{{__('description')}}
                                                ({{ __($value) }} )
                                                </label>
                                            <textarea type="text"
                                                      id="description_{{$locale}}"
                                                      name="description_{{$locale}}" class="form-control tinymce"
                                                      required rows="5"
                                            >{{isset($item)?@$item->translate($locale)->description:''}}</textarea>
                                        </div>


                                        <hr>
                                    @endforeach
                                    <div class="row">
                                        @if (@$support_offline_lessons)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{__('type')}}
                                                        <span class="text-danger">*</span></label>
                                                    <select id="type" name="meeting_type" class="form-control mb-5  rounded-pill"
                                                            required>
                                                        <option value="" selected disabled>{{__('type_select')}} </option>
                                                        @foreach(config('constants.meeting_type') as $meeting_type)
                                                            <option value="{{$meeting_type['key']}}" {{isset($item)?
                                                                        (@$item->meeting_type==$meeting_type['key'] ?'selected' :''):
                                                                            ($meeting_type['is_default']?'selected':'')}}>
                                                                {{__('meeting_type.'.$meeting_type['key'])}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" name="meeting_type" value="online">
                                        @endif

                                        <div class="col-md-6">

                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('category')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="type" name="category_id" class="form-control mb-5"
                                                        required>
                                                    <option value="" selected
                                                            disabled>{{__('category_select')}}</option>
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{@$category->value}}" {{@$item->category_id==$category->value ?'selected' :''}}>{{@$category->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('time_type')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="time_type" name="time_type"
                                                        class="form-control mb-5 mb-5  rounded-pill"
                                                        required>
                                                    <option value="" selected
                                                            disabled>{{__('select_time_type')}}</option>
                                                        <option value="hour" {{@$item->time_type=='hour' ?'selected' :''}}>{{__('hour')}} </option>
                                                        <option value="half_hour" {{@$item->time_type=='half_hour' ?'selected' :''}}>{{__('half_hour')}} </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('the_trainer')}}
                                                    <span class="text-danger">*</span></label>
                                                <select class="form-control mb-5  rounded-pill  "
                                                        name="teacher_id" id="search_lecturers" required>
                                                    @if(isset($item))

                                                        <option selected value="{{@$item->teacher->id}}">
                                                            {{@$item->teacher->name}}
                                                        </option>
                                                    @endif
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('student')}}</label>
                                                <select class="form-control mb-5  rounded-pill  "
                                                        name="student_id" id="search_students">
                                                    @if(isset($item))

                                                        <option selected value="{{@$item->student->id}}">
                                                            {{@$item->student->name}}
                                                        </option>
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                        {{--<div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('price')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group ">
                                                    <input type="number"
                                                        class="form-control mb-5  rounded-pill directionAlign"
                                                        name="price"
                                                        value="{{(isset($item) && $item->price!='')?$item->price :'' }}"
                                                    />
                                                </div>
                                            </div>
                                        </div>--}}
                                        @if(@$item)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('start_date')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group ">
                                                    <input type="date"
                                                        class="form-control mb-5  rounded-pill directionTextalign"
                                                        name="meeting_date"
                                                        value="{{(isset($item) && $item->meeting_date!='')?$item->meeting_date :'' }}"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('meeting.time_form')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group date">
                                                    <input type="time"
                                                        class="form-control mb-5  rounded-pill directionTextalign"
                                                        name="time_form"
                                                        value="{{(isset($item) && $item->time_form!='')?$item->time_form :'' }}"
                                                        onfocus="this.showPicker()"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{__('meeting.time_to')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group date">
                                                    <input type="time"
                                                        class="form-control mb-5  rounded-pill directionTextalign"
                                                        name="time_to"
                                                        value="{{(isset($item) && $item->time_to!='')?$item->time_to :'' }}"
                                                        onfocus="this.showPicker()"
                                                    />
                                                </div>

                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group col-4">
                                            <button type="button" id="rowAdder" class="btn btn-primary" title="إضافة أكثر من تاريخ">إضافة جدول المواعيد</button>
                                        </div>
                                        <div id="newDates" class="row"></div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        <div class="col-md-3">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('action')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body  d-flex align-items-center">
                                    @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                                    <a href="{{route('panel.privateLessons.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
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
<script>
    window.select2_hint = '{{__('select2_search_hint')}}';

</script>
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/tagify.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/select2.js')}}"></script>
@if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
@else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
@endif

    <script>
        $("#rowAdder").click(function () {
            newRowAdd =
                '<div id="row" class="row">'+
                    '<div class="col-md-4">'+
                        '<div class="form-group">'+
                            '<label>{{__('start_date')}}<span class="text-danger"></span></label>'+
                            '<br>'+
                            '<div class="input-group ">'+
                                '<input type="date" class="form-control mb-5  rounded-pill directionTextalign" name="meeting_date[]" value="" />'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                        '<div class="form-group">'+
                            '<label>{{__('meeting.time_form')}}<span class="text-danger"></span></label>'+
                            '<br>'+
                            '<div class="input-group date">'+
                                '<input type="time" class="form-control mb-5  rounded-pill directionTextalign" name="time_form[]" value="" onfocus="this.showPicker()" />'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-3">'+
                        '<div class="form-group">'+
                            '<label>{{__('meeting.time_to')}}<span class="text-danger"></span></label>'+
                            '<br>'+
                            '<div class="input-group date">'+
                                '<input type="time" class="form-control mb-5  rounded-pill directionTextalign" name="time_to[]" value="" onfocus="this.showPicker()"/>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="form-group col-2">'+
                        '<h3>&nbsp;</h3>'+
                        '<div class="form-group">'+
                            '<div class="left">'+
                                '<a href="javascript:;" id="DeleteRow" class="text-danger"><button type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path></svg>Button</button></a>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '<div>';

            $('#newDates').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        });
    </script>

    @endpush
@stop
