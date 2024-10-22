@extends('panel.layouts.index', ['sub_title' => 'الكوبونات', 'is_active' => 'coupons'])
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
                'title' => 'الرئيسية',
                'link' => route('panel.home'),
            ],
            [
                'title' => 'الكوبونات ',
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
                                        <label>الاسم
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ isset($item) ? @$item->title : '' }}" required />
                                    </div>
                                    <div class="form-group mt-2">
                                        <label>الكود
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="code" class="form-control"
                                            value="{{ isset($item) ? @$item->code : (new \App\Helper\CouponGenerator)::generateCoupon()  }}" required />
                                    </div>
                                    <div class="form-group">
                                        <label>عدد مرات الاستعمال
                                            <span class="text-info">
                                                اتركه فارغ اذا كان لا يوجد حد لمرات الاستخدام
                                            </span></label>
                                        <input type="text" name="num_uses" class="form-control"
                                            value="{{ isset($item) ? @$item->num_uses : '' }}" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-2 col-form-label">
                                            النوع
                                        </label>
                                        <div class="col-9 col-form-label">
                                            <div class="radio-inline">
                                                <label class="radio radio-success">
                                                    <input type="radio" name="amount_type" value="rate"
                                                        {{ isset($item) ? (@$item->amount_type == 'rate' ? 'checked' : '') : 'checked' }} />
                                                    <span></span>
                                                    نسبة
                                                </label>
                                                <label class="radio radio-success">
                                                    <input type="radio" name="amount_type" value="fixed"
                                                        {{ isset($item) ? (@$item->amount_type == 'fixed' ? 'checked' : '') : '' }} />
                                                    <span></span>
                                                    ثابت
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>القيمة
                                            <span class="text-danger">*</span></label>
                                        <input type="text" name="amount" class="form-control mb-5"
                                            value="{{ isset($item) ? @$item->amount : '' }}" required />
                                    </div>
                                    <div class="form-group">
                                        <label>تاريخ الانتهاء
                                            <span class="text-info">
                                                اتركه فارغ اذا كان لا يوجد فترة زمنية معينه لانتهاء صلاحيه الكوبون
                                            </span>
                                        </label>
                                        <div class="input-group ">
                                            <input type="date" class="form-control mb-5 directionTextalign" name="expiry_date"
                                                value="{{ isset($item) && $item->expiry_date != '' ? $item->expiry_date : '' }}" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>المسوق
                                            <span class="text-info">
                                                بإمكانك ربط الكوبون بأحد المسوقين
                                            </span></label>
                                        @php
                                            $marketers = [];
                                            if (isset($item)) {
                                                $marketers = $item->marketers;
                                            }
                                        @endphp

                                        <select class="form-control mb-5 text-right directionRTL" name="teacher_id"
                                            id="search_marketers">
                                            @if (isset($item))
                                                <option selected value="{{ @$item->teacher->id }}">
                                                    {{ @$item->teacher->name }}
                                                </option>
                                            @endif
                                        </select>
                                        {{-- <select class="form-control p-1 text-left select2 "
                                name="marketer_ids[]"  id="search_marketers" >
                                @foreach ($marketers as $marketer)
                                <option  selected value="{{@$marketer->user->id}}">
                                    {{@$marketer->user->name}}
                                </option>
                                @endforeach
                            </select> --}}
                                    </div>
                                    <div class="marketer-options"
                                        @if (count($marketers) == 0) style="display:none" @endif>
                                        <div class="form-group row">
                                            <label class="col-2 col-form-label">
                                                نوع نسبه المسوق
                                            </label>
                                            <div class="col-9 col-form-label">
                                                <div class="radio-inline">
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="marketer_amount_type" value="rate"
                                                            {{ isset($item) ? (@$item->marketer_amount_type == 'rate' ? 'checked' : '') : 'checked' }} />
                                                        <span></span>
                                                        نسبة
                                                    </label>
                                                    <label class="radio radio-success">
                                                        <input type="radio" name="marketer_amount_type" value="fixed"
                                                            {{ isset($item) ? (@$item->marketer_amount_type == 'fixed' ? 'checked' : '') : '' }} />
                                                        <span></span>
                                                        ثابت
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>قيمة المسوق
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="marketer_amount" class="form-control"
                                                value="{{ isset($item) ? @$item->marketer_amount : '' }}" required />
                                        </div>
                                        <div class="form-group">
                                            <label>قيمة المسوق من كل عمليه تسجيل طالب جديد
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
                                    <a href="{{route('panel.coupons.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
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
            </script>
        @endpush
    @stop
