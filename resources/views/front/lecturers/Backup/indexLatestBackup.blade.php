@extends('front.layouts.index', ['is_active' => 'teachers', 'sub_title' => 'المدربين'])

@section('content')
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			<div class="row ">
				<div class="col-lg-3 mb-4 mb-lg-0 filter-form-body">
					<div class="filter side-nav">
						<div class="d-flex d-lg-none justify-content-between align-items-center mb-3">
							<h3 class="font-medium">
								{{ __('search_by_courses') }}
							</h3>
							<button class="btn p-1 toggle-side-nav"><i class="fa-regular fa-xmark fa-lg"></i></button>
						</div>

						<div class="filter-head">
							<form class="form-search-by-title">
								<div class="input-icon right">
									<input class="form-control border-0 rounded_20" id="search_by_title" name="name"
										value="{{ request('name') }}" type="text" placeholder="{{ __('search') }}">
									<div class="">
										<button class="bg-transparent icon" type="submit">
											<i class="fa-regular fa-magnifying-glass fa-lg"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
						<div class="filter-body">
							<div class="mb-4">
								<div class="form-group">
									<h6 class="font-medium mb-2">{{ __('gender') }}</h6>
									<div class="d-flex align-items-center checkUser">
										@php
											$gender_type = config('constants.gender_type');
										@endphp
										@foreach ($gender_type as $gender)
											<label class="m-radio mb-0 me-5" for="item-gender-{{ $gender['key'] }}">
												<input class="checkAllUsers filter-courses" type="radio" name="gender"
													id="item-gender-{{ $gender['key'] }}" value="{{ $gender['key'] }}"
													{{ request('gender') == $gender['key'] ? 'checked' : '' }} /><span class="checkmark"></span>
												{{ __($gender['key']) }}
											</label>
										@endforeach
									</div>
								</div>
							</div>

                            @if (@$settings->valueOf('offline_private_lessons'))
                                <div class="mb-4">
                                    <div class="form-group">
                                        <h6 class="font-medium mb-2">نوع اللقاء</h6>
                                        <div class="align-items-center checkUser">
                                            @php
                                                $meeting_type = config('constants.meeting_type');
                                            @endphp
                                            @foreach ($meeting_type as $meeting)
                                                <label class="m-radio mb-0 me-5" for="item-meeting-{{ $meeting['key'] }}">
                                                    <input class="checkAllUsers filter-courses" type="radio" name="meeting"
                                                        id="item-meeting-{{ $meeting['key'] }}" value="{{ $meeting['key'] }}"
                                                        {{ request('meeting') == $meeting['key'] ? 'checked' : '' }} /><span class="checkmark"></span>
                                                    {{ __($meeting['key']) }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

							<div class="mb-4">
								<div class="form-group">
									<h6 class="font-medium mb-2">عمر المدرب</h6>
									<div class="align-items-center checkUser">
										@foreach ($agesRange as $age)
											<label class="m-radio mb-0 me-5" for="item-ageSelected-{{ $age->id }}">
												<input class="checkAllUsers filter-courses" type="radio" name="ageSelected"
													id="item-ageSelected-{{ $age->id }}" value="{{ $age->from }}-{{ $age->to }}"
													{{ request('ageSelected') == $age->id ? 'checked' : '' }} /><span
													class="checkmark"></span>{{ $age->from }}-{{ $age->to }}
											</label>
										@endforeach
									</div>
								</div>
							</div>


							<div class="d-flex ">
								<button class="btn btn-primary clear-filter" data-url="{{ route('lecturers.index') }}">
									{{ __('clear_filter') }}
								</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="row all-data">
						@include('front.lecturers.partials.all')

					</div>

				</div>
			</div>

		</div>
	</section>

	@push('front_js')
		<script src="{{ asset('assets/front/js/ajax_pagination.js') }}?v={{ getVersionAssets() }}"></script>
		<script>
			$(document).ready(function() {
				window.filter = getAttrFilter();
			});
			$(document).on('submit', '.form-search-by-title', function(e) {
				e.preventDefault();
				filterLecturers();
			});

			$(document).on('change', '.filter-courses', function() {
				filterLecturers();
			});

			function filterLecturers() {

				window.filter = getAttrFilter();
				var url = "";
				getData(getUrlWithSearchParm(url, filter, false))

			}

			function getAttrFilter() {
				var search_by_title = $('#search_by_title').val();
				var gender = $("input[name='gender']:checked").val();
				var meeting = $("input[name='meeting']:checked").val();
				var ageSelected = $("input[name='ageSelected']:checked").val();

				var filter = {
					"name": checkisNotNull(search_by_title) ? search_by_title : '',
					"gender": checkisNotNull(gender) ? gender : '',
					"meeting": checkisNotNull(meeting) ? meeting : '',
					"ageSelected": checkisNotNull(ageSelected) ? ageSelected : '',
				}

				return filter;
			}
		</script>
	@endpush
@endsection
