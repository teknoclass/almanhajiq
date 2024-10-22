@php
$user=$review->user;
@endphp
<tr>
    <td>
        <div class="row">
        <div class="py-2">
            <div class="bg-light-green py-2 px-3 rounded-3 d-flex align-items-start mb-3">
                <div class="col">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-60"><img class="rounded-circle"
                                src="{{imageUrl(@$user->image,'100x100')}}" alt="{{@$user->name}}" loading="lazy"/></div>
                        <div class="ms-3">
                            <h5 class="mb-2">{{@$user->name}}</h5>
                            <div class="data-rating d-flex align-items-center mb-2 rating-sm">
                               <span class="d-flex" data-rating="{{@$review->rate}}">
                               <i class="far fa-star"></i>
                               <i class="far fa-star"></i>
                               <i class="far fa-star"></i>
                               <i class="far fa-star"></i>
                               <i class="far fa-star"></i>
                               </span>
                            </div>
                            <h6 class="text-muted">
                                {{@$review->comment_text}}
                            </h6>
                            {{-- <h6 class="text-muted">
                                {{$review->getDescription()}}
                            </h6> --}}
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>{{changeDateFormate(@$review->created_at)}}</h6>
                    {{-- <div class="row">
                        <div class="col-6">
                            <a href="#"
                                class="btn btn-outline btn-outline-success btn-active-light-success rounded p-2">نشر</a>
                        </div>
                        <div class="col-6">
                            <a href="#"
                                class="btn btn-outline btn-outline-danger btn-active-light-danger rounded p-2">حذف</a>
                        </div>

                    </div> --}}

                </div>
            </div>
        </div>
        </div>
    </td>
    <td>
        @php
            $typeNames = [
                'course_lesson' => __('course1'),
                'session_group_course' => 'درس جماعي',
                'user' => __('student1'),
                'course' => __('course'),
                'private_lesson' => __('private_lesson1'),
            ];
        @endphp
        <span class="d-flex align-items-center">
            <span class="ms-2">
                {{ $typeNames[@$review->sourse_type] ?? 'Unknown Type' }}
            </span>
        </span>
    </td>

</tr>
