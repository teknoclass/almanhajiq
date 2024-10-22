<div class="col-12 mb-3">
    <div class="bg-white rounded-2 p-3 item-question">
        <h5 class="font-medium mb-3">
            <span class="square"></span> {{ $question->title }}
        </h5>
        <div class="myDropzone-{{ $question->id }} dropzone dropzone-course bg-transparent border-0">
            <input type="hidden" name="question[{{ $question->id }}][answer]">
        </div>
    </div>
</div>

@push('front_js')
    <script>
        $(document).ready(function () {
            if ($(".myDropzone-{{ $question->id }}").length > 0) {
                var myDropzoneNo{{ $question->id }} = new Dropzone(".myDropzone-{{ $question->id }}", {
                    url: "{{ route('user.courses.curriculum.assignment.file.upload', @$assignment->course_id) }}",
                    dictDefaultMessage: `
                        <span class='icon me-2'><i class="fa-solid fa-arrow-down-to-line"></i></span>
                        <span class='text'>إرفـاق ملفـات</span>`,
                    acceptedFiles: 'image/*,,application/pdf',
                    addRemoveLinks: true,
                    clickable: true,
                    init: function () {
                        var dropzoneInstance = this;

                        this.on("sending", function (file, xhr, formData) {
                            formData.append("_token", CSRF_TOKEN);
                        });

                        this.on("success", function (file, response) {
                            if (response.status) {
                                // Get the current value of the hidden input (should be an array)
                                var currentValues = $('input[name="question[{{ $question->id }}][answer]"]').val();
                                var fileArray = currentValues ? JSON.parse(currentValues) : [];
                                fileArray.push(response.file_name);
                                $('input[name="question[{{ $question->id }}][answer]"]').val(JSON.stringify(fileArray));

                                file.upload_name  = response.file_name;

                                // Always show the "+" icon at the end after any file uploads
                                var plusIcon = dropzoneInstance.previewsContainer.querySelector(".dropzone-add-file");
                                if (!plusIcon) {
                                    // Create a preview with custom HTML code
                                    var previewElement = document.createElement("div");
                                    previewElement.className = "dz-preview dz-complete dropzone-add-file";
                                    previewElement.innerHTML = `
                                        <span class='icon me-2'><i class="fa-solid fa-plus clickable"></i></span>
                                        <span class='text clickable'>إرفـاق ملفـات</span>
                                    `;

                                    // Append the preview to the dropzone container
                                    dropzoneInstance.previewsContainer.appendChild(previewElement);

                                    // Add click event to the "+" icon and text
                                    previewElement.querySelectorAll('.clickable').forEach(function (element) {
                                        element.addEventListener('click', function () {
                                            // Trigger the file input click event
                                            dropzoneInstance.hiddenFileInput.click();
                                        });
                                    });
                                } else {
                                    // If it's not the first file, move the "+" icon to the end
                                    dropzoneInstance.previewsContainer.appendChild(plusIcon);
                                }
                            }
                        });
                    },
                    removedfile: function(file) {
                        $.ajax({
                            type: 'delete',
                            url: "{{route('user.courses.curriculum.assignment.file.delete', @$assignment->course_id)}}",
                            data: {
                                file_name: file.upload_name,
                                _token:"{{csrf_token()}}"
                            },
                            success: function(result) {
                                reset_arrayy(file.upload_name , "{{ $question->id }}");
                            }
                        });
                        var _ref;
                        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                    }
                });

                // Show the custom HTML code initially
                $(".fa-arrow-down-to-line").show();
            }
        });

        function reset_arrayy(name = null , question_id)
        {
            var currentValues =  $('input[name="question[' + question_id + '][answer]"]').val();
            var fileArray     =  currentValues ? JSON.parse(currentValues) : [];
            var new_array     =  [];
            fileArray.forEach(function(item){
                if(item != name){
                    new_array.push(item);
                    console.log(item , name);
                }
            });
            $('input[name="question[' + question_id + '][answer]"]').val(JSON.stringify(new_array));
        }

    </script>
@endpush
