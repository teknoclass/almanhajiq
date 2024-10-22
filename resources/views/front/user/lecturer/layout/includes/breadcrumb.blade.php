<div class="row mb-4">
    <div class="col-12">
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
  </div>
