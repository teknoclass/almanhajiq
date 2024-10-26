@extends('panel.layouts.index' , ['is_active'=>'course_details','sub_title'=>__('course_details')])
@section('title',  __('course_details'))
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
$title_page=__('add_course_requests_details');
$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('course_details'),
'link'=>route('panel.addCourseRequests.all.index'),
],
]
@endphp

<!--begin::Entry-->
<div class="container">
@include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
   <!--begin::Container-->
   <!--begin::Form-->
   <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
      @csrf
      <div class="container">
         <div class="row">
            <div class="col-md-7">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                     <h3 class="card-title">
                        {{@$title_page}}
                     </h3>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body">
                     <table class="table table-hover">
                        <tr>
                           <td>
                               {{__('request_data')}}
                           </td>
                           <td>
                              {{@$item->date}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                               {{__('course')}}
                           </td>
                           <td>
                              {{@$item->course->title}}
                           </td>
                        </tr>
                         <tr>
                             <td>
                                 {{__('the_trainer')}}
                             </td>
                             <td>
                              @if($item->course && $item->course->lecturer)
                                 {{__(@$item->course->lecturer->name)}}
                              @else 
                              ---
                              @endif
                             </td>
                         </tr>

                         <tr>
                            <td>
                            {{__('course_preview')}}
                            </td>
                            <td>

                            <a class="text-underline text-dark"
                            href="{{route('panel.courses.preview.index',$item->courses_id)}}"
                               target="_blank">
                              <b> {{__('course_preview')}}</b>
                               </a>

                            </td>
                         </tr>

                        <tr>
                           <td>
                           {{__('details')}}
                           </td>
                           <td>

                           <a class="text-underline text-dark"
                           href="{{route('panel.courses.edit.baseInformation.index',$item->courses_id)}}"
                              target="_blank">
                             <b> {{__('details')}}</b>
                              </a>

                           </td>
                        </tr>




                        <tr>
                           <td>
                               {{__('status')}}
                           </td>
                           <td>
                              {{__(@$item->status)}}
                           </td>
                        </tr>
                        @if(@$item->status=='unacceptable' && $item->reason_unacceptable!='')
                        <tr>
                           <td>
                        {{__('reson_reject')}}
                           </td>
                           <td>
                              {{__(@$item->reason_unacceptable)}}
                           </td>
                        </tr>
                        @endif

                     </table>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
            @if(@$item->status=='pending')
            <div class="col-md-5">
               <!--begin::Card-->
               <div class="card card-custom gutter-b example example-compact">
                  <div class="card-header">
                      <h3 class="card-title"> {{__('action')}}</h3>
                     <div class="card-toolbar">
                         @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                         <a href="{{route('panel.addCourseRequests.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                     </div>
                  </div>
                  <!--begin::Form-->
                  <div class="card-body d-flex align-items-center   ">
                     <div class="row w-100">
                        <div class="col-md-12">
                           <div class="form-group w-100">
                              <label>{{__('status_select')}}
                              <span class="text-danger">*</span></label>
                              <select type="text" name="status" id="status" class="form-control"  required >
                                 <option value=""  selected disabled>{{__('status_select')}} </option>
                                 @foreach(config('constants.points_withdrawal_request_status') as $status)
                                 <option value="{{@$status}}">
                                    {{__($status)}}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <div class="col-md-12 reason-unacceptable" style="display:none">
                           <div class="form-group w-100">
                              <label>{{__('reson_reject')}}
                              <span class="text-danger">*</span></label>
                              <textarea name="reason_unacceptable" required
                              class="form-control " ></textarea>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!--end::Form-->
               </div>
               <!--end::Card-->
            </div>
            @endif


         </div>
      </div>
   </form>
</div>
@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>
<script>
    $(document).on('change', '#status', function(event) {

        if($(this).val()=='unacceptable'){
            $('.reason-unacceptable').show();

        }else{
            $('.reason-unacceptable').hide();
        }

    });


</script>
@endpush
@endsection
