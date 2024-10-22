<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    <table class="table table-cart mb-3">
        <thead>
          <tr>
            <td>{{ __('course_name') }}</td>
            <td>{{ __('type') }}</td>
            <td>{{ __('category') }}</td>
            <td>{{ __('student1') }}</td>
            <td>{{ __('status') }}</td>
            <td>{{ __('price') }}</td>
            {{--<td>{{ __('earnings') }}</td>--}}
            <td>{{ __('added_date') }}</td>
            <td>{{ __('action') }}</td>
          </tr>
        </thead>
        <tbody>

            @if(isset($courses) && count(@$courses)>0)
                <div class="row">
                    @foreach ($courses as $course)
                        @if (@$it_is_user_course)
                            <?php $course = $course->course; ?>
                        @endif
                        @include('front.user.lecturer.courses.my_courses.partials.course', ['course' => $course])
                    @endforeach
                </div>

            @else

                @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_courses')])

            @endif
        </tbody>
    </table>
    <nav>
        {{@$courses->links('vendor.pagination.custom')}}
    </nav>

    @include('front.user.lecturer.courses.my_courses.partials.reason_unacceptable_modal')


</div>

