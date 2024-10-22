<div class="hide-sm row mb-3 private-lessons-filter">
    <div class="col-12 mb-4">
        {{-- <h3>{{ __('name') }}</h3> --}}
        <form class="form-search-by-name">
            <div class="border search-box">
                <div class="icon"><i class="fa-regular fa-magnifying-glass fa-lg"></i></div>
                <input type="text" id="search_by_name" name="name" class="flex-fill" value="{{ request('name') }}"
                    placeholder="{{ __('search') }}">
                <button class="search-btn py-2">{{ __('search1') }}</button>
            </div>
        </form>
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
        <div class="col-12 col-md-6 col-lg-4">
            {{-- <h3>{{ __('materials') }}</h3> --}}
            <div class="form-group select-multiple select-users">
                <select class="selectpicker filter-teachers material-select" name="material_id" multiple=""
                    title="{{ __('materials') }}" data-size="5">
                    @foreach ($materials as $material)
                        <option value="{{ @$material->value }}"
                            {{ in_array($material->value, $selected_materials) ? 'selected' : '' }}
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
        <div class="col-12 col-md-6 col-lg-4">
            {{-- <h3>{{ __('languages') }}</h3> --}}
            <div class="form-group select-multiple select-users">
                <select class="selectpicker filter-teachers language-select" name="language_id" multiple=""
                    title="{{ __('languages') }}" data-size="5">
                    @foreach ($languages as $language)
                        <option value="{{ @$language->value }}"
                            {{ in_array($language->value, $selected_languages) ? 'selected' : '' }}
                            data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$language->name }}&lt;/span&gt;">
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    {{-- Mother Languages --}}
    {{-- @if (@$languages && @$languages->isNotEmpty())

        @php
        $selected_mother_languages = [];
        try {
            if (request('mother_language_ids')) {
                $selected_mother_mother_languages = json_decode(request('mother_language_ids'));
            }
        } catch (Exception $e) {
        }
        @endphp
        <div class="col-xl-3 pe-2 col-md-3 col-sm-3">
            <h3>{{ __('mother_language') }}</h3>
            <div class="form-group select-multiple select-users">
                <select class="selectpicker filter-teachers mother-language-select" name="mother_language_id"  multiple="" title="{{ __('search') }}" data-size="5">
                    @foreach ($languages as $language)
                    <option value="{{@$language->value}}"
                        {{ in_array($language->value, $selected_mother_languages) ? 'selected' : '' }}
                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{@$language->name}}&lt;/span&gt;">
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif --}}

    {{-- Genders --}}
    @php
        $gender_types = config('constants.gender_type');
        $selected_genders = [];
        try {
            if (request('genders')) {
                $selected_genders = json_decode(request('genders'));
            }
        } catch (Exception $e) {
        }
    @endphp
    <div class="col-12 col-md-6 col-lg-4">
        {{-- <h3>{{ __('gender') }}</h3> --}}
        <div class="form-group select-multiple select-users">
            <select class="selectpicker filter-teachers gender-select" name="gender_id" multiple=""
                title="{{ __('gender') }}" data-size="5">
                @foreach ($gender_types as $gender)
                    <option value="{{ @$gender['key'] }}"
                        {{ in_array($gender['key'], $selected_genders) ? 'selected' : '' }}
                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ __($gender['key']) }}&lt;/span&gt;">
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Countries --}}
    @if (@$countries && @$countries->isNotEmpty())
        @php
            $selected_countries = [];
            try {
                if (request('countries')) {
                    $selected_countries = json_decode(request('countries'));
                }
            } catch (Exception $e) {
            }
        @endphp
        <div class="col-12 col-md-6 col-lg-4">
            {{-- <h3>{{ __('country') }}</h3> --}}
            <div class="form-group select-multiple select-users">
                <select class="selectpicker filter-teachers country-select" name="country_id" multiple=""
                    title="{{ __('country') }}" data-size="5">
                    @foreach ($countries as $country)
                        <option value="{{ @$country->value }}"
                            {{ in_array($country->value, $selected_countries) ? 'selected' : '' }}
                            data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$country->name }}&lt;/span&gt;">
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    {{-- Lecturer Types --}}

    @php
        $selected_lecturer_types = [];
        try {
            if (request('lecturer_types')) {
                $selected_countries = json_decode(request('lecturer_types'));
            }
        } catch (Exception $e) {
        }
    @endphp
    <div class="col-12 col-md-6 col-lg-4">
        {{-- <h3>{{ __('type') }}</h3> --}}
        <div class="form-group select-multiple select-users">
            <select class="selectpicker filter-teachers lecturer-type-select" name="lecturer_types" multiple=""
                title="{{ __('type') }}" data-size="5">
                <option value="1" {{ in_array(1, $selected_lecturer_types) ? 'selected' : '' }}
                    data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;ينتمي إلينا &lt;/span&gt;">
                </option>
                <option value="0" {{ in_array(0, $selected_lecturer_types) ? 'selected' : '' }}
                    data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;لا ينتمي إلينا&lt;/span&gt;">
                </option>
            </select>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4">
        <div class="dropdown bootstrap-select">
            <button class="prim-border bs-placeholder dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ __('price') }}
            </button>
            <div class="dropdown-menu p-1">
                    <div class=" ">
                        <span class="range-slider d-flex align-items-center">
                            <input type="number" min="0" max="{{ @$maxMinValue->max_price }}" id="price_from_desktop"
                                name="price_from_desktop" value="{{ request('price_from') ?? @$maxMinValue->min_price }}"
                                class="filter-teacher" />
                            <div class=" range-slider__numbers ">
                                <input value="{{ request('price_from') ?? @$maxMinValue->min_price }}" min="0"
                                    max="{{ @$maxMinValue->max_price }}" step="10" type="range" />
                                <input value="{{ request('price_to') ?? @$maxMinValue->max_price }}" min="0"
                                    max="{{ @$maxMinValue->max_price }}" step="10" type="range" />
                            </div>
                            <input type="number" min="0" max="{{ @$maxMinValue->max_price }}" id="price_to_desktop"
                                name="price_to_desktop" value="{{ request('price_to') ?? @$maxMinValue->max_price }}"
                                class="filter-teacher" />
                        </span>
                    </div>
            </div>
        </div>


    </div>
    {{-- Clear Filter --}}
    <div class="form-group text-center mt-2">
        <button class="clear-filter bg-transparent text-color-third text-decoration-underline"
            data-url="{{ route('private_lessons.index') }}">
            {{ __('clear_filter') }}
        </button>
    </div>
</div>

{{-- Mobile Filters --}}
<div class="row d-lg-none mobile_filters">
    <!-- modal filter -->
    <details>
        <summary>
            <p class="fs-6 text-white">فلتر</p>
            <i class="fs-6 px-1 fa-regular fa-filter"></i>
        </summary>
        <div class="modal-content">
            <div class="row">
                <div class="col-xl-2 col-md-6 col-sm-6">
                    <h3>{{ __('name') }}</h3>
                    <form class="form-search-by-name">
                        <div class="form-group select-multiple select-users">
                            <input type="text" id="search_by_name" name="name" class="form-control"
                                value="{{ request('name') }}" placeholder="{{ __('search') }}">
                        </div>
                    </form>
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
                    <div class="col-xl-2 col-md-6 col-sm-6">
                        <h3>{{ __('materials') }}</h3>
                        <div class="form-group select-multiple select-users">
                            <select class="selectpicker filter-teachers material-select" name="material_id"
                                multiple="" title="{{ __('search') }}" data-size="5">
                                @foreach ($materials as $material)
                                    <option value="{{ @$material->value }}"
                                        {{ in_array($material->value, $selected_materials) ? 'selected' : '' }}
                                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$material->name }}&lt;/span&gt;">
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div class="col-xl-2 col-md-6 col-sm-6">
                    <h3>{{ __('price') }}</h3>
                    <div class="form-group">
                        <div class=" ">
                            <span class="range-slider d-flex align-items-center">
                                <input type="number" min="0" max="{{ @$maxMinValue->max_price }}"
                                    id="price_from_mobile" name="price_from_mobile"
                                    value="{{ request('price_from') ?? @$maxMinValue->min_price }}"
                                    class="filter-teacher" />
                                <div class=" range-slider__numbers ">
                                    <input value="{{ request('price_from') ?? @$maxMinValue->min_price }}"
                                        min="0" max="{{ @$maxMinValue->max_price }}" step="10"
                                        type="range" />
                                    <input value="{{ request('price_to') ?? @$maxMinValue->max_price }}"
                                        min="0" max="{{ @$maxMinValue->max_price }}" step="10"
                                        type="range" />
                                </div>
                                <input type="number" min="0" max="{{ @$maxMinValue->max_price }}"
                                    id="price_to_mobile" name="price_to_mobile"
                                    value="{{ request('price_to') ?? @$maxMinValue->max_price }}"
                                    class="filter-teacher" />
                            </span>
                        </div>
                    </div>
                </div>

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
                    <div class="col-xl-2 col-md-6 col-sm-6">
                        <h3>{{ __('languages') }}</h3>
                        <div class="form-group select-multiple select-users">
                            <select class="selectpicker filter-teachers language-select" name="language_id"
                                multiple="" title="{{ __('search') }}" data-size="5">
                                @foreach ($languages as $language)
                                    <option value="{{ @$language->value }}"
                                        {{ in_array($language->value, $selected_languages) ? 'selected' : '' }}
                                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$language->name }}&lt;/span&gt;">
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif


                {{-- Genders --}}
                @php
                    $gender_types = config('constants.gender_type');
                    $selected_genders = [];
                    try {
                        if (request('genders')) {
                            $selected_genders = json_decode(request('genders'));
                        }
                    } catch (Exception $e) {
                    }
                @endphp
                <div class="col-xl-2 col-md-6 col-sm-6">
                    <h3>{{ __('gender') }}</h3>
                    <div class="form-group select-multiple select-users">
                        <select class="selectpicker filter-teachers gender-select" name="gender_id" multiple=""
                            title="{{ __('search') }}" data-size="5">
                            @foreach ($gender_types as $gender)
                                <option value="{{ @$gender['key'] }}"
                                    {{ in_array($gender['key'], $selected_genders) ? 'selected' : '' }}
                                    data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ __($gender['key']) }}&lt;/span&gt;">
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Countries --}}
                @if (@$countries && @$countries->isNotEmpty())
                    @php
                        $selected_countries = [];
                        try {
                            if (request('countries')) {
                                $selected_countries = json_decode(request('countries'));
                            }
                        } catch (Exception $e) {
                        }
                    @endphp
                    <div class="col-xl-2 col-md-6 col-sm-6">
                        <h3>{{ __('country') }}</h3>
                        <div class="form-group select-multiple select-users">
                            <select class="selectpicker filter-teachers country-select" name="country_id"
                                multiple="" title="{{ __('search') }}" data-size="5">
                                @foreach ($countries as $country)
                                    <option value="{{ @$country->value }}"
                                        {{ in_array($country->value, $selected_countries) ? 'selected' : '' }}
                                        data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;{{ @$country->name }}&lt;/span&gt;">
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                {{-- Lecturer Types --}}

                @php
                    $selected_lecturer_types = [];
                    try {
                        if (request('lecturer_types')) {
                            $selected_countries = json_decode(request('lecturer_types'));
                        }
                    } catch (Exception $e) {
                    }
                @endphp
                <div class="col-xl-2 col-md-6 col-sm-6">
                    <h3>{{ __('type') }}</h3>
                    <div class="form-group select-multiple select-users">
                        <select class="selectpicker filter-teachers lecturer-type-select" name="lecturer_types"
                            multiple="" title="{{ __('search') }}" data-size="5">
                            <option value="1" {{ in_array(1, $selected_lecturer_types) ? 'selected' : '' }}
                                data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;ينتمي إلينا&lt;/span&gt;">
                            </option>
                            <option value="0" {{ in_array(0, $selected_lecturer_types) ? 'selected' : '' }}
                                data-content="&lt;span class='d-flex align-items-center'&gt;&lt;span class='symbol symbol-30'&gt; &lt;/span&gt;لا ينتمي إلينا&lt;/span&gt;">
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </details>
    <!-- modal -->
</div>


@push('front_js')
    <script>
        $(document).on('submit', '.form-search-by-name', function(e) {
            e.preventDefault();
            filterLecturers();
        });

        $(document).on('change', '.filter-teachers', function() {
            filterLecturers();
        });

        function filterLecturers() {

            window.filter = getAttrFilter();
            var url = "";
            getData(getUrlWithSearchParm(url, filter, false))

        }

        function getAttrFilter() {
            var search_by_name = $('#search_by_name').val();

            var price_from_desktop = $('#price_from_desktop').val();
            var price_to_desktop = $('#price_to_desktop').val();

            var price_from_mobile = $('#price_from_mobile').val();
            var price_to_mobile = $('#price_to_mobile').val();

            var isDesktopVisible = $('#price_from_desktop').is(':visible');


            var material_ids = []
            var selected_materials = document.querySelectorAll('select.material-select option:checked');
            for (var i = 0; i < selected_materials.length; i++) {
                material_ids.push(selected_materials[i].value)
            }

            var language_ids = []
            var selected_languages = document.querySelectorAll('select.language-select option:checked');
            for (var i = 0; i < selected_languages.length; i++) {
                language_ids.push(selected_languages[i].value)
            }

            // var mother_language_ids = []
            // var selected_mother_languages = document.querySelectorAll('select.mother-language-select option:checked');
            // for (var i = 0; i < selected_mother_languages.length; i++) {
            //     mother_language_ids.push(selected_mother_languages[i].value)
            // }

            var genders = []
            var selected_genders = document.querySelectorAll('select.gender-select option:checked');
            for (var i = 0; i < selected_genders.length; i++) {
                genders.push(selected_genders[i].value)
            }

            var countries = []
            var selected_countries = document.querySelectorAll('select.country-select option:checked');
            for (var i = 0; i < selected_countries.length; i++) {
                countries.push(selected_countries[i].value)
            }

            var lecturer_types = []
            var selected_lecturer_types = document.querySelectorAll('select.lecturer-type-select option:checked');
            for (var i = 0; i < selected_lecturer_types.length; i++) {
                lecturer_types.push(selected_lecturer_types[i].value)
            }

            var filter = {
                "name": checkisNotNull(search_by_name) ? search_by_name : '',
                "material_ids": material_ids.length > 0 ? JSON.stringify(material_ids) : [],
                "language_ids": language_ids.length > 0 ? JSON.stringify(language_ids) : [],
                // "mother_language_ids": mother_language_ids.length > 0 ? JSON.stringify(mother_language_ids) : [],
                "genders": genders.length > 0 ? JSON.stringify(genders) : [],
                "countries": countries.length > 0 ? JSON.stringify(countries) : [],
                "lecturer_types": lecturer_types.length > 0 ? JSON.stringify(lecturer_types) : [],
                "price_from": isDesktopVisible ? price_from_desktop : checkisNotNull(price_from_mobile) ?
                    price_from_mobile : '',
                "price_to": isDesktopVisible ? price_to_desktop : checkisNotNull(price_to_mobile) ? price_to_mobile :
                    '',
            }

            return filter;
        }
    </script>
    <script>
        function attachRangeSliderListeners(rangeInputs, numberInputs) {
            var timeout;

            rangeInputs.forEach(function(el) {
                el.oninput = function() {
                    clearTimeout(timeout);

                    timeout = setTimeout(function() {
                        var slide1 = parseFloat(rangeInputs[0].value);
                        var slide2 = parseFloat(rangeInputs[1].value);

                        if (slide1 > slide2) {
                            [slide1, slide2] = [slide2, slide1];
                        }

                        numberInputs[0].value = slide1;
                        numberInputs[1].value = slide2;

                        filterLecturers(); // Trigger the function when the user stops interacting
                    }, 500); // Adjust the timeout duration as needed
                };
            });

            numberInputs.forEach(function(el) {
                el.oninput = function() {
                    clearTimeout(timeout);

                    timeout = setTimeout(function() {
                        var number1 = parseFloat(numberInputs[0].value);
                        var number2 = parseFloat(numberInputs[1].value);

                        if (number1 > number2) {
                            [number1, number2] = [number2, number1];
                        }

                        rangeInputs[0].value = number1;
                        rangeInputs[1].value = number2;

                        filterLecturers(); // Trigger the function when the user stops interacting
                    }, 500); // Adjust the timeout duration as needed
                };
            });
        }

        // For desktop inputs
        var desktopRangeInputs = document.querySelectorAll(".range-slider input[type=range]");
        var desktopNumberInputs = document.querySelectorAll(".range-slider input[type=number]");
        attachRangeSliderListeners(desktopRangeInputs, desktopNumberInputs);

        // For mobile inputs
        var mobileRangeInputs = document.querySelectorAll(".mobile_filters .range-slider input[type=range]");
        var mobileNumberInputs = document.querySelectorAll(".mobile_filters .range-slider input[type=number]");
        attachRangeSliderListeners(mobileRangeInputs, mobileNumberInputs);
    </script>
@endpush
