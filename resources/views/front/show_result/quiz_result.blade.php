@extends('front.layouts.index')

@section('content')
	<!-- start:: section -->
	<section class="section bg-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 order-1 order-lg-0">
					<div class="text-center"> <img src="{{ imageUrl(@$settings->valueOf('show_result_img')) }}" alt="" loading="lazy"/></div>
				</div>
				<div class="col-lg-6">
					<div class="row">
                        <h2 class="home-title mb-4 font-bold text-center">{{ __("welcome") }}</h2>
                        <h3 class="home-text mb-4 pb-lg-2 text-center"> {{ __("happy_to_share_quiz_result") }} <br> <strong class="text-primary">{{ @$quiz->user->name }}</strong></h3>
                        <div class="bg-white rounded-2 p-3 p-lg-4 ">
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <div class="col-3 col-lg-6 p-2">
                                    <h4 class="font-medium text-primary-3 home-text ">{{ __('course') }}</h4>
                                </div>
                                <div class="col-3 col-lg-6 p-2">
                                    <h4 class="font-medium text-primary-3 home-text ">{{ __('quiz') }}</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <div class="col-3 col-lg-6 p-2">
                                    <h3 class="font-medium text-primary"><strong>{{ @$quiz->course->title }}</strong></h3>
                                </div>
                                <div class="col-3 col-lg-6 p-2">
                                    <h3 class="font-medium text-primary"><strong>{{ @$quiz->quiz->title }}</strong></h3>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white rounded-2 p-2 p-lg-4 ">
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <div class="col-12 col-lg-12 p-2">
                                    <h5 class="font-medium text-primary-3 home-text ">{{ __('grad') }}</h5>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center text-center">
                                <div class="col-12 col-lg-12 p-2">
                                    <h4 class="font-medium text-primary"><strong>{{ @$quiz->user_grade }}</strong></h4>
                                </div>
                            </div>
                        </div>
                        <h3 class="home-text mb-4 pb-lg-2 text-center">{{ __("proud_to_see_commitment") }} {{ @$quiz->user->name }}</h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end:: section -->
@endsection
