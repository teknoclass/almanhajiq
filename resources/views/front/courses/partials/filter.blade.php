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
                    <form method="get" action="/courses">
                    <div class="row">

                    <select id="gradeLevel" class="form-control col-4 filtergrade_level_id" style="max-width:300px;margin:10px" name="grade_level_id">
                        <option disabled readonly>{{__('choose_level')}}</option>
                        @foreach ($grade_levels as $i => $level)
                        <option value="{{$level->id}}">{{$level->name}}</option>
                        @endforeach
                    </select>

                    <select id="years" class="form-control col-4 select2 filterCourses" style="max-width:300px;margin:10px" name="grade_sub_level">
                        <option readonly disabled>{{__('choose_year')}}</option>
                       
                    </select>

                    <select id="subjects" class="form-control col-4 select2 filterCourses" style="max-width:300px;margin:10px" name="id">
                        <option readonly disabled>{{__('choose_subject')}}</option>
                      
                    </select>

                    </div>
                    
                    <button class=" join-btn font-bold" style="border: 1px solid var(--primary-color); padding: 12px 14px; border-radius: 6px;transition: all .3s linear;">{{ __('search1') }}</button>
                    </form>
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
