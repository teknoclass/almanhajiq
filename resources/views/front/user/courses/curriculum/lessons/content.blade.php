@switch(@$course_item->file_type)
    @case('video')
        @include('front.user.courses.curriculum.lessons.content_type.video')
        @break

    @case('listen')
        @include('front.user.courses.curriculum.lessons.content_type.audio')
        @break

    @case('text')
        @include('front.user.courses.curriculum.lessons.content_type.text')
        @break

    @case('doc')
        @include('front.user.courses.curriculum.lessons.content_type.doc')
        @break

    @case('image')
        @include('front.user.courses.curriculum.lessons.content_type.image')
        @break

    @default

@endswitch
