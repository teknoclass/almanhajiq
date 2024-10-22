@extends('front.layouts.index', ['is_active' => 'my_private_lessons', 'sub_title' => 'مواعيدي القادمة'])

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


      <div class="col-12 bg-white p-4 rounded-4">
        <div class="d-block font-14 text-gray mt-1 mb-3 d-inline-flex">
            @if (isset($lecturer_materials) && count(@$lecturer_materials) > 0)
            <span class="privateLessonSpan">الرجاء اختيار المادة</span>
                <select name="program" class="form-select mx-2" style="width: 150px;" id="program">
                    @foreach ($lecturer_materials as $material)
                        <option value="{{ @$material->id }}">{{ @$material->category->name}}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 table-custom mb-1">
                <thead>
                    <tr class="border-0">
                        <th>المادة</th>
                        <th>المدرب</th>
                        <th>التاريخ</th>
                        <th>ساعة البدء</th>
                        <th>ساعة الانتهاء</th>

                        @if (@$settings->valueOf('offline_private_lessons'))
                        <th>نوع اللقاء</th>
                        @endif
                        
                        <th>المبلغ المدفوع</th>
                        <th>الحالة</th>
                        <th class="text-center">انضمام للدرس</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($privateLessons as $privateLesson)
                    <tr>
                        <td>{{@$privateLesson->category->name}}</td>
                        <td>{{@$privateLesson->teacher->name}}</td>
                        <td><span><i class="far fa-calendar"></i> </span> <span>{{@$privateLesson->meeting_date}}</span></td>
                        <td>{{@$privateLesson->time_form}}</td>
                        <td>{{@$privateLesson->time_to}}</td>

                        @if (@$settings->valueOf('offline_private_lessons'))
                            <td>{{ __(@$privateLesson->meeting_type) }}</td>
                        @endif

                        <td>{{@$privateLesson->price}}</td>

                        @if(@$privateLesson->status=="acceptable" && isset($privateLesson->student_id))
                            @php
                            $privateLesson_status=__('acceptable');
                            @endphp
                        @endif
                        @if(@$privateLesson->status=="unacceptable")
                            @php
                            $privateLesson_status=__('canceled');
                            @endphp
                        @endif
                        <td>{{@$privateLesson_status}}</td>

                        <td>

                            @if(@$privateLesson->meeting_link == '')
                            <strong>---</strong>
                            @endif

                            @if(@$privateLesson->meeting_link != '' )
                            @if (\Bigbluebutton::isMeetingRunning('meeting_id_'.@$privateLesson->id))
                            <a target="_blank" class="btn btn-success py-1 px-2"
                                href="{{route('user.lecturer.private_lessons.meeting.join', ['id'=>$privateLesson->id])}}">
                                {{__('join_to_meet')}}
                            </a>
                            @else
                            <div class="btn btn-danger py-1 px-2">
                                {{ __('finished') }}
                            </a>
                            @endif
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

         <!--  Meeting Rate Modal   -->

      </div>
    </div>
  </div>

</section>

@if(!empty($meeting))
@include('front.user.courses.modals.meeting_rate_modal', ['item' => @$meeting])
@endif

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
@endsection
