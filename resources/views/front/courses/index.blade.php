@extends('front.layouts.index', ['is_active' => 'courses', 'sub_title' => __('courses')])

@section('content')
    {{-- <div>
        <img class="hero" src="{{ asset('assets/front/images/newimages/Hero-courses-section.png') }}" alt="Hero-section">
    </div> --}}
    <!-- start:: section -->
    <section id="courses-page" class="wow fadeInUp" data-wow-delay="0.1s">
        <div class="mb-4 mb-lg-0 filter-form-body">
            @include('front.courses.partials.filter')

        </div>

        <div class="container">

            <div class="">
                @if (@$categories && @$categories->isNotEmpty())
                    <div id="categoryAccordion" class="form-group pt-5 col-12 col-lg-3 col-md-6">
                        <h2 class="pb-3">{{ __('study_material') }}</h2>
                        <div class="bootstrap-select dropdown">
                            <h4 data-target="#categoryContent"
                                class="mb-2 prim-border select-item d-flex justify-content-between align-items-center"
                                data-bs-toggle="dropdown" style="cursor: pointer;">
                                <span id="selectedCategoryName">
                                    {{ __('study_material') }}
                                </span>
                                <span>
                                    <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="-0.00292969" y="0.261597" width="25" height="25" rx="12.5"
                                            fill="#D18CF3" />
                                        <g clip-path="url(#clip0_259_1484)">
                                            <path
                                                d="M12.492 17.0116C12.2618 17.0116 12.0581 16.9319 11.8811 16.7726L6.78105 11.6726C6.62168 11.4955 6.54199 11.2918 6.54199 11.0616C6.54199 10.8314 6.62168 10.6278 6.78105 10.4507C6.95814 10.2913 7.16178 10.2116 7.39199 10.2116C7.6222 10.2116 7.82585 10.2913 8.00293 10.4507L12.492 14.9663L16.9811 10.4507C17.1581 10.2913 17.3618 10.2116 17.592 10.2116C17.8222 10.2116 18.0258 10.2913 18.2029 10.4507C18.3623 10.6278 18.442 10.8314 18.442 11.0616C18.442 11.2918 18.3623 11.4955 18.2029 11.6726L13.1029 16.7726C12.9258 16.9319 12.7222 17.0116 12.492 17.0116Z"
                                                fill="white" />
                                        </g>
                                    </svg>
                                </span>
                            </h4>
                            @php
                                $selected_category = null;
                                try {
                                    if (request('category_ids') && request('category_ids') != '') {
                                        $selected_category = json_decode(request('category_ids'))[0];
                                    }
                                } catch (Exception $e) {
                                }
                            @endphp
                            <div id="categoryContent" class="dropdown-menu px-2">
                                <div class="d-flex flex-column gap-3">
                                    @foreach ($categories as $category)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <label class="mb-0 dropdown-item">
                                                <input class="filter-courses form-check-input category-radio"
                                                    type="radio" name="category_id" value="{{ $category->value }}"
                                                    data-name="{{ $category->name }}"
                                                    {{ $category->value == $selected_category ? 'checked' : '' }} />
                                                <span>{{ $category->name }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="all-data py-5">
                    @include('front.courses.partials.all-courses')
                </div>
            </div>
        </div>
    </section>
    <!-- end:: section -->

    @push('front_js')
        <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
        <script>
            // Starat
            function clearFilter() {
                $('input[name=grade_level_id]').prop('checked', false);
                $('input[name=category_id]').prop('checked', false);
                $('#categoryAccordion').hide();
                $('#selectedCategoryName').text('{{ __('study_material') }}');
            }
            var sideNav = document.querySelector('.filter-nav');
            var toggleButton = document.querySelector('.toggle-side-nav');
            var chevronIcon = document.getElementById('chevron-icon');

            toggleButton.addEventListener('click', function() {
                if (sideNav.style.display === 'none' || sideNav.style.display === '') {
                    sideNav.style.display = 'block';
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                } else {
                    sideNav.style.display = 'none';
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#categoryAccordion').hide();
            });
            $(document).ready(function() {
                window.filter = getAttrFilter();
                if (filter.price_type != 'paid') {
                    $('#price-range-input').hide();
                }
            });
            $(document).on('submit', '.form-search-by-title', function(e) {
                e.preventDefault();
                filterLecturers();
            });
            $(document).on('submit', '.form-price-filter', function(e) {
                e.preventDefault();
                filterLecturers();
            });

            $(document).on('change', '.filter-courses', function() {
                filterLecturers();
            });

            $(document).on('change', '.price-range', function() {
                if ($(this).val() === 'paid') {
                    $('#price-range-input').show();
                    filterLecturers();
                } else {
                    $('#price-range-input').hide();
                    filterLecturers();
                }
            });

            function filterLecturers() {

                window.filter = getAttrFilter();
                console.log(filter);
                var url = "";
                getData(getUrlWithSearchParm(url, filter, false))

            }

            function getAttrFilter() {
                var search_by_title = $('#search_by_title').val();

                var selectedGradeLevel = $('input[name=grade_level_id]:checked').val();

                var category_ids = []
                var selected_categories = document.querySelectorAll('input[name=category_id]:checked');
                for (var i = 0; i < selected_categories.length; i++) {
                    category_ids.push(selected_categories[i].value)
                }


                // var level_ids = []
                // var selected_levels = document.querySelectorAll('input[name=level_id]:checked');
                // for (var i = 0; i < selected_levels.length; i++) {
                //     level_ids.push(selected_levels[i].value)
                // }



                var filter = {
                    "title": checkisNotNull(search_by_title) ? search_by_title : '',
                    "category_ids": category_ids.length > 0 ? JSON.stringify(category_ids) : [],
                    "grade_sub_level": checkisNotNull(selectedGradeLevel) ? selectedGradeLevel : '',

                }

                return filter;
            }
            $(document).ready(function() {
                // Function to update the selected category name
                function updateSelectedCategoryName() {
                    var selectedCategory = $('.category-radio:checked').data('name');

                    if (selectedCategory) {
                        // Show the selected category's name
                        $('#selectedCategoryName').text(selectedCategory);
                    } else {
                        // If no category is selected, show the default text
                        $('#selectedCategoryName').text('{{ __('study_material') }}');
                    }
                }

                // Initialize the selected category name on page load
                updateSelectedCategoryName();

                // Update category name when a radio button is changed
                $('.category-radio').on('change', function() {
                    updateSelectedCategoryName();
                });
            });
        </script>
    @endpush
@endsection
