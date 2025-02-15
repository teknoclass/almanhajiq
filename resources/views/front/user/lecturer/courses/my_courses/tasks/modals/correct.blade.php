<div class="modal show" id="Correct_Modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body p-0">
          <div class="text-end">
            <button class="btn-close me-3 mt-3 mb-0" onclick="closeModal()" ></button>
          </div>
          <h2 class="modal-title text-center font-bold mb-3"> {{ @$course_item->title}} </h2>
          <div class="scroll max-height-400 px-4 px-lg-5 py-4">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="d-flex symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></div>
                <h5 class="ms-2"> {{ @$student->name }} </h5>
              </div>

            </div>
            <hr/>

             @if ($course_item->assignmentResults[0]->status == 'not_submitted' || $course_item->assignmentResults[0]->status == 'pending')
            <form id="task_correct_form" action="{{route('user.lecturer.my_courses.tasks.submitResults')}}" to="{{ route('user.lecturer.my_courses.tasks.students' , $item_id) }}" method="POST" enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="student_id" id="student_id" value="{{@$student_id}}">
                <input type="hidden" name="course_id"  id="course_id"  value="{{@$course_id}}">
                <input type="hidden" name="item_id"    id="item_id"    value="{{@$item_id}}">
                <input type="hidden" name="result_id"    id="result_id"    value="{{@$course_item->assignmentResults[0]->id}}">


               @foreach($course_item->assignmentQuestions as $key => $question)

                @switch($question->type)
                    @case(\App\Models\CourseAssignmentQuestions::$text)
                        @include('front.user.lecturer.courses.my_courses.tasks.modals.text')
                        @break

                    @case(\App\Models\CourseAssignmentQuestions::$file)
                        @include('front.user.lecturer.courses.my_courses.tasks.modals.file')
                        @break

                    @default

                @endswitch
             @endforeach

             <div class="form-group text-center mt-3">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="col-lg-3 me-3">
                        <button id="btn_submit remove" type="submit" class="btn btn-primary px-1 w-100 btn-add-qestion-task" onclick="setTimeout(() => location.reload(), 1000)">{{ __('save') }}</button>
                    </div>
                </div>
            </div>
            </form>

            @else
                @foreach($course_item->assignmentQuestions as $key => $question)

                    @switch($question->type)
                        @case(\App\Models\CourseAssignmentQuestions::$text)
                            @include('front.user.lecturer.courses.my_courses.tasks.modals.text')
                            @break

                        @case(\App\Models\CourseAssignmentQuestions::$file)
                            @include('front.user.lecturer.courses.my_courses.tasks.modals.file')
                            @break

                        @default

                    @endswitch
                @endforeach
            @endif

          </div>
        </div>
      </div>
    </div>
</div>


<script src="{{ asset('assets/front/js/post.js') }}"></script>
<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script>
  /*------------------------------------
    PerfectScrollbar
  --------------------------------------*/
  $('.scroll').each(function () {
    const ps = new PerfectScrollbar($(this)[0]);
  });

  function closeModal() {
        $("#Correct_Modal").hide();
 }
</script>
