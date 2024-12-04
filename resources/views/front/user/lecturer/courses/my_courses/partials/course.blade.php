<tr id="course_row_{{ @$course->id }}">
    <td><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">{{@$course->title}}</span></span></td>
	<td>{{ __('course_types.' . @$course->type) }}</td>
	<td>{{ @$course->category->name }}</td>
	<td>{{ @$course->students_count }} </td>
	@php
		switch (@$course->status) {
		    case 'accepted':
		        $color = 'text-success';
		        break;

		    case 'unaccepted':
		        $color = 'text-danger';
		        break;

		    default:
		        $color = 'text-primary';
		        break;
		}
	@endphp
	<td class="{{ @$color }}">
        {{ __(@$course->status) }}
        @if (@$course->status == 'unaccepted')
            <button type="button" class="bg-transparent reasonUnaccetapbleModalBtn"
                    data-reason="{{ @$course->evaluation[0]->reason_unacceptable }}">
                <i class="text-danger fas fa-info-circle ms-1 me-3"></i>
            </button>
        @endif
    </td>
	<td><strong>{!! @$course->getPriceDisc() !!}</strong></td>
	{{--<td><strong>{{ @$course->getTotalSales() }}</strong></td>--}}{{-- lecturer total sales --}}
	{{-- <td data-title="مراجعة"><span class="d-inline-block px-4 rounded-3 bg-success text-white font-medium py-2 min-width-110 text-center">تم التصحيح</span></td> --}}
	<td><span><i class="fa-regular fa-clock me-2"></i> {{ date('m/d/Y', strtotime(@$course->created_at)) }} </span></td>
	<td>
		<span class="d-flex align-items-center w-100 justify-content-between">
			<div class="dropdown" id="dropdown">
				<button class="btn btn-drop px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa-regular fa-ellipsis-vertical"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end p-3">
					<p><a href="{{ route('user.lecturer.course.curriculum.preview.index', $course->id) }}" target="__blank">{{ __('course_preview') }}</a></p>
                    @if($course->type == 'live')<p><a href="{{ route('user.lecturer.my_courses.edit.courseSchedule.preview', $course->id) }}" target="__blank">{{ __('live_lessons') }}</a></p>@endif
					<p><a href="{{ route('user.lecturer.my_courses.edit.baseInformation.index', $course->id) }}">{{ __('edit_course') }}</a></p>
                    <p><a href="{{ route('user.lecturer.course.curriculum.preview_curriculum.item', ['course_id' => @$course->id]) }}" target="__blank">{{ __("view_curriculum") }}</a></p>
                    <p><a href="{{ route('user.lecturer.my_courses.create_curriculum', $course->id) }}">{{ __("edit_curriculum") }}</a></p>
                    @if (@$course->status == 'accepted')
                        <p><a href="{{ route('user.lecturer.my_courses.tasks.all', $course->id) }}">{{ __("students_tasks") }}</a></p>
                        <p><a href="{{ route('user.lecturer.my_courses.exams.all', $course->id) }}">{{ __("course_exams") }}</a></p>
                        <p><a href="{{ route('user.lecturer.my_courses.viewRatings.index', $course->id) }}">{{ __("ratings") }}</a></p>
                        <p><a href="{{ route('user.lecturer.my_courses.comments', $course->id) }}">{{ __("comments") }}</a></p>
                    @endif
                    @if (@$course->status == 'unaccepted')
                        <p><a href="{{ route('user.lecturer.my_courses.unaccepted_evaluation', $course->id) }}">{{ __("evaluation_result") }}</a></p>
                    @endif

				
				</div>
			</div>
		</span>
	</td>
</tr>
