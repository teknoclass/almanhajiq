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
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
<!--begin::Form-->
<form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
 url="{{url()->current()}}" enctype="multipart/form-data" class="w-100">
   @csrf
   <div class="container">
       @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
      <div class="row">
         @include('panel.courses.partials.toolbar')
         <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
               <div class="card-header">
                  <h3 class="card-title">
                     {{@$title_page}}
                  </h3>
                  <div class="card-toolbar">
                      @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                      <a href="{{route('panel.courses.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                  </div>
               </div>
               <!--begin::Form-->
               <div class="card-body">
                  <div class="row">
                     <div id="kt_repeater_1" class="w-100">
                        <div class=" row">
                           <div data-repeater-list="sections" class="col-lg-12">
                              @php
                              $content_details=$item->requirements;
                              @endphp
                              @if(count($content_details)>0)

                              @foreach($content_details as $details)

                                @include('panel.courses.partials.course_requirement_form',[
                                 'details'=>$details
                                 ])

                              @endforeach

                              @else

                              @include('panel.courses.partials.course_requirement_form')


                              @endif

                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-4">
                              <a href="javascript:;" data-repeater-create=""
                              class="btn btn-sm font-weight-bolder btn-light-primary add-new-content" >
                              <i class="la la-plus"></i>
                                  {{__('add')}}
                           </a>
                           </div>
                        </div>
                     </div>
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
 <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/repeater.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>

<script>

   $('.add-new-content').click(function () {
      setInterval(function(){

      tinymce.init({
        selector: '.tinymce'
      });

      var last_content=$('.widget_item-course-content').last();
      $(last_content).find(".content-icon").prop('required',true);

      $(last_content).find('.preview-content-course-icon').remove();
      },500);



  });





</script>
@endpush
@stop
