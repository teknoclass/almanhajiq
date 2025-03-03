<div class="row">
    <div class="col-12">
        @switch(@$course_item->storage)
            @case('upload')
            <video id="videoPlayer" width="640" height="360" controls>
                <source src="{{ CourseVideoUrlStream(@$course->id, @$course_item->file) }}" type="video/mp4">
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

                @case('vimeo_link')
                <div class="video-container">
                    <iframe src="https://player.vimeo.com/video/{{ @$course_item->file }}"
                style="position:absolute;top:0;left:0;width:100%;height:100%;"
                frameborder="0"
                allow="autoplay; fullscreen"
                allowfullscreen>
                </iframe>

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

