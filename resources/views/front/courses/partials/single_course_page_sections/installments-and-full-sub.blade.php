@push('front_before_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.css') }}">
    <script src="{{ asset('assets/front/js/intlTelInput.js') }}"></script>
@endpush

                    <div class="row">
           
                        <ul class="nav nav-sub-pills2 mb-3 nav-pills-login" id="pills-sub2-tab">
                                   @if(! checkIfstudentFullySubscribeOnCourse(@$course->id))
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-group2-sub"
                                            type="button" role="tab" style="border-bottom: background-color:rgb(111, 43, 144);">{{ __('full_paid') }}</button>
                                    </li>
                                    @endif
                                   
                                    @if($course->open_installments == 1 && @$course->type == "live" &&  (@$course->priceDetails && (@$course->priceDetails->price != '' && @$course->priceDetails->price != 0) ) )
                                    <li class="nav-item">
                                        <button class="nav-link " data-bs-toggle="pill" data-bs-target="#tab-single2-sub"
                                            type="button" role="tab" style="border-bottom: background-color:rgb(111, 43, 144);">{{ __('installment_paid') }}</button>
                                    </li>  
                                    @endif
                                </ul>
                                <div class="tab-content" id="pills-sub-tabContent2">
                                
                                    <div class="tab-pane fade show active" id="tab-group2-sub">
                                        <div class="card" style="max-width:700px;margin: auto;">
                                            <div class="card-header">
                                                <div class="card-title" class="text-center">{{ __('full_paid') }}</div>
                                            </div>
                                            <div class="card-body">
                                            @if ( @$course->priceDetails && (@$course->priceDetails->price != '' && @$course->priceDetails->price != 0) )
                                            <div class="col-12">
                                                <div class="form-group text-center my-1">
                                                <a href="{{ url('/user/full-select-payment-method', ['course_id' => $course->id ?? '']) }}"
                                                id="stop-submit_free_reg_btn" type="button"
                                                        class="secondary-btn p-1 stop-confirm-free-registeration"
                                                        data-url="{{ url('user/full-subscribe-course') }}"
                                                        data-id="{{ @$course->id }}"
                                                        data-to="{{ route('user.courses.curriculum.item', ['course_id' => $course->id]) }}"
                                                        data-marketer_coupon="{{ request('marketer_coupon') }}"
                                                        data-is_relpad_page="true">
                                                        {{ __('register_now') }} 
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <button id="submit_free_reg_btn" type="button"
                                                        class="secondary-btn w-100 font-bold rounded-pill confirm-free-registeration"
                                                        data-url="{{ route('user.courses.register.submit') }}"
                                                        data-id="{{ @$course->id }}"
                                                        data-to="{{ route('user.courses.curriculum.item', ['course_id' => $course->id]) }}"
                                                        data-marketer_coupon="{{ request('marketer_coupon') }}"
                                                        data-is_relpad_page="true">
                                                        {{ __('subscribe_now') . __('the_free')}} 
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if ( @$course->priceDetails && (@$course->priceDetails->price != '' && @$course->priceDetails->price != 0))
                                    <div class="tab-pane fade " id="tab-single2-sub">
                                        <div class="card" style="max-width:700px;margin: auto;">
                                                <div class="card-header">
                                                    <div class="card-title">{{ __('installment_paid') }}</div>
                                                </div>
                                                <div class="card-body">
                                                    @php 
                                                    $installments = App\Models\CourseSessionInstallment::where('course_id',$course->id)->get();
                                                    $lastIdOnPreviousLoop = 0;
                                                    @endphp
                                                    <div class="row d-flex ">
                                                    @foreach($installments as $installment)
                                                    @php
                                                        $untilLesson = $installment->course_session_id;
                                                        if(!$untilLesson){continue;}
                                                        $lessons = App\Models\CourseSession::where("course_id",$course->id)
                                                        ->where('id','>',$lastIdOnPreviousLoop)
                                                        ->where("id","<=",$untilLesson)->get();
                                                        $lastSession = $lessons->last();
                                                        $firstInstallment = $installments->first();
                                                        $lastIdOnPreviousLoop = $lastSession->id ?? '';
                                                        if($lastIdOnPreviousLoop == "")
                                                        {
                                                            continue;
                                                        }
                                                        $checkIfPrevious = App\Models\StudentSessionInstallment::where('student_id',auth('web')->user()->id)
                                                        ->where('access_until_session_id',$untilLesson)->where("course_id",$course->id)->first();
                                                        $checkIfPreviousIsPaided = $checkIfPrevious ? 1 : 0;
                                                        if($checkIfPreviousIsPaided == 1)
                                                        {
                                                            $isCurrentInstallment = App\Models\CourseSessionInstallment::where('course_session_id','>',$checkIfPrevious->access_until_session_id)->first();
                                                           
                                                           $currentInstallment = @$isCurrentInstallment->course_session_id;
                                                        }
                                                   
                                                        @endphp
                                                    <div class="card col-4" style="max-width:200px;padding:0px 2px">
                                                        <div class="card-header">
                                                            <div class="card-title">
                                                                {{$installment->name}}
                                                               
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                        <p >{{__('price')}} :  ({{$installment->price}}) دينار عراقى</p>
                                                        <hr>
                                                        <ul>
                                                        @foreach($lessons as $lesson)
                                                        <li style="list-style-type: disc;">{{$lesson->title}}</li>
                                                      
                                                        @endforeach
                                                        </ul>
                                                        
                                                        @if(! in_array($untilLesson,studentCourseSessionInstallmentsIDs($course->id)))
                                                        <hr>
                                                        <p style="font-size: 13px;color:red"><br>{{__('last_pay_date')}} : {{$lastSession->date.' '.$lastSession->time}} </p>
                                                        @endif
                                                      <br>
                                                      <br>
                                                        @if(! in_array($untilLesson,studentCourseSessionInstallmentsIDs($course->id)) && ($checkIfPreviousIsPaided == 1 || $firstInstallment->id == $installment->id || @$currentInstallment == $untilLesson) )
                                                        <a href="{{ url('/user/installment-select-payment-method', ['course_id' => @$course->id ,'id' => $untilLesson ?? '','price' => $installment->price]) }}" style="position:absolute;bottom:5px;text-align:center;cursor:pointer"
                                                         class="stop-payInstallment {{$untilLesson}} primary-btn w-50" alt="{{$untilLesson}}" data-price="{{$installment->price}}">{{__('payment')}} 
                                                        </a>
                                                        @elseif(in_array($untilLesson,studentCourseSessionInstallmentsIDs($course->id)) && ($checkIfPreviousIsPaided == 1 || $firstInstallment->id == $installment->id) )
                                                        <a style="position:absolute;bottom:5px;text-align:center;cursor:not-allowed;background-color:gray"
                                                         class="primary-btn w-50" >{{__('paid')}}
                                                        </a>
                                                        @elseif($checkIfPreviousIsPaided == 0 && $firstInstallment->id != $installment->id)
                                                        <a style="position:absolute;bottom:5px;text-align:center;cursor:not-allowed;background-color:gray"
                                                         class="primary-btn w-50" ><i class="fa fa-lock"></i>
                                                        </a>
                                                        @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                              
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                    
                    </div>
                </div>
            
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
@endpush
