
<div class="col-lg-4">
    <div class="widget_item-student bg-white mb-3">
        <a href="{{ $widget['route'] }}">
            <div class="widget_item-content d-flex align-items-center">
                <div class="widget_item-icon me-3 text-white"><i class="fa-solid {{ $widget['icon'] }}"></i></div>
                <h5 class="font-medium">{{ $widget['title'] }}</h5>
                <div class="widget_item-number font-medium ms-auto">{{ $widget['count'] }}</div>
            </div>
        </a>
    </div>
</div>
