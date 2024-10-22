@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        @php
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
        <div class="container">
            <!--begin::Container-->
            <!--begin::Form-->
            @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
            <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
                  url="{{url()->current()}}" class="w-100">
                @csrf
                <input type="hidden" value="{{@$item->image}}" name="image" id="image"/>
                <div class="container">
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
                                                <div data-repeater-list="faqs" class="col-lg-12">
                                                    @php
                                                        $faqs=$item->faqs;
                                                    @endphp
                                                    @if(count($faqs)>0)

                                                        @foreach($faqs as $faq)

                                                            @include('panel.courses.partials.faq_form',[
                                                             'faq'=>$faq->faq
                                                             ])

                                                        @endforeach

                                                    @else

                                                        @include('panel.courses.partials.faq_form')

                                                    @endif

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-4">
                                                    <a href="javascript:;" data-repeater-create=""
                                                       class="btn btn-sm font-weight-bolder btn-light-primary add-faq">
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
            <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
            @if( app()->isLocale('ar'))
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @else
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
            @endif

            <script>

                $('.add-faq').click(function () {
                    tinymce.init({
                        selector: '.tinymce'
                    });
                });

            </script>
    @endpush
@stop
