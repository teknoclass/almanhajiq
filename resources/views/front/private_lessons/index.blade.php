@extends('front.layouts.index', ['is_active' => 'private_lessons', 'sub_title' => __('private_lessons')])

@section('content')
    <section id="privet-lesson" class="section-padding wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
            <div class="row mb-4">
                <div class="col-12 mb-4">
                    <h2 class="font-bold mb-1 mb-lg-0">{{ __('private_lessons') }}</h2>
                    <!--<h3 class=" mb-2 mb-lg-0">{{ __('choose_from_hundreds_of_teachers') }}</h3>-->
                </div>
            </div>
            {{-- Filter goes here --}}
			<div class="row mb-3mt-3 pb-2 mt-2">
                @include('front.private_lessons.partials.filter')
			</div>

            <div class="row all-data">
                @include('front.private_lessons.partials.all')
            </div>

		</div>
	</section>

	@push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
	@endpush
@endsection
