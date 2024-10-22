
<div class="col-lg-4">
    <div class="course-content border-light-primary rounded-10 bg-white">
      <div class="course-content-body p-4">
        <div class="course-widget">
          <div class="course-widget-head d-flex align-items-center">
            <div class="icon me-2"><i class="fa-solid fa-microphone"></i></div>
            <h4 class="font-medium">الشابتر الأول : أنواع المحتوى</h4>
          </div>
          <ul class="course-widget-list">
              <li class="mb-2"><a href="{{ route('user.courses.chapter.type', ['type'=>'text']) }}">محتوى نصي</a>
                <div class="progress progress-custom">
                  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.chapter.type', ['type'=>'video']) }}"> محتوى فيديو</a>
                <div class="progress progress-custom">
                  <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.chapter.type', ['type'=>'voice']) }}">محتوى صوت </a>
                <div class="progress progress-custom">
                  <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </li>
            </ul>
        </div>
        <div class="course-widget">
          <div class="course-widget-head d-flex align-items-center">
            <div class="icon me-2"><i class="fa-solid fa-microphone"></i></div>
            <h4 class="font-medium">الشابتر الثاني : أنواع الامتحانات</h4>
          </div>
          <ul class="course-widget-list">
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'description']) }}">تفاصيل الاختبار</a>
                <div class="progress progress-custom">
                  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'tasks']) }}">واجبات</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'task_solutions']) }}">واجبات حلول</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'true_false']) }}">صح وخطأ</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'true_false_solutions']) }}">صح وخطأ حلول</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'fill']) }}">أكمل الفراغ</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'fill_solutions']) }}">أكمل الفراغ حلول</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
              <li class="mb-2"><a href="{{ route('user.courses.quizzes.type', ['type' => 'complete']) }}">نتيجة الاختبار</a>
                  <div class="progress progress-custom">
                      <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </li>
          </ul>
        </div>
      </div>
    </div>
    <button class="btn bg-transparent border-0 px-0 d-inline-flex align-items-center">مشاهدة المزيد
      <div class="icon-chevron-down ms-2"><i class="fa-solid fa-chevron-down"></i></div>
    </button>
  </div>
