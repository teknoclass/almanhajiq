@extends('front.user.lecturer.layout.index')

@push('front_css')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
@endpush

@section('content')

    @php
        $item = isset($item) ? $item : null;

        isset($item) ? ($title_page = @$item->title) : ($title_page = __('add'));

        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('user.home.index'),
            ],
            [
                'title' => __('courses'),
                'link' => route('user.lecturer.my_courses.index'),
            ],
            [
                'title' => @$title_page,
                'link' => '#',
            ],
        ];
    @endphp
    <section class="section wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <!--begin::breadcrumb-->
            @if (@$item)
                @include('front.user.lecturer.layout.includes.course_breadcrumb', [
                    'breadcrumb_links' => $breadcrumb_links,
                ])
                @include('front.user.lecturer.courses.my_courses.create.components.request_review_modal')
                <input type="hidden" id="needToolbarConfirm" value="false">
            @else
                @include('front.user.lecturer.layout.includes.breadcrumb', [
                    'breadcrumb_links' => $breadcrumb_links,
                ])
            @endif
            <!--end::breadcrumb-->

            <!--begin::Content-->
            <div class="g-5 gx-xxl-12 mb-4">
                <div class="bg-white rounded-4">

                    <div class="row">
                        <div class="col-12">
                            <form id="form" method="{{ isset($item) ? 'POST' : 'POST' }}" to="#"
                                url="{{ url()->current() }}" class="w-100">
                                @csrf
                                <input type="hidden" value="{{ @$item->image }}" name="image" id="image" />
                                <input type="hidden" value="{{ @$item->video_image }}" name="video_image" id="image_2" />
                                <input type="hidden" value="{{ @$item->cover_image }}" name="cover_image" id="image_3" />
                                @include('front.user.lecturer.courses.my_courses.create.partials.toolbar')

                                <div class="row">

                                    @foreach (locales() as $locale => $value)
                                        <div class="form-group col-12">
                                            <label>{{ __('title') }}
                                                ({{ __($value) }})
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_{{ $locale }}" class="form-control"
                                                value="{{ isset($item) ? @$item->translate($locale)->title : '' }}" required />
                                        </div>

                                        <div class="form-group col-12">
                                            <label>{{ __('description_title') }}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <textarea type="text" name="description_{{ $locale }}" id="description_{{ $locale }}"
                                                class="form-control tinymce" required rows="15">
                                            {!! isset($item) ? @$item->translate($locale)->description : '' !!}
                                        </textarea>
                                        </div>
                                    @endforeach

                                    <div class="form-group col-6">
                                        <label>{{ __('type') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="type" name="type" class="form-control" required>
                                            <option value="" selected disabled>{{ __('type_select') }} </option>
                                            @foreach (config('constants.course_types') as $course_type)
                                                <option value="{{ $course_type['key'] }}"
                                                    {{ isset($item)
                                                        ? (@$item->type == $course_type['key']
                                                            ? 'selected'
                                                            : '')
                                                        : ($course_type['is_default']
                                                            ? 'selected'
                                                            : '') }}>
                                                    {{ __('course_types.' . $course_type['key']) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" value="{{ @$item->status ?? 'being_processed' }}" name="status"
                                        id="status" />
                                    {{-- <div class="form-group col-6">
                                    <label>{{__('status')}}
                                        <span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-control"
                                            required>
                                        <option value="" selected disabled>{{__('type_select')}} </option>
                                        @foreach (config('constants.course_status') as $course_status)
                                            <option value="{{$course_status['key']}}" {{isset($item)?
                                                    (@$item->status==$course_status['key'] ?'selected' :''):
                                                        ($course_status['is_default']?'selected':'')}}>
                                                {{__($course_status['key'])}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                    <div class="form-group col-6">
                                        <label>{{ __('languages') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="language_id" name="language_id" class="form-control" required>
                                            <option value="" selected disabled>{{ __('lang_select') }}</option>
                                            @foreach ($languages as $language)
                                                <option value="{{ @$language->value }}"
                                                    {{ @$item->language_id == $language->value ? 'selected' : '' }}>
                                                    {{ @$language->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{ __('category') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="category_id" name="category_id" class="form-control" required>
                                            <option value="" selected disabled>{{ __('category_select') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ @$category->value }}"
                                                    {{ @$item->category_id == $category->value ? 'selected' : '' }}>
                                                    {{ @$category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{ __('level') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="level_id" name="level_id" class="form-control   " required>
                                            <option value="" selected disabled>{{ __('level_select') }}</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ @$level->value }}"
                                                    {{ @$item->level_id == $level->value ? 'selected' : '' }}>
                                                    {{ @$level->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>

                                        <div class="form-group col-6">
                                            <label>{{ __('grade_level') }}
                                                <span class="text-danger">*</span></label>
                                            <select id="grade_level_id"  name="grade_level_id" class="form-control" required>
                                                <option value="" selected disabled>{{ __('level_select') }}</option>
                                                @foreach ($grade_levels as $grade_level)
                                                    <option data-child="{{ json_encode($grade_level->getSubChildren()) }}" value="{{ $grade_level->id }}" {{ old('grade_level_id', @$item->grade_level_id) == $grade_level->id ? 'selected' : '' }}>
                                                        {{ $grade_level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-6">
                                            <label>{{ __('grade_sub_level') }}
                                                <span class="text-danger">*</span></label>
                                            <select id="sub_level_id" name="grade_sub_level" class="form-control" required>
                                                <option value="" selected disabled>{{ __('grade_sub_level') }}</option>


                                            </select>
                                        </div>
<script>
    const select1 = document.getElementById("grade_level_id");
    const select2 = document.getElementById("sub_level_id");

    select1.addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];

        // Get the data-child attribute (which is a JSON string)
        const children = selectedOption.getAttribute('data-child');

        // Parse the JSON string into an array of objects
        let childrenOptions = [];
        if (children) {
            childrenOptions = JSON.parse(children);
        }

        // Clear the second select
        select2.innerHTML = '<option value="">Select a Child</option>';

        // Populate the second select with child options
        childrenOptions.forEach(child => {
            const option = document.createElement("option");
            option.value = child.id; // Assuming each child has an id
            option.textContent = child.name; // Assuming each child has a name
            select2.appendChild(option);
        });
    });

</script>
                                    <div class="form-group col-6">
                                        <label>{{ __('age_categories') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="age_range_id" name="age_range_id" class="form-control  " required>
                                            <option value="" selected disabled>{{ __('age_categories_select') }}
                                            </option>
                                            @foreach ($age_categories as $age_category)
                                                <option value="{{ @$age_category->value }}"
                                                    {{ @$item->age_range_id == $age_category->value ? 'selected' : '' }}>
                                                    {{ @$age_category->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group col-6">
                                        <label>{{ __('lessons_follow_up') }}
                                            <span class="text-danger"></span></label>
                                        <select id="lessons_follow_up" name="lessons_follow_up" class="form-control   "
                                            required>
                                            <option value="" selected disabled>{{ __('type_select') }} </option>

                                            <option value="1" {{ @$item->lessons_follow_up == 1 ? 'selected' : '' }}>
                                                {{ __('yes') }}
                                            </option>
                                            <option value="0" {{ @$item->lessons_follow_up == 0 ? 'selected' : '' }}>
                                                {{ __('no') }}
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{ __('can_subscribe_to_session_group') }}
                                            <span class="text-danger"></span></label>
                                        <select id="can_subscribe_to_session_group" name="can_subscribe_to_session_group" class="form-control   "
                                            required>
                                            <option value="" selected disabled>{{ __('type_select') }} </option>

                                            <option value="1" {{ @$item->can_subscribe_to_session_group == 1 ? 'selected' : '' }}>
                                                {{ __('yes') }}
                                            </option>
                                            <option value="0" {{ @$item->can_subscribe_to_session_group == 0 ? 'selected' : '' }}>
                                                {{ __('no') }}
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{ __('can_subscribe_to_session') }}
                                            <span class="text-danger"></span></label>
                                        <select id="can_subscribe_to_session" name="can_subscribe_to_session" class="form-control   "
                                            required>
                                            <option value="" selected disabled>{{ __('type_select') }} </option>

                                            <option value="1" {{ @$item->can_subscribe_to_session == 1 ? 'selected' : '' }}>
                                                {{ __('yes') }}
                                            </option>
                                            <option value="0" {{ @$item->can_subscribe_to_session == 0 ? 'selected' : '' }}>
                                                {{ __('no') }}
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{ __('open_installments') }}
                                            <span class="text-danger"></span></label>
                                        <select id="open_installments" name="open_installments" class="form-control   "
                                            required>
                                            <option value="" selected disabled>{{ __('type_select') }} </option>

                                            <option value="1" {{ @$item->open_installments == 1 ? 'selected' : '' }}>
                                                {{ __('yes') }}
                                            </option>
                                            <option value="0" {{ @$item->open_installments == 0 ? 'selected' : '' }}>
                                                {{ __('no') }}
                                            </option>

                                        </select>
                                    </div>

                                    <div class="form-group col-6">
                                        <label>{{__('start_date')}}
                                            <span class="text-danger"></span>
                                        </label>
                                        <br>
                                        <div class="input-group date">
                                            <input type="datetime-local"
                                                class="form-control   "
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
                                                class="form-control   "
                                                name="end_date"
                                                value="{{(isset($item) && $item->end_date!='')?$item->end_date :'' }}"
                                            />

                                        </div>
                                    </div>

                                    {{-- <div class="form-group col-6">
                                        <label>{{__('number_of_free_lessons')}}
                                            <span class="text-danger"></span></label>
                                        <input type="number" class="form-control  "
                                            name="num_lessons"
                                            value="{{(isset($item) && $item->num_lessons!='')?$item->num_lessons :'' }}"/>
                                    </div> --}}

                                    <div class="col-12">
                                        <div class="row">
                                            <label>{{ __('welcome_vidoes') }}</label>
                                            <div class="form-group  col-lg-3">
                                                @php
                                                    $videoType = @$item->video_type;
                                                @endphp
                                                <select class="selectpicker" id="videoType" name="video_type">
                                                    <option value="" {{ @$videoType == '' ? 'selected' : '' }}>
                                                        {{ __('type_select') }}</option>
                                                    <option value="link" {{ @$videoType == 'link' ? 'selected' : '' }}>
                                                        {{ __('external_link') }}</option>
                                                    <option value="file" {{ @$videoType == 'file' ? 'selected' : '' }}>
                                                        {{ __('file') }}</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-9 form-group link">
                                                <input class="form-control" type="text" name="video_link"
                                                    value="{{ @$videoType == 'link' ? @$item->video : '' }}"
                                                    placeholder="YouTube or Vimeo iframe" />
                                            </div>
                                            <div class="col-lg-9 form-group file">
                                                <div class="form-group col-6">
                                                    <div class="form-group text-center">
                                                        <label class="input-image-preview d-block px-3 pointer"
                                                            for="course_demo_video">
                                                            <input class="input-file-image-1" type="file"
                                                                name="video_file" id="course_demo_video" accept=".mp4">
                                                            <span
                                                                class="img-show h-100 d-flex align-items-center py-1"></span>
                                                            <span
                                                                class="input-image-container d-flex align-items-center justify-content-between h-100">
                                                                <div class="flipthis-wrapper">
                                                                    <span class=""> {{ @$item->video }} </span>
                                                                </div>
                                                                <span class="d-flex align-items-center"><i
                                                                        class="fa-light fa-paperclip fa-lg"></i></span>
                                                            </span>
                                                        </label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <label class="mb-3">{{ __('course_image') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group row align-items-center">
                                            <div class="text-start">
                                                <div class="image-input image-input-outline">
                                                    {{-- Image preview wrapper --}}
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ imageUrl(@$item->image) }})">
                                                    </div>

                                                    <label for="preview-input-image-1"
                                                        class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow"
                                                        data-image-input-action="change"><i
                                                            class="fa fa-pen fs-6"></i></label>
                                                    <input type="file" id="preview-input-image-1"
                                                        class="preview-input-image-1 d-none" name="image"
                                                        accept=".png, .jpg, .jpeg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <label class="mb-3">{{ __('cover_image') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="form-group row align-items-center">
                                            <div class="text-start">
                                                <div class="image-input image-input-outline">
                                                    {{-- Image preview wrapper --}}
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ imageUrl(@$item->cover_image) }})">
                                                    </div>

                                                    <label for="preview-input-image-2"
                                                        class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow"
                                                        data-image-input-action="change"><i
                                                            class="fa fa-pen fs-6"></i></label>
                                                    <input type="file" id="preview-input-image-2"
                                                        class="preview-input-image-2 d-none" name="cover_image"
                                                        accept=".png, .jpg, .jpeg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-4 col-sm-6">
                                        <label class="mb-3">{{ __('video_image') }}</label>
                                        <div class="form-group row align-items-center">
                                            <div class="text-start">
                                                <div class="image-input image-input-outline">
                                                    {{-- Image preview wrapper --}}
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url({{ imageUrl(@$item->video_image) }})">
                                                    </div>

                                                    <label for="preview-input-image-3"
                                                        class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow"
                                                        data-image-input-action="change"><i
                                                            class="fa fa-pen fs-6"></i></label>
                                                    <input type="file" id="preview-input-image-3"
                                                        class="preview-input-image-3 d-none" name="video_image"
                                                        accept=".png, .jpg, .jpeg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @include('front.user.lecturer.courses.new_course.components.save_button')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Content-->
        </div>
    </section>

    @push('front_js')
        @if (@$item)
            <script src="{{ asset('assets/panel/js/post.js') }}"></script>
        @endif
        @include('front.user.lecturer.courses.new_course.partials.scripts')
        <script src="{{ asset('assets/front/js/post.js') }}"></script>
        <script src="{{ asset('assets/front/lecturer/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
        <script src="{{ asset('assets/front/lecturer/js/forms/editors/tinymce.js') }}?v=1"></script>

        <script>
            $(document).ready(function() {
                checkVideoType($('#videoType').val());
            });

            $(document).on("change", "#videoType", function() {
                checkVideoType($(this).val());
            });

            function checkVideoType(videoType) {
                $('.file').hide();
                $('.link').hide();
                if (videoType == 'file') {
                    $('.file').show();
                } else if (videoType == 'link') {
                    $('.link').show();
                }
            }
        </script>
    @endpush
@endsection
