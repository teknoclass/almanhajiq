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

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h2 class="font-medium text-start mb-3">{{ __('live_lessons') }}</h2>
                </div>

                <div class="bg-white p-4 mt-0 rounded-4">
                    <div class="row">
                        <div class="col-12">

                            <div class="all-data">
                                @foreach($live_lessons_groups as $course)
                                    <h4>{{ __('private_lesson_groups') }} - <b>{{__('lesson_name')}}</b>: &nbsp; {{ $course->title }}</h4> <!-- Course title -->
                                    @foreach($course->groups as $group)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="group{{ $group->id }}">
                                                <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse{{ $group->id }}">
                                                    {{ __('group_title') }}: &nbsp;{{ $group->title }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $group->id }}" class="accordion-collapse collapse">
                                                <div class="accordion-body">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>{{ __('session_title') }}</th>
                                                            <th>{{ __('date') }}</th>
                                                            <th>{{ __('time') }}</th>
                                                            <th>{{ __('action') }}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($group->sessions as $session)
                                                            @php
                                                                $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                                                $now = now();
                                                                $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 10;
                                                                $isSessionInPast = $sessionDateTime->isPast();
                                                                $isSessionStartingSoon = $sessionDateTime->isFuture() || $sessionDateTime->diffInMinutes($now) <= 120;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $session->title }}</td>
                                                                <td>{{ $session->date }}</td>
                                                                <td>{{ $session->time }}</td>
                                                                <td>
                                                                    @if($isSessionNow)
                                                                        <span><a href="{{ route('user.lecturer.live.createLiveSession', $session->id) }}" class="btn btn-primary">{{ __('Start Session') }}</a></span>
                                                                    @elseif ($isSessionStartingSoon)
                                                                        <button class="btn btn-warning" disabled>{{ __('starting_soon') }}</button>
                                                                    @elseif ($isSessionInPast)
                                                                        <button class="btn btn-secondary" disabled>{{ __('Ended') }}</button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
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
