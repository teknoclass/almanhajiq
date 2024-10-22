@extends('front.layouts.index', ['sub_title' => 'مواعيدي القادمة'])

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/fullcalendar.min.css') }}" />
@endpush

@section('content')
@php
    $is_active = 'my_private_lessons';

    $breadcrumb_links = [
        [
            'title' => __('home'),
            'link' => route('user.home.index'),
        ],
    ];

    if (@$type == 'upcoming') {
        $breadcrumb_links[] = [
            'title' => __('my_private_lessons'),
            'link' => '#',
        ];
    } else if (@$type == 'finished') {
        $breadcrumb_links[] = [
            'title' => __('my_private_lessons'),
            'link' => route('user.private_lessons.index'),
        ];
        $breadcrumb_links[] = [
            'title' => __('my_finished_appointments'),
            'link' => '#',
        ];
    }
@endphp
<section class="section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        @include('front.user.components.breadcrumb')

        <div class="row mb-3">

            <div class="col-12 bg-white p-4 rounded-4">
                <div class="row mb-4 justify-content-between align-items-center">
                    <div class="col-8">
                        <div class="d-lg-flex align-items-center justify-content-between">
                            @if (@$type == 'upcoming')
                                <h2 class="font-medium">{{ __('my_upcoming_appointments') }}</h2>
                            @elseif (@$type == 'finished')
                                <h2 class="font-medium">{{ __('my_finished_appointments') }}</h2>
                            @endif
                        </div>
                    </div>
                    <div class="col-4 mb-2 d-flex justify-content-end">
                        @if (@$type == 'upcoming')
                            <a class="btn btn-primary"
                                href="{{ route('user.private_lessons.index', ['type' => 'finished']) }}">{{ __('my_finished_appointments') }}</a>
                        @elseif (@$type == 'finished')
                            <a class="btn btn-primary"
                                href="{{ route('user.private_lessons.index') }}">{{ __('my_upcoming_appointments') }}</a>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="all-data">
                            @include('front.user.private_lessons.partials.all')
                        </div>
                    </div>
                </div>

                <!--  Meeting Rate Modal   -->

            </div>
        </div>
    </div>

</section>

@if (!empty($meeting))
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
@push('front_js')
    <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
    <script>
        $(document).on('click', '.rate_btn', function (e) {
            e.preventDefault();
            $('#rate_modal').modal('show');
            var lesson_id = $(this).data('lesson');
            var lesson_title = $(this).data('title');
            $('#sourse_id').val(lesson_id);
            $('#meeting_title').text(lesson_title);
        });
    </script>
@endpush
@endsection
