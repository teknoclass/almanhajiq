<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($user_courses) && count(@$user_courses)>0)

    <div class="table-container">
        <table class="table table-cart table-2 mb-3">
            <thead>
                <tr>
                    <td>{{ __('course_name') }}</td>
                    {{-- <td>{{ __('level') }}</td> --}}
                    <td>{{ __('rate') }}</td>
                    <td>{{ __('course_type') }}</td>
                    <td>{{ __('reg_date') }}</td>
                    <td width="20%">{{ __('certificate') }}</td>
                </tr>
            </thead>
            <tbody>

                @foreach($user_courses as $user_course)

                @include('front.user.courses.completed_courses.partials.course')

                @endforeach
            </tbody>
        </table>

        <nav>
            {{@$user_courses->links('vendor.pagination.custom')}}
        </nav>
    </div>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_courses')])

    @endif
</div>

