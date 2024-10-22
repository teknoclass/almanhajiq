

@push('front_css')
<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}"/>
@endpush

<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <form id="form" action="{{route('user.lecturer.settings.update')}}" to="{{ url()->current() }}" method="post" enctype="multipart/form-data">
       @csrf
        <div class="row gx-lg-3">
            @foreach (locales() as $locale => $value)
            <div class="col-lg-12 form-group">
                <h3>{{ __('abstract') }} ({{ __($value) }})</h3>
                <textarea class="form-control p-3" rows="2" name="abstract_{{ $locale }}" placeholder="{{ __('abstract') }}">{{isset($lecturer->lecturerSetting->abstract)?@$lecturer->lecturerSetting->translate($locale)->abstract:''}}</textarea>
            </div>
            @endforeach
            @foreach (locales() as $locale => $value)
            <div class="col-lg-12 form-group">
                <h3>{{ __('description_title') }} ({{ __($value) }})</h3>
                <textarea class="form-control p-3" rows="4" name="description_{{ $locale }}" placeholder="{{ __('about_trainer') }}">{{isset($lecturer->lecturerSetting->description)?@$lecturer->lecturerSetting->translate($locale)->description:''}}</textarea>
            </div>
            @endforeach
            <div class="form-group  col-lg-6">
                <h3>{{ __('section') }}</h3>
                <select class="selectpicker" required name="major_id">
                    <option value="" selected disabled>{{__('section')}}</option>
                    @foreach($majors as $major)
                    <option value="{{@$major->value}}" {{@$lecturer->lecturerSetting->major_id==$major->value?'selected':''}}>
                            {{@$major->name}}
                    </option>
                    @endforeach
                </select>
             </div>
             <div class="col-6 form-group">
                <h3>{{ __('experience_years_count') }}</h3>
                <input class="form-control" name="exp_years" value="{{ @$lecturer->lecturerSetting->exp_years }}" type="number" placeholder="{{ __('experience_years_count') }}"/>
            </div>
            @foreach (locales() as $locale => $value)
            <div class="col-6 form-group">
                <h3>{{ __('job_title') }} ({{ __($value) }})</h3>
                <input class="form-control" type="text" name="position_{{ $locale }}" value="{{isset($lecturer->lecturerSetting->position)?@$lecturer->lecturerSetting->translate($locale)->position:''}}" placeholder="{{ __('job_title') }}"/>
            </div>
            @endforeach


            <div class="form-group col-6">
                <input type="hidden" value="{{ @$lecturer->lecturerSetting->video_thumbnail }}" name="video_thumbnail"/>
                <h3>{{ __('video_image') }}</h3>
                <div class="form-group row align-items-center">
                    <div class="text-start">
                        <div class="image-input image-input-outline">
                            {{-- Image preview wrapper --}}
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: url({{ imageUrl(@$lecturer->lecturerSetting->video_thumbnail) }})"></div>

                            <label for="preview-input-image-1" class="btn btn-icon btn-circle btn-color-muted w-25px h-25px bg-body shadow" data-image-input-action="change"><i class="fa fa-pen fs-6"></i></label>
                            <input type="file" id="preview-input-image-1" class="preview-input-image-1 d-none"
                                name="video_thumbnail" accept=".png, .jpg, .jpeg"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <h3>{{ __('welcome_vidoes') }}</h3>
                    <div class="form-group  col-lg-3">
                        @php
                            $videoType = @$lecturer->lecturerSetting->video_type;
                        @endphp
                        <select class="selectpicker" id="videoType" name="video_type">
                            <option value="" {{ @$videoType == "" ? "selected" : "" }}>{{ __('type_select') }}</option>
                            <option value="link" {{ @$videoType == "link" ? "selected" : "" }}>{{ __('external_link') }}</option>
                            <option value="file" {{ @$videoType == "file" ? "selected" : "" }}>{{ __('file') }}</option>
                        </select>
                     </div>
                    <div class="col-lg-9 form-group link">
                        <input class="form-control" type="text" name="video_link" value="{{ (@$videoType == "link") ? @$lecturer->lecturerSetting->video : "" }}" placeholder="YouTube or Vimeo iframe"/>
                    </div>
                    <div class="col-lg-9 form-group file">
                        <div class="form-group col-6">
                            <div class="form-group text-center">
                                <label class="input-image-preview d-block px-3 pointer" for="lecturer_video">
                                    <input class="input-file-image-1" type="file" name="video_file" id="lecturer_video" accept=".mp4">
                                    <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                                    <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                       <div class="flipthis-wrapper">
                                          <span class=""> {{ @$lecturer->lecturerSetting->video }} </span>
                                       </div>
                                       <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                    </span>
                                 </label>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12">
                @include('front.user.lecturer.courses.new_course.components.save_button')
            </div>
        </div>
    </form>

    <div class="row gx-lg-3">
        {{-- Experties --}}
        <div class="col-lg-12 form-group">
            <h3 class="font-medium text-start mb-3 pt-5">{{ __('experiences') }}</h3>
        </div>
        <div class="col-lg-12 form-group">
            <div class="list-add-experty">
                @if (isset($expertise) && count(@$expertise) > 0)
                @foreach ($expertise as $experty)
                <div id="experty_{{ @$experty->id }}" class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                    <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="circle bg-dark ms-2 me-2"></div>
                            <h5 class="cursor-pointer">
                                {{ @$experty->name}}
                            </h5>
                        </div>
                        <div class="d-flex align-items-center ms-lg-auto">
                            <div class="widget_item-action d-flex align-items-center">
                                <div class="widget_item-icon edit-experty" data-bs-toggle="modal" data-bs-target="#modalAddExperty"
                                    data-id="{{ @$experty->id }}"
                                    data-name_ar ="{{ @$experty->{'name:ar'} }}" data-description_ar="{{ @$experty->{'description:ar'} }}"
                                    data-name_en ="{{ @$experty->{'name:en'} }}" data-description_en="{{ @$experty->{'description:en'} }}"
                                    data-start_date="{{ @$experty->start_date }}" data-end_date="{{ @$experty->end_date }}"  >
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </div>
                                <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                                        data-url="{{route('user.lecturer.settings.experty.delete')}}"
                                        data-id="{{ @$experty->id }}" data-is_relpad_page="true"
                                        data-row="experty_{{ @$experty->id }}">
                                    <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <button class="p-1 bg-transparent font-medium btn-add-faq" data-bs-toggle="modal"
                    data-bs-target="#modalAddExperty" id="addExpertyButton" type="button">
                <i class="fa-regular fa-plus ms-2"></i> {{ __('add_new_experience') }}
            </button>
        </div>
        <hr>

        {{-- Languages --}}
        <div class="col-lg-12 form-group">
            <h3 class="font-medium text-start mb-3 pt-5">{{ __('languages') }}</h3>
        </div>
        <div class="col-lg-12 form-group">
            <div class="list-add-language">
                @if (isset($lecturer_languages) && count(@$lecturer_languages) > 0)
                @foreach ($lecturer_languages as $language)
                <div id="language_{{ @$language->id }}" class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                    <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="circle bg-dark ms-2 me-2"></div>
                            <h5 class="cursor-pointer">
                                {{ @$language->category->name}}
                            </h5>
                        </div>
                        <div class="d-flex align-items-center ms-lg-auto">
                            <div class="widget_item-action d-flex align-items-center">
                                <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                                        data-url="{{route('user.lecturer.settings.category.delete')}}"
                                        data-id="{{ @$language->id }}" data-is_relpad_page="true"
                                        data-row="language_{{ @$language->id }}">
                                    <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <button class="p-1 bg-transparent font-medium btn-add-faq" data-bs-toggle="modal"
                    data-bs-target="#modalAddLanguage" id="addLanguageButton" type="button">
                <i class="fa-regular fa-plus ms-2"></i> {{ __('add_language') }}
            </button>
        </div>
        <hr>
        {{-- Materials --}}
        <div class="col-lg-12 form-group">
            <h3 class="font-medium text-start mb-3 pt-5">{{ __('materials') }}</h3>
        </div>
        <div class="col-lg-12 form-group">
            <div class="list-add-material">
                @if (isset($lecturer_materials) && count(@$lecturer_materials) > 0)
                @foreach ($lecturer_materials as $material)
                <div id="material_{{ @$material->id }}" class="widget_item-section bg-light-green rounded-3 p-2 p-lg-3 mb-3">
                    <div class="bg-white rounded-3 p-2 widget_item-head d-lg-flex align-items-center d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="circle bg-dark ms-2 me-2"></div>
                            <h5 class="cursor-pointer">
                                {{ @$material->category->name}}
                            </h5>
                        </div>
                        <div class="d-flex align-items-center ms-lg-auto">
                            <div class="widget_item-action d-flex align-items-center">
                                <button type="button" class="p-1 text-muted bg-transparent confirm-category"
                                        data-url="{{route('user.lecturer.settings.category.delete')}}"
                                        data-id="{{ @$material->id }}" data-is_relpad_page="true"
                                        data-row="material_{{ @$material->id }}">
                                    <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <button class="p-1 bg-transparent font-medium btn-add-faq" data-bs-toggle="modal"
                    data-bs-target="#modalAddMaterial" id="addMaterialButton" type="button">
                <i class="fa-regular fa-plus ms-2"></i> {{ __('add_new_material') }}
            </button>
        </div>
    </div>
</div>
@include('front.user.lecturer.settings.partials.components.modals')

@push('front_js')


<script src="{{ asset('assets/front/js/lecturer_settings.js') }}"> </script>
<script>
    $(document).ready(function() {

        var expertiesConfig = {
            addButtonId: 'addExpertyButton',
            modalId: 'modalAddExperty',
            formId: 'expertyForm',
            saveButtonId: 'saveExperty',
            apiUrl: '{{ route('user.lecturer.settings.experty.set') }}',
            deleteUrl: '{{route('user.lecturer.settings.experty.delete')}}',
            section: 'experty',
            displayAttributes: ['id', 'name', 'start_date', 'end_date', 'description']
        };

        var languagesConfig = {
            addButtonId: 'addLanguageButton',
            modalId: 'modalAddLanguage',
            formId: 'languageForm',
            saveButtonId: 'saveLanguage',
            apiUrl: '{{ route('user.lecturer.settings.category.set') }}',
            deleteUrl: '{{route('user.lecturer.settings.category.delete')}}',
            section: 'language',
            displayAttributes: ['id', 'name']
        };

        var materialsConfig = {
            addButtonId: 'addMaterialButton',
            modalId: 'modalAddMaterial',
            formId: 'materialForm',
            saveButtonId: 'saveMaterial',
            apiUrl: '{{ route('user.lecturer.settings.category.set') }}',
            deleteUrl: '{{route('user.lecturer.settings.category.delete')}}',
            section: 'material',
            displayAttributes: ['id', 'name']
        };

        var expertiesSection = new PageSection(expertiesConfig, true);
        var languagesSection = new PageSection(languagesConfig, false);
        var materialsSection = new PageSection(materialsConfig, false);

        expertiesSection.init();
        languagesSection.init();
        materialsSection.init();


    });
</script>

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

<script src="{{ asset('assets/front/js/bootstrap-datetimepicker.min.js') }}"> </script>
<script>
    $(".datetimepicker_1").datetimepicker({
        format: "yyyy/mm/dd",
        todayHighlight: true,
        autoclose: true,
        startView: 2,
        minView: 2,
        forceParse: 0,
        pickerPosition: "bottom-left",
    });
</script>
<script>

    $(".input-file-image-1").on('change', function () {
                var $this = $(this)
                    if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    var fileName = this.files[0].name;
                    reader.onload = function (e) {
                        $($this).closest('.input-image-preview').addClass('uploaded')
                     //   $('.input-image-preview .img-show').attr('src', e.target.result).fadeIn();
                        $($this).closest('.input-image-preview').find('.img-show').attr('src', e.target.result).fadeIn();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
</script>
@endpush
