<div class="filter section-padding-02 pb-5">
    <div class="container">
        <div class="filter-nav">
            <div class="filter-head">
                <h2 class="title">{{ __('interactive_educational_curricula') }}</h2>
                <form class="form-search-by-title">
                    <div class="">
                        <div class="border search-box">
                            <div class="icon"><i class="fa-regular fa-magnifying-glass fa-lg"></i></div>
                            <input class="flex-fill group-date" type="text" id="search_by_title" name="title"
                                value="{{ request('title') }}" placeholder="{{ __('search') }}">
                            <button class="search-btn py-2">{{ __('search1') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="filter-body ">
                <div class="mt-2">
                    <div class="row">

                        @foreach ($grade_levels as $i => $level)
                            <div id="levelAccordion-{{ $i }}" class="form-group col-12 col-lg-4 col-md-4">
                                <div class="bootstrap-select dropdown">
                                    <h4 data-target="#levelContent-{{ $i }}"
                                        class="mb-2 prim-border select-item  d-flex justify-content-between align-items-center"
                                        data-bs-toggle="dropdown" style="cursor: pointer;">
                                        <span>
                                            <svg width="25" height="26" viewBox="0 0 25 26" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-0.00976562" y="0.261597" width="25" height="25"
                                                    rx="12.5" fill="#D18CF3" />
                                                <g clip-path="url(#clip0_259_1493)">
                                                    <path
                                                        d="M17.5906 7.23661V19.5616L12.4906 16.5866L7.39062 19.5616V7.23661C7.40833 6.88245 7.53229 6.58141 7.7625 6.33349C8.01042 6.10328 8.31146 5.97932 8.66563 5.96161H16.3156C16.6698 5.97932 16.9708 6.10328 17.2188 6.33349C17.449 6.58141 17.5729 6.88245 17.5906 7.23661Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_259_1493">
                                                        <rect width="10.5" height="13.6" fill="white"
                                                            transform="matrix(1 0 0 -1 7.24023 19.5616)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        {{ $level->name }}
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
                                        $selected_levels = [];
                                        try {
                                            if (request('grade_level_ids')) {
                                                $selected_grade_levels = json_decode(request('grade_level_ids'));
                                            }
                                        } catch (Exception $e) {
                                        }
                                    @endphp
                                    <div id="levelContent-{{ $i }}" class="dropdown-menu px-2">
                                        <div class="d-flex flex-column gap-3">
                                            @foreach ($level->getSubChildren() as $child)
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <label class="mb-0 dropdown-item">
                                                        <input class="filter-courses  form-check-input" type="radio"
                                                            name="grade_level_id" value="{{ @$child->id }}"
                                                            onchange="$('#categoryAccordion').show()" />
                                                        <span>{{ @$child->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach





                        <div class="form-group text-center mt-2">
                            <button onclick="clearFilter()" class="clear-filter bg-transparent text-white text-decoration-underline"
                                data-url="{{ route('courses.index') }}">
                                {{ __('clear_filter') }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
