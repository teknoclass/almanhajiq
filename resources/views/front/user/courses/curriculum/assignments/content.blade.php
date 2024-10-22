@extends('front.layouts.index', ['is_active' => 'test_courses', 'sub_title' => @$assignment->course->title])

@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/dropzone.min.css') }}" />
@endpush

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
		        'title' => @$assignment->course->title,
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
						<h4 class="font-medium"><span class="square me-2"></span> {{ @$assignment->title }}</h4>
						<div class="remaining-time font-medium d-flex align-items-center">
                            <i class="fa-solid fa-timer me-2"></i> {{ __("remaining_time") }}  <span id="time"> </span>
                        </div>
					</div>
				</div>
			</div>

            <form id="save_answer" action="{{ route('user.courses.curriculum.assignment.store.result', ['course_id' => @$assignment->course->id, 'id' => @$assignment->id]) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                <div class="row">
                    <input type="hidden" name="assignment_result_id" value="{{ $assignmentResult->id }}" class="form-control" placeholder=""/>

                    @foreach($assignmentQuestions as $key => $question)

                        @switch($question->type)
                            @case(\App\Models\CourseAssignmentQuestions::$text)
                                @include('front.user.courses.curriculum.assignments.question_types.text')
                                @break

                            @case(\App\Models\CourseAssignmentQuestions::$file)
                                @include('front.user.courses.curriculum.assignments.question_types.file')
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
<script src="{{ asset('assets/front/js/dropzone.min.js') }}"></script>
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

    $(document).ready(function() {
        timePage();
    });

    function timePage() {
        var totalTimeInSeconds = parseInt("{{ @$assignment->time * 60}}");
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
