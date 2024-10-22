@extends('front.user.lecturer.layout.index' )

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('courses'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('my_courses'),
		        'link' => route('user.lecturer.my_courses.index'),
		    ],

		];
	@endphp
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
			<!--begin::breadcrumb-->
			@include('front.user.lecturer.layout.includes.breadcrumb', ['breadcrumb_links' => $breadcrumb_links])
			<!--end::breadcrumb-->

			<!--begin::Content-->
			<div class="row g-5 gx-xxl-8 mb-4">
				<div class="bg-white p-4 rounded-4">
					<div class="row">
						<div class="col-12">
							<h2 class="font-medium text-start mb-3"> {{@$course->title}}  </h2>
                            @if($assignments)
                                @foreach ($assignments as $assignment)
                                     @include('front.user.lecturer.courses.my_courses.tasks.partials.all')
                                @endforeach
                                <nav>
                                    {{@$assignments->links('vendor.pagination.custom')}}
                                </nav>
                            @else

                            @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_courses')])

                            @endif
						</div>


					</div>
				</div>
			</div>
            <!--end::Content-->
		</div>
	</section>
@endsection
