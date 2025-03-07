<div class="modal show" id="modalAddAttachment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button type='button' class="btn-close" onclick="closeModal()"></button>
                        <table id="attachment-table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{__('name')}}</th>
                                    <th>{{__('delete')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attachments as $attachment)
                                    <tr id="attachment-row-{{ $attachment->id }}">
                                        <td>{{ $attachment->original_name }}</td>
                                        <td>
                                            <button type='button' class="btn btn-danger delete-attachment" data-id="{{ $attachment->id }}" data-id="{{ $attachment->id }}">
                                                {{__('delete')}}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    <div class="btn btn-primary mt-3" type="button" id="kt_dropzone_1" data-session-id="{{$session->id}}">{{__('add')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/front/js/post.js') }}"></script>
<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/front/js/summernote.min.js') }}"></script>
<script>
    $('.scroll').each(function() {
        const ps = new PerfectScrollbar($(this)[0]);
    });

    function closeModal() {
        $("#modalAddAttachment").hide();
    };
    $('#kt_dropzone_1').dropzone({
            url: "{{ route('panel.courses.edit.add_attachment') }}", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            acceptedFiles: ".pdf", // Allowed file types
            accept: function(file, done) {
                done()
            },
            sending: function(file, xhr, formData) {
                let sessionId = $('#kt_dropzone_1').data('session-id');
                formData.append("_token", $('meta[name="csrf-token"]').attr('content')); // CSRF token
                formData.append('session_id', sessionId);
            },
            success: function(file, response) {
                $(file.previewElement).find('.dz-success-mark').on('click', function() {
                    var newRow = `
                        <tr id="attachment-row-${response.attachment.id}">
                            <td>${response.attachment.original_name}</td>
                            <td>
                                <button class="btn btn-danger delete-attachment" data-id="${response.attachment.id}">
                                    {{__('delete')}}
                                </button>
                            </td>
                        </tr>`;
                    $("#attachment-table tbody").append(newRow);
                    let dz = Dropzone.forElement("#kt_dropzone_1");
                    dz.removeFile(file);
                });

                $(file.previewElement).find('.dz-error-mark').on('click', function() {
                    var attachmentId = response.attachment.id;


                    $.ajax({
                        url: "{{ route('panel.courses.edit.delete_attachment') }}", // Your API route
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: attachmentId
                        },
                        success: function(response) {
                            if (response.success) {
                                console.log('delete done');
                            } else {
                                alert("Failed to delete attachment.");
                            }
                        },
                        error: function(xhr) {
                            console.error("Error");
                        }
                    });

                    let dz = Dropzone.forElement("#kt_dropzone_1");
                    dz.removeFile(file);
                });
            },
            error: function(file, errorMessage) {
                console.error("Upload failed:", errorMessage);
            }
        });

    function done(){

    }

</script>

