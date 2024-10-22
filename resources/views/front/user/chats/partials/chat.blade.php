@if (@$chat->otherUser())
<a class="widget_item-notification d-flex align-items-center border-bottom pb-3 mb-3" href="{{ route('user.chat.open.chat', @$chat->otherUser()->id) }}">
	<div class="widget_item-image col-auto symbol symbol-60 symbol symbol-60">
        <img class="rounded-circle" src="{{ imageUrl(@$chat->otherUser()->image) }}" alt="" loading="lazy"/></div>
	<div class="widget_item-content col px-3">
		<h4 class="font-medium mb-2">{{ @$chat->otherUser()->name }}</h4>
		<h5 class="text-muted">{{ @$chat->lastMessage()->body }}</h5>
	</div>
	<div class="widget_item-date col-auto me-auto">
        @php
            (@$chat->lastMessage() == null) ? $lastMessageDate = @$chat->created_at : $lastMessageDate = @$chat->lastMessage()->created_at;
        @endphp
		<h6 class="text-muted"><i class="fa-regular fa-clock ms-2"></i> {{ diffForHumans(@$lastMessageDate) }}</h6>
	</div>
</a>
@endif
