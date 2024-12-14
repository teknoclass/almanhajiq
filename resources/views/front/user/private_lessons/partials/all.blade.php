<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($privateLessons) && count(@$privateLessons)>0)

    <div class="table-responsive">
        <table class="table mobile-table table-row-dashed table-row-gray-200 align-middle gy-2 table-custom mb-1">
            <thead>
                <tr class="border-0">
                    <th>{{ __('name') }}</th>
                    <th>{{ __('material_name') }}</th>
                    <th>{{ __('lecturer') }}</th>
                    <th>{{ __('date') }}</th>
                    <th>{{ __('time') }}</th>

                    @if (@$settings->valueOf('offline_private_lessons'))
                    <td>{{ __('type') }}</td>
                    @endif

                    <th>{{ __('price') }}</th>
                    @if (@$type == 'upcoming')
                    <th>{{ __('status') }}</th>
                    @endif
                    @if (@$type == 'upcoming')
                  {{--  <th>{{ __('Actions') }}</th> --}}
                    @endif
                    <th class="text-center">{{ __('join_to_meet') }}</th>
                    @if (@$type == 'finished')
                    <th>{{ __('rate') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($privateLessons as $privateLesson)
                @include('front.user.private_lessons.partials.lesson')
                @endforeach
            </tbody>
        </table>

        <nav>
            {{@$privateLessons->links('vendor.pagination.custom')}}
        </nav>

    </div>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_lessons')])

    @endif
</div>
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('cancel')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="cancelForm" data-url="{{route('user.private_lessons.cancel')}}">
                    <input class="form-control" type="text" hidden name="private_lesson_id" id="private_lesson_id" value="" >

                    <label for="files">{{__('Supporting Files')}}:</label>
                    <input class="form-control" type="file" name="cancel_files[]" multiple>

                    <!-- Hidden inputs for lesson and user details -->

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success" >{{__('send request')}}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('close')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="postPoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('postpone')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="postponeRequestForm" data-url="{{route('user.private_lessons.postpone')}}" method="POST" enctype="multipart/form-data">
                    <!-- Date inputs -->
                    <label for="dates">{{__('Suggested Dates')}}:</label>
                    <input class="form-control" type="date" name="suggested_dates[]"   min="{{ @$privateLesson->meeting_date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$privateLesson->meeting_date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$privateLesson->meeting_date }}" required>
                    <input class="form-control" type="text" hidden name="private_lesson_id" id="private_lesson_id" value="" >

                    <!-- File inputs -->
                    <label for="files">{{__('Supporting Files')}}:</label>
                    <input class="form-control" type="file" name="postpone_files[]" multiple>

                    <!-- Hidden inputs for lesson and user details -->

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success" >{{__('send request')}}</button>
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
        document.querySelectorAll('#cancelButton').forEach(function (button) {
            button.addEventListener('click', function() {
                document.getElementById('private_lesson_id').value = this.getAttribute('data-id');
            });
        });     document.querySelectorAll('#postPoneButton').forEach(function (button) {
            button.addEventListener('click', function() {
                document.getElementById('private_lesson_id').value = this.getAttribute('data-id');
            });
        });
        document.getElementById('postponeRequestForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var route = $('#postponeRequestForm').data('url')
            console.log(route);
            var lessonId = document.querySelector('input[name="private_lesson_id"]').value;
            formData.append('private_lesson_id', lessonId);
            formData.append('user_type', "student");
            var dateInputs = document.querySelectorAll('input[name="suggested_dates[]"]');
            dateInputs.forEach(function (input) {
                formData.append('suggested_dates[]', input.value);
            });
            var fileInput = document.querySelector('input[name="postpone_files[]"]');
            var files = fileInput.files;
            if (files) {
                for (var i = 0; i < files.length; i++) {
                    formData.append('postpone_files[]', files[i]);
                }
            }
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
                        $("#postponeRequestForm").append("<div class='alert alert-primary' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);

                    } else {
                        $("#postponeRequestForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);

                    }
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('cancelForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var route = $('#cancelForm').data('url')
            console.log(route);
            var lessonId = document.querySelector('input[name="private_lesson_id"]').value;
            formData.append('private_lesson_id', lessonId);
            formData.append('user_type', "student");
            var fileInput = document.querySelector('input[name="cancel_files[]"]');
            var files = fileInput.files;
            if (files) {
                for (var i = 0; i < files.length; i++) {
                    formData.append('postpone_files[]', files[i]);
                }
            }
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
                        $("#cancelForm").append("<div class='alert alert-success' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                    } else {
                        $("#cancelForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);

                    }
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });

</script>

