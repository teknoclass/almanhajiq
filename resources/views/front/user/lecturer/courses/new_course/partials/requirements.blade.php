
<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row" id="requirementsGroup">
        <div class="form-group col-12">
            <input type="text" class="form-control form-control-lg form-control-solid px-15 rounded-pill" name="search" value="" placeholder="مهارات ومواهب">
        </div>
    </div>
    <div class="row">
        <div class="m-3">
            <button class="p-1 bg-transparent font-medium btn-add-requirement" type="button"><i class="fa-regular fa-plus ms-2"></i> إضافة مهارة جديدة</button>
          </div>
    </div>
    @include('front.user.lecturer.courses.new_course.components.save_button')
</div>

@push('front_js')
<script>

    $('.btn-add-requirement').click(function(){
       $('#requirementsGroup').append(`
        <div class="form-group col-12">
            <input type="text" class="form-control form-control-lg form-control-solid px-15 rounded-pill" name="search" value="" placeholder="مهارات ومواهب">
        </div>
       `)
      })
</script>
@endpush
