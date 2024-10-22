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

<div class="modal fade" id="respondRequestModal" tabindex="-1" role="dialog"  aria-hidden="true" aria-labelledby="respondRequestButton" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('Change Status')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cancelForm" data-url="{{route('user.private_lessons.respond')}}">
                    <input class="form-control" type="text" hidden name="request_id" id="request_id" value="" >
                    <select class="form-control" id="statusSelect" name="status" required>
                        <option value="accepted">{{__('Accept')}}</option>
                        <option value="rejected" >{{__('Reject')}}</option>
                        <option selected disabled value="pending">{{__('pending')}}</option>
                    </select>

                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group" id="date-group" >

                        </div>

                    <button type="submit" class="btn btn-success" >{{__('change')}}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('close')}}</button>
            </div>
        </div>
    </div>
</div>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#respondRequestButton').forEach(function (button) {
            button.addEventListener('click', function() {
                // Get the current status from the backend (data-status)
                // Set the selected option based on the current status
                document.getElementById('statusSelect').value = this.getAttribute('data-status');
            });
        });
        function toggleDateGroup(status) {
            const dateGroup = $('#date-group');

            if (status === 'accepted') {
                dateGroup.show();

                // Make radio buttons required when status is 'accepted'
                document.querySelectorAll('input[name="date"]').forEach(function(radio) {
                    radio.setAttribute('required', 'required');
                });
            } else {
                dateGroup.hide();

                // Remove the 'required' attribute when the status is not 'accepted'
                document.querySelectorAll('input[name="date"]').forEach(function(radio) {
                    radio.removeAttribute('required');
                });
            }
        }

        // On modal open, handle setting initial values and status from backend
        document.querySelectorAll('#respondRequestButton').forEach(function (button) {
            button.addEventListener('click', function() {
                // Extract data from the clicked button
                const requestId = this.getAttribute('data-id');
                const requestType = this.getAttribute('data-type');
                const requestStatus = this.getAttribute('data-status');
                const suggestedDates = JSON.parse(this.getAttribute('data-suggested-dates'));

                // Set the values in the modal
                document.getElementById('request_id').value = requestId;


                // Populate date options if the request type is 'postpone'
                if (requestType === 'postpone') {
                    let dateGroup = document.getElementById('date-group');
                    dateGroup.innerHTML = ''; // Clear previous content
                    suggestedDates.forEach((date, index) => {
                        dateGroup.innerHTML += `
                        <input type="radio" class="btn-check" id="date${index}" value="${date}" name="date" autocomplete="off">
                        <label class="btn btn-outline-primary" for="date${index}">${date}</label>
                    `;
                    });

                    // Toggle date group visibility based on the initial backend status
                    toggleDateGroup(requestStatus);
                } else {
                    $('#date-group').hide();  // Hide the date group if it's not a 'postpone' request
                }
            });
        });

        // Handle changing the status to toggle date group visibility
        $('#statusSelect').on('change', function() {
            const selectedStatus = this.value;
            toggleDateGroup(selectedStatus);
        });
        document.getElementById('cancelForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var route = $('#cancelForm').data('url')
            console.log(route);
            var lessonId = document.querySelector('input[name="request_id"]').value;
            var status = document.querySelector('select[name="status"]').value;
            var dateInputElement = document.querySelector('input[name="date"]');

            if (dateInputElement) {
                var date = dateInputElement.value;
                formData.append('chosen_date', date);
            }

            formData.append('request_id', lessonId);
            formData.append('status', status);
            fetch(route, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json', // This should be set, but no need for Content-Type
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        $("#cancelForm").append("<div class='alert alert-primary' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                        location.reload();
                    } else {
                        $("#cancelForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });


</script>
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
