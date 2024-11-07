@push('front_before_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/front/js/intlTelInput.js') }}"></script>
@endpush

<div class="container mb-5 pt-10 tab" id="{{ @$tab }}">
    <div class="row">
        <div class="col-12">
            <div class="card-course prim-border shadow-sm p-3" style="max-width:700px;margin: auto;">
                <div class="text-center pt-10">
                    <h5 class="text-colot-primary font-bold text-center">{{ __("subscription_offers") }}</h6>
                    <img src="{{ asset('assets/front/images/info/subscription_offers.webp') }}" style="width: 100px;height:100px;border-radius:100%" loading="lazy"/>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                  
                        @if (auth('web')->check() && auth('web')->user()->role == 'student')
                        <ul class="nav nav-sub-pills mb-3 nav-pills-login" id="pills-sub-tab">
                                    @if($course->can_subscribe_to_session_group == 1)
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-group-sub"
                                            type="button" role="tab" style="border-bottom: background-color:rgb(111, 43, 144);">{{ __('group_course_session_sub') }}</button>
                                    </li>
                                    @endif
                                    @if($course->can_subscribe_to_session == 1)
                                    <li class="nav-item">
                                        <button class="nav-link " data-bs-toggle="pill" data-bs-target="#tab-single-sub"
                                            type="button" role="tab" style="border-bottom: background-color:rgb(111, 43, 144);">{{ __('single_course_session_sub') }}</button>
                                    </li>  
                                    @endif
                                </ul>
                                <div class="tab-content" id="pills-sub-tabContent">
                                    @php 
                                    $studentSubscribedSessionsIds = auth('web')->user()->studentSubscribedSessions()->pluck('course_session_id')->toArray();
                                    $groupsHasSessions = App\Models\CourseSession::pluck('group_id')->toArray();

                                    $studentGroupSubscriptions = studentSessionGroupSubscriptions();
                                    $sessionGroups = App\Models\CourseSessionsGroup::whereIn('id',$groupsHasSessions)
                                    ->whereHas('sessions',function($q) use($course){
                                        $q->where('course_id',$course->id);
                                    })
                                    ->whereNotIn('id',$studentGroupSubscriptions->pluck('course_session_group_id')->toArray())->get();
                                    $sessions = App\Models\CourseSession::whereNotIn('id',$studentSubscribedSessionsIds)->where('course_id',$course->id)->get();
                                    @endphp
                                    
                                    <div class="tab-pane fade show active" id="tab-group-sub">
                                        <div class="card" style="max-width:700px;margin: auto;">
                                            <div class="card-header">
                                                <div class="card-title" class="text-center">{{ __('group_course_session_sub') }}</div>
                                            </div>
                                            <div class="card-body">
                                                <label>{{__('session_group')}}</label>
                                                <select class="form-control sessionGroupId">
                                                    <option disabled readonly selected value="">{{__('choose_pls')}}</option>
                                                @foreach($sessionGroups as $sessionGroup)
                                                    <option data-price="{{$sessionGroup->price}}"  value="{{$sessionGroup->id}}">{{$sessionGroup->title}}  ({{__('price')}} : {{$sessionGroup->price}})</option>
                                                @endforeach
                                                </select>
                                                <div class="form-group mt-4 text-center col-3 subscribeToSessionGroup" style="margin: auto;">
                                                    <button class="primary-btn p-2 w-100 " type="submit"
                                                        id="btn_submit">{{ __('subscribe') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade " id="tab-single-sub">
                                    <div class="card" style="max-width:700px;margin: auto;">
                                            <div class="card-header">
                                                <div class="card-title">{{ __('single_course_session_sub') }}</div>
                                            </div>
                                            <div class="card-body">
                                            <label>{{__('lesson')}}</label>
                                                <select class="form-control sessionId">
                                                    <option disabled readonly selected value="">{{__('choose_pls')}}</option>
                                                @foreach($sessions as $session)
                                                    <option data-price="{{$session->price}}"  value="{{$session->id}}">{{$session->title}} ({{__('price')}} : {{$session->price}})</option>
                                                @endforeach
                                                </select>
                                                <div class="form-group mt-4 text-center col-3 subscribeToSession"  style="margin: auto;">
                                                    <button class="primary-btn p-2 w-100 " type="submit"
                                                        id="btn_submit">{{ __('subscribe') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @else
                        <div class="form-group mt-4 text-center col-4 " style="margin: auto;">
                            <a href="{{url('/login')}}" class="primary-btn p-2 w-100 font-medium" type="submit"
                                id="btn_submit">{{ __('login_as_student') }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
 

    <script>
    $(document).ready(function(){
        $(document).on('click','.subscribeToSessionGroup',function(){
            var target_id = $('.sessionGroupId').val();
            if (target_id !== null && target_id !== undefined)
            {  
                var type = "group";
                var course_id = "{{@$course->id}}";
                var price = $('.sessionGroupId option:selected').data('price');

                var url = "{{ url('/user/session-select-payment-method') }}" + 
                "/" + course_id + 
                "/" + target_id + 
                "/" + price +
                "/group";

                window.location.href = url;
            }else{
                customSweetAlert(
                        'error',
                        "{{__('please_choose_group')}}"
                    );
            }
        });

        $(document).on('click','.subscribeToSession',function(){
            var target_id = $('.sessionId').val();
            if (target_id !== null && target_id !== undefined)
            {    
                var type = "session";
                var course_id = "{{@$course->id}}";
                var price = $('.sessionId option:selected').data('price');

                var url = "{{ url('/user/session-select-payment-method') }}" + 
                "/" + course_id + 
                "/" + target_id + 
                "/" + price +
                "/session";

                window.location.href = url;
            }else{
                customSweetAlert(
                        'error',
                        "{{__('please_choose_session')}}"
                    );
            }

       });
   });
    </script>
@endpush
