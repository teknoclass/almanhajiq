@extends('front.layouts.index', ['is_active' => 'chats', 'sub_title' => __('my_chats')])

@section('content')
	@php
        $is_active = 'my_chats';

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => route('user.home.index'),
		    ],
		    [
		        'title' => __('my_chats'),
		        'link' => '#',
		    ],
		];

	@endphp
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            @if (checkUser('student'))
                @php $is_active = 'my_chats'; @endphp
			    @include('front.user.components.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
            @else
                @include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
            @endif

			<div class="row">
				<div class="col-12">
                    <div class="bg-white rounded p-4">
                        <div class="all-data">
                            @include('front.user.chats.partials.all')
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</section>
	<!-- end:: section -->

    @push('front_js')
    <script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const messaging = firebase.messaging();


        function retreiveToken(){
            $('#load').show();

            messaging.getToken({ vapidKey: '{{ env("FIREBASE_VAPID_KEY") }}' }).then((currentToken) => {
                if (currentToken) {

                    $.ajax({
                        type:'POST',
                        url:"{{ route('user.chat.update.token') }}",
                        data:{device_token:currentToken},
                        success:function(data){
                            console.log(currentToken);
                        }
                    });
                 //   console.log(currentToken);
                } else {
                    alert('Something went wrong!');
                }
            }).catch((err) => {
                console.log(err.message);
            });

            $('#load').hide();
        }

        $(document).ready(function() {
            retreiveToken();
        });
    </script>
    @endpush
@endsection
