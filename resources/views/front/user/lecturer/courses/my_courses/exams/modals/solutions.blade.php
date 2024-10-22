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

            @foreach($course_item->quizQuestions as $key => $question)

                @switch($question->type)
                    @case(\App\Models\CourseQuizzesQuestion::$descriptive)
                        @include('front.user.courses.curriculum.quizzes.solution_types.fill')
                        @break

                    @case(\App\Models\CourseQuizzesQuestion::$multiple)
                        @include('front.user.courses.curriculum.quizzes.solution_types.multiple')
                        @break

                    @case(\App\Models\CourseQuizzesQuestion::$true_false)
                        @include('front.user.courses.curriculum.quizzes.solution_types.true_false')
                        @break

                    @default

                @endswitch
            @endforeach

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
