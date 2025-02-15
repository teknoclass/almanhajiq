@extends('front.user.lecturer.layout.index' )

@section('content')

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}"/>
@endpush
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('courses'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('my_courses'),
		        'link' => route('user.lecturer.my_courses.index'),
		    ],
		    [
		        'title' => @$assignmentt->course->title,
		        'link' => '#',
		    ],
		];
	@endphp
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
			<!--begin::breadcrumb-->
			@include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
			<!--end::breadcrumb-->

			<!--begin::Content-->
			<div class="row g-5 gx-xxl-8 mb-4">
				<div class="bg-white p-4 rounded-4">
					<div class="row">
						<div class="col-12">

                            @if(@$assignments)
							<table class="table table-cart mb-3">
								<thead>
									<tr>
										<td>{{ __('student_name') }}</td>
										<td>{{ __("result") }}</td>
                                        <td>{{ __("review") }}</td>
                                        <td>{{ __("submission_date") }}</td>
									</tr>
								</thead>
								<tbody>
                                    @foreach(@$assignments as $assignment)
                                        @include('front.user.lecturer.courses.my_courses.tasks.partials.student_tasks')
                                    @endforeach

								</tbody>
							</table>

                            <nav>
                                {{@$assignments->links('vendor.pagination.custom')}}
                            </nav>
                            @else

                                    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_courses')])

                            @endif

						</div>
					</div>
				</div>
			</div>
            <!--end::Content-->
		</div>
    </section>

    <div id="targetCorrectDiv">

    </div>


@push('front_js')
<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script>
  /*------------------------------------
    PerfectScrollbar
  --------------------------------------*/
  $('.scroll').each(function () {
    const ps = new PerfectScrollbar($(this)[0]);
  });
</script>

<script>
    $(document).ready(function() {
     $(document).on('click', '.correct_modal', function (e) {

            var student_id = $(this).data('student_id');
            var item_id    = $(this).data('item_id');
            var course_id  = $(this).data('course_id');
            $.ajax({
                url: "{{ route('user.lecturer.course.curriculum.get_correct_modal') }}", // Use the new endpoint
                method: "GET",
                data: {
                    student_id : student_id,
                    item_id    : item_id,
                    course_id : course_id
                },
                success: function(response) {
                    $("#targetCorrectDiv").html(response.content);
                    showMyModal();

                },
                error: function() {
                    console.error("Failed to fetch lesson modal.");
                }
            });
        });

        function showMyModal() {
            $("#Correct_Modal").show();
        }
    });
</script>
@endpush

@endsection
