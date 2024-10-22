<div class="row">
    <div class="col-12">
        @if (@$course_item->file)
            @php
                $extension = pathinfo(@$course_item->file, PATHINFO_EXTENSION);
                $doc = courseDocUrl(@$course->id, @$course_item->file);
            @endphp

            @if ($extension == 'pdf')
                <embed src="{{ $doc }}#toolbar=0" type="application/pdf" width="100%" height="500px" />

            {{-- @elseif ($extension == 'doc' || $extension == 'docx' || $extension == 'pptx')
                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ $doc }}' width='100%' height='500px'></iframe> --}}
            @endif

        @endif
    </div>
</div>
