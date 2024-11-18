@if(@$user_course->course)
<tr>
    <td data-title="{{__('course_name')}}">{{ @$user_course->course->title }}</td>
    {{-- <td data-title="المستوى">مبتدأ</td> --}}
    @if (@$user_course->is_end && !@$user_course->is_rating)
    <td data-title="{{__('rate')}}">
        <button type="button" class="btn btn-primary px-3 py-2" data-bs-toggle="modal"
            data-bs-target="#RateCourseModal"
            data-course-id="{{ @$user_course->course->id }}"
            data-course-title="{{ @$user_course->course->title }}">
            {{ __('rate_the_course') }}
        </button>
    </td>
    @else
    <td data-title="{{__('rate')}}"><span><i class="fa-solid fa-star star-fill"></i> {{ @$user_course->course->getRating() }}/5</span></td>
    @endif
    <td data-title="{{__('course_type')}}">{{ __('course_types.'.@$user_course->course->type) }} </td>
    <td data-title="{{__('reg_date')}}"><i class="fa-regular fa-clock me-2"></i>{{ changeDateFormate(@$user_course->created_at) }}</td>
    <td data-title="{{__('certificate')}}">
        @if(@$user_course->course->certificate_template_id!=null || in_array($user_course->course->category_id, $certTempsCats))
        <a href="{{route('user.courses.certificateIssuance',['id'=>$user_course->id])}}" class="btn btn-primary px-3 py-2"><i class="fa-regular fa-download me-2"></i>إصدار الشهادة</a>
        @else
      -
        @endif
    </td>
</tr>
@endif
