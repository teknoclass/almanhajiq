<div class="row mt-5 mb-4 pt-4">
	<div class="container">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a href="#reviews" role="tab" data-toggle="tab" class="tabTitle nav-link active"> التقييمات
					({{ @$lecturer->getRatingCount() }}) </a>
			</li>
			<li class="nav-item">
				<a href="#courses" role="tab" data-toggle="tab" class="tabTitle nav-link"> الدورات
					({{ $lecturer->lecturer_courses_count }}) </a>
			</li>
			<li class="nav-item">
				<a href="#experience" role="tab" data-toggle="tab" class="tabTitle nav-link"> الخبرات </a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" role="tabpanel" id="reviews">

				<div class="col-12">
					<div class="data-rating d-flex align-items-center mb-3 mt-4">
						<h2 class="font-bold">التقييمات ({{ @$lecturer->getRatingCount() }}) </h2> <span class="d-flex pr-3"
							data-rating="{{ @$lecturer->getRating() }}"> <i class="far fa-star"></i><i class="far fa-star"></i><i
								class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i></span><span
							class="pt-1">({{ @$lecturer->getRating() }})</span>
					</div>
				</div>

				<div class="row">
					<div class="row all-reviews">
						@if ($lecturer->reviews_count > 0)
							@include('front.lecturer_profile.partials.reviews')
						@else
							@include('front.components.no_found_data', ['no_found_data_text' => __('no_found_rating')])
						@endif
					</div>
					{{-- <div class="col-12 view-more-button" @if ($lecturer->reviews_count < 7) style="display: none;" @endif>
						<div class="text-center">
							<button type="button" class="btn btn-primary view-more-data"
								data-url="{{ route('lecturerProfile.getMoreReviews', ['id' => request('id')]) }}" data-section="all-reviews"
								data-grids="grid-reviews">
								{{ __('view_more') }}
							</button>
						</div>
					</div> --}}

				</div>
			</div>


			<div class="tab-pane" role="tabpanel" id="courses">
				<div class="row">
					<div class="col-12">
						<div class="row mb-4 mt-4 justify-content-between align-items-center">
							<div class="col-lg-9">
								<h2 class="font-bold">الدورات ({{ $lecturer->lecturer_courses_count }})</h2>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="row all-courses">
							@if ($lecturer->lecturer_courses_count > 0)
								@include('front.lecturer_profile.partials.courses')
							@else
								@include('front.components.no_found_data', ['no_found_data_text' => __('no_found_courses')])
							@endif
						</div>
					</div>
					{{-- <div class="row">
						<div class="col-12 view-more-button" @if ($lecturer->lecturer_courses_count < 7) style="display: none;" @endif>
							<div class="text-center">
								<button type="button" class="btn btn-primary view-more-data"
									data-url="{{ route('lecturerProfile.getMoreCourses', ['id' => request('id')]) }}" data-section="all-courses"
									data-grids="grid-courses">
									{{ __('view_more') }}
								</button>
							</div>
						</div>
					</div> --}}
				</div>
			</div>

			<div class="tab-pane" role="tabpanel" id="experience">
				<div class="col-12 mb-4 mt-4">
					<h2 class="font-bold"> الخبرات </h2>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="table-container">
							<table class="table table-cart mb-3">
								<thead>
									<tr>
										<td width="25%">التاريخ</td>
										<td width="20%">الخبرة</td>
										<td>الوصف</td>
									</tr>
								</thead>
								<tbody>
								@foreach ($lecturerExpertise as $expertise)
									<tr>
										<td data-title="التاريخ"><span><i class="fa-regular fa-clock me-2"></i>
                                            {{ @$expertise->start_date ? changeDateFormate(@$expertise->start_date) : '' }} - {{ @$expertise->end_date ? changeDateFormate(@$expertise->end_date) : '' }}</span></td>
										<td class="text-success font-medium" data-title=""> {{ @$expertise->name }}</td>
										<td data-title="">{{ @$expertise->description }}</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
