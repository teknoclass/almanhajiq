@extends('front.layouts.index', ['is_active' => 'show_mettings', 'sub_title' => __('show_mettings')])
@section('content')
	<section class="section wow fadeInUp" data-wow-delay="0.1s">

		<div class="bg-white p-4 rounded-4 border-primary">
			<div class="row">

				<div class="col-12">
					<h2 class="font-medium text-center mb-3">
						{{ __('show_mettings') }}
					</h2>
				</div>

				<div class="col-12">
					<iframe src="{{ @$url }}" width="100%" height="500"
						allow="fullscreen;microphone;camera;display-capture;web-share">
					</iframe>
                    {{-- allow="camera;microphone;fullscreen"> --}}

				</div>
			</div>
		</div>
	</section>

	@push('front_js')
	@endpush
@endsection
