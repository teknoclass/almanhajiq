document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#cancelButton').forEach(function (button) {

        button.addEventListener('click', function () {
            document.getElementById('course_session_id').value = this.getAttribute('data-id');
        });
    });
    document.querySelectorAll('#postPoneButton').forEach(function (button) {
        button.addEventListener('click', function () {
            document.getElementById('course_session_id').value = this.getAttribute('data-id');
            console.log('titlee::::' + document.getElementById('course_session_id').value);
        });
    });
    document.getElementById('postponeRequestForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData();
        var route = $('#postponeRequestForm').data('url')

        var lessonId = document.querySelector('input[name="course_session_id"]').value;
        console.log(lessonId);
        formData.append('course_session_id', lessonId);
        var userType = document.querySelector('input[name="user_type"]').value;

        formData.append('user_type', userType);
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
                    $("#postponeRequestForm").append("<div class='alert alert-primary' id='alert-message' role='alert'>" + data.message + "</div>");
                    setTimeout(function () {
                        $("#alert-message").alert('close');
                    }, 2000);

                } else {
                    $("#postponeRequestForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>" + data.message + "</div>");
                    setTimeout(function () {
                        $("#alert-message").alert('close');
                    }, 2000);

                }
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    });
});
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('cancelForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData();
        var route = $('#cancelForm').data('url')
        console.log(route);
        var lessonId = document.querySelector('input[name="course_session_id"]').value;
        var userType = document.querySelector('input[name="user_type"]').value;
        formData.append('course_session_id', lessonId);
        formData.append('user_type', userType);
        var fileInput = document.querySelector('input[name="cancel_files[]"]');
        var files = fileInput.files;
        if (files) {
            for (var i = 0; i < files.length; i++) {
                formData.append('postpone_files[]', files[i]);
            }
        }
        console.log(formData);
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
                    $("#cancelForm").append("<div class='alert alert-success' id='alert-message' role='alert'>" + data.message + "</div>");
                    setTimeout(function () {
                        $("#alert-message").alert('close');
                    }, 2000);
                } else {
                    $("#cancelForm").append("<div class='alert alert-danger' id='alert-message' role='alert'>" + data.message + "</div>");
                    setTimeout(function () {
                        $("#alert-message").alert('close');
                    }, 2000);

                }
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    });
});
