
@if(count($notifications)>0)
    <div class="mb-4">
        @foreach($notifications as $notification)

        @include('front.user.notifications.partials.notification')

        @endforeach
    </div>
    <nav >
        {{@$notifications->links('vendor.pagination.custom')}}
    </nav>

@else
    <div class="mb-4">
    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_notifications')])
    </div>
@endif

