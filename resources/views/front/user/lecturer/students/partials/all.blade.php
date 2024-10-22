<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($students) && count(@$students)>0)

        <table class="table table-cart mb-3">
            <thead>
                <tr>
                    <td>{{ __('student_name') }}</td>
                    {{-- <td>{{ __('phone') }}</td> --}}
                    <td>{{ __('courses') }}</td>
                    <td>{{ __('private_lessons') }}</td>
                    <td>{{ __('start_date') }}</td>
                    {{-- <td>{{ __('action') }}</td> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)

                @include('front.user.lecturer.students.partials.student')

                @endforeach
            </tbody>
        </table>

        <nav>
            {{@$students->links('vendor.pagination.custom')}}
        </nav>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_students')])

    @endif
</div>
