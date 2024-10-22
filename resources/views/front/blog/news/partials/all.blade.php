@if(@$news)

<div class="row">
    @foreach($news as $new)

    @include('front.blog.news.partials.new')

    @endforeach
</div>
<nav>
    {{@$news->links('vendor.pagination.custom')}}
</nav>


@else

@include('front.components.no_found_data',['no_found_data_text'=>__('no_found_posts')])

@endif
