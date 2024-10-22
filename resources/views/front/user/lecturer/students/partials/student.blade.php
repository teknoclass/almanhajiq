
<tr>
    <td>
        <span class="d-flex align-items-center">
            <span class="symbol symbol-40">
                <img class="rounded-circle" src="{{imageUrl(@$student->image)}}" alt="{{@$student->name}} " loading="lazy"/>
            </span>
            <span class="ms-2">
                {{@$student->name}}
                {{-- <br>
                <span class="ms-2 text-muted">
                    {{@$student->email}}
                </span> --}}
            </span>
        </span>
    </td>
    {{-- <td>{{@$student->mobile}} </td> --}}
    <td>
        <strong>
            <a href="{{ route('user.lecturer.students.student.courses', ['id' => @$student->id]) }}">
                {{ @$student->LecturerRelatedCoursesCount(auth()->id())  }}
            </a>
        </strong>
    </td>
    <td>
        <strong>
            <a href="{{ route('user.lecturer.students.student.lessons', ['id' => @$student->id]) }}">
                {{ @$student->LecturerRelatedLessonsCount(auth()->id())  }}
            </a>
        </strong>
    </td>
    <td><span><i class="fa-regular fa-clock me-2"></i>{{changeDateFormate(@$student->created_at)}}</span></td>
    {{-- <td>
        <span class="d-flex align-items-center w-100 justify-content-between">
            <div class="dropdown" id="dropdown">
                <button class="btn btn-drop px-1 py-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-ellipsis-vertical"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3">
                    <p><a href="#">الملف الشخصي</a></p>
                    <p><a href="#">تحرير</a></p>
                    <p><a href="#">الشهادات</a></p>
                    <p><a href="#">الواجبات</a></p>
                    <p><a href="#" class="text-danger">حذف</a></p>
                </div>
            </div>
        </span>
    </td> --}}
</tr>
