<tr>
    <td data-title="{{ __('student_name') }}"><span class="d-flex align-items-center"><span class="symbol symbol-40"><img
                    class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">
                {{@$exam->user->name}}</span></span></td>
    <td data-title="{{ __("result") }}">( {{@$examm->pass_mark}} / {{@$exam->user_grade}} )</td>
    @if(@$exam->status == "passed" || @$exam->status == "failed" )
    <td data-title="{{ __("review") }}"><span class="d-inline-block px-4 rounded-3 bg-success text-white font-medium py-2 min-width-110 text-center correct_modal" style="cursor:pointer;" data-item_id="{{@$exam->quiz_id }}" data-student_id="{{@$exam->user->id}}" data-course_id="{{@$exam->course_id}}"> مراجعه  </span></td>
    @else
    <td data-title="{{ __("review") }}">
        <span class="d-inline-block px-4 rounded-3 bg-light-blue font-medium py-2 min-width-110 text-center" style="cursor:pointer;" >  قيد الانتظار </span>
    </td>
    @endif
    <td data-title="{{ __("submission_date") }}"><span><i class="fa-regular fa-clock me-2"></i>{{@$exam->started_at}}</span></td>
</tr>
