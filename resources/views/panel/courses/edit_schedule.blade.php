@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
            $price_details=$item->priceDetails;
                $title_page=__('add_course');
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
                        ]
        @endphp
 @section('title', $title_page)
<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
<!--begin::Form-->
<form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
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
                      @if(!$item->published)
                      @include('panel.components.btn_submit',['btn_submit_text'=>__('save_as_draft')])
                      @endif
                      @include('panel.components.btn_publish')
                      <a href="{{route('panel.courses.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                  </div>
               </div>
               <!--begin::Form-->
               <div class="card-body">
                  <div class="row">
                     <div id="kt_repeater_1" class="w-100">






                        <div class=" row">
                           <div data-repeater-list="suggested_dates" class="col-lg-12">
                                @include('panel.courses.partials.schedule',[
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
                               <div class="btn btn-success" id="loading" style="display: none;">{{__('Loading...')}}</div>

                           </div>
                        </div>
                     </div>

                    <div id="targetDiv">
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
</div>

@push('panel_js')
            <script src="{{asset('assets/panel/js/post.js')}}"></script>
            <script src="{{asset('assets/panel/js/publish.js')}}"></script>
<script src="{{asset('assets/panel/js/schedule.js')}}"></script>
<script src="{{asset('assets/panel/js/schedule-groups.js')}}"></script>
 <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/repeater.js')}}"></script>
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/form-repeater.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
@if( app()->isLocale('ar'))
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
@else
        <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
@endif
<script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')}}"></script>
@include("panel.courses.partials.session_script")

<script>
    $(document).ready(function() {

        // Close modal if clicked outside of it
        $(document).on('click', '.attachment_modal', function(e) {
            var session_id = $(this).data('session-id');
            console.log(session_id);
            $('#load').show();
            $.ajax({
                url: "{{ route('panel.courses.edit.get_attachment_modal') }}", // Use the new endpoint
                method: "GET",
                data: {
                    session_id: session_id
                },
                success: function(response) {
                    $('#load').hide();
                    $("#targetDiv").html(response.content);
                    console.log('success');
                    showMyModal();

                },
                error: function(xhr, status, error) {
                    $('#load').hide();
                    console.log("AJAX Error:", error);
                    console.log("Status:", status);
                    console.log("Response Text:", xhr.responseText);
                    console.error("Failed to fetch lesson modal.");
                }
            });
        });

        function showMyModal() {
            // Assuming your modal has an ID, e.g., #myModal
            $("#modalAddAttachment").show();
        }
    });
</script>

@endpush
@stop
