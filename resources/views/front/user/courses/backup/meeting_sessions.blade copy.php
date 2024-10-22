@extends('front.layouts.index', ['is_active' => 'meeting_sessions', 'sub_title' => 'مواعيدي القادمة'])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/front/css/fullcalendar.min.css') }}"/>
@endpush

@section('content')
<section class="section wow fadeInUp" data-wow-delay="0.1s">
  <div class="container">
    <div class="row mb-3">
      <div class="col-12">
        <div class="d-lg-flex align-items-center justify-content-between">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}">الرئيسية</a></li>
            <li class="breadcrumb-item active">مواعيدي القادمة</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="bg-white p-4 rounded-4">
          <div class="row">
            <div class="col-12">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-3 mx-auto">
            <div class="text-center">
              <button class="btn btn-primary w-100 px-2">حغظ </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="LessonModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border rounded-15">
      <div class="modal-body p-5">
        <div class="text-center">
          <div class="icon mb-4"><i class="fa-solid fa-circle-exclamation"></i></div>
          <h2 class="font-bold">لا يمكنك تأجيل معاد هذا الدرس</h2>
          <h4 class="mb-4">تعذر تأجيل معاد هذا الدرس لأنه تبقى أقل من 24 ساعة للدرس</h4>
          <button class="btn btn-primary w-100" data-bs-dismiss="modal">حسنــاً</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="AddLessonModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border rounded-15">
      <div class="modal-body p-5">
        <div class="form-group">
          <input class="form-control datetimeclock" type="text" placeholder="حدد الوقت"/>
        </div>
        <div class="form-group">
          <select class="selectpicker" title="مدة الجلسة" data-size="5">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="4">4 </option>
          </select>
        </div>
        <div class="form-group">
          <select class="selectpicker" title="اختر المدرب" data-size="5">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="4">4 </option>
          </select>
        </div>
        <div class="form-group">
          <select class="selectpicker" title="اسم الدرس" data-size="5">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="4">4 </option>
          </select>
        </div>
        <div class="form-group">
          <button class="btn btn-primary w-100" data-bs-dismiss="modal">موافق</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('front_js')

<script src="{{ asset('assets/front/js/fullcalendar.js') }}"> </script>
<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"> </script>
<script>
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: {
      title: '',
    },
    buttonText: {
        today: 'اليوم'
    },
    events: [
      {
        type_id: 1,
        lesson_name: 'اسم الدرس',
        start: '2023-06-25',
        clock: 'وقت الجلسة',
        session_duration: 'مدة الجلسة',
        teacher_name: 'اسم المدرب',
        url: 'https://mail.google.com/mail',
      },
      {
        type_id: 1,
        lesson_name: 'اسم الدرس',
        start: '2023-06-01',
        clock: 'وقت الجلسة',
        session_duration: 'مدة الجلسة',
        teacher_name: 'اسم المدرب',
        url: 'https://mail.google.com/mail',
      },
      {
        type_id: 2,
        lesson_name: 'اسم الدرس',
        start: '2023-06-10',
        clock: 'وقت الجلسة',
        session_duration: 'مدة الجلسة',
        teacher_name: 'اسم المدرب',
      },
    ],
    events2: [
      {
        lesson_name: 'اسم الدرس',
        start: '2023-06-11',
      },
    ],
    timeFormat: 'H(:mm)' ,
    eventContent: function(arg) {
    console.log("🚀 ~ file: meeting-dates.pug:218 ~ arg:", arg)
      if(arg?.event?.extendedProps.type_id === 1){
        return {
          html:`
          <span class="bg-primary rounded-2 p-lg-2 align-items-center d-flex flex-column text-center">
            <span class="d-flex align-items-center w-100 justify-content-between">
              <div class="dropdown">
                <button class="btn btn-drop px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-regular fa-ellipsis-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3">
                  <h5>  الأربعاء 8 مارس 2023 <i class="fa-light fa-calendar"></i></h5>
                  <p>${arg?.event?.extendedProps.clock}</p>
                  <p>${arg?.event?.extendedProps.session_duration}</p>
                  <p>${arg?.event?.extendedProps.teacher_name}</p>
                  <p>${arg?.event?.extendedProps.lesson_name}</p>
                  <a href="" data-bs-toggle="modal" data-bs-target="#LessonModal" class="btn btn-outline-danger w-100 px-2 py-1 mt-2 font-size-12">تأجيــل الدرس</a>
                </div>
              </div>
              <span class="font-medium text-white">${arg?.event?.extendedProps.lesson_name}</span>
            </span>
            <span class="font-medium text-white">${arg?.event?.extendedProps.clock} <i class="fa-regular fa-clock me-1"></i></span>
          </span>`
        }
      }else{
        return {
          html:`
          <div class="dropdown text-center">
            <button data-bs-toggle="modal" data-bs-target="#AddLessonModal" class="btn btn-add px-1 py-0 bg-primary rounded-2 p-lg-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-regular fa-plus"></i>
            </button>
          </div>`
        }
      }

    },

    eventClick: function(info) {
      info.jsEvent.preventDefault();
      if (info.event.url) {
        //- window.open(info.event.url);
      }
    },
  });
  calendar.render();
  $('.fc-event-main').closest('.fc-day').addClass('fc-event-day')

</script>
<script>
  $('.datetimeclock').datetimepicker({
    pickDate: false,
    minuteStep: 5,
    pickerPosition: 'bottom-right',
    format: 'HH:ii',
    autoclose: true,
    showMeridian: true,
    todayHighlight: true,
    startView: 1,
    maxView: 1,
  });

  $('.dropdown-menu').click(function(e){
    e.stopPropagation()
  })
</script>
@endpush
