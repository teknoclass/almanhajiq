@extends('panel.layouts.index',['sub_title' =>__('private_lessons_requests') ,'is_active'=>'posts'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp

    @php
        $title_page=__('private_lessons_requests');

       $breadcrumb_links=[
       [
       'title'=>__('home'),
       'link'=>route('panel.home'),
       ],
        [
       'title'=>__('private_lessons_requests'),
       'link'=>route('panel.PrivateLessonRequests.index'),
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
            <form id="form" id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}">
                @csrf
                <input class="form-control" type="text" hidden name="request_id" id="request_id" value="{{$item->id}}" >
                <select class="form-control" id="statusSelect" name="status" required>
                    <option selected disabled value="pending">{{__('pending')}}</option>
                    <option value="accepted">{{__('Accept')}}</option>
                    <option value="rejected" >{{__('Reject')}}</option>

                </select>

                @if($item->type === 'postpone')
                    <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" id="date-group" style="display:none;">
                        <h5>{{__('suggested dates')}}</h5>
                        <input type="radio" class="btn-check" id="date1" onclick="$('#custom_date').val('')" value="{{$item->suggested_dates[0]}}" name="chosen_date" autocomplete="off">
                        <label class="btn btn-outline-primary" for="date1">{{$item->suggested_dates[0]}}</label>

                        <input type="radio" class="btn-check" id="date2" onclick="$('#custom_date').val('')" value="{{$item->suggested_dates[1]}}" name="chosen_date" autocomplete="off">
                        <label class="btn btn-outline-primary" for="date2">{{$item->suggested_dates[1]}}</label>

                        <input type="radio" class="btn-check" onclick="$('#custom_date').val('')" id="date3" value="{{$item->suggested_dates[2]}}" name="chosen_date" autocomplete="off">
                        <label class="btn btn-outline-primary" for="date3">{{$item->suggested_dates[2]}}</label>
                        <div class="col-md-3">

                            <label  for="custom_date">{{__('Custom Date')}}</label>
                            <input type="date" class="form-control" id="custom_date"  name="custom_date">
                        </div>
                    </div>
                    <label  for="custom_date">{{__('admin_response')}}</label>
                    <input type="text" class="form-control" id="admin_response"  name="admin_response">
                @endif
                <button type="submit" class="btn btn-success" >{{__('change')}}</button>
            </form>        </div>

        <script>

            document.addEventListener('DOMContentLoaded', function () {
                $('#statusSelect').on('change', function() {
                    if (this.value ==='accepted'){
                        $('#date-group').css('display','block');
                    }
                });

            });
            $('')
        </script>
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
