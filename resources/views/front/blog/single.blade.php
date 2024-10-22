@extends('front.blog.layout.index', ['is_active' => 'blog', 'sub_title' => @$post->title])

@section('content')
    <!-- start:: section -->
    <section class="section-padding wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="blog-single-image mb-4 pb-lg-3">
                    <img src="{{ imageUrl(@$post->image) }}"
                        alt="{{ @$post->title }}" loading="lazy"/>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="blog-single-publisher mb-4 pb-lg-3">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-70 me-3"><img src="{{ imageUrl(@$post->user->image) }}"
                                    alt="{{ @$post->user->name }}" loading="lazy"/>
                            </div>
                            <div class="d-flex flex-column">
                                <h3 class="font-medium">{{ @$post->user->name }}</h3>
                                <h6 class="text-muted"><i
                                        class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse(@$post->created_at)->diffForHumans() }}
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="blog-single-title mb-4">
                        <h2 class="font-bold text-color-primary">{{ @$post->title }}</h2>
                    </div>
                    <div class="blog-single-text mb-4">
                        {!! @$post->text !!}
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-12">
                    <h4 class="mb-2 circle-before font-medium border-top pt-4"><span class="square me-1"></span> التعليقات
                    </h4>
                </div>
                <div class="col-12 mb-4">
                    <div class="widget__item-addComment">
                        <input class="form-control" type="text" placeholder="..اكتب تعليقاً" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="widget__item-message bg-white p-3 rounded-2 flex-column mb-3">
                        <div class="widget__item-head toggle-message pointer" data-bs-toggle="collapse"
                            data-bs-target="#collapse-1">
                            <div class="d-flex mb-3">
                                <div class="widget__item-image symbol symbol-50"><img class="rounded-circle"
                                        src="{{ asset('assets/front/images/avatar.png') }}" alt="" /></div>
                                <div class="widget__item-content ms-3 border-0 pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column">
                                            <h5 class="widget__item-name font-medium mb-2">أ.علي الرحباني</h5>
                                            <div
                                                class="data-rating d-flex align-items-center rating-sm justify-content-center">
                                                <span class="d-flex" data-rating="3"><i class="far fa-star"></i><i
                                                        class="far fa-star"></i><i class="far fa-star"></i><i
                                                        class="far fa-star"></i><i class="far fa-star"></i></span>
                                            </div>
                                        </div>
                                        <h6 class="widget__item-date">م 11 : 4</h6>
                                    </div>
                                </div>
                            </div>
                            <h5 class="widget__item-desc text-muted ms-3">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                    </div>
                    <div class="widget__item-message bg-white p-3 rounded-2 flex-column mb-3">
                        <div class="widget__item-head toggle-message pointer" data-bs-toggle="collapse"
                            data-bs-target="#collapse-1">
                            <div class="d-flex mb-3">
                                <div class="widget__item-image symbol symbol-50"><img class="rounded-circle"
                                        src="{{ asset('assets/front/images/avatar.png') }}" alt="" /></div>
                                <div class="widget__item-content ms-3 border-0 pb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex flex-column">
                                            <h5 class="widget__item-name font-medium mb-2">أ.علي الرحباني</h5>
                                            <div
                                                class="data-rating d-flex align-items-center rating-sm justify-content-center">
                                                <span class="d-flex" data-rating="3"><i class="far fa-star"></i><i
                                                        class="far fa-star"></i><i class="far fa-star"></i><i
                                                        class="far fa-star"></i><i class="far fa-star"></i></span>
                                            </div>
                                        </div>
                                        <h6 class="widget__item-date">م 11 : 4</h6>
                                    </div>
                                </div>
                            </div>
                            <h5 class="widget__item-desc text-muted ms-3">أهلاً بك ، الإجابة على سؤالك</h5>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
    <!-- end:: section -->
    <!-- start:: section -->
    <section class="section wow fadeInUp bg-white" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="font-bold text-center text-color-primary mb-5"> {{ __('similar_blogs') }}</h4>
                </div>
            </div>
            <div class="row mb-4">
                <div class="latestBlog position-relative">
                    <div class="swiper-container swiper-latestBlog-2 pb-4">
                        <div class="row">
                            @if (@$related_posts)
                                @foreach (@$related_posts as $r_post)
                                    <div class="col-12 col-lg-4 col-md-6">
                                        <div class="">
                                            <div class="blog-item">
                                                <div class="info-blog prim-border p-3 rounded-3 shadow-sm">
                                                    <div class="img-blog">
                                                        <img class="rounded-3"
                                                            src="{{ imageUrl(@$r_post->image) }}"
                                                            alt="{{ @$r_post->title }}" loading="lazy"/>
                                                    </div>
                                                    <div class="widget_item-content">
                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                            <div class="type-blog rounded-3">
                                                                <p>{{ @$r_post->category->name }}</p>
                                                            </div>
                                                            <div class="text-muted">
                                                                <svg width="15" height="15" viewBox="0 0 21 22"
                                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M9.76009 19.9474H2.60746C2.04911 19.9474 1.51363 19.7256 1.11881 19.3308C0.724001 18.9359 0.502197 18.4005 0.502197 17.8421V5.21053C0.502197 4.65218 0.724001 4.11669 1.11881 3.72188C1.51363 3.32707 2.04911 3.10526 2.60746 3.10526H15.239C15.7974 3.10526 16.3329 3.32707 16.7277 3.72188C17.1225 4.11669 17.3443 4.65218 17.3443 5.21053V9.42105H0.502197M13.1338 1V5.21053M4.71272 1V5.21053M16.2917 15.2063V16.7895L17.3443 17.8421M12.0811 16.7895C12.0811 17.9062 12.5248 18.9771 13.3144 19.7668C14.104 20.5564 15.175 21 16.2917 21C17.4084 21 18.4793 20.5564 19.269 19.7668C20.0586 18.9771 20.5022 17.9062 20.5022 16.7895C20.5022 15.6728 20.0586 14.6018 19.269 13.8122C18.4793 13.0226 17.4084 12.5789 16.2917 12.5789C15.175 12.5789 14.104 13.0226 13.3144 13.8122C12.5248 14.6018 12.0811 15.6728 12.0811 16.7895Z"
                                                                        stroke="#06060680" stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                                {{ \Carbon\Carbon::parse(@$r_post->created_at)->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                                            {{-- <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-50 me-2"><img
                                                                    src="{{ imageUrl(@$r_post->user->image) }}"
                                                                    alt="{{ @$r_post->user->name }}" /></div>
                                                            <h3 class="font-medium">{{ @$r_post->user->name }}</h3>
                                                        </div> --}}
                                                        </div>
                                                        <h5 class="widget_item-title font-bold mb-3"><a
                                                                href="{{ route('blog.single.post', ['id' => @$r_post->id]) }}">
                                                                {{ @$r_post->title }} </a></h5>
                                                        <p class="text-muted mb-3 widget_item-text">
                                                            {!! \Illuminate\Support\Str::limit(strip_tags($r_post->text), 120) !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="btn-blog">
                                                    <a class="p-2 fw-bold d-block text-center primary-btn"
                                                        href="{{ route('blog.single.post', ['id' => @$r_post->id]) }}">
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
    </section>
    <!-- end:: section -->
@endsection
