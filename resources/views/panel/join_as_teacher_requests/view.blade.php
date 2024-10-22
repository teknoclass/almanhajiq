@extends('panel.layouts.index' , ['is_active'=>'join_as_teacher_requests','sub_title'=>__('join_as_teacher_requests')])
@section('title',  __('join_as_teacher_requests_details'))
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
@php
$title_page=__('join_as_teacher_requests_details');
$breadcrumb_links=[
[
'title'=>__('home'),
'link'=>route('panel.home'),
],
[
'title'=>__('join_as_teacher_requests_details'),
'link'=>route('panel.joinAsTeacherRequests.all.index'),
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
                               {{__('full_name')}}
                           </td>
                           <td>
                              {{@$item->name}}
                           </td>
                        </tr>
                         <tr>
                             <td>
                                 {{__('gender')}}
                             </td>
                             <td>
                                 {{__($item->gender)}}
                             </td>
                         </tr>

                        <tr>
                           <td>
                               {{__('email')}}
                           </td>
                           <td>
                              {{@$item->email}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                               {{__('mobile')}}
                           </td>
                           <td>
                              {{@$item->mobile}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                               {{__('country')}}
                           </td>
                           <td>
                              {{@$item->country->name}}
                           </td>
                        </tr>
                        <tr>
                           <td>
                               {{__('city')}}
                           </td>
                           <td>
                              {{@$item->city}}
                           </td>
                        </tr>
                         <tr>
                             <td>
                                 {{__('about')}}
                             </td>
                             <td>
                                 {{@$item->about}}
                             </td>
                         </tr>

                         <tr>
                             <td>
                                 {{__('certificate')}}
                             </td>
                             <td>
                                 {{@$item->certificate->name}}
                             </td>
                         </tr>

                         <tr>
                             <td>
                                 {{__('section')}}
                             </td>
                             <td>
                                 {{@$item->specialization->name}}
                             </td>
                         </tr>
                         <tr>
                             <td>
                                 {{__('materials')}}
                             </td>
                             <td>
                                 {{@$item->material->name}}
                             </td>
                         </tr>


                        <tr>
                           <td>
                           {{__('id_image')}}
                           </td>
                           <td>
                           @if($item->id_image!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->id_image)}}" target="_blank">
                             <b> {{__('id_image')}}</b>
                              </a>
                           @else
                           -
                           @endif
                           </td>
                        </tr>


                        <tr>
                           <td>
                               {{__('job_proof_image')}}
                           </td>
                           <td>
                           @if($item->job_proof_image!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->job_proof_image)}}" target="_blank">
                             <b> {{__('job_proof_image')}}</b>
                              </a>
                           @else
                           -
                           @endif
                           </td>
                        </tr>



                        <tr>
                           <td>
                               {{__('cv')}}
                           </td>
                           <td>
                           @if($item->cv_file!='')
                           <a class="text-underline text-dark"
                           href="{{fileUrl($item->cv_file)}}" target="_blank">
                             <b> {{__('cv_file')}}</b>
                              </a>
                           @else
                           -
                           @endif
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

                         <a href="{{route('panel.joinAsTeacherRequests.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
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
