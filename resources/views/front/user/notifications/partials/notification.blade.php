    <a class="widget_item-notification d-flex align-items-center border-bottom pb-3 mb-3"
        href="{{@$notification->getAction()}}">
        <div class="widget_item-image col-auto symbol symbol-60 symbol symbol-60">
            <img class="rounded-circle"
                src="{{@$notification->image!='' ? imageUrl(@$notification->image) : imageUrl(@$settings->valueOf('logo'), '65x65') }}" alt="{{@$notification->title}}" loading="lazy"/>
        </div>
        <div class="widget_item-content col px-3">
            <h4 class="font-medium mb-2">{{@$notification->title}}</h4>
            <h5 class="text-muted">{{@$notification->text}}</h5>
        </div>
        <div class="widget_item-date col-auto me-auto">
            <h6 class="text-muted"><i class="fa-regular fa-clock ms-2"></i>  {{diffForHumans(@$notification->created_at)}}</h6>
        </div>
    </a>
