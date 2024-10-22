<div class="wow fadeInUp" id="accordion" data-wow-delay="0.2s">
    @if(isset($chats) && count(@$chats)>0)

        <div class="mb-4">
        @foreach($chats as $chat)

        @include('front.user.chats.partials.chat')

        @endforeach
        </div>

        <nav>
            {{@$chats->links('vendor.pagination.custom')}}
        </nav>
    @else

    @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_chats')])

    @endif
</div>


