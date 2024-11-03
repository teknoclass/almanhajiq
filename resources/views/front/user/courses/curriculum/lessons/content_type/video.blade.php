<div class="row">
    <div class="col-12">
        @switch(@$course_item->storage)
            @case('upload')
            <video class="player" id="videoPlayer" controls>
                    <source type="video/mp4">
                </video>
                @break

            @case('youtube')
                <div class="video-container">
                    {!! @$course_item->file !!}
                </div>
                {{-- <div class="player" data-plyr-provider="youtube" data-plyr-embed-id="{{ @$course_item->file }}"></div> --}}
                @break

            @case('external_link')
                <div class="video-container">
                    <iframe src="{{ @$course_item->file }}" frameborder="0" allowfullscreen></iframe>
                </div>
                @break

            @case('google_drive')
                <div class="video-container">
                    {!! @$course_item->file !!}
                </div>
                @break

            @case('iframe')
                <div class="video-container">
                    {!! @$course_item->file !!}
                </div>
                @break

            @default

        @endswitch
    </div>
</div>
<script>
    fetch('{{ courseVideoUrl(@$course->id, @$course_item->file) }}')
        .then(response => response.blob())
        .then(blob => {
            const url = URL.createObjectURL(blob);
            const video = document.getElementById('videoPlayer');
            video.src = url;
        });
</script>