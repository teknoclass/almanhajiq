<div class="row mb-3">
    <div class="col-12">
     @if($course->is_delete == 1)
        <h3 class="font-medium text-danger"><span class="circle ms-2"></span>{{ __('deleted_course_comment') }}</h3>
     @endif
    <div class="d-flex align-items-center flex-wrap justify-content-between">
        <h4 class="font-medium"><span class="square ms-2"></span> {{ @$course_item->title }}</h4>
        <div class="d-flex align-items-center">
        @include('front.user.courses.curriculum.components.content_navigation_buttons')
        </div>
    </div>
    </div>
</div>
