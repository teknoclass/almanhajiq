
<div class="bg-white p-4 rounded-4">
    <ul class="nav nav-pills mb-3 nav-pills-circulum" role="tablist">
        @foreach($categories as $key=>$category)
            <li class="nav-item waves-effect waves-light">
                <a class="nav-link   {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#category_{{$key}}" role="tab">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block"> {{@$category->name}} </span>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div class="tab-content p-3 text-muted">
@foreach($categories as $key2=>$category)

    <div class="tab-pane  {{ $key2 == 0 ? 'active' : '' }}" id="category_{{$key2}}" role="tabpanel">

    <form class="form_category" id="form_category_{{$category->id}}" type="{{$category->id}}" action="{{route('user.lecturer.private_lessons.settings.store-prices')}}" to="#" method="post">
                    @csrf
                    <!--end::Row-->
                    <input type="hidden" name="category_id" value="{{@$category->value}}">
                    <h2 class="font-medium text-start">{{ __('online_lessons') }}</h2>
                    <div class="bg-white p-4 rounded-4">
                        <div class="row">
                            <div class="form-group col-6">
                                <h3>{{ __('price') }}</h3>
                                <div class="input-icon left">
                                    <input name="online_price" value="{{ @$category->prices[0]->online_price }}" class="form-control group-date" type="text" placeholder="" />
                                    <div class="icon"><strong>$</strong></div>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <h3>{{ __('discount_amount') }} (%)</h3>
                                <div class="input-icon left">
                                    <input name="online_discount" value="{{ @$category->prices[0]->online_discount }}" class="form-control" type="text" placeholder="" />
                                    <div class="icon"><strong>%</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    @if (@$settings->valueOf('offline_private_lessons'))
                        <h2 class="font-medium text-start pt-5">{{ __('offline_lessons') }}</h2>
                        <div class="bg-white p-4 rounded-4 mt-2">
                            <div class="row align-items-center">
                                {{-- <div class="form-group col-6">
                                    <div class="d-lg-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center mb-2 mb-lg-0">
                                        <h3>انضم للقائمة البريدية</h3>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input name="" class="form-check-input" type="checkbox" role="switch">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group col-6">
                                    <h3>{{ __('price') }}</h3>
                                    <div class="input-icon left">
                                        <input name="offline_price" value="{{ @$category->prices[0]->offline_price }}" class="form-control group-date" type="text" placeholder="" />
                                        <div class="icon"><strong>$</strong></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <h3>{{ __('discount_amount') }} (%)</h3>
                                    <div class="input-icon left">
                                        <input name="offline_discount" value="{{ @$category->prices[0]->offline_discount }}" class="form-control" type="text" placeholder="" />
                                        <div class="icon"><strong>%</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <h2 class="font-medium text-start pt-5">{{ __('groups_private_lessons') }}</h2>
                    <div class="bg-white p-4 rounded-4 mt-2">
                        <div class="row">
                            <div class="form-group col-6">
                                <div class="d-lg-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center mb-2 mb-lg-0">
                                    <h3>{{ __('available_for_group_lessons') }}</h3>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input name="accept_group" type="hidden" value="0">
                                            <input name="accept_group" {{ @$category->prices[0]->accept_group ? 'checked' : '' }}  value="1" class="form-check-input" type="checkbox" role="switch">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <h3 class="mt-2 mb-1"><strong>{{ __('groups_private_lessons_options') }} ({{ __('online') }})</strong></h3>
                            <div class="form-group col-4">
                                <h4>{{ __('minimum_students_count') }}</h4>
                                <div class="input-icon left">
                                    <input name="online_group_min_no" value="{{ @$category->prices[0]->online_group_min_no }}" class="form-control" type="text" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <h4>{{ __('maximum_students_count') }}</h4>
                                <div class="input-icon left">
                                    <input name="online_group_max_no" value="{{ @$category->prices[0]->online_group_max_no }}" class="form-control" type="text" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group col-4">
                                <h4>{{ __('price') }}</h4>
                                <div class="input-icon left">
                                    <input name="online_group_price" value="{{@$category->prices[0]->online_group_price }}" class="form-control group-date" type="text" placeholder="" />
                                    <div class="icon"><strong>$</strong></div>
                                </div>
                            </div>

                            @if (@$settings->valueOf('offline_private_lessons'))
                                <h3 class="mt-2 mb-1"><strong>{{ __('groups_private_lessons_options') }} ({{ __('offline') }})</strong></h3>
                                <div class="form-group col-4">
                                    <h4>{{ __('minimum_students_count') }}</h4>
                                    <div class="input-icon left">
                                        <input name="offline_group_min_no" value="{{ @$category->prices[0]->offline_group_min_no }}" class="form-control" type="text" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <h4>{{ __('maximum_students_count') }}</h4>
                                    <div class="input-icon left">
                                        <input name="offline_group_max_no" value="{{ @$category->prices[0]->offline_group_max_no }}" class="form-control" type="text" placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group col-4">
                                    <h4>{{ __('price') }}</h4>
                                    <div class="input-icon left">
                                        <input name="offline_group_price" value="{{ @$category->prices[0]->offline_group_price }}" class="form-control group-date" type="text" placeholder="" />
                                        <div class="icon"><strong>$</strong></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group text-center mt-2">
                      <button type="submit" id="btn_{{$category->id}}" class="btn btn-primary px-5">{{ __('save') }}</button>
                    </div>
        </form>
    </div>
@endforeach
</div>

