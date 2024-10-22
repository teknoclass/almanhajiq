@extends('front.layouts.index', ['is_active' => 'completed_courses', 'completed_courses' => 'الدورات المكتملة'])

@section('content')
	@php
        $is_active = "my_courses";

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => route('user.home.index'),
		    ],
		    [
		        'title' => __('completed_courses'),
		        'link' => '#',
		    ],
		];
	@endphp
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			@include('front.user.components.breadcrumb')
			<div class="row">
				<div class="col-12">
                    <div class="all-data">
                        @include('front.user.courses.completed_courses.partials.all')
                    </div>
				</div>
			</div>
		</div>
	</section>

    @include('front.user.courses.components.course_rate_modal')

    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
        <script>
            $(document).on('show.bs.modal', '#RateCourseModal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var courseId = button.data('course-id'); // Extract info from data-* attributes
                var modal = $(this);

                // Set the course ID in the modal form
                modal.find('#sourse_id').val(courseId);

                // You can also update other modal content based on the course if needed
                modal.find('.modals-title').text('{{ __('add_a_rateing_to') }} ' + button.data('course-title'));
            });
        </script>
    @endpush
@endsection
