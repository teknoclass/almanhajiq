
    <!-- Start Experties Modal-->
    <div class="modal fade" id="modalAddExperty" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body px-5 py-4">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="text-center mb-4">{{ __('add_new_experience') }}</h2>

                    <form id="expertyForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        @foreach (locales() as $locale => $value)
                        <div class="form-group">
                            <input class="form-control" type="text" id="name_{{ $locale }}" name="name_{{ $locale }}" placeholder="{{ __('experience') }}  ({{ __($value) }})">
                        </div>
                        @endforeach
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="input-icon left">
                                    <input class="form-control datetimepicker_1 group-date" type="text" name="start_date" id="start_date" placeholder="{{ __('start_date') }}" autocomplete="off"/>
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <div class="input-icon left">
                                    <input class="form-control datetimepicker_1 group-date" type="text" name="end_date" id="end_date" placeholder="{{ __('end_date') }}" autocomplete="off"/>
                                    <div class="icon"><i class="fa-light fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        @foreach (locales() as $locale => $value)
                        <div class="form-group">
                            <textarea class="form-control" name="description_{{ $locale }}" id="description_{{ $locale }}" rows="3" placeholder="{{ __('description_title') }} ({{ __($value) }})"></textarea>
                        </div>
                        @endforeach
                        <div class="form-group text-center">
                            <button class="btn btn-primary px-5 btn_submit" id="saveExperty">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Experties Modal-->

    <!-- Start Languages Modal-->
    <div class="modal fade" id="modalAddLanguage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body px-5 py-4">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="text-center mb-4">{{ __('add_language') }}</h2>

                    <form id="languageForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="category_type" id="category_type" value="course_languages">

                        <div class="form-group col-12">
                            <select class="selectpicker" required name="category_id">
                                <option value="" selected disabled>{{__('languages')}}</option>
                                @foreach($languages as $language)
                                <option value="{{@$language->value}}"
                                    {{-- {{@$lecturer->lecturerSetting->major_id==$language->value?'selected':''}} --}}
                                    >
                                        {{@$language->name}}
                                </option>
                                @endforeach
                            </select>
                         </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary px-5" id="saveLanguage">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Languages Modal-->

    <!-- Start Materials Modal-->
    <div class="modal fade" id="modalAddMaterial" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body px-5 py-4">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="text-center mb-4">{{ __('add_new_material') }}</h2>

                    <form id="materialForm">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="category_type" id="category_type" value="joining_course">

                        <div class="form-group col-12">
                            <select class="selectpicker" required name="category_id" id="category_id">
                                <option value="" selected disabled>{{__('materials')}}</option>
                                @foreach($materials as $material)
                                <option value="{{@$material->value}}"
                                    {{-- {{@$lecturer->lecturerSetting->major_id==$material->id?'selected':''}} --}}
                                    >
                                    {{@$material->name}}
                                </option>
                                @endforeach
                            </select>
                         </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary px-5" id="saveMaterial">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Materials Modal-->
