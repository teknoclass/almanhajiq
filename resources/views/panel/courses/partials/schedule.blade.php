<style>
   #select_sessions,.select2-selection{
    height: auto !important;
   }
</style>

<div  class="form-group row align-items-center" id="schedule_form">
   <div class="col-md-10" id="schedule">
       @if (!$item->published)<h2>{{__('Create a lesson plan')}}</h2>
       <div class="row" >
           <div class="col-md-6">
               <div class="form-group">
                   <label for="weekly_sessions">{{ __('Weekly Sessions') }}</label>
                   <select class="form-control no-select-2" name="weekly_sessions" id="weekly_sessions" onchange="generateSessionInputs({{$item->published}});generateSessionCount()">
                       <option value="" disabled selected>{{ __('Weekly Sessions') }}</option>
                       @for ($i = 1; $i <= 7; $i++)
                           <option value="{{ $i }}" {{ (isset($item['weekly_sessions_count']) && $item['weekly_sessions_count'] == $i) ? 'selected' : '' }}>
                               {{ $i }}
                           </option>
                       @endfor
                   </select>
               </div>
           </div>

           <div class="col-md-6">
               <div class="form-group">
                   <label for="total_sessions">{{ __('Total Sessions') }}</label>

                   <select class="form-control no-select-2" name="total_sessions" id="total_sessions">
                       <option value="" disabled selected>{{ __('Total Sessions') }}</option>
                       @for ($i = $item['total_sessions_count']; $i <= 100; $i++)
                           <option value="{{ $i }}" {{ (isset($item['total_sessions_count']) && $item['total_sessions_count'] == $i && $item['total_sessions_count'] !=0) ? 'selected' : '' }}>
                               {{ $i }}
                           </option>
                       @endfor
                   </select>
               </div>
           </div>
       </div>
       <br>

       <div id="sessionInputsContainer">

       </div>
       <div id="planContainer">
           <table class="table table-bordered mt-4 " id="timeTable">
               <thead>
               <tr>
                   <th>{{ __('Day') }}</th>
                   <th>{{ __('Date') }}</th>
                   <th>{{ __('Time') }}</th>
                   <th>{{ __('Session Title') }}</th>
                   <th>{{ __('Actions') }}</th>

               </tr>
               </thead>
               <tbody>
               @foreach ($item['sessions'] as $index => $session)
               <br>
                   <tr>
                       <td >
                           <input type="text" class="form-control session_day" name="session_day_display_{{ $index }}" value="{{ __($session->day) }}" placeholder="{{ __($session->day) }}" readonly>
                           <input type="hidden" name="session_day_{{ $index }}" value="{{ $session->day }}">

                       </td>

                       <td>
                           <input hidden type="text" class="form-control" name="session_id_{{ $index }}" value="{{ $session->id }}">

                           <input type="date" class="form-control" name="session_date_{{ $index }}" value="{{ $session->date }}">
                       </td>
                       <td>
                           <input type="time" class="form-control" name="session_time_{{ $index }}" value="{{ $session->time }}">
                       </td>
                       <td>
                           <input minlength="3" maxlength="255"  type="text" class="form-control" name="session_title_{{ $index }}" value="{{ $session->title }}">
                       </td>
                       @if (!$item->published)
                       <td>

                           <button type="button" class="btn btn-danger" onclick="deleteSession(this)">
                               {{ __('delete') }}
                           </button>
                       </td>
                       @endif
                   </tr>

               @endforeach

               </tbody>
           </table>
       </div>
       <div>

   </div>
       <button type="button" class="btn btn-secondary" id="add_lesson" onclick="addNewRow('{{$item->start_date}}')">
           {{ __('Add Lesson') }}
       </button>
   </div>
    @else
        <script src="{{asset('assets/panel/js/schedule-inputs.js')}}">

        </script>
    @endif


    @if($item->published)
        @if(count($item['sessions'])>0)
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>{{ __('session_title') }}</th>
                <th>{{ __('group') }}</th>
                <th>{{ __('day') }}</th>
                <th>{{ __('date') }}</th>
                <th>{{ __('time') }}</th>
                <th>{{ __('price') }}</th>
                <th>{{ __('actions') }}</th>
                <th>{{ __('Attachments') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($item['sessions'] as $session)
            @php
                $isFuture = \Carbon\Carbon::parse($session->date . ' ' . $session->time)->isFuture();
            @endphp
                <tr>
                    <td>{{ $session->title }}</td>
                    <td><span class="badge badge-info">{{ $session->group?->title??__('no_group') }}</span></td>
                    <td>{{__($session->day)}}</td>
                    <td><input  {{ $isFuture ? '' : 'disabled' }} type="date" class="form-control changeDate {{$session->id}} " alt="{{$session->id}}"  value="{{ $session->date }}"></td>
                    <td><input  {{ $isFuture ? '' : 'disabled' }} type="time" class="form-control changeTime {{$session->id}} " alt="{{$session->id}}"  value="{{ $session->time }}"></td>
                    <td><input  {{ $isFuture ? '' : 'disabled' }} type="number" step="any" min="0" class="sessionPrice {{$session->id}} form-control" alt="{{$session->id}}" value="{{$session->price}}"></td>
                    <td>
                        @php
                            $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                            $now = now();
                            $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 10;
                            $isSessionInPast = $sessionDateTime->isPast();
                            $isSessionStartingSoon = $sessionDateTime->isFuture() && $sessionDateTime->diffInMinutes($now) <= 120;
                        @endphp

                        @if($isSessionNow)
                            <span><a href="{{ route('user.lecturer.live.createLiveSession', $session->id) }}" class="btn btn-primary">{{ __('Start Session') }}</a></span>
                        @elseif ($isSessionStartingSoon)
                            <button class="btn btn-warning" disabled>{{ __('starting_soon') }}</button>
                        @elseif ($isSessionInPast)
                            <button class="btn btn-secondary" disabled>{{ __('Ended') }}</button>
                        @else
                            <button class="btn btn-primary" disabled>{{ __('did_not_start_yet') }}</button>
                        @endif
                    </td>
                    <td><span><a class="btn btn-primary attachment_modal" data-session-id="{{ $session->id }}">{{ __('add') }}</a></span></td>
                    @endforeach
            </tbody>
        </table>
        @endif
        <h2>{{__('Lessons Groups')}}</h2>
        <div id="groupsAccordion" class="accordion mt-4">
            @if($item['groups'])
                @foreach ($item['groups']->unique('id') as $groupIndex => $group)
                    <div class="accordion-item session_accordion-item">
                        <div class="accordion-header" id="heading{{ $groupIndex }}">
                            <h2 class="mb-0">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $groupIndex }}">
                                    {{ $group->title }}
                                    <span style="padding: 0 20px;"><i class="bi bi-cash-stack"></i> {{__('price')}} : {{$group->price}}</span>
                                </button>
                                <input type="text" name="group_{{ $groupIndex }}_title" hidden value="{{ $group->title }}">
                                <input hidden type="text" name="group_{{ $groupIndex }}_id" value="{{ $group->id }}">
                            </h2>
                        </div>

                        <div id="collapse{{ $groupIndex }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                @if(!isCourseHasSubscriptions($item->id))
                                <button type="button" class="btn btn-secondary btn-sm float-right" data-group-url="{{ route('panel.courses.edit.courseSchedule.getGroupWithSessions',["courseId"=>$item->id])}}" onclick="openGroupModal(true, {{ $groupIndex }},{{$group->id }},$(this).attr('data-url'))"  data-url="{{ route('panel.courses.edit.courseSchedule.group.update',['courseId'=>$item->id,'groupId'=> $group->id]) }}">
                                    <i class="fa fa-pencil-alt"></i> {{ __('Edit') }}
                                </button>
                                <button type="button" class="btn btn-danger btn-sm float-right mr-2" id="remove_group_{{ $group->id }}" onclick="removeGroup({{ $group->id }})" data-url="{{ route('panel.courses.edit.courseSchedule.group.delete', ['courseId'=>$item->id,'groupId'=> $group->id]) }}">
                                    <i class="fa fa-trash"></i> {{ __('Remove') }}
                                </button>
                                @endif
                                <ul class="list-group" id="sessionsContainer_{{ $groupIndex }}">
                                    @foreach ($group->sessions as $sessionIndex => $session)
                                        <li class="list-group-item">{{ $session->title }} - {{ __($session->day) }} ({{ $session->date }}) - {{ $session->time }}</li>
                                        <input type="text" id="session_{{ $groupIndex }}" name="session_{{ $groupIndex }}_{{$sessionIndex}}" hidden value="{{ $session->id }}">
                                        @php
                                            $sessionDateTime = \Carbon\Carbon::parse($session->date . ' ' . $session->time);
                                            $now = now();
                                            $isSessionNow = $sessionDateTime->equalTo($now) || $sessionDateTime->diffInMinutes($now) <= 10;
                                        @endphp

                                        @if($isSessionNow)
                                            <span><a href="{{ route('panel.courses.live.createLiveSession', $session->id) }}" class="btn btn-primary">Start Session</a></span>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="addGroup" @if(!$item->published) style="display:none;" @else style="display:block;" @endif>
            <button type="button" class="btn btn-primary mt-4" onclick="openGroupModal(false)"  data-method="POST" data-sessions="{{route('panel.courses.edit.courseSchedule.group.sessions.used', $item->id)}}" data-url="{{ route('panel.courses.edit.courseSchedule.group.store',$item->id) }}" data-translations='{
            "add_group": "{{ __('add_group') }}",
            "group_title": "{{ __('group_title') }}",
            "edit": "{{ __('Edit') }}",
            "remove": "{{ __('Remove') }}",
            "enter_group_title": "{{ __('enter_group_title') }}",
            "group_saved": "{{ __('group_saved') }}",
            "error_saving_group": "{{ __('error_saving_group') }}",
            "delete_group_confirmation": "{{ __('delete_group_confirmation') }}",
            "delete_group_warning": "{{ __('delete_group_warning') }}",
            "confirm_delete": "{{ __('confirm_delete') }}",
            "cancel": "{{ __('cancel') }}",
            "group_deleted": "{{ __('group_deleted') }}",
            "error": "{{ __('error') }}",
            "error_deleting_group": "{{ __('error_deleting_group') }}",
            "ok": "{{ __('ok') }}",
            "group_has_been_deleted": "{{ __('group_has_been_deleted') }}"
        }'>
                <i class="fa fa-plus"></i> {{ __('Add Group') }}
            </button>
        </div>

        <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="groupModalLabel">{{ __('add_group') }}</h5>
                        <button type="button" class="close btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="group_title">{{ __('group_title') }}</label>
                            <input type="text" required class="form-control" id="group_title" placeholder="{{ __('enter_group_title') }}">
                            <input type="text" class="form-control" id="group_id" hidden>

                            <div class="invalid-feedback" id="groupTitleError" style="display: none;">
                                {{ __('group_title_required') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">{{ __('price') }}</label>
                            <input type="number" step="any" min="0" required class="form-control" id="price">
                            <input type="text" class="form-control" id="price" hidden>

                            <div class="invalid-feedback" id="priceError" style="display: none;">
                                {{ __('price_required') }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="select_sessions">{{ __('Select Sessions') }}</label>
                            <select multiple class="form-control" id="select_sessions" style="height: auto !important;">
                                @foreach ($item['sessions'] as $session)
                                    <option value="{{ $session->id }}">{{ $session->title }} - {{ __($session->day) }} ({{ $session->date }}) - {{ $session->time }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="selectSessionsError" style="display: none;">
                                {{ __('At least one session must be selected') }}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalBtn" data-dismiss="modal">{{ __('close') }}</button>
                        <button type="button" class="btn btn-primary" id="saveGroupBtn" data-url="{{ route('panel.courses.edit.courseSchedule.group.store',$item->id) }}">{{ __('Save Group') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        const translations = {
            select_day: "{{ __('select_day') }}",
            day: "{{ __('day') }}",
            date: "{{ __('date') }}",
            time: "{{ __('time') }}",
            session_title: "{{ __('session_title') }}",
            actions: "{{ __('actions') }}",
            delete: "{{ __('delete') }}",
            total_sessions: "{{ __('Total Sessions') }}",
            hello: "{{ __('hello') }}",
            welcome: "{{ __('welcome') }}",

                monday: "{{ __('monday') }}",
                tuesday: "{{ __('tuesday') }}",
                wednesday: "{{ __('wednesday') }}",
                thursday: "{{ __('thursday') }}",
                friday: "{{ __('friday') }}",
                saturday: "{{ __('saturday') }}",
                sunday: "{{ __('sunday') }}"

        };
    </script>

    <div class="col-12">
      <div class="separator separator-dashed  separator-dashed-dark my-8"></div>
   </div>
</div>
