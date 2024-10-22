@if(count($notifications)>0)
    @foreach($notifications as $notification)
    <li class="cursor-pointer">
        <div class="widget_item-notification d-flex align-items-center border-bottom p-3" onclick="read_notification({{ @$notification->id }})" >
            <div class="widget_item-image col-auto symbol symbol-60">
                <img class="rounded-circle" src="{{@$notification->image!='' ? imageUrl(@$notification->image) : imageUrl(@$settings->valueOf('logo'), '65x65') }}" alt="{{@$notification->title}}" loading="lazy"/>
            </div>
            <div class="widget_item-content col px-3">
                <h6 class="font-medium mb-2">{{@$notification->text}}</h6>
                <h6 class="text-muted"><i class="fa-regular fa-clock me-2"></i>{{diffForHumans(@$notification->created_at)}}</h6>
            </div>
        </div>
    </li>
    @endforeach
@else
    <a href="#"
    class="widget_item-notification d-flex align-items-center border-bottom p-3 ">
    <div class="widget_item-image col-auto">
        <img src="{{ imageUrl(@$settings->valueOf('logo'), '65x65') }}" alt="" loading="lazy">
    </div>
    <div class="widget_item-content col px-3">
        <h4 class="font-medium mb-2">
            {{__('message.no_notifications')}}
        </h4>
    </div>
    </a>
@endif
