@extends('front.layouts.index', ['is_active'=>'home','sub_title'=> __('home'), ])
@push('front_css')
        <!-- New Style CSS -->
        <link rel="stylesheet" href="{{asset('assets/front/css/swiper-bundle.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/icofont.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/flaticon.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/plugins.min.css')}}">
        {{-- <link rel="stylesheet" href="{{asset('assets/front/css/style.min.css')}}"> --}}
@endpush

@section('content')

    @php
        $sectionHTML = [
            'statistics'        => 'statistics',
            'latest_courses'    => 'latest_courses',
            'how_its_work'      => 'how_we_work',
            'our_teachers'      => 'teachers',
            'our_service'       => 'services',
            'students_opinions' => 'testimonials',
            //'our_partner'       => 'partners',
            //'our_messages'      => 'messages',
            //'our_teams'         => 'teams',
        ];

        //$sectionData = collect(@$section_settings)->where('section_key', 'statistics')->first();
        //$statisticsIsActive = $sectionData ? $sectionData['is_active'] : null;
    @endphp

    @include('front.home.sections.about_platform')
    @include('front.home.sections.about')

    @if (@$section_settings)
    @foreach ($section_settings as $section)
        @if (@$section['is_active'] === 1 && isset($sectionHTML[$section['section_key']]) )
        @include('front.home.sections.'.$sectionHTML[$section['section_key']])
        @endif
    @endforeach
    @endif
    
    @include('front.home.sections.featured_courses')

	{{-- @include('front.home.sections.about_platform')

    @include('front.home.sections.services')

    @include('front.home.sections.latest_courses')

    @include('front.home.sections.teachers')

    @include('front.home.sections.how_we_work')

    @include('front.home.sections.testimonials')

    @include('front.home.sections.partners') --}}


@endsection
