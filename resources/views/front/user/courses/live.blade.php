@extends('front.layouts.index', ['is_active' => 'test_courses', 'sub_title' => @$course->title])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/plyr.css') }}"/>

    <style>
        a.disabled {
            pointer-events: none;
            cursor: default;
            background-color: grey;
        }

        .accordion-item {
            border: 1px solid #bac0db; /* Light gray border */
            border-radius: 0.25rem; /* Optional: Add some border radius for a softer look */
        }
    </style>
@endpush


@section('content')
    @php
        $active_option = "curriculum";

        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('my_courses'),
                'link' => route('user.courses.myCourses'),
            ],
            [
                'title' => @$course->title,
                'link' => '#',
            ],
        ];

        //installments
            $checkIfStudentInstallCourse = App\Models\StudentSessionInstallment::where('course_id',$course->id)
            ->where('student_id',auth('web')->user()->id)->orderBy('id','desc')->first();
            if($checkIfStudentInstallCourse)
            {
                $nextInstallment = App\Models\CourseSessionInstallment::where('course_id',$course->id)
                ->where('course_session_id','>',$checkIfStudentInstallCourse->access_until_session_id)->first();
                $nextInstallmentDate = "";
                if($nextInstallment)
                {
                    $courseSession = App\Models\CourseSession::find($nextInstallment->course_session_id);
                    $nextInstallmentDate =  __($courseSession->day) .' ' .$courseSession->date.' '.$courseSession->time;
                }
            }else{
                $nextInstallmentDate = "";
            }

    @endphp

    @if (@$course->is_end && !@$course->is_rating)
        @include('front.user.courses.components.course_rate_modal')
    @endif

    <section class="section wow fadeInUp" data-wow-delay="0.1s">

        <div class="container">
            @include('front.user.courses.components.registered_course_breadcrumb')

            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#live_sessions" type="button" role="tab" aria-controls="live_sessions" aria-selected="true">{{ __('live_lessons') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#course_curr" type="button" role="tab" aria-controls="course_curr" aria-selected="true">{{ __('course_curriculum') }}</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="live_sessions" role="tabpanel" aria-labelledby="pills-home-tab">
                @if($nextInstallmentDate)
                <div class="card-header" style="background-color:slategrey;width:auto;padding:10px;color:white;text-align:center">
                    {{__('next_inst_date')}}: {{$nextInstallmentDate}}
                    <a style="cursor: pointer;"
                        class="payInstallment {{$nextInstallment->course_session_id}} btn btn-sm primary-btn " alt="{{$nextInstallment->course_session_id}}">{{__('payment')}}
                    </a>
                </div>
                @endif
                    <div class="bg-white p-4 mt-0 rounded-4">
                        <div class="row">
                            <div class="col-12">

                                <div class="all-data">
                                    @if($sessions)
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>

                                                <th>{{ __('session_title') }}</th>
                                                <th>{{ __('day') }}</th>
                                                <th>{{ __('date') }}</th>
                                                <th>{{ __('group') }}</th>
                                                <th>{{ __('time') }}</th>
                                                <th>{{ __('status') }}</th>
                                                <th>{{ __('actions') }}</th>
                                                <th>{{ __('Start Session') }}</th>
                                                <th>{{ __('password') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach ($sessions as $session)
                                                <tr>
                                                    <td>{{ $session->title }}</td>
                                                    <td>{{__($session->day)}}</td>
                                                    <td>{{ $session->date }}</td>
                                                    <td>{{ $session->group?->title??__('no_group') }}</td>
                                                    <td>{{ $session->time }}</td>

                                                    <td>
                                                        @if($session->studentRequests->first())
                                                        {{__('status')}} :  {{__($session->studentRequests->first()?->status)??''}}

                                                        <br>
                                                        {{__('type')}} : {{__($session->studentRequests->first()?->type)??''}}
                                                        @endif
                                                    </td>
                                                    @php
                                                        $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                                        $now = now();
                                                        $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 15;
                                                        $isSessionInPast = $sessionDateTime->isPast();
                                                        $isSessionStartingSoon = $sessionDateTime->isFuture() && $sessionDateTime->diffInMinutes($now) <= 120;

                                                    @endphp
                                                    @if(isCourseonStudentCourse(@$course->id) || isStudentSubscribeToSession($session->id) || in_array($session->id,installementdLessonsIds(@$course->id)))
                                                    <td>
                                                        
                                                    @if(!$isSessionInPast && ( !@$session->studentRequests->first() || (@$session->studentRequests->first() && @$session->studentRequests->first()?->status == "rejected") ) )

                                                            <button data-bs-toggle="modal" data-id="{{ $session->id }}"
                                                            data-bs-target="#cancelModal"  id="cancelButton" class="btn btn-danger btn-sm "  style="width:100px;margin-top:5px">
                                                           
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
                                                        @if($isSessionNow )
                                                        <button type="button" class="btn btn-primary bigBlueSessonBtnModal" alt = "{{$session->id}}">
                                                                {{__('go_to_live_session')}}
                                                            </button>
                                                        @elseif ($isSessionStartingSoon)
                                                            <button class="btn btn-warning"
                                                                    disabled>{{ __('starting_soon') }}</button>
                                                        @elseif ($isSessionInPast)
                                                            <button class="btn btn-secondary"
                                                                    disabled>{{ __('Ended') }}</button>
                                                        @else
                                                            <button class="btn btn-primary"
                                                                    disabled>{{ __('did_not_start_yet') }}</button>

                                                        @endif

                                                    
                                                    </td>
                                              
                                                    <td>
                                                    @if ($isSessionNow)
                                                    @if(! $session->public_password)
                                                        <p style="color:#8B0000;font-size:13px">{{__('waiting_password')}}</p>
                                                        @else
                                                            {{ $session->public_password }}
                                                    @endif
                                                    @endif
                                                    </td>

                                                @else
                                                <td colspan="2"><p style="color:#8B0000">{{__('you_not_subscribed')}}</p></td>
                                                @endif

                                                
                                               
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="accordion" id="sessionAccordion">
                        @foreach ($groups as $group)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="group{{ $group->id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $group->id }}">
                                        {{ $group->title }}
                                        @if(!isCourseonStudentCourse(@$course->id) && !isStudentSubscribeToSessionGroup($group->id) && !in_array($session->id,installementdLessonsIds(@$course->id)))
                                            <p style="color:#ffcc00;padding:0px 5px">({{__('you_not_subscribed_to_group')}})</p>
                                               
                                        @endif
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
                                                <th>{{ __('Start Session') }}</th>
                                                <th>{{ __('action') }}</th>
                                                <th>{{ __('password') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($group->sessions as $session)
                                                <tr>
                                                    <td>{{ $session->title }}</td>
                                                    <td>{{ $session->date }}</td>
                                                    <td>{{ $session->time }}</td>
                                                    @php
                                                            $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                                            $now = now();
                                                            $isSessionInPast = $sessionDateTime->isPast();
                                                               $isSessionNow= $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 15;
                                                            $isSessionStartingSoon = $sessionDateTime->isFuture() && $sessionDateTime->diffInMinutes($now) <= 120;

                                                        @endphp
                                                    @if(isCourseonStudentCourse(@$course->id) || isStudentSubscribeToSession($session->id) || in_array($session->id,installementdLessonsIds(@$course->id)))
                                                    <td>
                                                   
                                                            @if ($isSessionNow )
                                                                <button type="button" class="btn btn-primary bigBlueSessonBtnModal" alt = "{{$session->id}}">
                                                                    {{__('go_to_live_session')}}
                                                                </button>
                                                            @elseif ($isSessionInPast)

                                                                <button class="btn btn-secondary"
                                                                        disabled>{{__('Ended')}}</button>
                                                            @elseif ($isSessionStartingSoon)
                                                                <button class="btn btn-warning"
                                                                        disabled>{{__('Starting Soon')}}</button>
                                                            @else
                                                                <button class="btn btn-primary"
                                                                        disabled>{{ __('did_not_start_yet') }}</button>
                                                            @endif

                                                            
                                                    </td>
                                                    <td>
                                                      
                                                    @if(!$isSessionInPast && ( !@$session->studentRequests->first() || (@$session->studentRequests->first() && @$session->studentRequests->first()?->status == "rejected") ) )
                                                    <button data-bs-toggle="modal" data-id="{{ $session->id }}"
                                                            data-bs-target="#cancelModal" id="cancelButton" class="btn btn-danger btn-sm "  style="width:100px;margin-top:5px">
                                                           
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
                                                        <div>

                                                          
                                                            @if ($isSessionNow)
                                                        
                                                            @if(! $session->public_password)
                                                                <p style="color:#8B0000;font-size:13px">{{__('waiting_password')}}</p>
                                                            @endif
                                                            {{ $session->public_password }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    
                                                    @else
                                                    <td colspan="3">
                                                        <p style="color:#8B0000">{{__('you_not_subscribed')}}</p>
                                                    </td>
                                                    @endif

                                                   
                                                </tr>
                                                
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="course_curr" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div id="" class="tab-content">

                        <div class="row mb-2">

                            <div class="col-lg-8">

                                @switch($item_type)

                                    @case('quiz')
                                    @if (@$course_item->studentQuizResults->isNotEmpty())
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $end_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $course_item->studentQuizResults[0]->started_at)->addMinutes($course_item->time);

                                            $passed_time = $now > $end_time;

                                            $finished = @$course_item->studentQuizResults[0]->status != 'waiting';
                                        @endphp
                                        @if (@$finished)
                                            @include('front.user.courses.curriculum.quizzes.solution')
                                        @else
                                            @include('front.user.courses.curriculum.quizzes.description')
                                        @endif
                                    @else
                                        @include('front.user.courses.curriculum.quizzes.description')
                                    @endif

                                    @break

                                    @case('assignment')
                                    @if (@$course_item->studentAssignmentResults->isNotEmpty())
                                        @php
                                            $now = \Carbon\Carbon::now();
                                            $end_time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $course_item->studentAssignmentResults[0]->started_at)->addMinutes($course_item->time);

                                            $passed_time = $now > $end_time;

                                            $finished = @$course_item->studentAssignmentResults[0]->status != 'not_submitted';
                                        @endphp
                                        @if (@$finished)
                                            @include('front.user.courses.curriculum.assignments.solution')
                                        @else
                                            @include('front.user.courses.curriculum.assignments.description')
                                        @endif
                                    @else
                                        @include('front.user.courses.curriculum.assignments.description')
                                    @endif

                                    @break


                                @endswitch
                            </div>

                        </div>

                    </div>
                </div>
            </div>




        </div>
    </section>

        <!-- model-->
<div class="modal fade" id="bigBlueSessonTable" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">الالتحاق بالجلسة
                </h5>
            <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form
                action="{{route('user.courses.live.joinLiveSession')}}"
                method="POST">
                @csrf
                <input hidden id="modelSessionId" name="id">
                <label> {{__('name')}}
                    <input class="form-control" value=""
                            name="userName">
                </label>
                <label>{{__('password')}}
                    <input class="form-control" value=""
                            name="password">
                </label>
                <br><br>
                <button type="submit"
                        class="btn btn-primary btn-sm">التحاق</button>
            </form>
        </div>
        <div class="modal-footer">
            <br>
            <button type="button" class="btn btn-secondary btn-sm"
                    data-bs-dismiss="modal">{{__('close')}}</button>
        </div>
    </div>
</div>
@endsection

@include('front.user.courses.course_status_modal')

@push('front_js')
    <script src="{{ asset('assets/front/js/plyr.polyfilled.js') }}"></script>
    <script src="{{ asset('assets/front/js/course_status.js') }}"></script>

    <script>
         $(document).ready(function(){

$(document).on('click','.payInstallment',function(){
    var id = $(this).attr('alt');
    var course_id = "{{@$course->id}}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{url('/user/pay-to-course-session-installment')}}",
        data:{id:id,course_id:course_id},
        method: 'post',
        success: function (response) {
            $(".payInstallment"+"."+id).attr('disabled',true);
            $(".payInstallment"+"."+id).css({
                "pointer-events": "none",
                "opacity": "0.5",
                "cursor": "not-allowed"
            });
            customSweetAlert(
                response.status_msg,
                response.message,
            );
            setTimeout(function() {
                console.log("wait..");
            }, 3000);

            window.location.href = "/user/courses/curriculum/item/"+course_id;
        }
    });

});


//session modal

$(document).on('click','.bigBlueSessonBtnModal',function(){
    var id = $(this).attr('alt');
    $('#modelSessionId').val(id);
    $('#bigBlueSessonTable').modal('show');
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
