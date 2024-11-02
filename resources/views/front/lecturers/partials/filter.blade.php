<div class="filter">
    <div class="filter-head pt-5">
        <div class="container">
            <h1 class="text-white pb-5 fw-bold text-center">{{ __('lecturers') }}</h1>
            <div class="gap-3 d-flex align-items-center pt-4 flex-column flex-lg-row justify-content-center">
                <div id="event-box" class="d-flex align-items-center gap-3">
                    <div class="d-flex">
                        <button onclick="filterHeadShow()" id="search-btn-event">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="9.90039" cy="9.8999" r="9" stroke="#001D1E" stroke-width="1.2" />
                                <path d="M16.5 16.5L22.864 22.864" stroke="#001D1E" stroke-width="1.2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <form class="form-search-by-title">
                            <div class="search-box border">
                                <input class="flex-fill group-date" type="text" id="search_by_title"
                                    placeholder="{{ __('search') }}" name="title" value="{{ request('title') }}"
                                    placeholder="{{ __('search') }}">
                                <button class="search-btn">{{ __('search1') }}</button>
                            </div>
                        </form>
                    </div>
                    <button onclick="materialsModal()" id="close-filter-modal">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21.6299 14.75C21.6299 15.64 21.3799 16.48 20.9399 17.2C20.1199 18.58 18.6099 19.5 16.8799 19.5C15.1499 19.5 13.6399 18.57 12.8199 17.2C12.3799 16.49 12.1299 15.64 12.1299 14.75C12.1299 12.13 14.2599 10 16.8799 10C19.4999 10 21.6299 12.13 21.6299 14.75Z"
                                stroke="#001D1E" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M18.6604 14.73H15.1104" stroke="#001D1E" stroke-miterlimit="10"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16.8799 13V16.55" stroke="#001D1E" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M20.6905 4.02002V6.23999C20.6905 7.04999 20.1805 8.06001 19.6805 8.57001L17.9205 10.12C17.5905 10.04 17.2405 10 16.8805 10C14.2605 10 12.1305 12.13 12.1305 14.75C12.1305 15.64 12.3805 16.48 12.8205 17.2C13.1905 17.82 13.7005 18.35 14.3205 18.73V19.07C14.3205 19.68 13.9205 20.49 13.4105 20.79L12.0005 21.7C10.6905 22.51 8.87054 21.6 8.87054 19.98V14.63C8.87054 13.92 8.46055 13.01 8.06055 12.51L4.22055 8.46997C3.72055 7.95997 3.31055 7.05001 3.31055 6.45001V4.12C3.31055 2.91 4.22055 2 5.33055 2H18.6705C19.7805 2 20.6905 2.91002 20.6905 4.02002Z"
                                stroke="#001D1E" stroke-miterlimit="10" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <div class="flex-fill d-flex gap-3 align-items-center flex-wrap-reverse justify-content-center">
                    <div class="flex-fill" id="toggle-filter-box">
                        <ul class="category-link">
                            <li><a class="fs-5 clear-filter bg-transparent active"
                                    data-url="{{ route('lecturers.index') }}">{{ __('all_lecturers') }}</a></li>
                            @php
                                $genders = config('constants.gender_type');
                            @endphp
                            @foreach ($genders as $gender)
                                <li>
                                    <a>
                                        <input id="item-gender-{{ $gender['key'] }}" value="{{ $gender['key'] }}"
                                            class="filter-lecturers courseType-item-check" type="radio" name="gender"
                                            {{ request('gender') == $gender['key'] ? 'checked' : '' }}>
                                        <label class="rounded-0 fs-5" for="item-gender-{{ $gender['key'] }}">
                                            {{ $gender['key'] == 'male' ? __('males') : __('females') }}

                                        </label>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="time-create-event">
                        <a class="active">الجميع</a>
                        <a>الأكثر تقييماً</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="filter-body filter-modal  position-relative">
        <div class="p-3 mt-2">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-start">
                    <div id="genderAccordion" class="form-group col-6 col-lg-3 col-md-3">
                        <div class="bootstrap-select dropdown">
                            <h4 data-target="#genderContent"
                                class="mb-1 select-item prim-border d-flex justify-content-between align-items-center"
                                data-bs-toggle="dropdown" style="cursor: pointer;">
                                {{ __('gender') }}
                                <span>
                                    <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.00292969" y="0.261597" width="25" height="25"
                                            rx="12.5" fill="#D18CF3" />
                                        <g clip-path="url(#clip0_259_1484)">
                                            <path
                                                d="M12.492 17.0116C12.2618 17.0116 12.0581 16.9319 11.8811 16.7726L6.78105 11.6726C6.62168 11.4955 6.54199 11.2918 6.54199 11.0616C6.54199 10.8314 6.62168 10.6278 6.78105 10.4507C6.95814 10.2913 7.16178 10.2116 7.39199 10.2116C7.6222 10.2116 7.82585 10.2913 8.00293 10.4507L12.492 14.9663L16.9811 10.4507C17.1581 10.2913 17.3618 10.2116 17.592 10.2116C17.8222 10.2116 18.0258 10.2913 18.2029 10.4507C18.3623 10.6278 18.442 10.8314 18.442 11.0616C18.442 11.2918 18.3623 11.4955 18.2029 11.6726L13.1029 16.7726C12.9258 16.9319 12.7222 17.0116 12.492 17.0116Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_259_1484">
                                                <rect width="12.25" height="13.6" fill="white"
                                                    transform="matrix(1 0 0 -1 6.36719 19.5616)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                            </h4>
                            @php
                                $genders = config('constants.gender_type');
                            @endphp
                            <div id="genderContent" class="dropdown-menu px-2">
                                <ul class="tab-filter p-1 flex-column gap-2 bg-white">
                                    @foreach ($genders as $gender)
                                        <li>
                                            <input id="item-gender-{{ $gender['key'] }}"
                                                value="{{ $gender['key'] }}" class="filter-lecturers" type="radio"
                                                name="gender"
                                                {{ request('gender') == $gender['key'] ? 'checked' : '' }}>
                                            <label class="rounded-0" for="item-gender-{{ $gender['key'] }}">
                                                {{ __($gender['key']) }}

                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- <div id="typeAccordion" class="form-group">
                        <h4 data-target="#typeContent"
                            class="mb-2 title-cate  d-flex justify-content-between align-items-center"
                            data-toggle="collapse" style="cursor: pointer;">
                            {{ __('belongs_to_awael') }} <i class="fa-regular fa-chevron-down float-right"></i>
                        </h4>
                        <div id="typeContent" class="row collapse show">
                            <ul class="tab-filter">
                                <li>
                                    <input id="item-type-belong" value="yes" class="filter-lecturers" type="radio"
                                        name="lecturer_type" {{ request('lecturer_type') == 'yes' ? 'checked' : '' }}>
                                    <label for="item-type-belong">
                                        {{ __('yes') }}
                                    </label>
                                </li>
                                <li>
                                    <input id="item-type-donot-belong" value="no" class="filter-lecturers"
                                        type="radio" name="lecturer_type"
                                        {{ request('lecturer_type') == 'no' ? 'checked' : '' }}>
                                    <label for="item-type-donot-belong">
                                        {{ __('no') }}
                                    </label>
                                </li>

                            </ul>
                        </div>
                    </div> --}}

                    @if (@$materials && @$materials->isNotEmpty())
                        <div id="materialAccordion" class="form-group col-6 col-lg-3 col-md-3">
                            <div class="bootstrap-select dropdown">
                                <h4 class="mb-1 select-item prim-border d-flex justify-content-between align-items-center"
                                    data-bs-toggle="dropdown" aria-haspopup="listbox" style="cursor: pointer;">
                                    {{ __('materials') }}
                                    <span>
                                        <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="-0.00292969" y="0.261597" width="25" height="25"
                                                rx="12.5" fill="#D18CF3" />
                                            <g clip-path="url(#clip0_259_1484)">
                                                <path
                                                    d="M12.492 17.0116C12.2618 17.0116 12.0581 16.9319 11.8811 16.7726L6.78105 11.6726C6.62168 11.4955 6.54199 11.2918 6.54199 11.0616C6.54199 10.8314 6.62168 10.6278 6.78105 10.4507C6.95814 10.2913 7.16178 10.2116 7.39199 10.2116C7.6222 10.2116 7.82585 10.2913 8.00293 10.4507L12.492 14.9663L16.9811 10.4507C17.1581 10.2913 17.3618 10.2116 17.592 10.2116C17.8222 10.2116 18.0258 10.2913 18.2029 10.4507C18.3623 10.6278 18.442 10.8314 18.442 11.0616C18.442 11.2918 18.3623 11.4955 18.2029 11.6726L13.1029 16.7726C12.9258 16.9319 12.7222 17.0116 12.492 17.0116Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_259_1484">
                                                    <rect width="12.25" height="13.6" fill="white"
                                                        transform="matrix(1 0 0 -1 6.36719 19.5616)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </h4>
                                @php
                                    $selected_materials = [];
                                    try {
                                        if (request('material_ids')) {
                                            $selected_materials = json_decode(request('material_ids'));
                                        }
                                    } catch (Exception $e) {
                                    }
                                @endphp
                                <div class="dropdown-menu px-2">
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($materials as $material)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="mb-0 dropdown-item ps-1">
                                                    <input class="filter-lecturers form-check-input" type="checkbox"
                                                        name="material_id" value="{{ @$material->id }}"
                                                        {{ in_array($material->id, $selected_materials) ? 'checked' : '' }} />
                                                    <span>{{ @$material->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (@$languages && @$languages->isNotEmpty())
                        <div id="languageAccordion" class="form-group col-lg-3 col-md-3">
                            <div class="bootstrap-select dropdown">
                                <h4 data-target="#languageContent"
                                    class="mb-1 select-item prim-border d-flex justify-content-between align-items-center"
                                    data-bs-toggle="dropdown" style="cursor: pointer;">
                                    {{ __('languages') }}
                                    <span>
                                        <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="-0.00292969" y="0.261597" width="25" height="25"
                                                rx="12.5" fill="#D18CF3" />
                                            <g clip-path="url(#clip0_259_1484)">
                                                <path
                                                    d="M12.492 17.0116C12.2618 17.0116 12.0581 16.9319 11.8811 16.7726L6.78105 11.6726C6.62168 11.4955 6.54199 11.2918 6.54199 11.0616C6.54199 10.8314 6.62168 10.6278 6.78105 10.4507C6.95814 10.2913 7.16178 10.2116 7.39199 10.2116C7.6222 10.2116 7.82585 10.2913 8.00293 10.4507L12.492 14.9663L16.9811 10.4507C17.1581 10.2913 17.3618 10.2116 17.592 10.2116C17.8222 10.2116 18.0258 10.2913 18.2029 10.4507C18.3623 10.6278 18.442 10.8314 18.442 11.0616C18.442 11.2918 18.3623 11.4955 18.2029 11.6726L13.1029 16.7726C12.9258 16.9319 12.7222 17.0116 12.492 17.0116Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_259_1484">
                                                    <rect width="12.25" height="13.6" fill="white"
                                                        transform="matrix(1 0 0 -1 6.36719 19.5616)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </h4>
                                @php
                                    $selected_languages = [];
                                    try {
                                        if (request('language_ids')) {
                                            $selected_languages = json_decode(request('language_ids'));
                                        }
                                    } catch (Exception $e) {
                                    }
                                @endphp
                                <div id="languageContent" class="dropdown-menu px-2">
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($languages as $language)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="mb-0 dropdown-item ps-1">
                                                    <input class="filter-lecturers form-check-input" type="checkbox"
                                                        name="language_id" value="{{ @$language->value }}"
                                                        {{ in_array($language->value, $selected_languages) ? 'checked' : '' }} />
                                                    <span>{{ @$language->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (@$countries && @$countries->isNotEmpty())
                        <div id="countryAccordion" class="form-group col-6 col-lg-3 col-md-3">
                            <div class="bootstrap-select dropdown">
                                <h4 data-target="#countryContent"
                                    class="mb-1 select-item prim-border d-flex justify-content-between align-items-center"
                                    data-bs-toggle="dropdown" style="cursor: pointer;">
                                    {{ __('countries') }}
                                    <span>
                                        <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="-0.00292969" y="0.261597" width="25" height="25"
                                                rx="12.5" fill="#D18CF3" />
                                            <g clip-path="url(#clip0_259_1484)">
                                                <path
                                                    d="M12.492 17.0116C12.2618 17.0116 12.0581 16.9319 11.8811 16.7726L6.78105 11.6726C6.62168 11.4955 6.54199 11.2918 6.54199 11.0616C6.54199 10.8314 6.62168 10.6278 6.78105 10.4507C6.95814 10.2913 7.16178 10.2116 7.39199 10.2116C7.6222 10.2116 7.82585 10.2913 8.00293 10.4507L12.492 14.9663L16.9811 10.4507C17.1581 10.2913 17.3618 10.2116 17.592 10.2116C17.8222 10.2116 18.0258 10.2913 18.2029 10.4507C18.3623 10.6278 18.442 10.8314 18.442 11.0616C18.442 11.2918 18.3623 11.4955 18.2029 11.6726L13.1029 16.7726C12.9258 16.9319 12.7222 17.0116 12.492 17.0116Z"
                                                    fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_259_1484">
                                                    <rect width="12.25" height="13.6" fill="white"
                                                        transform="matrix(1 0 0 -1 6.36719 19.5616)" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </span>
                                </h4>
                                @php
                                    $selected_countries = [];
                                    try {
                                        if (request('country_ids')) {
                                            $selected_countries = json_decode(request('country_ids'));
                                        }
                                    } catch (Exception $e) {
                                    }
                                @endphp
                                <div id="countryContent" class="dropdown-menu px-2">
                                    <div class="d-flex flex-column gap-3">
                                        @foreach ($countries as $country)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="mb-0 dropdown-item ps-1">
                                                    <input class="filter-lecturers form-check-input" type="checkbox"
                                                        name="country_id" value="{{ @$country->value }}"
                                                        {{ in_array($country->value, $selected_countries) ? 'checked' : '' }} />
                                                    <span>{{ @$country->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="form-group mt-2 col-6 col-lg-12 col-md-3 text-center">
                        <a class="text-decoration-underline bg-transparent text-color-third clear-filter"
                            href="{{ route('lecturers.index') }}">
                            {{ __('clear_filter') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('front_js')
    <script>
        // Filter Nav Baisc Start
        function materialsModal() {
            document.querySelector(".filter-modal").classList.toggle('show');
        }

        function filterHeadShow() {
            document.querySelector("#lecturer .filter-head form.form-search-by-title").classList.toggle('show');
        }
        // Filter Nav Baisc End!
        $(document).ready(function() {
            window.filter = getAttrFilter();
        });
        $(document).on('submit', '.form-search-by-title', function(e) {
            e.preventDefault();
            filterLecturers();
        });

        $(document).on('change', '.filter-lecturers', function() {
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
            var lecturer_type = $("input[name='lecturer_type']:checked").val();

            var country_ids = []
            var selected_categories = document.querySelectorAll('input[name=country_id]:checked');
            for (var i = 0; i < selected_categories.length; i++) {
                country_ids.push(selected_categories[i].value)
            }

            var language_ids = []
            var selected_languages = document.querySelectorAll('input[name=language_id]:checked');
            for (var i = 0; i < selected_languages.length; i++) {
                language_ids.push(selected_languages[i].value)
            }

            var material_ids = []
            var selected_materials = document.querySelectorAll('input[name=material_id]:checked');
            for (var i = 0; i < selected_materials.length; i++) {
                material_ids.push(selected_materials[i].value)
            }

            var filter = {
                "name": checkisNotNull(search_by_title) ? search_by_title : '',
                "lecturer_type": checkisNotNull(lecturer_type) ? lecturer_type : '',
                "gender": checkisNotNull(gender) ? gender : '',
                "country_ids": country_ids.length > 0 ? JSON.stringify(country_ids) : [],
                "language_ids": language_ids.length > 0 ? JSON.stringify(language_ids) : [],
                "material_ids": material_ids.length > 0 ? JSON.stringify(material_ids) : [],
            }

            return filter;
        }
    </script>
@endpush
