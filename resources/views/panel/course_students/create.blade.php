@extends('panel.layouts.index',['sub_title' =>__('register_student') ,'is_active'=>'course_students'])
@section('contion')
@php
$item = isset($item) ? $item: null;
@endphp
   @php
   $title_page=__('add_student');

   $breadcrumb_links=[
   [
    'title'=>__('home'),
   'link'=>route('panel.home'),
   ],
   [
   'title'=>__('students'),
   'link'=>route('panel.courseStudents.all.index'),
   ],
   [
   'title'=>$title_page,
   'link'=>'#',
   ],
   ]
   @endphp
   @section('title', $title_page)
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->

        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <!--begin::Container-->
            <div class="container">
   @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('register_student'),])

   <!--begin::Entry-->

      <!--begin::Container-->
       <!--begin::Form-->
       <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
             url="{{url()->current()}}" class="w-100">
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
                               <div class="form-group">
                                   <label>{{__('course')}}
                                       <span class="text-danger">*</span></label>
                                   <select class="form-control p-1 text-left  course_id "
                                           name="course_id"  id="search_live_courses" required>
                                   </select>
                               </div>


                               <div class="form-group mt-5">
                                   <label>{{__('student')}}
                                       <span class="text-danger">*</span></label>
                                       <select class="form-control mb-5 p-4 addStudentToCourse"
                                           name="user_id" id="search_students" required>
                                       @if(isset($item))

                                           <option selected value="{{@$item->student->id}}">
                                               {{@$item->student->name}}
                                           </option>
                                       @endif
                                   </select>
                               </div>
                               <div class="weekly_meeting_times">
                                   <!-- weekly_meeting_times -->
                               </div>
                               <div class="form-group">
                                   <label for="exampleInputPassword1">
                                       {{__('payment_status')}} ؟
                                       <span class="text-danger">*</span></label>
                                   <div class="form-check">
                                       <input class="form-check-input" type="radio" name="is_complete_payment" value="1" checked  id="is_complete_payment">
                                       <label class="form-check-label" for="is_complete_payment">
                                           {{__('yes')}}
                                       </label>
                                   </div>
                                   <div class="form-check">
                                       <input class="form-check-input" type="radio" name="is_complete_payment" value="0"  id="is_complete_payment2">
                                       <label class="form-check-label" for="is_complete_payment2">
                                           {{__('no')}}
                                       </label>
                                   </div>
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

                               <a href="{{route('panel.courseStudents.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                           </div>
                           <!--end::Form-->
                       </div>
                       <!--end::Card-->
                   </div>
               </div>
           </div>
       </form>




            </div>
</div>
</div>

   @push('panel_js')
   <script src="{{asset('assets/panel/js/post.js')}}"></script>
   <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/select2.js')}}"></script>


   @endpush

   @stop
