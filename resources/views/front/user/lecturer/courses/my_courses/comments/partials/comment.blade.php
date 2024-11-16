<tr id="comm_{{$comment->id}}">
    <td>
    <div class="py-2" >
        <div class="bg-light-green py-2 px-3 rounded-3 d-flex align-items-start mb-3">
            <div class="col">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60"><img class="rounded-circle" src="{{imageUrl(@$comment->user()->image,'100x100')}}" alt="{{@$comment->user()->name}}" alt="" loading="lazy"/></div>
                    <div class="ms-3">
                        <h5 class="mb-2"> </h5>
                        <h6 class="text-muted"> {!! @$comment->text !!}</h6>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <h6 class="text-muted pt-1"><i class="fa-regular fa-clock me-2"></i>{{changeDateFormate(@$comment->created_at)}}</h6>
                <div class="row">
                    <div class="col-6">
                        <a  class="btn btn-outline btn-outline-success btn-active-light-success rounded p-2 confirm-category"
                        data-url="{{ route('user.lecturer.my_courses.comment_publish' , $comment->id) }}"
                        data-id="{{ @$comment->id }}" data-is_relpad_page="true"
                        >
                         @if($comment->is_published == 1)
                           {{ __('not_publish') }}
                         @else
                           {{ __('publish') }}
                         @endif
                    </a>
                    </div>
                    <div class="col-6">
                        <a  class="btn btn-outline btn-outline-danger btn-active-light-danger rounded p-2 confirm-category"
                        data-url="{{ route('user.lecturer.my_courses.delete_comment' , $comment->id) }}"
                        data-id="{{ @$comment->id }}" data-is_relpad_page="true"
                        data-row="comm_{{ @$comment->id }}">{{ __('delete') }}</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
  </td>
  <td><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{imageUrl(@$comment->course->image)}}" alt="" loading="lazy"></span><span class="ms-2">{{@$comment->course->title}}</span></span></td>

</tr>
