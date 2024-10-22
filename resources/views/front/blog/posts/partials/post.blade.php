<div class="col-12 col-lg-4 col-md-6 mb-4">
    <div class="blog-item">
        <div class="info-blog prim-border p-3 rounded-3 shadow-sm">
            <div class="img-blog">
                <img src="{{ imageUrl(@$post->image) }}" alt="{{ @$post->title }}" loading="lazy">
            </div>
            <div class="widget_item-content">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="type-blog rounded-3">
                        <p>{{ @$post->category->name }}</p>
                    </div>
                    <div class="text-muted">
                        <svg width="15" height="15" viewBox="0 0 21 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.76009 19.9474H2.60746C2.04911 19.9474 1.51363 19.7256 1.11881 19.3308C0.724001 18.9359 0.502197 18.4005 0.502197 17.8421V5.21053C0.502197 4.65218 0.724001 4.11669 1.11881 3.72188C1.51363 3.32707 2.04911 3.10526 2.60746 3.10526H15.239C15.7974 3.10526 16.3329 3.32707 16.7277 3.72188C17.1225 4.11669 17.3443 4.65218 17.3443 5.21053V9.42105H0.502197M13.1338 1V5.21053M4.71272 1V5.21053M16.2917 15.2063V16.7895L17.3443 17.8421M12.0811 16.7895C12.0811 17.9062 12.5248 18.9771 13.3144 19.7668C14.104 20.5564 15.175 21 16.2917 21C17.4084 21 18.4793 20.5564 19.269 19.7668C20.0586 18.9771 20.5022 17.9062 20.5022 16.7895C20.5022 15.6728 20.0586 14.6018 19.269 13.8122C18.4793 13.0226 17.4084 12.5789 16.2917 12.5789C15.175 12.5789 14.104 13.0226 13.3144 13.8122C12.5248 14.6018 12.0811 15.6728 12.0811 16.7895Z"
                                stroke="#06060680" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ \Carbon\Carbon::parse(@$post->created_at)->diffForHumans() }}
                    </div>
                </div>
                <h5 class="widget_item-title font-bold mb-3">
                    <a href="{{ route('blog.single.post', ['id' => @$post->id]) }}">
                        {{ @$post->title }}
                    </a>
                </h5>
                <p class="widget_item-text text-muted mb-3">{!! \Illuminate\Support\Str::limit(strip_tags($post->text), 120) !!}</p>
            </div>
        </div>
        <div class="btn-blog">
            <a class="p-2 fw-bold w-100 d-block text-center primary-btn"
                href="{{ route('blog.single.post', ['id' => @$post->id]) }}">
                {{ __('read_more') }}
            </a>
        </div>
        {{-- <div class="widget_item-latestBlog mb-4">
            <div class="widget_item-image"><a href="{{ route('blog.single.post', ['id' => @$post->id]) }}"><img
                        src="{{ imageUrl(@$post->image, '375x215') }}" alt="{{ @$post->title }}" /></a></div>
            <div class="widget_item-content p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">

                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-30 me-2"><img src="{{ imageUrl(@$post->user->image, '30x30') }}"
                                alt="{{ @$post->user->name }}" /></div>
                        <h3 class="font-medium">{{ @$post->user->name }}</h3>
                    </div>
                    <h6 class="text-muted"><i
                            class="fa-regular fa-clock me-1"></i>{{ \Carbon\Carbon::parse(@$post->created_at)->diffForHumans() }}
                    </h6>
                </div>
                <h6 class="widget_item-title font-bold mb-3"><a
                        href="{{ route('blog.single.post', ['id' => @$post->id]) }}"> {{ @$post->title }} </a></h6>
                <h6 class="widget_item-text text-muted mb-3">{!! \Illuminate\Support\Str::limit(strip_tags($post->text), 200) !!}</h6>
                <div class="text-center"><a class="btn btn-primary px-5 rounded-pill py-1"
                        href="{{ route('blog.single.post', ['id' => @$post->id]) }}">قراءة المزيد </a></div>
            </div>
        </div> --}}
    </div>
</div>
