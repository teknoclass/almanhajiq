@extends('front.layouts.index', ['is_active'=>'faqs','sub_title'=> __('faqs'), ])

@section('content')
	<!-- start:: section -->
	<section class="section wow fadeInUp section-faq" data-wow-delay="0.1s">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-5 mb-4 col-10 m-auto mb-lg-0"><img src="{{ asset('assets/front/images/faq.png') }}" alt="" loading="lazy"/></div>
				<div class="col-lg-7">
                    <div class="all-data">
                        @include('front.faqs.partials.all')
                    </div>
				</div>
			</div>
		</div>
	</section>
	<!-- end:: section -->
	@push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
	@endpush
@endsection
