@foreach($lecturerCourses as $lecturerCourse)
    @if($lecturerCourse->course)
        @include('front.courses.partials.course', ['course'=>$lecturerCourse->course, 'col_class'=>'col-md-4'])
    @endif
@endforeach
