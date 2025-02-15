@extends('front.layouts.index', ['is_active' => '', 'my_acitvity' => __('course_details')])

@section('content')
@php
    $active_option = "my_activity";

    $breadcrumb_links = [
        [
            'title' => __('home'),
            'link' => route('user.home.index'),
        ],
        [
            'title' => __('sons'),
            'link' => route('user.home.index'),
        ],
        [
            'title' => @$son->son->name,
            'link' => '',
        ],
        [
            'title' => __('courses_details'),
            'link' => route('user.parent.sons.courses',$son->son_id),
        ],
        [
            'title' => @$course->title,
            'link' => '#',
        ],
    ];

@endphp
<!-- start:: section -->
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">

        <div class="row mb-4 justify-content-between align-items-center">
            <div class="col-lg-9">
                <ol class="breadcrumb mb-0">
                    @foreach($breadcrumb_links as $sub_link)
                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                            @if(@$sub_link['link']!='#')
                                <a href="{{ @$sub_link['link'] }}">{{ @$sub_link['title'] }}</a>
                            @else
                                {{ @$sub_link['title'] }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>


        <div class="row mb-2">
            <div class="col-12">
                <h4 class="my-2 font-medium"><span class="square me-2"></span>
                {{__('course_details')}}
                </h4>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{__('day')}}</th>
                    <th>{{__('time')}}</th>
                    <th>{{__('date')}}</th>
                    <th>{{__('title')}}</th>
                    <th>{{__('Attend')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session['day'] }}</td>
                        <td>{{ $session['time'] }}</td>
                        <td>{{ $session['date'] }}</td>
                        <td>{{ $session['title'] }}</td>
                        <td>
                            @if ($session['attend'])
                                {{__('Attend')}}
                            @else
                                {{__('Absent')}}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
</section><!-- end:: section -->



@endsection

@push('front_js')

@endpush
