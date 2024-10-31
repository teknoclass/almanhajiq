@extends('front.user.lecturer.layout.index')

@section('content')
@php
    $breadcrumb_links=[
        [
            'title'=>__('admin_panel'),
            'link'=>'#',
        ],
    ];


    $statistics = [
        [
            'title' => __('monthly_profits'),
            'currency' => __('currency'),
            'icon' => "iqd",
            'value' => @$totalEarningsLastMonth,
            'type' => '',
        ],
        [
            'title' => __('student_count'),
            'currency' => "",
            'icon' => "grad_hat",
            'value' => auth()->user()->RelatedStudents()->count(),
            'type' => '',
        ],
        [
            'title' => __('courses_count'),
            'currency' => "",
            'icon' => "play",
            'value' => auth()->user()->lecturerCoursesCount(),
            'type' => '',
        ],
        [
            'title' => __('private_lessons_count'),
            'currency' => "",
            'icon' => "play",
            'value' => auth()->user()->teacherPrivateLessons()->count(),
            'type' => '',
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
            <!--begin::Statistics-->
            <div class="row gy-5 g-lg-3 mb-4">
                @foreach ($statistics as $i => $statistic)
                @include('front.components.lecturer_statistic_card', ['statistic' => $statistic, 'i' =>$i])
                @endforeach
            </div>
            <!--end::Statistics-->

            <!--begin::Tables-->
            <div class="row g-5 gx-xxl-12 mb-4">

                <!--begin::Students-->
                <div class="col-md-6">
                    <div class="bg-white p-4 mt-0 rounded-4">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="font-medium text-start">{{ __('private_lessons_list') }}</h2>
                                <hr>
                                <table class="table table-cart mb-3">
                                    <thead>
                                        <tr>
                                            <td>{{ __('name') }}</td>
                                            <td>{{ __('date') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($private_lessons) && count(@$private_lessons) > 0)
                                        @foreach($private_lessons as $private_lessson)
                                        <tr>
                                            <td>
                                                <span>
                                                    <span class="ms-2">
                                                        {{@$private_lessson->title}}
                                                    </span>
                                                </span>
                                            </td>
                                            <td><span><i class="fa-regular fa-clock me-2"></i>{{@$private_lessson->meeting_date}}</span></td>

                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Students-->

                <!--begin::Students-->
                <div class="col-md-6">
                    <div class="bg-white p-4 mt-0 rounded-4">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="font-medium text-start">{{ __('student_list') }}</h2>
                                <hr>
                                <table class="table table-cart mb-3">
                                    <thead>
                                        <tr>
                                            <td>{{ __('student_name') }}</td>
                                            <td>{{ __('start_date') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($students) && count(@$students) > 0)
                                        @foreach($students as $student)
                                        <tr>
                                            <td>
                                                <span class="d-flex align-items-center">
                                                    <span class="symbol symbol-40">
                                                        <img class="rounded-circle" src="{{imageUrl(@$student->image)}}" alt="{{@$student->name}} " loading="lazy"/>
                                                    </span>
                                                    <span class="ms-2">
                                                        {{@$student->name}}
                                                        {{-- <br>
                                                        <span class="ms-2 text-muted">
                                                            {{@$student->email}}
                                                        </span> --}}
                                                    </span>
                                                </span>
                                            </td>
                                            <td><span><i class="fa-regular fa-clock me-2"></i>{{changeDateFormate(@$student->created_at)}}</span></td>

                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Students-->

            </div>
            <!--end::Tables-->
        </div>
        <!--end::Content-->
    </div>
</section>
@endsection
