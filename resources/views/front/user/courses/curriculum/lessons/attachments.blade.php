@php $attachments = @$course_item->attachments @endphp

@if (@$attachments && @$attachments->isNotEmpty())
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-2 font-medium"><span class="square me-1"></span> {{ __('attachments') }}</h4>
    </div>

    @foreach ($attachments as $attachment)
        @php
            $extension = pathinfo($attachment->attachment, PATHINFO_EXTENSION);
        @endphp
        @if ($extension == 'pdf')
            <div class="col-lg-2">
                <div class="widget__item-attac">
                    <a href="{{ CourseAttachmentUrl(@$course->id, @$attachment->attachment) }}" download="{{ $attachment->attachment }}">
                        <div class="widget__item-icon"><i class="fas fa-file-pdf fa-2x"></i></div>
                        {{-- <div class="widget__item-content">
                            <h5 class="widget__item-title">ملف PDF - أنواع الخوارزميات</h5>
                        </div> --}}
                    </a>
                </div>
            </div>
        @else
            <div class="col-lg-2">
                <div class="widget__item-attac">
                    <a href="{{ CourseAttachmentUrl(@$course->id, @$attachment->attachment) }}" download="{{ $attachment->attachment }}">
                        <div class="widget__item-icon"><img src="{{ CourseAttachmentUrl(@$course->id, @$attachment->attachment) }}" alt="" loading="lazy"/></div>
                        {{-- <div class="widget__item-content">
                            <h5 class="widget__item-title">ملف PDF - أنواع الخوارزميات</h5>
                        </div> --}}
                    </a>
                </div>
            </div>
        @endif
    @endforeach
</div>
@endif
