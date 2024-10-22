

<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex align-items-center border-bottom pb-3 mt-4">
            <div class="col-auto">
                <div class="symbol symbol-60">
                    <img class="rounded-circle" src="{{ imageUrl(@$course_item->lecturer->image) }}"
                        alt="{{ @$course_item->lecturer->name }}" loading="lazy"/></div>
            </div>
            <div class="col ms-3">
                <h4 class="font-medium">{{ @$course_item->lecturer->name }}</h4>
                <h6>{{ @$course_item->lecturer->lecturerSetting->position }}</h6>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-2 font-medium"><span class="square me-1"></span> {{ __('lesson_desc') }}</h4>
        <div class="text--muted">{!! @$course_item->description !!}</div>
    </div>
</div>
