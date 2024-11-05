<!-- Course Information -->
<div class="container tab" id="{{ @$tab }}">
    <div class="row gap-5 gap-lg-0 my-5">
        <div class="col-lg-8 col-12 mt-4">
            <div class="information">
                <h2 class="text-color-primary font-bold">{{ __('course_brief_explanation') }}</h2>

                    {{-- {!! @$course->welcome_text_for_registration !!} --}}
                    @if (@$course->description)
                        {!!@$course->description!!}
                    @endif

            </div>
            <h2 class="text-color-primary font-bold my-2">{{ __('course_details') }}</h2>
            <div class="row course-details">
                @if($course->type !='live')
                <div class="col-6 col-md-3 mb-3">

                        <div class="content">
                            <h4 class="text-color-muted-02 mb-3">{{ __('lessons') }}</h4>
                            <div>
                            <span>
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.5 16.7399V4.66994C22.5 3.46994 21.52 2.57994 20.33 2.67994H20.27C18.17 2.85994 14.98 3.92994 13.2 5.04994L13.03 5.15994C12.74 5.33994 12.26 5.33994 11.97 5.15994L11.72 5.00994C9.94 3.89994 6.76 2.83994 4.66 2.66994C3.47 2.56994 2.5 3.46994 2.5 4.65994V16.7399C2.5 17.6999 3.28 18.5999 4.24 18.7199L4.53 18.7599C6.7 19.0499 10.05 20.1499 11.97 21.1999L12.01 21.2199C12.28 21.3699 12.71 21.3699 12.97 21.2199C14.89 20.1599 18.25 19.0499 20.43 18.7599L20.76 18.7199C21.72 18.5999 22.5 17.6999 22.5 16.7399Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M12.5 5.48999V20.49" stroke="#013B3D" stroke-width="1.5"
                                          stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M8.25 8.48999H6" stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                    <path d="M9 11.49H6" stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                          stroke-linejoin="round" />
                                </svg>
                            </span>
                                <span class="num">{{$course->getTotalItemsCount()}}</span>
                            </div>
                        </div>

                </div>
                @endif
                    @if($course->type !='live')
                <div class="col-6 col-md-3 mb-3">
                    <div class="content">
                        <h4 class="text-color-muted-02 mb-3">{{ __('duration') }}</h4>
                        <div>
                            <span>
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.5 12C22.5 17.52 18.02 22 12.5 22C6.98 22 2.5 17.52 2.5 12C2.5 6.48 6.98 2 12.5 2C18.02 2 22.5 6.48 22.5 12Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M16.2099 15.18L13.1099 13.33C12.5699 13.01 12.1299 12.24 12.1299 11.61V7.51001"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="num">{{$course->getDurationInDays()}} {{__('days')}}</span>
                        </div>
                    </div>
                </div>
                    @endif
                <div class="col-6 col-md-3 mb-3">
                    <div class="content">
                        <h4 class="text-color-muted-02 mb-3">{{ __('grade_level') }}</h4>
                        <div>
                            <span>
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M19.7598 18.9V7.1C19.7598 5.6 19.1198 5 17.5298 5H16.4898C14.8998 5 14.2598 5.6 14.2598 7.1V18.9"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M5.75977 18.9V12.1C5.75977 10.6 6.39977 10 7.98977 10H9.02977C10.6198 10 11.2598 10.6 11.2598 12.1V18.9"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2.5 19H22.5" stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="num">{{@App\Models\Category::find(@$course->grade_level_id)->name ?? ""}} </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="content">
                        <h4 class="text-color-muted-02 mb-3">{{ __('students') }}</h4>
                        <div>
                            <span>
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.5001 7.16C18.4401 7.15 18.3701 7.15 18.3101 7.16C16.9301 7.11 15.8301 5.98 15.8301 4.58C15.8301 3.15 16.9801 2 18.4101 2C19.8401 2 20.9901 3.16 20.9901 4.58C20.9801 5.98 19.8801 7.11 18.5001 7.16Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M17.4704 14.4399C18.8404 14.6699 20.3504 14.4299 21.4104 13.7199C22.8204 12.7799 22.8204 11.2399 21.4104 10.2999C20.3404 9.58992 18.8104 9.34991 17.4404 9.58991"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M6.46949 7.16C6.52949 7.15 6.59949 7.15 6.65949 7.16C8.03949 7.11 9.13949 5.98 9.13949 4.58C9.13949 3.15 7.98949 2 6.55949 2C5.12949 2 3.97949 3.16 3.97949 4.58C3.98949 5.98 5.08949 7.11 6.46949 7.16Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M7.49945 14.4399C6.12945 14.6699 4.61945 14.4299 3.55945 13.7199C2.14945 12.7799 2.14945 11.2399 3.55945 10.2999C4.62945 9.58992 6.15945 9.34991 7.52945 9.58991"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M12.5001 14.63C12.4401 14.62 12.3701 14.62 12.3101 14.63C10.9301 14.58 9.83008 13.45 9.83008 12.05C9.83008 10.62 10.9801 9.46997 12.4101 9.46997C13.8401 9.46997 14.9901 10.63 14.9901 12.05C14.9801 13.45 13.8801 14.59 12.5001 14.63Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M9.58973 17.7799C8.17973 18.7199 8.17973 20.2599 9.58973 21.1999C11.1897 22.2699 13.8097 22.2699 15.4097 21.1999C16.8197 20.2599 16.8197 18.7199 15.4097 17.7799C13.8197 16.7199 11.1897 16.7199 9.58973 17.7799Z"
                                        stroke="#013B3D" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </span>
                            <span class="num">
                                {{$course->students()->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12 mt-4">
            @include('front.courses.partials.single_course_page_sections.course_curriculum')
            @include('front.courses.partials.single_course_page_sections.about_lecturer')
        </div>
    </div>
</div>
