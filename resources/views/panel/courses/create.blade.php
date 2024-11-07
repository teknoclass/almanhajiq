@extends('panel.layouts.index',['sub_title' =>__('courses') ,'is_active'=>'courses'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    @php
        $title_page=__('add_course');
        if(isset($item)){
        $title_page=@$item->title;
        }
        $breadcrumb_links=[
        [
        'title'=>__('home'),
        'link'=>route('panel.home'),
        ],
        [
        'title'=>__('courses'),
        'link'=>route('panel.courses.all.index'),
        ],
        [
        'title'=>$title_page,
        'link'=>'#',
        ],
        ]
    @endphp
    @section('title', $title_page)
    <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">

            <!--begin::Container-->
            <!--begin::Form-->
            <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
                  url="{{url()->current()}}" class="w-100">
                @csrf
                <input type="hidden" value="{{@$item->image}}" name="image" id="image"/>
                <input type="hidden" value="{{@$item->video_image}}" name="video_image" id="image_2"/>
                <input type="hidden" value="{{@$item->cover_image}}" name="cover_image" id="image_3"/>

                <div class="container">
                    @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>__('courses'),])
                    <div class="row">
                        @include('panel.courses.partials.toolbar')
                        <div class="col-md-9">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        {{@$title_page}}
                                    </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    @foreach(locales() as $locale => $value)
                                        <div class="form-group">
                                            <label>{{__('title')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_{{$locale}}"
                                                   class="form-control mb-5"
                                                   value="{{isset($item)?@$item->translate($locale)->title:''}}"
                                                   required/>
                                        </div>
                                        <div class="form-group mb-5">
                                            <label>{{__('description_title')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <textarea type="text" name="description_{{$locale}}"
                                                      id="description_{{$locale}}"
                                                      class="form-control mb-5 tinymce" required
                                                      rows="5">{{isset($item)?@$item->translate($locale)->description:''}}</textarea>
                                        </div>




                                    @endforeach
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('type')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="type" name="type" class="form-control mb-5"
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('status')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="status" name="status" class="form-control mb-5"
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
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('languages')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="language_id" name="language_id"
                                                        class="form-control mb-5"
                                                        required>
                                                    <option value="" selected disabled>{{__('lang_select')}}</option>
                                                    @foreach($languages as $language)
                                                        <option
                                                            value="{{@$language->value}}" {{@$item->language_id==$language->value ?'selected' :''}}>{{@$language->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('level')}}
                                                    <span class="text-danger">*</span></label>
                                                <select  name="level_id"
                                                        class="form-control mb-5"
                                                        required>
                                                    <option value="" selected disabled>{{__('level_select')}}</option>
                                                    @foreach($levels as $level)
                                                        <option
                                                            value="{{@$level->value}}" {{@$item->level_id==$level->value ?'selected' :''}}>{{@$level->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group col-6">
                                            <label>{{ __('grade_level') }}
                                                <span class="text-danger">*</span></label>
                                            <select id="grade_level_id" name="grade_level_id" class="form-control" required>
                                                <option value="" selected disabled>{{ __('level_select') }}</option>
                                                @foreach ($grade_levels as $grade_level)
                                                    <option value="{{ $grade_level->id }}" data-child="{{ json_encode($grade_level->getSubChildren()) }}"{{ old('grade_level_id', @$item->grade_level_id) == $grade_level->id ? 'selected' : '' }}>
                                                        {{ $grade_level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                   
                                        <div class="form-group col-6">
                                            <label>{{ __('grade_sub_level_id') }}
                                                <span class="text-danger">*</span></label>
                                            <select id="sub_level_id" name="grade_sub_level" class="form-control" required>
                                                <option value="" selected disabled>{{ __('grade_sub_level') }}</option>
                                                @if(isset($item)) <option value="{{@App\Models\Category::find(@$item->grade_sub_level)->id ?? ''}}" selected>{{@App\Models\Category::find(@$item->grade_sub_level)->name ?? ""}} </option> @endif
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('material')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="material_id" name="material_id"
                                                        class="form-control mb-5"
                                                        required>
                                                    <option value="" selected
                                                            disabled>{{__('material_select')}}</option>
                                                @if(isset($item)) <option value="{{@App\Models\Category::find(@$item->material_id)->id ?? ''}}" selected>{{@App\Models\Category::find(@$item->material_id)->name ?? ""}} </option> @endif
                                                </select>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-6">
                                            <div class="form-group stdeunt_fields">
                                                <label>{{__('age_categories')}}
                                                    <span class="text-danger">*</span></label>
                                                <select id="age_range_id" name="age_range_id"
                                                        class="form-control mb-5 "
                                                        required>
                                                    <option value="" selected
                                                            disabled>{{__('age_categories_select')}}</option>
                                                    @foreach($age_categories as $age_category)
                                                        <option
                                                            value="{{@$age_category->value}}" {{@$item->age_range_id==$age_category->value ?'selected' :''}}>{{@$age_category->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                     

                                      
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('start_date')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group date">
                                                    <input type="datetime-local"
                                                           class="form-control mb-5 "
                                                           name="start_date"
                                                           value="{{@item->start_date }}"
                                                    />

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('end_date')}}
                                                    <span class="text-danger"></span></label>
                                                <br>
                                                <div class="input-group date">
                                                    <input type="datetime-local"
                                                           class="form-control mb-5 "
                                                           name="end_date"
                                                           value="{{@$item->end_date}}"
                                                    />

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>{{__('lessons_follow_up')}}
                                                    <span class="text-danger"></span></label>
                                                <select id="lessons_follow_up" name="lessons_follow_up" class="form-control mb-5 ">
                                                    <option value="" selected disabled>{{__('type_select')}} </option>

                                                        <option value="1"
                                                            {{@$item->lessons_follow_up==1 ?'selected' :''}}>
                                                            {{__('yes')}}
                                                        </option>
                                                    <option value="0"
                                                        {{@$item->lessons_follow_up==0 ?'selected' :''}}>
                                                        {{__('no')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>{{__('can_subscribe_to_session')}}
                                                    <span class="text-danger"></span></label>
                                                <select id="can_subscribe_to_session" name="can_subscribe_to_session" class="form-control mb-5 ">
                                                    <option value="" selected disabled>{{__('choose_pls')}} </option>

                                                        <option value="1"
                                                            {{@$item->can_subscribe_to_session==1 ?'selected' :''}}>
                                                            {{__('yes')}}
                                                        </option>
                                                    <option value="0"
                                                        {{@$item->can_subscribe_to_session==0 ?'selected' :''}}>
                                                        {{__('no')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>{{__('can_subscribe_to_session_group')}}
                                                    <span class="text-danger"></span></label>
                                                <select id="can_subscribe_to_session_group" name="can_subscribe_to_session_group" class="form-control mb-5 ">
                                                    <option value="" selected disabled>{{__('choose_pls')}} </option>

                                                        <option value="1"
                                                            {{@$item->can_subscribe_to_session_group==1 ?'selected' :''}}>
                                                            {{__('yes')}}
                                                        </option>
                                                    <option value="0"
                                                        {{@$item->can_subscribe_to_session_group==0 ?'selected' :''}}>
                                                        {{__('no')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group" >
                                                <label>{{__('open_installments')}}
                                                    <span class="text-danger"></span></label>
                                                <select id="open_installments" name="open_installments" class="form-control mb-5 ">
                                                    <option value="" selected disabled>{{__('choose_pls')}} </option>

                                                        <option value="1"
                                                            {{@$item->open_installments==1 ?'selected' :''}}>
                                                            {{__('yes')}}
                                                        </option>
                                                    <option value="0"
                                                        {{@$item->open_installments==0 ?'selected' :''}}>
                                                        {{__('no')}}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__('the_trainer')}}
                                                    <span class="text-danger">*</span></label>
                                                <select class="form-control mb-5 "
                                                        name="user_id" id="search_lecturers" required>
                                                    @if(isset($item))
                                                        <option selected value="{{@$item->lecturers->id}}">
                                                            {{@$item->lecturers->name}}
                                                        </option>
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <hr/>

                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <div class="col-md-3">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('action')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body d-flex align-items-center   ">
                                    @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                                    <a href="{{route('panel.courses.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('image')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$item->image)}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$item->image)}})"></div>
                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="{{__('edit')}}">
                                                    <i class="fa fa-pen fs-6"><span class="path1"></span><span
                                                            class="path2"></span></i>

                                                    <!--begin::Inputs-->
                                                    <input type="file" class="fileupload" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="image_remove"/>
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="{{__('cancel')}}">
                                                   <i class="fa fa-ban fs-3"></i>
                                                    </span>
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title=""{{__('cancel')}}"">

                                                <i class="fa fa-ban fs-3"></i>
                                                </span>
                                                <!--end::Cancel button-->
                                            </div>
                                            <!--end::Image input-->
                                            <!--end::Image input placeholder-->

                                            <!--begin::Image input-->

                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->

                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('cover_image')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$item->cover_image)}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$item->cover_image)}})"></div>
                                                <!--end::Image preview wrapper-->

                                                <!--begin::Edit button-->
                                                <label
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="{{__('edit')}}">
                                                    <i class="fa fa-pen fs-6"><span class="path1"></span><span
                                                            class="path2"></span></i>

                                                    <!--begin::Inputs-->
                                                    <input type="file" class="file_another_upload_2"
                                                           accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="image_remove"/>
                                                    <!--end::Inputs-->
                                                </label>
                                                <!--end::Edit button-->

                                                <!--begin::Cancel button-->
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title="{{__('cancel')}}">
                                                   <i class="fa fa-ban fs-3"></i>
                                                    </span>
                                                <span
                                                    class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click"
                                                    title=""{{__('cancel')}}"">

                                                <i class="fa fa-ban fs-3"></i>

                                                </span>

                                                <!--end::Cancel button-->
                                            </div>

                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>

                            <!--end::Card-->


                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{__('welcome_vidoes')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <label>{{__('youtube_link')}}</label>
                                    <input type="text" class=" form-control mb-5"
                                           name="video"
                                           placeholder="{{__('youtube_link')}}"
                                           value="{{(isset($item) && $item->video!='')?$item->video :'' }}"/>
                                    <div class="col-lg-12 col-xl-12 text-center mt-2">


                                        <div class="image-input  image-input-outline" data-kt-image-input="true"
                                             style="background-image: url({{imageUrl(@$item->video_image)}})">
                                            <!--begin::Image preview wrapper-->
                                            <div class="image-input-wrapper w-125px h-125px"
                                                 style="background-image: url({{imageUrl(@$item->video_image)}})"></div>
                                            <!--end::Image preview wrapper-->

                                            <!--begin::Edit button-->
                                            <label
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="{{__('edit')}}">
                                                <i class="fa fa-pen fs-6"><span class="path1"></span><span
                                                        class="path2"></span></i>

                                                <!--begin::Inputs-->
                                                <input type="file" class="file_another_upload"
                                                       accept=".png, .jpg, .jpeg"/>
                                                <input type="hidden" name="image_remove"/>
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Edit button-->

                                            <!--begin::Cancel button-->
                                            <span
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="cancel"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="{{__('cancel')}}">
                                                   <i class="fa fa-ban fs-3"></i>
                                                    </span>
                                            <span
                                                class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="remove"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="{{__('cancel')}}">

                                            <i class="fa fa-ban fs-3"></i>

                                            </span>

                                            <!--end::Cancel button-->
                                        </div>


                                    </div>

                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
            </form>
        </div>>
        @push('panel_js')
            <script>
                window.select2_hint = '{{__('select2_search_hint')}}';

            </script>
            <script src="{{asset('assets/panel/js/post.js')}}"></script>
            <script src="{{asset('assets/panel/js/grade_levels.js')}}"></script>
            <script src="{{asset('assets/panel/js/image-input.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datetimepicker.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/select2.js')}}"></script>
            <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
            @if( app()->isLocale('ar'))
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @else
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
            @endif

            <script>
            $(document).ready(function() {
                $('#grade_level_id').change(function() {
                    let id = $(this).val();
                    $('#sub_level_id').prop('disabled', !id);

                        if (id) {
                            $.ajax({
                                url: `/get-sub-levels/${id}`,
                                type: 'GET',
                                success: function(response) {
                                    $('#sub_level_id').empty();
                                    $('#sub_level_id').empty().append('<option selected readonly disabled value="">{{__('grade_sub_level')}}</option>');

                                    response.forEach(function(response) {
                                        $('#sub_level_id').append(`<option value="${response.id}">${response.name}</option>`);
                                    });
                                }
                            });
                        }
                    });
               
                    $('#sub_level_id').change(function() {
                    let id = $(this).val();
                    $('#material_id').prop('disabled', !id);

                        if (id) {
                            $.ajax({
                                url: `/get-materials/${id}`,
                                type: 'GET',
                                success: function(response) {
                                    $('#material_id').empty();
                                    $('#material_id').empty().append('<option selected readonly disabled value="">{{__('material')}}</option>');
                                    response.forEach(function(response) {
                                        $('#material_id').append(`<option value="${response.id}">${response.name}</option>`);
                                    });
                                }
                            });
                        }
                    });


              
                });
             
            </script>
    @endpush
@stop
