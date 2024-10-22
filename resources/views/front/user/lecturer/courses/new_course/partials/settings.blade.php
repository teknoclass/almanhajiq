<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <form id="form" method="POST" action="{{route('user.lecturer.course.store')}}"  to = "{{ route('user.lecturer.course.create', 'curriculum') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @foreach(locales() as $locale => $value)
                <div class="form-group col-12">
                    <label>{{__('title')}}
                        ({{ __($value) }} )
                        <span class="text-danger">*</span></label>
                    <input type="text" name="title_{{$locale}}"
                            class="form-control rounded-pill"
                            value="{{isset($item)?@$item->translate($locale)->title:''}}"
                            required/>
                </div>

                <div class="form-group col-12">
                    <label>{{__('description_title')}}
                        ({{ __($value) }} )
                        <span class="text-danger">*</span></label>
                    <textarea type="text" name="description_{{$locale}}"
                                id="description_{{$locale}}"
                                class="form-control rounded-pill tinymce" required
                                rows="5">{{isset($item)?@$item->translate($locale)->description:''}}</textarea>
                </div>
            @endforeach

            <div class="form-group col-6">
                <label>{{__('type')}}
                    <span class="text-danger">*</span></label>
                <select id="type" name="type" class="form-control rounded-pill"
                        required>
                    <option value="" selected disabled>{{__('type_select')}} </option>
                    @foreach(config('constants.course_types') as $course_type)
                        <option value="{{$course_type['key']}}" {{isset($item)?
                                    (@$item->type==$course_type['key'] ?'selected' :''):
                                        ($course_type['is_default']?'selected':'')}}>
                            {{__('course_types.'.$course_type['key'])}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-6">
                <label>{{__('status')}}
                    <span class="text-danger">*</span></label>
                <select id="status" name="status" class="form-control rounded-pill"
                        required>
                    <option value="" selected disabled>{{__('type_select')}} </option>
                    @foreach(config('constants.course_status') as $course_status)
                        <option value="{{$course_status['key']}}" {{isset($item)?
                                (@$item->status==$course_status['key'] ?'selected' :''):
                                    ($course_status['is_default']?'selected':'')}}>
                            {{__($course_status['key'])}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-6">
                <label>{{__('languages')}}
                    <span class="text-danger">*</span></label>
                <select id="language_id" name="language_id"
                        class="form-control rounded-pill"
                        required>
                    <option value="" selected disabled>{{__('lang_select')}}</option>
                    @foreach($languages as $language)
                        <option
                            value="{{@$language->value}}" {{@$item->language_id==$language->value ?'selected' :''}}>{{@$language->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-6">
                <label>{{__('category')}}
                    <span class="text-danger">*</span></label>
                <select id="category_id" name="category_id"
                        class="form-control rounded-pill"
                        required>
                    <option value="" selected
                            disabled>{{__('category_select')}}</option>
                    @foreach($categories as $category)
                        <option
                            value="{{@$category->value}}" {{@$item->category_id==$category->value ?'selected' :''}}>{{@$category->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-6">
                <label>{{__('level')}}
                    <span class="text-danger">*</span></label>
                <select id="level_id" name="level_id"
                        class="form-control   rounded-pill "
                        required>
                    <option value="" selected disabled>{{__('level_select')}}</option>
                    @foreach($levels as $level)
                        <option
                            value="{{@$level->value}}" {{@$item->level_id==$level->value ?'selected' :''}}>{{@$level->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-6">
                <label>{{__('age_categories')}}
                    <span class="text-danger">*</span></label>
                <select id="age_range_id" name="age_range_id"
                        class="form-control  rounded-pill "
                        required>
                    <option value="" selected
                            disabled>{{__('age_categories_select')}}</option>
                    @foreach($age_categories as $age_category)
                        <option
                            value="{{@$age_category->value}}" {{@$item->age_range_id==$level->value ?'selected' :''}}>{{@$age_category->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-6">
                <label>{{__('start_date')}}
                    <span class="text-danger"></span></label>
                <br>
                <div class="input-group date">
                    <input type="datetime-local"
                        class="form-control   rounded-pill "
                        name="start_date"
                        value="{{(isset($item) && $item->start_date!='')?$item->start_date :'' }}"
                    />

                </div>
            </div>

            <div class="form-group col-6">
                <label>{{__('end_date')}}
                    <span class="text-danger"></span></label>
                <br>
                <div class="input-group date">
                    <input type="datetime-local"
                        class="form-control   rounded-pill "
                        name="end_date"
                        value="{{(isset($item) && $item->end_date!='')?$item->end_date :'' }}"
                    />

                </div>
            </div>

            <div class="form-group col-6">
                <label>{{__('number_of_free_lessons')}}
                    <span class="text-danger"></span></label>
                <input type="number" class="form-control  rounded-pill "
                    name="num_lessons"
                    value="{{(isset($item) && $item->num_lessons!='')?$item->num_lessons :'' }}"/>
            </div>

            <div class="form-group col-12">
                <label>{{__('lessons_follow_up')}}
                    <span class="text-danger"></span></label>
                <select id="lessons_follow_up" name="lessons_follow_up" class="form-control    rounded-pill"
                        required>
                    <option value="" selected disabled>{{__('type_select')}} </option>

                        <option value="1"
                            {{@$item->lessons_follow_up==1 ?'selected' :''}}>
                            {{__('yes')}}
                        </option>
                    <option value="2"
                        {{@$item->lessons_follow_up==2 ?'selected' :''}}>
                        {{__('no')}}
                    </option>

                </select>
            </div>

            <div class="form-group col-6">
                <label class="input-image-preview d-block px-3 pointer" for="image">
                    <input class="input-file-image-1" type="file" name="image" id="image"  accept="image/png, image/jpeg, image/jpg,application/pdf">
                    <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                    <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                       <div class="flipthis-wrapper">
                          <span class="">{{__('course_image')}} </span>
                       </div>
                       <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                    </span>
                 </label>
            </div>
            <div class="form-group col-6">
                <div class="form-group text-center">
                    <label class="input-image-preview d-block px-3 pointer" for="cover_image">
                        <input class="input-file-image-1" type="file" name="cover_image" id="cover_image"  accept="image/png, image/jpeg, image/jpg,application/pdf">
                        <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                        <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                           <div class="flipthis-wrapper">
                              <span class="">{{__('cover_image')}} </span>
                           </div>
                           <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                        </span>
                     </label>

                </div>
            </div>

            <div class="form-group col-6">
                <div class="form-group text-center">
                    <label class="input-image-preview d-block px-3 pointer" for="video_image">
                        <input class="input-file-image-1" type="file" name="video_image" id="video_image"  accept="image/png, image/jpeg, image/jpg,application/pdf">
                        <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                        <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                           <div class="flipthis-wrapper">
                              <span class="">{{__('video_image')}} </span>
                           </div>
                           <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                        </span>
                     </label>
                </div>
            </div>

            <div class="form-group col-6">
                <div class="form-group text-center">

                    <input type="text" class=" form-control    rounded-pill mb-3" name="video" placeholder="رابط اليوتيوب " value="" fdprocessedid="ng625">

                </div>
            </div>

        </div>
    @include('front.user.lecturer.courses.new_course.components.save_button')
   </form>
</div>
