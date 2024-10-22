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
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">

               <div class="card-body">
                  <div class="row">
                     <div id="kt_repeater_1" class="w-100">

                        <div class=" row">

                            @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')
                           <div data-repeater-list="suggested_dates" class="col-lg-12">

                              @if(count($suggested_dates)>0)

                              @foreach($suggested_dates as $suggested_date)

                                @include('front.user.lecturer.courses.my_courses.create.partials.suggested_date_form',[
                                 'suggested_date'=>$suggested_date
                                 ])

                              @endforeach

                              @else

                              @include('front.user.lecturer.courses.my_courses.create.partials.suggested_date_form')


                              @endif

                           </div>
                        </div>
                        <div class="form-group row">
                           <div class="col-lg-4">
                              <a href="javascript:;" data-repeater-create=""
                               class="btn btn-sm font-weight-bolder btn-light-primary add-suggested_date">
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
      @include('front.user.lecturer.courses.new_course.components.save_button')
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

    <script src="{{ asset('assets/front/js/post.js') }}"></script>
 <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/repeater.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')}}"></script>

<script>
$('.add-suggested_date').click(function () {
   tinymce.init({
        selector: '.tinymce'
      });
  });

 </script>
@endpush
@stop
