<div class="col-12 col-lg-4 col-md-6 mb-4">
    <div class="blog-item">
        <div class="info-blog prim-border p-3 rounded-3 shadow-sm">
            <div class="img-blog">
                <img class="rounded-3" src="{{ imageUrl(@$new->image) }}"
                    alt="{{ @$new->title }}" loading="lazy"/>
            </div>
            <div class="widget_item-content p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="type-blog rounded-3">
                        <p>الأحدث</p>
                    </div>
                    <div class="text-muted">
                        <svg width="15" height="15" viewBox="0 0 21 22" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.76009 19.9474H2.60746C2.04911 19.9474 1.51363 19.7256 1.11881 19.3308C0.724001 18.9359 0.502197 18.4005 0.502197 17.8421V5.21053C0.502197 4.65218 0.724001 4.11669 1.11881 3.72188C1.51363 3.32707 2.04911 3.10526 2.60746 3.10526H15.239C15.7974 3.10526 16.3329 3.32707 16.7277 3.72188C17.1225 4.11669 17.3443 4.65218 17.3443 5.21053V9.42105H0.502197M13.1338 1V5.21053M4.71272 1V5.21053M16.2917 15.2063V16.7895L17.3443 17.8421M12.0811 16.7895C12.0811 17.9062 12.5248 18.9771 13.3144 19.7668C14.104 20.5564 15.175 21 16.2917 21C17.4084 21 18.4793 20.5564 19.269 19.7668C20.0586 18.9771 20.5022 17.9062 20.5022 16.7895C20.5022 15.6728 20.0586 14.6018 19.269 13.8122C18.4793 13.0226 17.4084 12.5789 16.2917 12.5789C15.175 12.5789 14.104 13.0226 13.3144 13.8122C12.5248 14.6018 12.0811 15.6728 12.0811 16.7895Z"
                                stroke="#06060680" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ \Carbon\Carbon::parse(@$new->created_at)->diffForHumans() }}
                    </div>
                </div>
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <h5 class="widget_item-title font-bold"><a
                            href="{{ route('blog.single.post', ['id' => @$new->id]) }}">
                            {{ @$new->title }} </a>
                        </h5>
                </div>
                <p class="text-muted mb-3 widget_item-text">
                    {!! \Illuminate\Support\Str::limit(strip_tags($new->text), 150) !!}
                </p>
            </div>
        </div>
        <div class="btn-blog">
            <a class="p-2 fw-bold w-100 d-block text-center primary-btn"
                href="{{ route('blog.single.post', ['id' => @$new->id]) }}">قراءة
                المزيد
            </a>
        </div>
    </div>
</div>
