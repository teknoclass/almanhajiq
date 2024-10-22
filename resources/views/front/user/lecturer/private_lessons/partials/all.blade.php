<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($lessons) && count(@$lessons)>0)

        <table class="table table-cart mb-3">
            <thead>
                <tr>
                    <td>{{ __('lesson_name') }}</td>
                    <td>{{ __('category') }} </td>

                    @if (@$settings->valueOf('offline_private_lessons'))
                    <td>{{ __('type') }}</td>
                    @endif

                    <td>{{ __('date') }}</td>
                    <td>{{ __('time') }}</td>
                    <td>{{ __('price') }}</td>
                    <td>{{ __('earnings') }}</td>
                    <td>{{ __('status') }}</td>
                    <td>{{ __('subscribers') }}</td>
                    <td>{{ __('session1') }} </td>
                    @if (@$type == 'finished')
                    <td>{{ __('rate') }}</td>
                    @endif
                    <td>{{__('request_status')}}</td>
                    <td>{{__('request_admin_response')}}</td>
                    <td>{{ __('action') }}</td>
                    <td>{{ __('cancel') }}/{{ __('postpone') }}</td>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)

                @include('front.user.lecturer.private_lessons.partials.lesson')

                @endforeach
            </tbody>
        </table>

        <nav>
            {{@$lessons->links('vendor.pagination.custom')}}
        </nav>
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
                <form id="teacherCancelForm" data-url="{{route('user.private_lessons.cancel')}}">
                    <input type="text" id="private_lesson_id" name="private_lesson_id" value="" hidden>

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
                <form id="TeacherPostponeRequestForm" data-url="{{route('user.private_lessons.postpone')}}" enctype="multipart/form-data">
                    <!-- Date inputs -->
                    <label for="dates">{{__('suggested dates')}}:</label>
                    <input class="form-control" type="date" name="suggested_dates[]"   min="{{ @$lesson->meeting_date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$lesson->meeting_date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$lesson->meeting_date }}" required>
                    <input type="text" id="postpone_private_lesson_id" name="postpone_private_lesson_id" value="" hidden>
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
        });
        document.querySelectorAll('#postponeButton').forEach(function (button) {
            button.addEventListener('click', function() {
                document.getElementById('postpone_private_lesson_id').value = this.getAttribute('data-id');
            });
        });
        document.getElementById('TeacherPostponeRequestForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var route = $('#TeacherPostponeRequestForm').data('url')
            console.log(route);
            var lessonId = document.querySelector('input[name="postpone_private_lesson_id"]').value;
            formData.append('private_lesson_id', lessonId);
            formData.append('user_type', "teacher");
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
                        $("#TeacherPostponeRequestForm").append("<div class='alert alert-primary' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);

                    } else {
                        $("#TeacherPostponeRequestForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                    }
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('teacherCancelForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            var route = $('#teacherCancelForm').data('url')
            console.log(route);
            var lessonId = document.querySelector('input[name="private_lesson_id"]').value;
            formData.append('private_lesson_id', lessonId);
            formData.append('user_type', "teacher");

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
                        $("#teacherCancelForm").append("<div class='alert alert-success' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                    } else {
                        $("#teacherCancelForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>"+data.message+"</div>");  setTimeout(function () {
                            $("#alert-message").alert('close');
                        }, 2000);
                    }
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    });

</script>
