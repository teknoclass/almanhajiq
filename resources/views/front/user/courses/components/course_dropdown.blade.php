
<div class="col-lg-3">
    <select class="selectpicker bg-primary rounded-pill" data-style="select-primary rounded-pill" title="تفاصيل الدورة" id="courseDropDown">
        <option {{ (@$active_option == '') ? 'selected' : '' }} value="{{ route('courses.single', ['id'=>@$course->id,'title'=>mergeString(@$course->title, '')]) }}">{{ __("course_details") }}</option>
        <option {{ (@$active_option == 'curriculum') ? 'selected' : '' }} value="{{ route('user.courses.curriculum.item', ['course_id'=>@$course->id??0]) }}">{{ __("course_curriculum") }}</option>
        <option {{ (@$active_option == 'my_activity') ? 'selected' : '' }} value="{{ route('user.courses.myAcitivity', ['id' => @$course->id]) }}">{{ __("my_activity_in_course") }}</option>
        @if (@$course->is_end && !@$course->is_rating)
        <option value="RateCourseModal">{{ __("rate_course") }}</option>
        @endif
        {{-- <option value="{{ route('user.certificate.index') }}">اصدار شهادة</option> --}}
    </select>
</div>


@push('front_js')
<script>
    const selectElement = document.getElementById('courseDropDown');

    selectElement.addEventListener('change', function() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedValue = selectedOption.value;

        if (selectedValue === 'RateCourseModal') {
            // Trigger the modal to open
            const modal = new bootstrap.Modal(document.getElementById('RateCourseModal'));
            modal.show();
        } else if (selectedValue) {
            window.location.href = selectedValue;
        }
    });
</script>
@endpush
