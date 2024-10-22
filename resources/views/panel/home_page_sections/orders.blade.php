@extends('panel.layouts.index' , ['is_active'=>'home_page_sections','sub_title'=>__('home_page_sections') ])@section('contion')
@php
    $title_page=__('home_page_sections');
  $breadcrumb_links=[
  [
   'title'=>__('home'),
  'link'=>route('panel.home'),
  ],
  [
  'title'=>$title_page,
  'link'=>'#',
  ],
]
@endphp
@section('title',__('our_services').'-'.$title_page)
@push('panel_css')
<link href="{{ asset('assets/panel/plugins/custom/kanban/kanban.bundle.css') }}" rel="stylesheet" type="text/css" />


@endpush

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->

        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="container">
           <!--begin::Container-->
            @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
    <!--begin::Form-->
    <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
      @csrf
      <input type="hidden" value="{{@$item->image}}" name="image" id="image" />
      <div class="container">
	<div class="row">


		<div class="col-md-9">
			<!--begin::Card-->
			<div class="card card-custom gutter-b example example-compact">
				<div class="card-header">
					<h3 class="card-title"> {{__('home_page_sections_order')}} </h3>

				</div>
				<!--begin::Form-->
					<div class="card-body">

                        <div id="kt_kanban_1_1"></div>





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

                    <a href="{{route('panel.home')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>


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
   <script type="text/javascript" src="{{asset('assets/panel/plugins/custom/kanban/kanban.bundle.js')}}"></script>
   <script type="text/javascript" src="{{asset('assets/panel/js/pages/features/miscellaneous/kanban-board.js')}}"></script>
<script>

var kanban = new jKanban({
 element: '#kt_kanban_1_1',
 gutter: '0',
 widthBoard: '250px',
 boards: [{
         'id': '_inprocess',
         'title': '{{$title_page}}',
         'item': [
             @foreach(@$sections as $section)
             {
                 'title': '<input name="orderItems[]" type="hidden" value="'+"{{@$section->id}}"+'"<span class="font-weight-bold">'+"{{@$section->title}}"+'</span>'
             },
             @endforeach

         ]
     },
 ]
});



</script>
    @endpush


@endsection
