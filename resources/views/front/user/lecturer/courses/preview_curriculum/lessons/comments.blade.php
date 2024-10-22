@php $comments = @$course_item->comments @endphp
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-2 circle-before font-medium"><span class="square me-1"></span> {{ __('comments') }}</h4>
    </div>
    @if (@$comments && @$comments->isNotEmpty())
    <div class="col-12">
        <div class="accordion" id="accordion">
            @foreach ($comments as $comment)
            <div class="widget__item-message bg-white p-3 rounded-2 flex-column">
                {{-- title --}}
                <div class="widget__item-head toggle-message pointer" data-bs-toggle="collapse" data-bs-target="#collapse-{{ @$comment->id }}"
                    {{ $loop->first ? 'aria-expanded="false"' : '' }}>
                    <div class="d-flex">
                        <div class="widget__item-image symbol symbol-50">
                            <img class="rounded-circle" src="{{ imageUrl(@$comment->user->image) }}" alt="{{ @$comment->user->name }}" loading="lazy"/>
                        </div>
                        <div class="widget__item-content ms-3 border-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="widget__item-name font-medium mb-2">{{ @$comment->user->name }}</h5>
                                <h6 class="widget__item-date">{{ diffForHumans(@$comment->created_at) }}</h6>
                            </div>
                            <h5 class="widget__item-desc text--muted">{{ @$comment->text }}</h5>
                        </div>
                    </div>
                </div>

                {{-- content --}}
                <div class="widget__item-body widget__inner accordion-collapse collapse show" id="collapse-{{ $comment->id }}"
                    data-bs-parent="#accordion">
                    <div class="d-flex align-items-center justify-content-between px-2 mt-2">
                        <div class="d-flex align-items-center">
                            <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18.286" height="16" viewBox="0 0 18.286 16">
                                <path id="Icon_awesome-reply" data-name="Icon awesome-reply" d="M.3,12.613l6.286,5.428A.858.858,0,0,0,8,17.392V14.533c5.737-.066,10.286-1.215,10.286-6.652a7.3,7.3,0,0,0-2.976-5.5.636.636,0,0,0-1,.665C15.926,8.221,13.539,9.6,8,9.676V6.536a.858.858,0,0,0-1.417-.649L.3,11.316a.857.857,0,0,0,0,1.3Z" transform="translate(0 -2.25)" fill="#212F3E"></path>
                            </svg>
                            <h6 class="font-medium">{{ @$comment->children->count() }} ردود</h6>
                        </div>
                    </div>
                    <div class="">
                        {{-- previous replies --}}
                        @foreach ($comment->children as $child_comment)
                            <div class="widget__item-message-inner d-flex pb-3 mb-3 border-bottom">
                                <div class="widget__item-image symbol symbol-30">
                                    <img class="rounded-circle" src="{{ imageUrl(@$child_comment->user->image) }}" alt="{{ @$comment->user->name }}" loading="lazy"/>
                                </div>
                                <div class="widget__item-content ms-3 border-0 pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="widget__item-name font-medium mb-0">{{ @$child_comment->user->name }}</h6>
                                        <h6 class="widget__item-date">{{ diffForHumans(@$child_comment->created_at) }}</h6>
                                    </div>
                                    <h5 class="widget__item-desc text--muted">{{ @$child_comment->text }}</h5>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
