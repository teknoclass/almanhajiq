<div class="modal show" id="modalAddAttachment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-course">
        <div class="modal-content">
            <div class="py-3">
                <div class="scroll scroll-lesson">
                    <div class="modal-body px-5 py-0">
                        <button type='button' class="btn-close" onclick="closeModal()"></button>
                        @if($attachments->isNotEmpty())
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
                    @else
                        <p>{{__('no_data')}}</p>
                    @endif

                    <input type="file" id="fileInput" style="display: none;" data-session-id="{{$session->id}}" accept="application/pdf">

                    <button class="btn btn-primary mt-3" type="button" id="addAttachmentBtn" >{{__('add')}}</button>
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
    }
</script>
