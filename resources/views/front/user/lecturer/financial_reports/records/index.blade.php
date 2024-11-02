@extends('front.user.lecturer.layout.index')
@section('content')
	@php

		$statistics = [
		    [
		        'title' => __('total_balance'),
		        'currency' => __('currency'),
		        'icon' => "iqd",
		        'value' => number_format(@$available_balance, 2),
                'type' => 'financial-record',
		    ],
		    /*[
		        'title' => __('suspended_balance'),
		        'currency' => __('currency'),
		        'icon' => "iqd",
		        'value' => number_format(@$suspended_balance, 2),
                'type' => 'financial-record',
		    ],
		    [
		        'title' => __('retractable'),
		        'currency' => __('currency'),
		        'icon' => "iqd",
		        'value' => number_format(@$retractable_balance, 2),
                'type' => 'financial-record',
		    ],*/
		   /* [
		        'title' => __('system_commission'),
		        'currency' => "%",
		        'icon' => "iqd",
		        'value' => getSystemCommission(auth()->id()) == '' ? 0 : getSystemCommission(auth()->id()),
		    ],*/
		];

		$breadcrumb_links = [
		    [
		        'title' => __("financial_reports"),
		        'link' => '#',
		    ],
		    [
		        'title' => __("lecturer_earnings"),
		        'link' => '#',
		    ],
		];

	@endphp


	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<!--begin::breadcrumb-->
			@include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
			<!--end::breadcrumb-->

			<div class="row gy-5 g-lg-3 mb-4">
                @foreach ($statistics as $i => $statistic)
                @include('front.components.lecturer_statistic_card', ['statistic' => $statistic, 'i' =>$i])
                @endforeach
			</div>
			<div class="row">
				<div class="col-12">
					<div class="all-data">
						@include('front.user.lecturer.financial_reports.records.partials.all')
					</div>
				</div>
			</div>
		</div>
	</section>

	@push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
		<script src="{{ asset('assets/front/js/post.js') }}?v={{ getVersionAssets() }}"></script>
	@endpush
@endsection
