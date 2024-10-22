
<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">

    <form id="course_from" action="{{route('user.lecturer.course.price.set_price')}}"  to = "{{ route('user.lecturer.course.create', 'faqs') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" id="course_id" value="{{@$course->id}}">
        <input type="hidden" name="id" id="id">
        <div class="row">
            <div class="form-group d-flex align-items-center justify-content-between col-12">
            <label class="m-checkbox mb-0">
                <input type="checkbox" name="free" value="1"/><span class="checkmark"></span><span>حدد إذا كنت تريد هذه الدورة مجانية</span>
            </label>
            </div>
            <div class="form-group col-12">
                <label class="mb-2">سعر الدورة ($)</label>
                <input type="number" class="form-control form-control-lg form-control-solid px-15 rounded-pill" name="price" value="" placeholder="سعر الدورة ($)">
            </div>
            <div class="form-group d-flex align-items-center justify-content-between col-12">
            <label class="m-checkbox mb-0">
                <input type="checkbox" name="discount" value="1"/><span class="checkmark"></span><span>تحقق مما إذا كنت تريد هذه الدورة بها خصم</span>
            </label>
            </div>
            <div class="form-group col-12">
                <label class="mb-2">سعر مخفض ($)</label>
                <input type="number" class="form-control form-control-lg form-control-solid px-15 rounded-pill" name="discount_price" value="" placeholder="سعر مخفض ($)">
                <label class="mb-2 text-muted">هذه الدورة تحتوي <span class="text-danger">0%</span> خصم</label>
            </div>
        </div>

             @include('front.user.lecturer.courses.new_course.components.save_button')
        </form>
</div>
