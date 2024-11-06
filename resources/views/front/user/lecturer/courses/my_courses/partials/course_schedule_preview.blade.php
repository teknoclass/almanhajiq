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


            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="font-medium text-start mb-3">{{ __('live_lessons') }}</h2>
            </div>

            <div class="bg-white p-4 mt-0 rounded-4">
                <div class="row">
                    <div class="col-12">

                        <div class="all-data">
                            @if(count($item['sessions'])>0)
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>{{ __('session_title') }}</th>
                                        <th>{{ __('day') }}</th>
                                        <th>{{ __('date') }}</th>
                                        <th>{{ __('group') }}</th>
                                        <th>{{ __('time') }}</th>
                                        <th>{{ __('request') }}</th>
                                        <th>{{ __('actions') }}</th>
                                        <th>{{ __('Start Session') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($item['sessions'] as $session)
                                    
                                        <tr>
                                            <td>{{ $session->title }}</td>
                                            <td>{{__($session->day)}}</td>
                                            <td>{{ $session->date }}</td>
                                            <td>{{ $session->group?->title??__('no_group') }}</td>
                                            <td>{{ $session->time }}</td>
                                            <td>
                                                @if($session->teacherRequests->first())
                                              {{__('status')}} :  {{__($session->teacherRequests->first()?->status)??''}}

                                                <br>
                                              {{__('type')}} : {{__($session->teacherRequests->first()?->type)??''}}
                                              @endif
                                            </td>
                                            @php
                                                $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                                $now = now();
                                                $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 15;
                                                $isSessionInPast = $sessionDateTime->isPast();
                                                $isSessionStartingSoon = $sessionDateTime->isFuture() && $sessionDateTime->diffInMinutes($now) <= 120;
                                            @endphp

                                            <td>
                                                @if(!$isSessionInPast && ( !@$session->teacherRequests->first() || (@$session->teacherRequests->first() && @$session->teacherRequests->first()?->status == "rejected") ) )

                                                    <button data-bs-toggle="modal" data-id="{{ $session->id }}"
                                                            data-bs-target="#cancelModal" id="cancelButton" class="btn btn-danger btn-sm " style="width:100px">
                                                           
                                                            <i class="fa fa-cancel"></i>     {{ __('cancel')}} 
                                                    </button>

                                                    <button data-bs-toggle="modal" data-id="{{ $session->id }}"
                                                             id="postPoneButton" class="btn btn-primary btn-sm "
                                                             data-date="{{$session->date}}"
                                                             style="width:100px;margin-top:5px">
                                                            <i class="fa fa-calendar"></i>  {{ __('postpone')}}
                                                    </button>

                                                @endif
                                            </td>


                                            <td>


                                                @if($isSessionNow && $session->meeting_status != "finished")
                                                    <span><a
                                                            href="{{ route('user.lecturer.live.createLiveSession', $session->id) }}"
                                                            class="btn btn-primary">{{ __('Start Session') }}</a></span>
                                                @elseif ($isSessionStartingSoon)
                                                    <button class="btn btn-warning"
                                                            disabled>{{ __('starting_soon') }}</button>
                                                @elseif ($isSessionInPast)
                                                     
                                                <p class="text-center">{{ __('Ended') }}</p>
                                                @if($session->getRecording() != "" && $session->meeting_status == "finished")
                                                <a class="btn btn-secondary" target="_blank" href="{{$session->getRecording()}}">{{__('recording_link')}} </a>
                                                @endif
                                                @else
                                                    <button class="btn btn-primary"
                                                            disabled>{{ __('did_not_start_yet') }}</button>

                                            </td>
                                          

                                            @endif
                                            @endforeach

                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->
        </div>
        <h2>{{__('Lessons Groups')}}</h2>
        <div id="groupsAccordion" class="accordion mt-4">
            @if($item['groups'])
                @foreach ($item['groups']->unique('id') as $groupIndex => $group)
                    <div class="accordion-item session_accordion-item">
                        <div class="accordion-header" id="heading{{ $groupIndex }}">
                            <h2 class="mb-0">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $groupIndex }}">
                                    {{ $group->title }}
                                </button>
                                <input type="text" name="group_{{ $groupIndex }}_title" hidden
                                       value="{{ $group->title }}">
                                <input hidden type="text" name="group_{{ $groupIndex }}_id" value="{{ $group->id }}">
                            </h2>
                        </div>

                        <div id="collapse{{ $groupIndex }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <ul class="list-group" id="sessionsContainer_{{ $groupIndex }}">
                                    @foreach ($group->sessions as $sessionIndex => $session)
                                        <li class="list-group-item">{{ $session->title }} - {{ __($session->day) }}
                                            ({{ $session->date }}) - {{ $session->time }}</li>
                                        <input type="text" id="session_{{ $groupIndex }}"
                                               name="session_{{ $groupIndex }}_{{$sessionIndex}}" hidden
                                               value="{{ $session->id }}">
                                        @php
                                            $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                            $now = now();
                                            $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 15;
                                        @endphp

                                        @if($isSessionNow && $session->meeting_status != "finished")
                                            <span><a
                                                    href="{{ route('panel.courses.live.createLiveSession', $session->id) }}"
                                                    class="btn btn-primary">Start Session</a></span>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>


    @include('front.user.lecturer.courses.my_courses.partials.course_status_modal')
    @push('front_js')
        <script src="{{ asset('assets/front/js/course_status.js') }}"></script>
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
        <script>
            var sideNav = document.querySelector('.filter-nav');
            var toggleButton = document.querySelector('.toggle-side-nav');
            var chevronIcon = document.getElementById('chevron-icon');

            toggleButton.addEventListener('click', function () {
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
            $(document).ready(function () {
                $('.reasonUnaccetapbleModalBtn').click(function () {
                    var reason = $(this).data('reason');

                    $('#reasonUnaccetapbleModalText').text(reason);

                    $('#reasonUnaccetapbleModal').modal('show');
                });

                //open modal
                $(document).on('click','#postPoneButton',function(){
                    var minDate = $(this).data('date');
                    $('.suggested_dates').attr('min',minDate);
                    $('#postPoneModal').modal('show');
                });

            });
        </script>
    @endpush
@endsection
