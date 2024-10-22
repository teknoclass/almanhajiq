
<div class="col-lg-2">
    <select class="selectpicker bg-primary rounded-pill" data-style="select-primary rounded-pill" title="تفاصيل الدورة" id="courseDropDown">
        <option value="{{ route('courses.live') }}">تفاصيل الدورة</option>
        <option value="{{ route('user.courses.chapter.type', ['type'=>'text']) }}">منهج الدورة</option>
        <option value="{{ route('user.courses.myAcitivity') }}">نشاطي في الدورة</option>
        <option value="ModalRating">تقييم الدورة</option>
        <option value="{{ route('user.certificate.index') }}">اصدار شهادة</option>
    </select>
</div>


@push('front_js')
<script>
    const selectElement = document.getElementById('courseDropDown');

    selectElement.addEventListener('change', function() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedValue = selectedOption.value;

        if (selectedValue === 'ModalRating') {
            // Trigger the modal to open
            const modal = new bootstrap.Modal(document.getElementById('ModalRating'));
            modal.show();
        } else if (selectedValue) {
            window.location.href = selectedValue;
        }
    });
</script>
@endpush
