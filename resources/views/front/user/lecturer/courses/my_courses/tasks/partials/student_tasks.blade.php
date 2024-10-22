<tr>
    <td data-title = "{{ __('student_name') }} ">
        <span class      = "d-flex align-items-center">
            <span class      = "symbol symbol-40">
                <img class = "rounded-circle" src = "{{ imageUrl(@$assignment->student->image) ?? asset('assets/front/images/avatar.png') }}" alt = ""
                    loading = "lazy" /></span><span class = "ms-2">
                {{ @$assignment->student->name }}
            </span>
        </span>
    </td>
    <td data-title = "{{ __('result') }}">({{ @$assignment->grade }})</td>
    @if (@$assignment->status == 'pending')
        <td data-title = "{{ __('review') }}"><span
                class = "d-inline-block px-4 rounded-3 bg-success text-white font-medium py-2 min-width-110 text-center correct_modal"
                style = "cursor:pointer;" data-item_id = "{{ @$assignment->assignment_id }}"
                data-student_id = "{{ @$assignment->student->id }}" data-course_id = "{{ @$assignment->course_id }}">
                تصحيح
            </span>
        </td>
    @else
        <td data-title = "{{ __('review') }}">
            <span
                class      = "d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center correct_modal"
                style = "cursor:pointer;" data-item_id = "{{ @$assignment->assignment_id }}"
                data-student_id = "{{ @$assignment->student->id }}"
                data-course_id = "{{ @$assignment->course_id }}">تم التصحيح
            </span>
        </td>
    @endif
    <td data-title = "{{ __('submission_date') }} ">
        <span>
            <i class = "fa-regular fa-clock me-2"></i>{{ $assignment->started_at }}
        </span>
    </td>
</tr>
