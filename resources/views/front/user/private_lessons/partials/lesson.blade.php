@if(Session::has('message'))
<div>
    <div class='alert alert-primary' id='alert-message' role='alert'>{{Session::get('message')}}</div>
</div>
@endif
<tr>
    <td>{{ @$privateLesson->title }}</td>
    <td>{{ @$privateLesson->category->name }}</td>
    <td>{{ @$privateLesson->teacher->name }}</td>
    <td><span><i class="far fa-calendar"></i> </span> <span>{{ @$privateLesson->meeting_date }}</span></td>
    <td><p>{{ \Carbon\Carbon::parse(@$privateLesson->time_form)->format('h:i A') }} <br> {{ \Carbon\Carbon::parse(@$privateLesson->time_to)->format('h:i A') }}</p></td>

    @if (@$settings->valueOf('offline_private_lessons'))
        <td>{{ __('meeting_type.'.@$privateLesson->meeting_type) }}</td>
    @endif


    @php
        $price = $privateLesson->price;
        if($user->country) {
            $price = ceil($user->country->currency_exchange_rate*$price) . ' ' . $user->country->currency_name;
        }else {
            $price = $price .' $';
        }
    @endphp
    <td>{{ @$price }}</td>




    @if (@$type == 'upcoming')
        @if (@$privateLesson->status == 'acceptable' && isset($privateLesson->student_id))
            @php
                $privateLesson_status = __('acceptable');
            @endphp
        @endif
        @if (@$privateLesson->status == 'unacceptable')
            @php
                $privateLesson_status = __('canceled');
            @endphp
        @endif
            @if (@$privateLesson->status == 'canceled')
            @php
                $privateLesson_status = __('canceled');
            @endphp
        @endif
        <td>{{ @$privateLesson_status }}</td>
    @endif


    @if (@$type == 'upcoming')

        <td><div>

                <button data-toggle="modal" data-target="#cancelModal" data-id="{{ @$privateLesson->id }}" id="cancelButton"><span class="far  fa-cancel"></span><label>{{ __('cancel')}}</label></button>
            </div>
            <div>
                <button data-toggle="modal" data-target="#postPoneModal" data-id="{{ @$privateLesson->id }}" id="postPoneButton"><span class="far  fa-calendar"></span><label>{{ __('postpone')}}</label></button>



            </div></td>
    @endif

    <td>

        @if (@$privateLesson->meeting_type == 'online')
            @if (@$privateLesson->meeting_link == '')
                <strong>---</strong>
            @endif

            @if (isset($privateLesson->meeting))
                @if (@$privateLesson->meeting->status=='active')
                    <a target="_blank" class="btn btn-success py-1 px-2"
                        href="{{ route('user.private_lessons.meeting.join', ['id' => $privateLesson->id]) }}">
                        {{ __('join_to_meet') }}
                    </a>
                @else
                    <div class="btn btn-danger py-1 px-2">
                        {{ __('finished') }}
                    </div>
                    <br>
                    @if ($privateLesson->meeting->participants->where('user_id' , auth('web')->id())->first())
                        <div class="text-success fs-5 px-2">
                            {{ __('Attend') }} <i class="fa fa-check"></i>
                        </div>
                    @else
                        <div class="text-danger fs-4">
                            {{ __('Not_Attend') }} <i class="fa fa-times"></i>
                        </div>
                    @endif
                @endif
            @endif

        @elseif (@$privateLesson->meeting_type == 'offline')
                <strong>درس حضوري</strong>
        @endif

    </td>

    @if (@$type == 'finished')
        @php
            $time_now = now()->toTimeString();
            $date_now = now()->toDateString();
            $date_passed= false;

            if (@$privateLesson->meeting_date < $date_now) {
                $date_passed= true;
            }
            else if(@$privateLesson->meeting_date == $date_now){
                if (@$privateLesson->time_to < $time_now)
                    $date_passed= true;
            }
        @endphp
        <td>
            @if (@$privateLesson->status == 'acceptable' && isset($privateLesson->meeting) && @$privateLesson->is_rated == 0 && $date_passed)

            <button data-lesson="{{@$privateLesson->id}}" data-title="{{@$privateLesson->title}}" class="rate_btn btn btn-add px-1 py-0 bg-primary rounded-2 p-lg-2">
                <i class="fa-regular fa-plus"></i>
            </button>

            @elseif(@$privateLesson->is_rated == 1)
                <div class="data-rating d-flex align-items-center"><span class="d-flex"
                    data-rating="{{ @$privateLesson->getRate()['total_rate'] }}"><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
                        class="far fa-star"></i><i class="far fa-star"></i></span><span class="pt-1">{{ @$privateLesson->getRate()['total_rate'] }}</span>
                </div>
            @else
            ----
            @endif
        </td>
    @endif
</tr>
