<div class="row">
    <div class="col-12">
        @switch(@$course_item->meeting)
            @case('pending')
                <div class="text-center py-5">
                    <img src="{{ asset('assets/front/images/file-clock.png') }}" alt="{{ @$course_item->title }}" loading="lazy"/>
                </div>
                @break

            @case('going_on')
                <iframe src="{{ @$course_item->meeting_link }}" width="100%" height="500"
                    allow="fullscreen;microphone;camera;display-capture;web-share">
                </iframe>
                @break

            @case('finished')
                @if (@$course_item->recording_link)
                    <iframe src="{{ @$course_item->recording_link }}" width="100%" height="500" frameborder="0" allowfullscreen></iframe>
                @else
                    <h6 class="font-medium py-5 text-center text-success">لقد مضى وقت الجلسة</h6>
                @endif
                @break
        @endswitch
    </div>
</div>
