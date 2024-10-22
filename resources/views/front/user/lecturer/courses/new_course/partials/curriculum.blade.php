<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row">
        <div class="d-lg-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center mb-2 mb-lg-0">
                <h2>الأقسام</h2>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-primary px-4 d-inline-flex align-items-center" data-bs-toggle="modal"
                    data-bs-target="#modalAddSection" id="AddSection"><i class="fa-solid fa-plus me-1"></i> إضافة قسم
                    جديد</button>
            </div>
        </div>


        <div class="mt-4 col-12">
            <div class="accordion" id="accordionSection">
                @include('front.user.lecturer.courses.new_course.components.curriculum.sections')
            </div>
        </div>
    </div>
    <!-- Start Modal-->
    <div class="modal fade" id="modalAddSection" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body px-5 py-4">
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h2 class="text-center mb-4">{{ __('add_new_section') }}</h2>
                    <form id="CourseSectionsForm">
                        @csrf
                        <input type="hidden" name="course_id" id="course_id" value="{{ @$course->id }}">
                        <input type="hidden" name="id" id="id">
                        @foreach (locales() as $locale => $value)
                            <div class="form-group">
                                <label class="mb-2"> {{ __('section_title') }} ({{__($value)}}) </label>
                                <input class="form-control" id="title" type="text"
                                    name="title_{{ $locale }}" />
                            </div>
                        @endforeach
                        <div class="d-lg-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center mb-2 mb-lg-0">
                                <h2>{{ __('active') }}</h2>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        role="switch" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary px-5" id="saveCourseSection">{{ __('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal-->

</div>
