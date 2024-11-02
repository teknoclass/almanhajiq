@extends('front.blog.layout.index', ['is_active' => 'blog', 'sub_title' => __('blog')])

@section('content')

    <!-- start:: section -->
    <section class="position-relative top-section wow bg-color-primary fadeInUp p-0" data-wow-delay="0.1s">
        <div class="swiper-container swiper-blog">
            <div class="swiper-wrapper">
                @if (@$slider_posts)
                    @foreach ($slider_posts as $s_post)
                        <div class="swiper-slide blog-swiper-slide">
                            <div class="blog-image position-relative">
                                <img src="{{ imageUrl(@$s_post->image) }}" alt="{{ @$s_post->title }}" loading="lazy">
                                <div class="text-absolute">
                                    <h3 class="font-bold">{{ @$s_post->title }}</h3>
                                    <div class="details">
                                        <p class="px-3">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($s_post->text), 200) !!}
                                        </p>
                                        <div class="px-5">
                                            <a href="{{ route('blog.single.post', ['id' => @$s_post->id]) }}"
                                                class="primary-btn p-1 m-auto d-block">{{ __('details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <h4 class="swiper-tag bg-primary text-white rounded-pill px-4">
                                    {{ \Carbon\Carbon::parse(@$s_post->created_at)->format('d \ m \ Y') }}
                                </h4> --}}
                            {{-- <div class="row title-absolute  w-100">
                                    <h2 class="swiper-title font-bold text-white mb-2">{{ @$s_post->title }}</h2>
                                    <h3 class="swiper-text">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($s_post->text), 200) !!}
                                        </h3>
                                </div> --}}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- end:: section -->
    <!-- start:: section -->
    <section class="section-padding-02 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="categories flex-wrap d-flex align-items-center justify-content-center">
                @if (@$categories)
                    @foreach ($categories as $category)
                        <div class="col-lg-3 col-sm-6 mb-3">
                        <a href="{{url('/blog?category_id='.@$category->value)}}">     <div class="mx-1 item-categ {{ $category->value == request()->category_id ? 'active' : '' }}"
                                data-filter="{{ @$category->name }}">{{ @$category->name }}</div>
                        </a>
                        </div>
                    @endforeach
                @endif
                {{-- <div class="mx-1 item-categ active" data-filter="all">جميع المقالات</div>
                <div class="mx-1 item-categ" data-filter="learn">مقالات التعليم</div>
                <div class="mx-1 item-categ" data-filter="train">مقالات التدريب</div>
                <div class="mx-1 item-categ" data-filter="public">مقالات عامة</div> --}}
            </div>
            {{-- Categories --}}
            {{-- <div class="row mb-4">
                @if (@$categories)
                    @foreach ($categories as $category)
                        <div class="col-lg-3 col-sm-6 mb-3">
                            <a class="widget_item-categoryBlog d-block"
                                href="{{ route('blog.category.posts', ['id' => @$category->value]) }}">
                                <div class="widget_item-image"><img src="{{ imageUrl(@$category->image, '260x200') }}"
                                        alt="{{ @$category->name }}" /></div>
                                <div class="widget_item-title text-center font-bold">{{ @$category->name }}</div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div> --}}
            {{-- <div class="row">
        <div class="col-12">
          <div class="text-end">
            <h3><a class="text-muted font-bold" href="{{ route('blog.single') }}">عرض الكل<i class="fa-regular fa-chevrons-left ms-2"></i></a></h3>
          </div>
        </div>
      </div> --}}
        </div>
    </section>
    <!-- end:: section -->
    <!-- start:: section -->
    <section class="section-padding wow fadeInUp bg-white" data-wow-delay="0.1s">
        <div class="latestBlog">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="latestBlog position-relative">
                            <div class="pb-4">
                                <div>
                                    <div class="row">
                                        @if (@$latest_posts)
                                            @foreach (@$latest_posts as $l_post)
                                                <div class="col-12 col-lg-4 col-md-6">
                                                    <div>
                                                        <div class="blog-item">
                                                            <div class="info-blog prim-border p-3 rounded-3 shadow-sm">
                                                                <div class="img-blog">
                                                                    <img class="rounded-3"
                                                                        src="{{ imageUrl(@$l_post->image) }}"
                                                                        alt="{{ @$l_post->title }}" loading="lazy"/>
                                                                </div>
                                                                <div class="widget_item-content">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between mb-3">
                                                                        <div class="type-blog rounded-3">
                                                                            <p>{{ @$l_post->category->name }}</p>
                                                                        </div>
                                                                        <div class="text-muted">
                                                                            <svg width="15" height="15"
                                                                                viewBox="0 0 21 22" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M9.76009 19.9474H2.60746C2.04911 19.9474 1.51363 19.7256 1.11881 19.3308C0.724001 18.9359 0.502197 18.4005 0.502197 17.8421V5.21053C0.502197 4.65218 0.724001 4.11669 1.11881 3.72188C1.51363 3.32707 2.04911 3.10526 2.60746 3.10526H15.239C15.7974 3.10526 16.3329 3.32707 16.7277 3.72188C17.1225 4.11669 17.3443 4.65218 17.3443 5.21053V9.42105H0.502197M13.1338 1V5.21053M4.71272 1V5.21053M16.2917 15.2063V16.7895L17.3443 17.8421M12.0811 16.7895C12.0811 17.9062 12.5248 18.9771 13.3144 19.7668C14.104 20.5564 15.175 21 16.2917 21C17.4084 21 18.4793 20.5564 19.269 19.7668C20.0586 18.9771 20.5022 17.9062 20.5022 16.7895C20.5022 15.6728 20.0586 14.6018 19.269 13.8122C18.4793 13.0226 17.4084 12.5789 16.2917 12.5789C15.175 12.5789 14.104 13.0226 13.3144 13.8122C12.5248 14.6018 12.0811 15.6728 12.0811 16.7895Z"
                                                                                    stroke="#06060680"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round" />
                                                                            </svg>
                                                                            {{ \Carbon\Carbon::parse(@$l_post->created_at)->diffForHumans() }}
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between mb-3">
                                                                        {{-- <div class="d-flex align-items-center">
                                                                        <div class="symbol symbol-50 me-2"><img
                                                                                src="{{ imageUrl(@$l_post->user->image) }}"
                                                                                alt="{{ @$l_post->user->name }}" /></div>
                                                                        <h3 class="font-medium">{{ @$l_post->user->name }}</h3>
                                                                    </div> --}}
                                                                    </div>
                                                                    <h5 class="widget_item-title font-bold mb-3"><a
                                                                            href="{{ route('blog.single.post', ['id' => @$l_post->id]) }}">
                                                                            {{ @$l_post->title }} </a></h5>
                                                                    <p class="text-muted mb-3 widget_item-text">
                                                                        {!! \Illuminate\Support\Str::limit(strip_tags($l_post->text), 120) !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="btn-blog">
                                                                <a class="p-2 fw-bold d-block text-center primary-btn"
                                                                    href="{{ route('blog.single.post', ['id' => @$l_post->id]) }}">
                                                                    {{ __('read_more') }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row mb-4">
                    @if (@$latest_posts)
                        @foreach ($latest_posts as $l_post)
                            <div class="col-12 col-lg-4 col-md-6 mb-4">
                                <div class="blog-item">
                                    <div class="info-blog prim-border p-3 rounded-3 shadow-sm">
                                        <div class="img-blog">
                                            <img class="rounded-3"
                                                src="{{ asset('assets/front/images/newimages/Rectangle-blog.png') }}"
                                                alt="{{ @$l_post->title }}" />
                                        </div>
                                        <div class="widget_item-content p-4">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="type-blog rounded-3">
                                                    <p>{{ @$l_post->category->name }}</p>
                                                </div>
                                                <div class="text-muted">
                                                    <svg width="15" height="15" viewBox="0 0 21 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9.76009 19.9474H2.60746C2.04911 19.9474 1.51363 19.7256 1.11881 19.3308C0.724001 18.9359 0.502197 18.4005 0.502197 17.8421V5.21053C0.502197 4.65218 0.724001 4.11669 1.11881 3.72188C1.51363 3.32707 2.04911 3.10526 2.60746 3.10526H15.239C15.7974 3.10526 16.3329 3.32707 16.7277 3.72188C17.1225 4.11669 17.3443 4.65218 17.3443 5.21053V9.42105H0.502197M13.1338 1V5.21053M4.71272 1V5.21053M16.2917 15.2063V16.7895L17.3443 17.8421M12.0811 16.7895C12.0811 17.9062 12.5248 18.9771 13.3144 19.7668C14.104 20.5564 15.175 21 16.2917 21C17.4084 21 18.4793 20.5564 19.269 19.7668C20.0586 18.9771 20.5022 17.9062 20.5022 16.7895C20.5022 15.6728 20.0586 14.6018 19.269 13.8122C18.4793 13.0226 17.4084 12.5789 16.2917 12.5789C15.175 12.5789 14.104 13.0226 13.3144 13.8122C12.5248 14.6018 12.0811 15.6728 12.0811 16.7895Z"
                                                            stroke="#06060680" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse(@$l_post->created_at)->diffForHumans() }}
                                                </div>
                                            </div>
                                            <h5 class="widget_item-title font-bold mb-3"><a
                                                    href="{{ route('blog.single.post', ['id' => @$l_post->id]) }}">
                                                    {{ @$l_post->title }} </a></h5>
                                            <p class="text-muted mb-4 widget_item-text">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($l_post->text), 120) !!}
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="symbol rounded-3 symbol-50 me-2">
                                                <img class="w-100"
                                                    src="{{ imageUrl(@$l_post->user->image) }}"
                                                    alt="{{ @$l_post->user->name }}" />
                                            </div>
                                            <h6 class="font-medium">{{ @$l_post->user->name }}</h6>
                                        </div>
                                    </div>
                                    <div class="btn-blog">
                                        <a class="p-2 fw-bold w-100 d-block text-center primary-btn"
                                            href="{{ route('blog.single.post', ['id' => @$l_post->id]) }}">
                                            {{ __('read_more') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div> --}}
            </div>
        </div>
    </section>
    <!-- end:: section -->
@endsection
