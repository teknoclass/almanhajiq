@extends('front.user.lecturer.layout.index')

@section('content')
    @php
        $breadcrumb_links = [
            [
                'title' => __('courses'),
                'link' => route('user.lecturer.my_courses.index'),
            ],
            [
                'title' => __('my_courses'),
                'link' => '#',
            ],
        ];

        $statistics = [
            [
                'title' => __('recorded_courses'),
                'currency' => '',
                'icon' => 'play',
                'value' => @$recorded_courses_count,
                'type' => '',
            ],
            [
                'title' => __('live_courses'),
                'currency' => '',
                'icon' => 'play',
                'value' => @$live_courses_count,
                'type' => '',
            ],
            [
                'title' => __('published_courses'),
                'currency' => '',
                'icon' => 'play',
                'value' => @$published_courses_count,
                'type' => '',
            ],
            [
                'title' => __('waiting_courses'),
                'currency' => '',
                'icon' => 'play',
                'value' => @$waiting_courses_count,
                'type' => '',
            ],
            [
                'title' => __('student_count'),
                'currency' => '',
                'icon' => 'grad_hat',
                'value' => @$students_count,
                'type' => '',
            ],
            /*[
                'title' => __('earnings'),
                'currency' => '',
                'icon' => 'dollar',
                'value' => @$total_sales,
                'type' => '',
            ],*/
        ];
    @endphp
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <!--begin::breadcrumb-->
            @include('front.user.lecturer.layout.includes.breadcrumb', [
                'breadcrumb_links' => $breadcrumb_links,
            ])
            <!--end::breadcrumb-->

            <!--begin::Content-->
            <div class="mb-4 mt-3">
                <!--begin::Row-->
                <div class="row gy-5 g-lg-3 mb-5">
                    @foreach ($statistics as $i => $statistic)
                        @include('front.components.lecturer_statistic_card', [
                            'statistic' => $statistic,
                            'i' => $i,
                        ])
                    @endforeach
                </div>
                <!--end::Row-->
                <h2 class="font-medium text-start mb-3">{{ __('filters') }}</h2>
                <div class="bg-white p-4 mt-0 rounded-4 filter-form-body">
                    @include('front.user.lecturer.courses.my_courses.partials.all-courses-filter')
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="font-medium text-start mb-3">{{ __('view_courses_list') }}</h2>
                    <button class="btn btn-primary">
                        <a style="color: #fff"
                            href="{{ route('user.lecturer.my_courses.create') }}">{{ __('add_new_course') }}</a>
                    </button>
                </div>

                <div class="bg-white p-4 mt-0 rounded-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="all-data">
                                @include('front.user.lecturer.courses.my_courses.partials.all-courses')
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
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
        <script>
            var sideNav = document.querySelector('.filter-nav');
            var toggleButton = document.querySelector('.toggle-side-nav');
            var chevronIcon = document.getElementById('chevron-icon');

            toggleButton.addEventListener('click', function() {
                if (sideNav.style.display === 'none' || sideNav.style.display === '') {
                    sideNav.style.display = 'block';
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                } else {
                    sideNav.style.display = 'none';
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('.reasonUnaccetapbleModalBtn').click(function() {
                    var reason = $(this).data('reason');

                    $('#reasonUnaccetapbleModalText').text(reason);

                    $('#reasonUnaccetapbleModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection
