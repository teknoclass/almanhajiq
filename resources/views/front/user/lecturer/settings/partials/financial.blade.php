<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row">

        <div class="col-lg-12 mx-auto">
            <form id="form" action="{{route('user.lecturer.settings.update')}}" to="{{ url()->current() }}" method="post">
               @csrf
               <input type="hidden" name="tab" value="financial">
                <div class="row gx-lg-3 mt-3">
                    <div class="col-lg-6">
                        <div class="form-group select-contry">
                            <h3>{{ __('bank') }}</h3>
                           <select class="selectpicker" required name="bank_id">
                              <option value="" selected disabled>
                                 {{__('bank')}}
                              </option>
                              @foreach($banks as $bank)
                              <option value="{{@$bank->value}}" {{@$lecturer->lecturerSetting->bank_id==$bank->value?'selected':''}}>
                              {{@$bank->name}}
                              </option>
                              @endforeach
                           </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h3>{{ __('name_in_bank') }}</h3>
                            <input class="form-control" name="name_in_bank"  placeholder="{{ __('name_in_bank') }}" required type="text" value="{{@$lecturer->lecturerSetting->name_in_bank}}" />
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <h3>{{ __('iban') }}</h3>
                        <input class="form-control" type="text" name="iban" required value="{{@$lecturer->lecturerSetting->iban}}" placeholder="{{__('iban')}}" />
                    </div>
                    <div class="form-group col-lg-12">
                        <h3>{{ __('account_num') }}</h3>
                        <input class="form-control" type="text" name="account_num" required value="{{@$lecturer->lecturerSetting->account_num}}" placeholder="{{__('account_num')}}" />
                    </div>
                    <div class="form-group d-flex align-items-center justify-content-between">
                        <label class="m-checkbox mb-0">
                            <input type="checkbox" name="agree_conditions" checked disabled>
                            <span class="checkmark"></span>
                            <span class="text-muted">
                                {{ __("disclaimer_message") }}
                            </span>

                        </label>
                    </div>
                </div>

                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
    </div>
</div>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
@endpush
