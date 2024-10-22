
<div class="row">
    <div class="col-xl-3 pe-2 col-md-4 col-sm-6">
		<h3>{{ __('name') }}</h3>
		<form class="form-search-by-title">
			<div class="form-group select-multiple select-users">
				<input type="text" id="search_by_title" name="title" multiple="" class="form-control" value="{{ request('title') }}"
					placeholder="{{ __('search') }}">
			</div>
		</form>
	</div>


	{{-- Course Type --}}
    @php
        $course_types = config('constants.course_types');
    @endphp
    <div class="col-xl-3 pe-2 col-md-4 col-sm-6">
        <h3>{{ __('course_type') }}</h3>
        <div class="form-group select-multiple select-users">
            <select class="selectpicker filter-courses course_type-select" multiple="" name="course_type" title="{{ __('search') }}"
                data-size="5">
                @foreach ($course_types as $course_type)
                    <option value="{{ $course_type['key'] }}"
                        {{ request('course_type') == $course_type['key'] ? 'selected' : '' }}>
                        {{ __('course_types.' . $course_type['key']) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

	{{-- Price Type --}}
    @php
        $price_types = config('constants.price_types');
    @endphp
    <div class="col-xl-3 pe-2 col-md-4 col-sm-6">
        <h3>{{ __('price') }}</h3>
        <div class="form-group  select-multiple select-users">
            <select class="selectpicker filter-courses price_type-select" multiple="" name="price_type" title="{{ __('search') }}"
                data-size="5">
                @foreach ($price_types as $price_type)
                    <option value="{{ $price_type['key'] }}"
                        {{ request('price_type') == $price_type['key'] ? 'selected' : '' }}>
                        {{ __('price_types.' . $price_type['key']) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

	{{-- Materials --}}
	@if (@$materials && @$materials->isNotEmpty())

		@php
			$selected_materials = [];
			try {
			    if (request('material_ids')) {
			        $selected_materials = json_decode(request('material_ids'));
			    }
			} catch (Exception $e) {
			}
		@endphp
		<div class="col-xl-3 pe-2 col-md-4 col-sm-6">
			<h3>{{ __('materials') }}</h3>
			<div class="form-group select-multiple select-users">
				<select class="selectpicker filter-courses material-select" name="material_id" multiple="" title="{{ __('search') }}"
					data-size="5">
					@foreach ($materials as $material)
						<option value="{{ @$material->value }}" {{ in_array($material->value, $selected_materials) ? 'selected' : '' }}
							data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$material->name }}&lt;/span&gt;">
						</option>
					@endforeach
				</select>
			</div>
		</div>
	@endif

	{{-- Languages --}}
	@if (@$languages && @$languages->isNotEmpty())

		@php
			$selected_languages = [];
			try {
			    if (request('language_ids')) {
			        $selected_languages = json_decode(request('language_ids'));
			    }
			} catch (Exception $e) {
			}
		@endphp
		<div class="col-xl-3 pe-2 col-md-4 col-sm-6">
			<h3>{{ __('languages') }}</h3>
			<div class="form-group select-multiple select-users">
				<select class="selectpicker filter-courses language-select" name="language_id" multiple="" title="{{ __('search') }}"
					data-size="5">
					@foreach ($languages as $language)
						<option value="{{ @$language->value }}" {{ in_array($language->value, $selected_languages) ? 'selected' : '' }}
							data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$language->name }}&lt;/span&gt;">
						</option>
					@endforeach
				</select>
			</div>
		</div>
	@endif

	{{-- levels --}}
	@if (@$levels && @$levels->isNotEmpty())

		@php
			$selected_levels = [];
			try {
			    if (request('level_ids')) {
			        $selected_levels = json_decode(request('level_ids'));
			    }
			} catch (Exception $e) {
			}
		@endphp
		<div class="col-xl-3 pe-2 col-md-4 col-sm-6">
			<h3>{{ __('course_levels') }}</h3>
			<div class="form-group select-multiple select-users">
				<select class="selectpicker filter-courses level-select" name="level_id" multiple="" title="{{ __('search') }}"
					data-size="5">
					@foreach ($levels as $level)
						<option value="{{ @$level->value }}" {{ in_array($level->value, $selected_levels) ? 'selected' : '' }}
							data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$level->name }}&lt;/span&gt;">
						</option>
					@endforeach
				</select>
			</div>
		</div>
	@endif

	{{-- age_categories --}}
	@if (@$age_categories && @$age_categories->isNotEmpty())

		@php
			$selected_age_ranges = [];
			try {
			    if (request('age_range_ids')) {
			        $selected_age_ranges = json_decode(request('age_range_ids'));
			    }
			} catch (Exception $e) {
			}
		@endphp
		<div class="col-xl-3 pe-2 col-md-4 col-sm-6">
			<h3>{{ __('age_categories') }}</h3>
			<div class="form-group select-multiple select-users">
				<select class="selectpicker filter-courses age_range-select" name="age_range_id" multiple="" title="{{ __('search') }}"
					data-size="5">
					@foreach ($age_categories as $age_range)
						<option value="{{ @$age_range->value }}" {{ in_array($age_range->value, $selected_age_ranges) ? 'selected' : '' }}
							data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$age_range->name }}&lt;/span&gt;">
						</option>
					@endforeach
				</select>
			</div>
		</div>
	@endif

    @php
        $status_types = config('constants.course_status');

        $selected_statuses = [];
        try {
            if (request('statuses')) {
                $selected_statuses = json_decode(request('statuses'));
            }
        } catch (Exception $e) {
        }
    @endphp
    <div class="col-xl-3 pe-2 col-md-4 col-sm-6">
        <h3>{{ __('status') }}</h3>
        <div class="form-group select-multiple select-users">
            <select class="selectpicker filter-courses status-select" name="status" multiple="" title="{{ __('search') }}"
                data-size="5">
                @foreach ($status_types as $status)
                    <option value="{{ @$status['key'] }}" {{ in_array($status['key'], $selected_statuses) ? 'selected' : '' }}
                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ __(@$status['key']) }}&lt;/span&gt;">
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group text-center mt-2">
        <button class="btn btn-primary clear-filter" data-url="{{ route('user.lecturer.my_courses.index') }}">
            {{ __('clear_filter') }}
        </button>
    </div>
</div>

@push('front_js')

<script>
    $(document).on('submit', '.form-search-by-title', function(e) {
        e.preventDefault();
        filterCourses();
    });

    $(document).on('change', '.filter-courses', function() {
        filterCourses();
    });

    function filterCourses() {

        window.filter = getAttrFilter();
        var url = "";
        getData(getUrlWithSearchParm(url, filter, false))

    }

    function getAttrFilter() {
        var search_by_title = $('#search_by_title').val();
        var price_type = $("select.price_type-select option:checked").val();
        var course_type = $("select.course_type-select option:checked").val();

        var material_ids = []
        var selected_categories = document.querySelectorAll('select.material-select option:checked');
        for (var i = 0; i < selected_categories.length; i++) {
            material_ids.push(selected_categories[i].value)
        }

        var language_ids = []
        var selected_languages = document.querySelectorAll('select.language-select option:checked');
        for (var i = 0; i < selected_languages.length; i++) {
            language_ids.push(selected_languages[i].value)
        }

        var level_ids = []
        var selected_levels = document.querySelectorAll('select.level-select option:checked');
        for (var i = 0; i < selected_levels.length; i++) {
            level_ids.push(selected_levels[i].value)
        }

        var age_range_ids = []
        var selected_age_ranges = document.querySelectorAll('select.age_range-select option:checked');
        for (var i = 0; i < selected_age_ranges.length; i++) {
            age_range_ids.push(selected_age_ranges[i].value)
        }

        var statuses = []
        var selected_statuses = document.querySelectorAll('select.status-select option:checked');
        for (var i = 0; i < selected_statuses.length; i++) {
            statuses.push(selected_statuses[i].value)
        }

        var filter = {
            "title": checkisNotNull(search_by_title) ? search_by_title : '',
            "price_type": checkisNotNull(price_type) ? price_type : '',
            "course_type": checkisNotNull(course_type) ? course_type : '',
            "material_ids": material_ids.length > 0 ? JSON.stringify(material_ids) : [],
            "language_ids": language_ids.length > 0 ? JSON.stringify(language_ids) : [],
            "level_ids": level_ids.length > 0 ? JSON.stringify(level_ids) : [],
            "age_range_ids": age_range_ids.length > 0 ? JSON.stringify(age_range_ids) : [],
            "statuses": statuses.length > 0 ? JSON.stringify(statuses) : [],
        }

        return filter;
    }
</script>
@endpush
