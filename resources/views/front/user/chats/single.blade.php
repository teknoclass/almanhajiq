@extends('front.layouts.index', ['is_active'=>'contact','sub_title'=>'تواصل معنا', ])

@section('content')
    @push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/perfect-scrollbar.min.css') }}"/>
    <style>
        .text-sm {
            font-size: 12px;
            margin-left: 30px;
            margin-right: 30px;
            direction: ltr;
        }
    </style>
    @endpush

	<section class="section-padding wow fadeInUp section-faq" data-wow-delay="0.1s">
		<div class="container">
			<div class="row align-items-center">
                <h2 class="font-bold mb-4 text-center">{{ __('chat') }}</h2>
                <div class="message-header d-flex align-items-center">
                    <div class="symbol symbol-40"><img class="rounded-circle" src="{{ imageUrl(@$chat->otherUser()->image) }}" alt="{{ @$chat->otherUser()->name }}" loading="lazy"/>
                    </div>
                    <h5 class="font-medium text-white ms-3">{{ @$chat->otherUser()->name }}</h5>
                </div>
                <div class="scroll message-body ps ps__rtl ps--active-y" style="height: 300px">
                    <div class="message-list">
                        @if (isset($chat))
                            @php($chat_messages = $chat->messages()->select('chat_messages.*' , DB::raw('DATE(created_at) as datee') )->get()->groupBy('datee'))
                            @foreach ($chat_messages as $date => $messages)
                                <div class="text-sm text-center">{{ date_create($date)->format('D,d M Y') }}</div>
                                @foreach ($messages as $message)
                                    <div class="message-item {{ (@$message->sender_id == auth()->id()) ? 'sender' : 'receiver' }}">
                                        <div class="message-image symbol symbol-40"><img class="rounded-circle" src="{{ imageUrl(@$message->sender->image) }}" alt="" loading="lazy"/></div>
                                        <div class="message-content">{{ @$message->body }}</div>
                                        <div class="text-sm">{{ @$message->created_at->format('h:i A') }}</div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="message-footer">
                    <form id="chatForm" action="{{ route('user.chat.send.message') }}" class="d-flex align-items-center" method="POST">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ @$chat->id }}">
                        <input class="form-control" id="messageBody" name="body" placeholder="الرسالة">
                        {{-- <label class="input-image-preview message-file-attachment d-block px-3 pointer rounded-pill" for="image">
                            <input id="image" type="file" accept="image/png, image/gif, image/jpeg" name="attachment"/><span><i class="fa-light fa-paperclip"></i></span>
                        </label> --}}
                        <button class="btn p-1 text-white" type="submit" id="chat_save_btn"><i class="fa-solid fa-paper-plane-top"></i></button>
                    </form>
                </div>
			</div>
		</div>
	</section>

@endsection

@push('front_js')
<script src="{{ asset('assets/front/js/post.js') }}"></script>

<script src="{{ asset('assets/front/js/perfect-scrollbar.min.js') }}"></script>
<script>
    /*------------------------------------
        PerfectScrollbar
    --------------------------------------*/
    $('.scroll').each(function () {
        const ps = new PerfectScrollbar($(this)[0]);
    });

    $(document).ready(function() {
        var messageContainer = $('.message-body');

        // Scroll to the last message
        messageContainer.scrollTop(messageContainer[0].scrollHeight);
    });
</script>

{{-- FireBase --}}
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script>
    const messaging = firebase.messaging();

    messaging.onMessage((payload)=>{

        messageBody = `
            <div class="message-item receiver">
                <div class="message-image symbol symbol-40"><img class="rounded-circle" src="${payload.data.sender_image}" alt="" loading="lazy"/></div>
                <div class="message-content">${payload.data.message}</div>
            </div>
        `;

        $('.message-list').append(messageBody);
        var messageContainer = $('.message-body');
        messageContainer.scrollTop(messageContainer[0].scrollHeight);
    });
</script>

@endpush
