@extends('front.layouts.index', ['is_active' => 'test_courses', 'sub_title' => 'الدورات التجريبية'])

@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/plyr.css') }}" />
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
                'title' => __('courses'),
                'link' => route('user.courses.myCourses'),
            ],
            [
                'title' => @$course->title,
                'link' => '#',
            ],
        ];
    @endphp

	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            <div class="row mb-4">
                <div class="col-lg-10">
                    <ol class="breadcrumb mb-lg-0">
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
                @if (checkUser('lecturer'))
                <div class="col-lg-2">
                    <a href="{{ route('user.lecturer.my_courses.create_curriculum' , @$course->id) }}" class="btn btn-primary px-3 py-2">
                        عودة الى التعديل
                    </a>
                </div>
                @elseif (auth('admin')->user())
                <div class="col-lg-2">
                    <a href="{{ route('panel.courses.edit.curriculum.index' , @$course->id) }}" class="btn btn-primary px-3 py-2">
                        عودة الى لوحة التحكم
                    </a>
                </div>
                @endif
            </div>


			<div class="row mb-2">

				<div class="col-lg-8">

                    @switch(@$item_type)
                        @case('lesson')

                            @include('front.user.lecturer.courses.preview_curriculum.lessons.lesson_title_and_nav_btns')

                            @include('front.user.courses.curriculum.lessons.content')

                            @include('front.user.courses.curriculum.lessons.description')

                            @include('front.user.courses.curriculum.lessons.attachments')

                            @include('front.user.lecturer.courses.preview_curriculum.lessons.comments')
                            @break

                        @case('quiz')
                            @include('front.user.lecturer.courses.preview_curriculum.quizzes.content')
                            @break

                        @case('assignment')
                            @include('front.user.lecturer.courses.preview_curriculum.assignments.content')
                            @break

                        @case('live_lesson')
                            @include('front.user.courses.curriculum.lessons.partials.lesson_title_and_nav_btns')

                            @include('front.user.courses.curriculum.live_lessons.content')

                            @include('front.user.courses.curriculum.lessons.description')

                            @include('front.user.courses.curriculum.lessons.attachments')

                            @include('front.user.lecturer.courses.preview_curriculum.lessons.comments')
                            @break

                    @endswitch
				</div>

				@include('front.user.lecturer.courses.preview_curriculum.components.content_navigation_widget')

			</div>
		</div>
	</section>
@endsection


@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
	<script src="{{ asset('assets/front/js/plyr.polyfilled.js') }}"></script>

	<script>
		/*------------------------------------
	        player
	        --------------------------------------*/
		if ($(".player").length) {
			new Plyr(".player");
		}
	</script>
@endpush
