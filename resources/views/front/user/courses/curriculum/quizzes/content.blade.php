@extends('front.layouts.index', ['is_active' => 'test_courses', 'sub_title' => @$quiz->course->title])


@section('content')
	@php
		$is_active = 'curriculum';

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('my_courses'),
		        'link' => '#',
		    ],
		    [
		        'title' => @$quiz->course->title,
		        'link' => '#',
		    ],
		];
	@endphp
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            <div class="row mb-4 justify-content-between align-items-center">
                <div class="col-lg-9">
                    <ol class="breadcrumb mb-0">
                        @foreach($breadcrumb_links as $sub_link)
                            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                @if(@$sub_link['link']!='#')
                                    <a href="{{ @$sub_link['link'] }}">{{ @$sub_link['title'] }}</a>
                                @else
                                    {{ @$sub_link['title'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
			<div class="row mb-3">
				<div class="col-12">
					<div class="d-flex align-items-center justify-content-between">
						<h4 class="font-medium"><span class="square me-2"></span> {{ @$quiz->title }}</h4>
						<div class="remaining-time font-medium d-flex align-items-center">
                            <i class="fa-solid fa-timer me-2"></i> {{ __("remaining_time") }}  <span id="time"> </span>
                        </div>
					</div>
				</div>
			</div>

            <form id="save_answer" action="{{ route('user.storeResult', ['course_id' => @$quiz->course->id, 'id' => @$quiz->id]) }}" method="post" class="">
                @csrf
                <div class="row">
                    <input type="hidden" name="quiz_result_id" value="{{ $quizResult->id }}" class="form-control" placeholder=""/>
                    {{-- <input type="hidden" name="attempt_number" value="{{ $attempt_count }}" class="form-control" placeholder=""/> --}}
                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                    @foreach($quizQuestions as $key => $question)

                        @switch($question->type)
                            @case(\App\Models\CourseQuizzesQuestion::$descriptive)
                                @include('front.user.courses.curriculum.quizzes.question_types.fill')
                                @break

                            @case(\App\Models\CourseQuizzesQuestion::$multiple)
                                @include('front.user.courses.curriculum.quizzes.question_types.multiple')
                                @break

                            @default

                        @endswitch
                    @endforeach

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between">
                            <button type="submit" class="btn btn-danger">{{ __("submit") }}</button>
                            {{-- <div class="remaining-time font-medium d-flex align-items-center">
                                <i class="fa-solid fa-timer me-2"></i> متبقي
                                1:20:33</div> --}}
                        </div>
                    </div>
                </div>
        </form>
		</div>
	</section>
@endsection

@push('front_js')
<script>
    $(document).ready(function() {
        timePage();
    });

    function timePage() {
        var totalTimeInSeconds = parseInt("{{ @$quiz->time * 60}}");
        var minutes, seconds;
        var interval = setInterval(function() {
            if (totalTimeInSeconds <= 0) {
                clearInterval(interval);
                $('#time').hide();
                $('#load').show();
                $('#save_answer')[0].submit();
                return;
            } else {
                minutes = Math.floor(totalTimeInSeconds / 60);
                seconds = totalTimeInSeconds % 60;

                // Format the minutes and seconds to display as MM:SS
                var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

                $('#time').text(': ' + formattedTime);

                totalTimeInSeconds--;
            }
        }, 1000);
    }
</script>
@endpush
