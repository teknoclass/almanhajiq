@if(count($posts)>0)

<div class="row">
    @foreach($posts as $post)

    @include('front.blog.posts.partials.post')

    @endforeach
</div>
<nav>
    {{@$posts->links('vendor.pagination.custom')}}
</nav>


@else

@include('front.components.no_found_data',['no_found_data_text'=>__('no_found_posts')])

@endif
