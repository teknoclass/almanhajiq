<tr id="row_{{ @$lesson->id }}">
    <td><span class="d-flex align-items-center"><span class="ms-2">{{@$lesson->title}}</span></span></td>
    <td>{{ @$lesson->category->name }} </td>

    @if (@$settings->valueOf('offline_private_lessons'))
        <td>{{ __('meeting_type.' . @$lesson->meeting_type) }}</td>
    @endif

    <td><span><i class="fa-regular fa-clock me-2"></i> {{ @$lesson->meeting_date }}</span></td>
    <td>
        <p>{{ \Carbon\Carbon::parse(@$lesson->time_form)->format('h:i A') }} <br>
            {{ \Carbon\Carbon::parse(@$lesson->time_to)->format('h:i A') }}</p>
    </td>
    <td><strong>{{ @$lesson->student_id ? @$lesson->getFirstPriceWithCurrency() : @$lesson->getPriceWithCurrency('', $lesson->meeting_type, $lesson->time_type) }}</strong>
    </td>
    <td><strong>{{ @$lesson->getEarningWithCurrency() }}</strong></td>



    <td>
        @php
            $lesson_status_class = "text-warning";
            $lesson_status_title = __('not_booked');
            $student = "";
        @endphp
        @if(@$lesson->status == "acceptable" && isset($lesson->student_id))
                @php
                    $lesson_status_class = "text-success";
                    $lesson_status_title = __('booked_by');
                    $student = @$lesson->student->name;
                @endphp
        @endif
        @if(@$lesson->status == "unacceptable")
                @php
                    $lesson_status_class = "text-danger";
                    $lesson_status_title = __('canceled');
                    $student = "";
                @endphp
        @endif
        <span class="{{@$lesson_status_class}}">
            {{@$lesson_status_title}} @if ($student != "") <br> {{ $student }} @endif
        </span>
    </td>
    <td>
        <span class="d-flex align-items-center">
            @if (@$lesson->status == "acceptable")
                @if (@$lesson->student_no > 0)
                    <span class="ms-2">{{@$lesson->student_no}} {{ __('persons') }}</span>
                @else
                    <span>{{ @$lesson->student->name }}</span>
                @endif
            @else
                <strong>---</strong>
            @endif
        </span>
    </td>
    @php
        $canStartMeeting = @$lesson->canStartMeeting();
        $lessonStatus = 'pending';

        if (@$lesson->meeting_link == '' && @$canStartMeeting && @$lesson->student_id != '')
            $lessonStatus = 'waiting_to_start';
        else if (@$lesson->meeting_link != '' && @$canStartMeeting && @$lesson->student_id != '')
            $lessonStatus = 'started_but_not_finished';
        else if (@$lesson->meeting_link != '' && !@$canStartMeeting && @$lesson->student_id != '')
            $lessonStatus = 'finished';
        else
            $lessonStatus = 'pending';

    @endphp
    <td>
        @if (@$lesson->meeting_type == 'online')
            @php
                $meeting = $lesson->meeting;
            @endphp

            @if(!$lesson->canStartMeeting())
                <strong>---</strong>
            @elseif($lesson->canStartMeeting() && !isset($meeting))
                <a target="_blank" href="{{route('user.lecturer.private_lessons.meeting.create', ['id' => $lesson->id])}}"
                    class="text-success">
                    {{__('start_now')}}
                </a>

            @elseif(isset($meeting) && @$meeting->status == 'active')

                <a target="_blank" href="{{route('user.lecturer.private_lessons.meeting.join', ['id' => $lesson->id])}}">
                    {{__('join_to_meet')}}
                </a>
            @elseif(isset($meeting) && @$meeting->status == 'finished')
                <div class="btn btn-danger py-1 px-2">
                    {{ __('finished') }}
                </div>
            @endif



        @elseif (@$lesson->meeting_type == 'offline')
            <strong>{{ __('meeting_type.offline') }}</strong>
        @endif
    </td>
    @if (@$type == 'finished')
        @php
            $time_now = now()->toTimeString();
            $date_now = now()->toDateString();
            $date_passed = false;

            if (@$lesson->meeting_date < $date_now) {
                $date_passed = true;
            } else if (@$lesson->meeting_date == $date_now) {
                if (@$lesson->time_to < $time_now)
                    $date_passed = true;
            }
        @endphp
        <td>
            @if(@$lesson->is_rated == 1)
                <div class="data-rating d-flex align-items-center"><span class="d-flex"
                        data-rating="{{ @$lesson->getRate()['total_rate'] }}"><i class="far fa-star"></i><i
                            class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
                            class="far fa-star"></i></span><span class="pt-1">{{ @$lesson->getRate()['total_rate'] }}</span>
                </div>
            @else
                ----
            @endif
        </td>

    @endif
    <td>{{__(@$lesson->requests->last()->status)}}</td>
  {{--  <td>{{@$lesson->requests->last()->admin_response}}</td>

    <td>
        <span class="d-flex align-items-center w-100 justify-content-between">
            <div class="dropdown" id="dropdown">
                <button class="btn btn-drop px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-ellipsis-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3">

                    @if ($lessonStatus == 'pending')
                        <p><a
                                href="{{ route('user.lecturer.private_lessons.edit.index', @$lesson->id) }}">{{ __("edit_private_lessons") }}</a>
                        </p>
                    @endif
                    @if (isset($lesson->student_id))
                        <p><a
                                href="{{ route('user.chat.open.chat', @$lesson->student_id) }}">{{ __("contact_student") }}</a>
                        </p>
                    @endif
                    @if (!isset($lesson->student_id))
                        <button type="button" class="bg-transparent btn-clean confirm-post"
                            data-url="{{route('user.lecturer.private_lessons.delete')}}" data-id="{{ @$lesson->id }}"
                            data-is_relpad_page="true">
                            <span class="text-danger">{{ __('cancel_lesson') }}</span>
                        </button>
                    @endif


                </div>
            </div>
        </span>
    </td> --}}

   {{-- <td>
        <div>

            <button data-toggle="modal" data-id="{{ $lesson->id }}" data-target="#cancelModal" id="cancelButton" ><span class="far  fa-cancel"></span><label>{{ __('cancel')}}</label></button>
        </div>
        <div>
            <button data-toggle="modal" data-id="{{ $lesson->id }}" data-target="#postPoneModal" id="postponeButton"><span class="far  fa-calendar"></span><label>{{ __('postpone')}}</label></button>


        </div>
    </td> --}}
</tr>


