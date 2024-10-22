@extends('front.layouts.index', ['is_active' => 'lecturer_profile', 'sub_title' => @$lecturer->name])

@php
    $reviews = $lecturer->reviews;
    $teacherPrivateLessons = $lecturer->teacherPrivateLessons->whereNull('student_id');
    $lecturerSetting = $lecturer->lecturerSetting;
    $lecturerExpertise = $lecturer->lecturerExpertise;
    $teacherPrivateLessonsCount = $lecturer->teacherPrivateLessons->whereNotNull('student_id')->count();
    $teacherStudentsPrivateLessonsCount = $lecturer->teacherPrivateLessons()->distinct()->count('student_id');
    $lecturerMaterials = @$lecturer->materials->map->category;
    $lecturerLanguages = @$lecturer->languages->map->category;
    //statistics
    $statistics = [
        [
            'title' => __('students'),
            'count' => @$count_students,
            'is_show' => true,
        ],
        [
            'title' => __('courses'),
            'count' => $lecturer->lecturer_courses_count,
            'is_show' => true,
        ],
        [
            'title' => __('graduates'),
            'count' => @$count_graduates,
            'is_show' => true,
        ],
        [
            'title' => __('ratings'),
            'count' => $lecturer->reviews_count,
            'is_show' => true,
        ],
    ];

    $lecturerCourses = $lecturer->lecturerCourses;

@endphp
@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/calendar-gc.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
@endpush

@section('content')
    <section id="lecturer-profile" class="wow fadeInUp" data-wow-delay="0.1s">
        {{-- <div class="row mb-5">
            <div class="col-12">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="#">الملف الشخصي</a></li>
                    <li class="breadcrumb-item active">{{ @$lecturer->name }}</li>
                </ol>
            </div>
        </div> --}}

        <div>
            @include('front.lecturer_profile.partials.description')
        </div>

        <div class="container">
            @if (@$lecturerExpertise->isNotEmpty())
                <div class="row mb-5">
                    <div class="col-12 mb-4">
                        <h2 class="font-bold"> الخبرات </h2>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-container">
                                <table class="table table-cart mb-3">
                                    <thead>
                                        <tr>
                                            <td width="25%">التاريخ</td>
                                            <td width="20%">الخبرة</td>
                                            <td>الوصف</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lecturerExpertise as $expertise)
                                            <tr>
                                                <td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>
                                                        {{ @$expertise->start_date ? changeDateFormate(@$expertise->start_date) : '' }}
                                                        -
                                                        {{ @$expertise->end_date ? changeDateFormate(@$expertise->end_date) : '' }}</span>
                                                </td>
                                                <td class="text-success font-medium" data-title=""> {{ @$expertise->name }}
                                                </td>
                                                <td data-title="">{{ @$expertise->description }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Table <<<>>><<<>>> --}}
            @if (@$lecturer->id != auth()->id() && @$lecturer->timeTable->count() > 0)
                <div class="container mb-5 tab" id="tab-2">
                    @include('front.lecturer_profile.partials.private_lessons')
                </div>
            @endif

            @if ($lecturer->lecturer_courses_count > 0)
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="row mb-4 justify-content-between align-items-center">
                            <div class="col-lg-9">
                                <h2 class="font-bold">الدورات ({{ @$lecturer->lecturer_courses_count }})</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row all-courses">
                            @foreach ($lecturerCourses as $lecturerCourse)
                                @include('front.courses.partials.course', [
                                    'course' => $lecturerCourse,
                                    'col_class' => 'col-md-4',
                                ])
                            @endforeach
                        </div>
                    </div>
                    @if (@$lecturer->lecturer_courses_count > 3)
                        <div class="col-12">
                            <div class="row mb-4 justify-content-center align-items-center">
                                <div class="col-4">
                                    <a class="btn btn-primary font-bold w-100 px-4"
                                        href="{{ route('lecturerProfile.courses', $lecturer->id) }}">
                                        {{ __('view_more') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if ($lecturer->reviews_count > 0)
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="data-rating d-flex align-items-center mb-4">
                            <h2 class="font-bold">التقييمات ({{ @$lecturer->reviews_count }}) </h2>
                        </div>
                    </div>

                    <div class="row">
                        <div class="row all-reviews">
                            @include('front.lecturer_profile.partials.reviews')
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/calendar-gc.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        /*------------------------------------
            	        PerfectScrollbar
            	    --------------------------------------*/
        $('.scroll').each(function() {
            const ps = new PerfectScrollbar($(this)[0]);
        });

        $('.fc-scroller').each(function() {
            const ps = new PerfectScrollbar($(this)[0]);
        });
    </script>
    <script>
        $('.dropdown-menu').click(function(e) {
            e.stopPropagation()
        })
    </script>
@endpush
