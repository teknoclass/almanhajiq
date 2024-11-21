@extends('front.user.lecturer.layout.index' )

@section('content')

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
<style>
    .delete-row {
        display: flex;
        margin: auto;
        margin-top: 10%;
    }
</style>
@endpush

@php
$breadcrumb_links=[
    [
        'title'=>__('my_settings'),
        'link'=> '#',
    ],
];
@endphp
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <!--begin::breadcrumb-->
        @include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links'=>$breadcrumb_links,])
        <!--end::breadcrumb-->

        <!--begin::Content-->
        <div class="row gx-xxl-8 mb-4">
            <div class="bg-white p-4 rounded-4">

                @php
                    $tabs=[
                        [
                            'title'=>__('main_information'),
                            'key'=>'main',
                        ],
                        [
                            'title'=>__('cv'),
                            'key'=>'education',
                        ],
                        [
                            'title'=>__('financial_information'),
                            'key'=>'financial',
                        ],
                        [
                            'title'=>__('contact_information'),
                            'key'=>'contacts',
                        ],
                      /*  [
                            'title'=>__('time_table'),
                            'key'=>'timetable',
                        ], */
                    ];
                @endphp
                <div class="row mb-4">
                    <div class="col-12">
                        <ul class=" nav nav-pills mb-3 nav-pills-circulum">
                            @foreach ($tabs as $tab)
                            <li class="nav-item">
                                <a href="{{ route('user.lecturer.settings.index', $tab['key']) }}" class="nav-link {{ $tab['key'] == @$active_tab ? 'active' : '' }}" >{{ $tab['title'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @include( 'front.user.lecturer.settings.partials.' . @$active_tab , ['key' => @$active_tab  ] )
                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
    </div>
</section>

@push('front_js')
{{--@include('front.components.mobile_number_script')--}}
<script src="{{ asset('assets/front/js/post.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
@endpush
@endsection
