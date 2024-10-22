<div class="row mb-4">
    <div class="col-lg-10">
      <ol class="breadcrumb mb-lg-0">
        @foreach($breadcrumb_links as $sub_link)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                @if(@$sub_link['link']!='#')
                    <a href="{{ @$sub_link['link'] }}">{{ @$sub_link['title'] }}</a>
                @else
                    {{ @$sub_link['title'] }}
                @endif
            </li>
        @endforeach
      </ol>
    </div>
    @if (@$item->status == 'being_processed' || @$item->status == 'unaccepted')
    <div class="col-lg-2">
        <button type="button" class="btn btn-primary px-3 py-2" data-bs-toggle="modal"
            data-bs-target="#requestReviewModal"
            data-course-id="{{ @$item->id }}">
            {{ __('publish_course') }}
        </button>
    </div>
    @endif
  </div>
