<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($lessons) && count(@$lessons)>0)

        <table class="table table-cart mb-3">
            <thead>
                <tr>
                    <td>{{ __('lesson_name') }}</td>
                    <td>{{ __('course') }}</td>
                    <td>{{ __('date') }}</td>
                    <td>{{ __('time') }}</td>
                    <td>{{ __('session1') }} </td>
                </tr>
            </thead>
            <tbody>
                @foreach($lessons as $lesson)

                @include('front.user.lecturer.courses.my_courses.live_lessons.partials.lesson')

                @endforeach
            </tbody>
        </table>

        <nav>
            {{@$lessons->links('vendor.pagination.custom')}}
        </nav>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_lessons')])

    @endif
</div>
