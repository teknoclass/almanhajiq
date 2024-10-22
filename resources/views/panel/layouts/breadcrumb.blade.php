<!--begin::Subheader-->
@php
    $cursor_dir = app()->getlocale() == 'ar' ? 'left' : 'right';
@endphp

<div class="row gy-5 g-lg-3 mb-7 mt-1">
    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
        <!--begin::Item-->
        <li class="breadcrumb-item text-muted" style="display: none">
            <a href="index.html" class="text-muted text-hover-primary fs-1">{{ $title_page }} </a>
        </li>
        @foreach ($breadcrumb_links as $sub_link)
            <li class="breadcrumb-item text-dark fw-bolder fs-1">
                @if (@$sub_link['link'] != '#')
                    <a href="{{ @$sub_link['link'] }}"
                        @if (!$loop->last) class="text-muted text-hover-primary fs-1"
                           @else
                       class="text-dark " @endif>{{ @$sub_link['title'] }}</a>
                @else
                    {{ @$sub_link['title'] }}
                @endif
            </li>
            @if (!$loop->last)
                <li class="breadcrumb-item">
                    <span class=" bg-gray-200 w-10px "><i class="fas fa-chevron-{{@$cursor_dir}}"></i></span>
                </li>
            @endif
        @endforeach

        <!--end::Item-->
    </ul>
</div>
<!--end::Subheader-->
