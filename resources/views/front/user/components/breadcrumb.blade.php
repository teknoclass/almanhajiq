<div class="row mb-4 justify-content-between align-items-center">
    <div class="col-9">
      <div class="d-lg-flex align-items-center justify-content-between">
        <ol class="breadcrumb mb-0">
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
    </div>
    @include('front.user.components.navigation_dropdown')
</div>
