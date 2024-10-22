<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($courses) && count(@$courses)>0)

        <div class="row">
            @foreach ($courses as $course)
                @include('front.courses.partials.course', ['course' => $course])
            @endforeach
        </div>

        <nav>
            {{@$courses->links('vendor.pagination.custom')}}
        </nav>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_courses')])

    @endif
</div>
