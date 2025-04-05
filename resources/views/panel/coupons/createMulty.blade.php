@extends('panel.layouts.index', ['sub_title' => __('coupons'), 'is_active' => 'coupons'])
@section('contion')
    @php
        $item = isset($item) ? $item : null;
    @endphp
    @php
       $title_page = __('add');
        if (isset($item)) {
            $title_page = __('edit');
        }
        $breadcrumb_links = [
            [
                'title' => __('home'),
                'link' => route('panel.home'),
            ],
            [
                'title' => __('coupons'),
                'link' => route('panel.coupons.all.index'),
            ],
            [
                'title' => $title_page,
                'link' => '#',
            ],
        ];
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

       <div class="container">
            @include('panel.layouts.breadcrumb', [ 'breadcrumb_links' => $breadcrumb_links, 'title_page' => 'الكوبونات '])
            <!--begin::Entry-->
            <form id="form" method="{{ isset($item) ? 'POST' : 'POST' }}" to="{{ url()->current() }}"
                url="{{ url()->current() }}" class="w-100">
                @csrf
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        {{ @$title_page }}
                                    </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>{{__('name')}}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ isset($item) ? @$item->title : '' }}" required />
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>{{__('Number of codes')}}
                                            <span class="text-danger">*</span></label>
                                            <input type="text" name="number" class="form-control"
                                            value="1" required />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('group_name')}}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="group_name" class="form-control"
                                                value="{{ isset($item) ? @$item->groupo_name : '' }}" required />
                                        </div>
                                    <div class="form-group">
                                        <label>{{__('Number of uses')}}
                                            <span class="text-info">
                                                {{__('Keep it empty if you dont want to use it')}}
                                            </span></label>
                                        <input type="text" name="num_uses" class="form-control"
                                            value="{{ isset($item) ? @$item->num_uses : '' }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">
                                            {{__('type')}}
                                        </label>
                                        <div class="col-9 col-form-label">
                                            <div class="radio-inline">
                                                <label class="radio radio-success">
                                                    <input type="radio" name="amount_type" value="rate"
                                                        {{ isset($item) ? (@$item->amount_type == 'rate' ? 'checked' : '') : 'checked' }} />
                                                    <span></span>
                                                    {{__('percentage')}}
                                                </label>
                                                <label class="radio radio-success">
                                                    <input type="radio" name="amount_type" value="fixed"
                                                        {{ isset($item) ? (@$item->amount_type == 'fixed' ? 'checked' : '') : '' }} />
                                                    <span></span>
                                                    {{__('static')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('value')}}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="amount" class="form-control mb-5"
                                            value="{{ isset($item) ? @$item->amount : '' }}" required />
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('end_date')}}
                                            <span class="text-info">
                                                {{__('Keep it empty if you dont want to use it')}}
                                            </span>
                                        </label>
                                        <div class="input-group ">
                                            <input type="date" class="form-control mb-5 directionTextalign" name="expiry_date"
                                                value="{{ isset($item) && $item->expiry_date != '' ? $item->expiry_date : '' }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('marketer')}}
                                            <span class="text-info">
                                                {{__('You can link the coupon with a marketer')}}
                                            </span></label>
                                        @php
                                            $marketers = [];
                                            if (isset($item)) {
                                                $marketers = $item->marketers;
                                            }
                                        @endphp

                                        <select class="form-control mb-5 text-right directionRTL" name="marketer_id"
                                            id="search_marketers">
                                            @if (isset($item))
                                                <option selected value="{{ @$item->marketer->user->id }}">
                                                    {{ @$item->marketer->user->name }}
                                                </option>
                                            @endif
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label>{{__('course')}}
                                            <span class="text-info">
                                                {{__('Keep it empty if you dont want to use it')}}
                                            </span></label>
                                        @php
                                            $cpnCourses = [];
                                            if (isset($couponCourses)) {
                                                $cpnCourses = $couponCourses;
                                            }
                                        @endphp

                                        <table class="table table-bordered" id="courses-table">
                                            <thead>
                                                <tr>
                                                    <th>{{__('course_name')}}</th>
                                                    <th>{{__('action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cpnCourses as $course)
                                                    <tr>
                                                        <td>{{ $course->course->title }}</td>
                                                        <td>
                                                            <input type="hidden" name="course_ids[]" value="{{ $course->course->id }}">
                                                            <div class="btn btn-danger remove-course">{{__('delete')}}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <select class="form-control mb-5 text-right directionRTL"
                                            id="search_courses">
                                        </select>
                                        <div class="btn btn-primary" id="add-course-coupon">{{__('add')}}</div>

                                    </div>
                                    <div class="marketer-options"
                                        @if (count($marketers) == 0) style="display:none" @endif>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label">
                                                {{__('marketer percentage type')}}
                                            </label>
                                            <div class="col-9 col-form-label">
                                                <div class="radio-inline">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="marketer_amount_type" value="rate"
                                                            {{ isset($item) ? (@$item->marketer_amount_type == 'rate' ? 'checked' : '') : 'checked' }} />
                                                        <span></span>
                                                        {{__('percentage')}}
                                                    </label>
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="marketer_amount_type" value="fixed"
                                                            {{ isset($item) ? (@$item->marketer_amount_type == 'fixed' ? 'checked' : '') : '' }} />
                                                        <span></span>
                                                        {{__('static')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('Marketer value')}}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="marketer_amount" class="form-control"
                                                value="{{ isset($item) ? @$item->marketer_amount : '' }}" required />
                                        </div>
                                        <div class="form-group">
                                            <label>{{__('Marketer value for each register')}}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="marketer_amount_of_registration"
                                                class="form-control"
                                                value="{{ isset($item) ? @$item->marketer_amount_of_registration : '' }}"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <div class="col-md-3">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> الإجراءات</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body d-flex align-items-center   ">
                                    @include('panel.components.btn_submit', ['btn_submit_text' => 'حفظ'])
                                    <a href="{{route('panel.coupons.groups.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
            </form>
       </div>

        @push('panel_js')
            <script src="{{ asset('assets/panel/js/post.js') }}"></script>
            <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
            <script src="{{ asset('assets/panel/js/pages/crud/forms/widgets/select2.js') }}"></script>
            <script>
                $(document).on('change', '#search_marketers', function() {
                    value = $('#search_marketers').val();
                    if (value) {
                        $('.marketer-options').show();
                    }
                });
                document.addEventListener("DOMContentLoaded", function () {
                    document.querySelectorAll(".remove-course").forEach(button => {
                        button.addEventListener("click", function () {
                            this.closest("tr").remove();
                        });
                    });
                    document.getElementById("add-course-coupon").addEventListener("click", function () {
                        let select = document.getElementById("search_courses");
                        let selectedOption = select.options[select.selectedIndex];


                        if (!selectedOption) {
                            customSweetAlert(
                                'error',
                                'يجب عليك اختيار كورس اولا',
                                ''
                            );
                            return;
                        }
                        let courseId = selectedOption.value;
                        let courseName = selectedOption.getAttribute("title");

                        // Check if the course is already added
                        if (document.querySelector(`tr[data-id='${courseId}']`)) {
                            customSweetAlert(
                                'error',
                                'تم اضافة هذا الكورس من قبل',
                                ''
                            );
                            return;
                        }

                        // Create a new table row
                        let tableBody = document.querySelector("#courses-table tbody");
                        let row = document.createElement("tr");
                        row.setAttribute("data-id", courseId);

                        row.innerHTML = `
                            <td>${courseName}</td>
                            <td>
                                <input type="hidden" name="course_ids[]" value="${courseId}">
                                <button type="button" class="btn btn-danger remove-course">{{__('delete')}}</button>
                            </td>
                        `;

                        tableBody.appendChild(row);
                        document.querySelectorAll(".remove-course").forEach(button => {
                            button.addEventListener("click", function () {
                                this.closest("tr").remove();
                            });
                        });
                        select.value = "";
                        select.title = "";
                        selectedOption.remove();
                    });
                });
            </script>


        @endpush
    @stop
