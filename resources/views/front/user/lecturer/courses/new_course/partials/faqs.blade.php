
<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <form id="course_from" action="{{route('user.lecturer.course.faqs.set_faq')}}"  to = "{{ route('user.lecturer.course.create', 'finish') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" id="course_id" value="{{@$course->id}}">
        <input type="hidden" name="id" id="id">
        <div class="row">
            <div class="list-add-faq">
                <div class="rounded-3 mb-3 bg-light-green p-3 widget_item-add-faq d-flex position-relative">
                    <button class="widget_item-remove" type="button"><i class="fa-solid fa-trash"></i></button>
                    <h5 class="font-medium mt-2">1.</h5>
                    <div class="ms-1 col">
                        <div class="form-group">
                            <input class="form-control" type="text" name="questions[]" placeholder="اكتب السؤال"/>
                        </div>
                        <div class="form-group mb-0">
                            <textarea class="form-control" rows="5" name="answer_1" placeholder="الاجابة"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button class="p-1 bg-transparent font-medium btn-add-faq" type="button"><i class="fa-regular fa-plus ms-2"></i> إضافة سؤال جديد</button>
            </div>
        </div>

         @include('front.user.lecturer.courses.new_course.components.save_button')
    </form>
</div>

@push('front_js')

<script>
    var counter = 2
    $('.btn-add-faq').click(function(){
      $('.list-add-faq').append(`
        <div class="rounded-3 mb-3 bg-light-green p-3 widget_item-add-faq d-flex position-relative">
          <button type="button" class="widget_item-remove"><i class="fa-solid fa-trash"></i></button>
          <h5 class="font-medium mt-2">${counter}.</h5>
          <div class="ms-1 col">
            <div class="form-group">
              <input type="text" class="form-control" name="questions[]"  placeholder="اكتب السؤال">
            </div>
            <div class="form-group mb-0">
              <textarea class="form-control" rows="5" name="answer_${counter}" placeholder="الاجابة"></textarea>
            </div>
          </div>
        </div>
      `)
      counter++
    });
    $(document).on('click','.widget_item-remove',function(){
      $(this).closest('.widget_item-add-faq').remove()
    });
  </script>
@endpush
