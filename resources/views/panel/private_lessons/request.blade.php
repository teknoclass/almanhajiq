@extends('front.layouts.index', ['sub_title' => 'طلبات المواعيد'])

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
            <div class="table-responsive">
                <table class="table mobile-table table-row-dashed table-row-gray-200 align-middle gy-2 table-custom mb-1">
                    <thead>
                    <tr class="border-0">
                        <th>{{ __('name') }}</th>
                        <th>{{ __('student') }}</th>
                        <th>{{ __('type') }}</th>
                        <th>{{ __('files') }}</th>
                        <th>{{ __('status') }}</th>

                            <th>{{ __('actions') }}</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($requests as $request)
                        @include('front.user.private_lessons.partials.request')
                    @endforeach
                    </tbody>
                </table>



            </div>

        </div>
    </div>

</section>

@if (!empty($meeting))
    @include('front.user.courses.modals.meeting_rate_modal', ['item' => @$meeting])
@endif
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
