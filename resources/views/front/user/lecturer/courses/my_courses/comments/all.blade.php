@extends('front.user.lecturer.layout.index' )

@section('content')
	@php
		$breadcrumb_links = [
		    [
		        'title' => __('courses'),
		        'link' => '#',
		    ],
		    [
		        'title' => __('comments'),
		        'link' => '#',
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
							<h2 class="font-medium text-start mb-3">{{ __('comments') }}</h2>
                            <div class="row">
                              <div class="col-12">
                                @if(count($comments)>0)
                                    <table class="table table-cart mb-3">
                                    <thead>
                                        <tr>
                                        <td>{{ __('comment') }}</td>
                                        <td>{{ __('course_name') }}</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($comments as $comment)
                                            @include('front.user.lecturer.courses.my_courses.comments.partials.comment')
                                        @endforeach
                                    </tbody>
                                    </table>
                                        <nav>
                                            {{@$comments->links('vendor.pagination.custom')}}
                                        </nav>
                                    @else
                                       @include('front.components.no_found_data',['no_found_data_text'=>__('no_found_comments')])

                                    @endif
                              </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
            <!--end::Content-->
		</div>
    </section>
    @push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
    @endpush
@endsection
