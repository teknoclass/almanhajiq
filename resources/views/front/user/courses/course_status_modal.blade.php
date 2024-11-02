<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('cancel')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="cancelForm" data-url="{{route('user.courses.live.requests.cancel')}}">
                    @csrf
                    <input class="form-control" type="text" hidden name="course_session_id" id="course_session_id" value="" >
                    <input class="form-control" type="text" hidden name="user_type" id="user_type" value="student" >

                    <label for="files">{{__('Supporting Files')}}:</label>
                    <input class="form-control" type="file" name="cancel_files[]" multiple>

                    <!-- Hidden inputs for lesson and user details -->

                    <!-- Submit button -->
                     <br>
                    <button type="submit" class="btn btn-success btn-sm" >{{__('send request')}}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('close')}}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="postPoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('postpone')}}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="postponeRequestForm" data-url="{{route('user.courses.live.requests.postpone')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="dates">{{__('Suggested Dates')}}:</label>
                    <input class="form-control" type="date" name="suggested_dates[]"   min="{{ @$session->date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$session->date }}" required>
                    <input class="form-control" type="date" name="suggested_dates[]"  min="{{ @$session->date }}" required>
                    <input class="form-control" type="text" hidden name="course_session_id" id="course_session_id" value="" >
                    <input class="form-control" type="text" hidden name="user_type" id="user_type" value="student" >

                    <!-- File inputs -->
                    <label for="files">{{__('Supporting Files')}}:</label>
                    <input class="form-control" type="file" name="postpone_files[]" multiple>

                    <!-- Hidden inputs for lesson and user details -->

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success" >{{__('send request')}}</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">{{__('close')}}</button>
            </div>
        </div>
    </div>
</div>
