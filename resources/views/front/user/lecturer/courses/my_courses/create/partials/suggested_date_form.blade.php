<div data-repeater-item="item" class="form-group row align-items-center">
    <div class="col-md-12">
        <div class="row">
            <input type="hidden" value="{{ isset($suggested_date) ? $suggested_date->id : 0 }}" name="suggested_date_id" />
            <div class="col-md-3">
                <div class="form-group">
                    <label>{{ __('date') }}
                        <span class="text-danger">*</span></label>
                    <input type="date" class="form-control  " placeholder="{{ __('date') }}" name="start_date"
                        value="{{ isset($suggested_date) && $suggested_date->start_date != '' ? $suggested_date->start_date : '' }}" />

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>{{ __('time') }}
                        <span class="text-danger">*</span></label>
                    <input type="time" class="form-control  " placeholder="{{ __('time') }}" name="start_time" onfocus="this.showPicker()"
                        value="{{ isset($suggested_date) && $suggested_date->start_time != '' ? $suggested_date->start_time : '' }}" />

                </div>
            </div>



            <div class="col-md-3">
                <div class="form-group">
                    <label>{{ __('user_status') }}
                        <span class="text-danger">*</span></label>
                    @php
                        $is_active = 1;
                        if (isset($suggested_date)) {
                            $is_active = $suggested_date->is_active;
                        }
                    @endphp
                    <select id="is_active" name="is_active" class="form-control" required>
                        <option value="" selected disabled>{{ __('active_status_hint') }}</option>
                        <option value="1" {{ @$is_active == 1 ? 'selected' : '' }}>
                            {{ __('yes') }}
                        </option>
                        <option value="0" {{ @$is_active == 0 ? 'selected' : '' }}>
                            {{ __('no') }}
                        </option>
                    </select>

                </div>
            </div>

        </div>
    </div>
    <div class="col-md-2">
        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
            <i class="la la-trash-o"></i>{{ __('delete') }}</a>
    </div>
    <div class="col-12">
        <div class="separator separator-dashed  separator-dashed-dark my-8"></div>
    </div>
</div>
