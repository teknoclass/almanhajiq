<div class="bg-light-green rounded-3 p-2 p-lg-3 mb-3">
    <div class="bg-white rounded-3 p-2 d-lg-flex align-items-center">
        <a href="{{ route('user.lecturer.my_courses.tasks.students' , $assignment->id) }}">
            <div class="d-flex align-items-center p-3">
            <div class="circle bg-dark ms-2 me-2"></div>
            <h5 class="mb-0"> {{ $assignment->title }} </h5>
            </div>
        </a>
    </div>
</div>