@if (@$courses && $courses->isNotEmpty())
    <div class="container pt-4">
        <div class="row pt-4">
            <div class="col-12">
                <h2 class="text-color-primary font-bold mb-3">{{ __('similar_courses') }}</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($courses as $course)
                @if ($course)
                    @include('front.courses.partials.course', ['course' => $course])
                @endif
            @endforeach
        </div>
    </div>
@endif
