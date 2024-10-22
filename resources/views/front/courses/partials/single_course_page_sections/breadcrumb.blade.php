@if ($course->isSubscriber())
    <div class="container">
        <div class="row mb-4 justify-content-between align-items-center">
            <div class="col-lg-9">
                <ol class="breadcrumb mb-0">
                    {{--<li class="breadcrumb-item text-white"><a href="#">{{ __('home') }}</a></li>--}}
                    <li class="breadcrumb-item text-white"><a class="text-white" href="{{ route('courses.index') }}">{{ __('courses') }}</a></li>
                    <li class="breadcrumb-item text-color-third active">{{ @$course->title }}</li>
                </ol>
            </div>
            @include('front.user.courses.components.course_dropdown', ['course' => @$course])
        </div>
    </div>
@else
    <div class="container">
        <div class="row mb-3">
            <div class="col-12 px-0">
                <div class="d-flex align-items-center justify-content-between same-page-nav-link">
                    <ol class="breadcrumb mb-0">
                        {{-- <li class="breadcrumb-item text-white"><a href="{{ route('index') }}">{{ __('home') }}</a>
                        </li> --}}
                        <li class="breadcrumb-item"><a class="text-white" href="{{ route('courses.index') }}">{{ __('courses') }}</a></li>
                        <li class="breadcrumb-item text-color-third active">{{ @$course->title }}</li>
                    </ol>

                    @if (!checkUser('lecturer'))

                        @if (checkUser('marketer'))
                            <button class="btn btn-primary rounded-pill" type="button" onclick="copyText();"
                                id="registration-link-button">
                                {{ __('share') }}
                            </button>
                        @else
                            {{-- <button class="btn btn-primary rounded-pill" data-scroll="course-registration">{{ __('register_now') }}</button> --}}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endauth
