@extends('front.user.lecturer.layout.index' )
@section('content')

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

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
'link' => route('user.home.index'),
],
[
  'title'=>__('courses'),
'link'=>route('user.lecturer.my_courses.index'),
],
[
'title'=>$title_page,
'link'=>'#',
],
];
@endphp
@section('title', $title_page)
<div class="container">
    @include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links'=>$breadcrumb_links,])

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
<!--begin::Form-->
<form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{ url()->current() }}"
   url="{{url()->current()}}" enctype="multipart/form-data" class="w-100">
   @csrf
   <div class="container">

      <div class="row">
         <div class="col-md-12">

             @include('front.user.lecturer.courses.my_courses.create.partials.toolbar', ['item' => @$item])

             <div class="card card-custom gutter-b example example-compact">

               <div class="card-body">
                  <div class="row">
                     <div id="kt_repeater_1" class="w-100">

                         <div class=" row">
                             <div data-repeater-list="suggested_dates" class="col-lg-12">
                                 @include('front.user.lecturer.courses.my_courses.create.components.btn_publish')



                                 @include('front.user.lecturer.courses.my_courses.create.partials.schedule',[
                                  'suggested_date'=>$item
                                  ])





                             </div>
                         </div>

                         <div class="form-group row" id="generate_btn_div" @if($item->published || count($item['sessions']) >0 )  style="display:none;" @else  style="display:block;" @endif>
                             <div class="col-lg-4" >
                                 <a  id="generate_btn" onClick="generatePlan('{{$item->start_date}}')"
                                     class="btn btn-success">
                                     <i class="la la-arrow-circle-o-right"></i>
                                     {{__('Generate Plan')}}
                                 </a>
                                 <div class="btn btn-success" id="loading" style="display: none;">{{__('Loading..')}}.</div>

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
    @if(!$item->published)
      @include('front.user.lecturer.courses.new_course.components.save_button',['btn_submit_text'=>__('save_as_draft')])
    @endif
</form>
</div>
</div>
</div>
</div>
</div>
<!--end::Content-->
</div>
</section>

@push('front_js')
    <script src="{{asset('assets/panel/js/publish.js')}}"></script>
    <script src="{{asset('assets/panel/js/save_course_group.js')}}"></script>
    <script src="{{asset('assets/panel/js/schedule.js')}}"></script>
    <script src="{{asset('assets/panel/js/schedule-groups.js')}}"></script>
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
 <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/repeater.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')}}"></script>

    <script src="{{asset('assets/panel/plugins/custom/select2/select2.js')}}"></script>
<script>
$('.add-suggested_date').click(function () {
   tinymce.init({
        selector: '.tinymce'
      });
  });

 </script>
 <script>
$(document).ready(function(){
    $(document).on('change','.sessionPrice',function(){
        var price = $(this).val();
        var id = $(this).attr("alt");
        $.ajax({
            url: "{{url('/user/lecturer/update-session-price')}}",
            data:{id:id,price:price},
            method: 'get',
            success: function (response) {
                customSweetAlert(
                    response.status_msg,
                    response.message,
                );
            }
        });
    });
});
</script>
@endpush
@stop
