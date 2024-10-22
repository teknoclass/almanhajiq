{{-- Start Courses Content Section --}}
<div class="container mb-5 tab" id="{{ @$tab }}">
    <div class="row">
        <div class="col-12">
            <div class="card-course">
                <div class="card-header">
                    <h3 class="font-medium text-center">{{ __('course_content') }}</h3>
                </div>
                <div class="card-body p-4">
                    <div class="row gx-lg-5">
                        @foreach ($course->whatWillYouLearn as $item)
                        <div class="col-lg-6">
                            <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                                <div class="symbol symbol-100"><img src="{{ imageUrl(@$item->image) }}"
                                        alt="{{ @$item->title }}"  loading="lazy"/></div>
                                <div class="me-3">
                                    <h5 class="font-medium">{{ @$item->title }}</h5>
                                    <h6>{!! @$item->description !!}</h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Courses Content Section --}}
