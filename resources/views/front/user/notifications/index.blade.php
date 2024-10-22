@extends('front.layouts.index', ['is_active' => 'notifications', 'sub_title' => 'الاشعارات'])

@section('content')
	<!-- start:: section -->
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<div class="row mb-4 justify-content-between align-items-center">
				<div class="col-lg-9">
					<ol class="breadcrumb mb-lg-0">
						<li class="breadcrumb-item"><a href="#">{{ __('home') }}</a></li>
						<li class="breadcrumb-item active">{{ __('all_notifications') }}</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="bg-white rounded p-4">
                        <div class="all-data">
                        @include('front.user.notifications.partials.all')
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end:: section -->
@endsection

@push('front_js')
<script src="{{asset('assets/front/js/ajax_pagination.js')}}?v={{getVersionAssets()}}"></script>
@endpush
