@extends('panel.layouts.index',['sub_title' => __('setting'),'is_active'=>'general_settings'])
@section('title', __('setting'))
@section('contion')
    @push('panel_css')
    @endpush

    @php
        $breadcrumb_links=[
        [
         'title'=>__('home'),
        'link'=>route('panel.home'),
        ],
        [
        'title'=>__('setting'),
        'link'=>'#',
        ],
        ]
    @endphp
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Subheader-->

        <!--begin::Container-->
        <div class="container">
            @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=> __('setting'),])


            <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
                  url="{{url()->current()}}" class="w-100">
                @csrf
                @method('put')
                <input type="hidden" value="{{@$settings->valueOf('logo')}}" name="logo" id="image"/>
                <input type="hidden" value="{{@$settings->valueOf('white_logo')}}" name="white_logo" id="image_2"/>
                <input type="hidden" value="{{@$settings->valueOf('login_image')}}" name="login_image" id="image_3"/>
                <input type="hidden" value="{{@$settings->valueOf('image_how_its_work')}}" name="image_how_its_work" id="image_4"/>
                <input type="hidden" value="{{@$settings->valueOf('image_why_register')}}" name="image_why_register" id="image_10"/>
                <input type="hidden" value="{{@$settings->valueOf('show_result_img')}}" name="show_result_img" id="image_9"/>
                <input type="hidden" value="{{@$settings->valueOf('student_reg_img')}}" name="student_reg_img" id="image_5"/>
                <input type="hidden" value="{{@$settings->valueOf('lecturer_reg_img')}}" name="lecturer_reg_img" id="image_6"/>
                <input type="hidden" value="{{@$settings->valueOf('marketer_reg_img')}}" name="marketer_reg_img" id="image_7"/>
                <input type="hidden" value="{{@$settings->valueOf('verification_img')}}" name="verification_img" id="image_8"/>

                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('setting')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                        @php
                                        $tabs=[
                                            [
                                                'id'        => 'tab_site_settings',
                                                'title'     => __('genral_setting'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => true,
                                            ],
                                            [
                                                'id'        => 'tab_social_media',
                                                'title'     => __('social_setting'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'tab_contact',
                                                'title'     => __('contact_setting'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'tab_points',
                                                'title'     => __('point_setting'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'tab_user_balance',
                                                'title'     => __('balance_setting'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'auth_images',
                                                'title'     => __('auth_images'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'tab_notification_times',
                                                'title'     => __('Scheduled_Notifications_Times'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                            [
                                                'id'        => 'tab_application_settings',
                                                'title'     => __('application_settings'),
                                                'icon'      => 'flaticon-settings-1',
                                                'is_active' => false,
                                            ],
                                        ];
                                        @endphp
                                        @foreach($tabs as $tab)
                                            <li class="nav-item">
                                                <a class="nav-link {{@$tab['is_active']?'active active':''}}"
                                                   data-bs-toggle="tab" href="#{{@$tab['id']}}"> <i
                                                        class="{{$tab['icon']}} mr-2"></i>
                                                    {{$tab['title']}}</a>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="tab_site_settings" role="tabpanel">
                                            @foreach(locales() as $locale => $value)
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('title')}}
                                                        ({{ __($value) }} )
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="title_{{$locale}}"
                                                           class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                           value="{{@$settings->valueOf('title_'.$locale)}}" required
                                                           id="exampleInputPassword1" placeholder=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('description_title')}}
                                                        ({{ __($value) }} )
                                                        <span class="text-danger">*</span></label>
                                                    <textarea type="text" name="describe_{{$locale}}"
                                                              class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                              rows="4"
                                                              required>{{@$settings->valueOf('describe_'.$locale)}}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('footer_text')}}
                                                        ({{ __($value) }} )
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="copyright_{{$locale}}"
                                                           class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                           value="{{@$settings->valueOf('copyright_'.$locale)}}"
                                                           required id="exampleInputPassword1" placeholder=""/>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{__('post_keys')}}
                                                        ({{ __($value) }} )
                                                        <span class="text-danger">*</span></label>
                                                    <input id="kt_tagify_1_{{$locale}}"
                                                           class="form-control mb-10 d-flex align-items-center justify-content-between tagify-input"
                                                           name='tags_{{$locale}}' placeholder=''
                                                           value="{{@$settings->valueOf('tags_'.$locale)}}" required/>
                                                </div>
                                                <hr>
                                            @endforeach
                                            <div class="kt-portlet__body">
                                                <div class="form-group m-form__group row">
                                                   <label for="example-text-input" class="col-4 col-form-label">{{ __('blog') }}</label>
                                                   <div class="col-8">
                                                       <div class="form-check form-switch form-check-custom form-check-solid">
                                                            <input type="hidden" name="blog_status" value="0">
                                                            <span class="switch">
                                                                <label>
                                                                    <input class="form-check-input " type="checkbox" {{ @$settings->valueOf('blog_status') ? 'checked' : ''}} name="blog_status" value="1">
                                                                </label>
                                                            </span>
                                                        </div>
                                                   </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                   <label for="example-text-input" class="col-4 col-form-label">{{ __('forum') }}</label>
                                                   <div class="col-8">
                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                        <input type="hidden" name="forum_status" value="0">
                                                         <span class="switch">
                                                             <label>
                                                                 <input class="form-check-input " type="checkbox" {{ @$settings->valueOf('forum_status') ? 'checked' : ''}} name="forum_status" value="1">
                                                             </label>
                                                         </span>
                                                     </div>
                                                   </div>
                                                </div>
                                                {{-- <div class="form-group m-form__group row">
                                                   <label for="example-text-input" class="col-4 col-form-label">{{ __('offline_private_lessons') }}</label>
                                                   <div class="col-8">
                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                        <input type="hidden" name="offline_private_lessons" value="0">
                                                         <span class="switch">
                                                             <label>
                                                                 <input class="form-check-input " type="checkbox" {{ @$settings->valueOf('offline_private_lessons') ? 'checked' : ''}} name="offline_private_lessons" value="1">
                                                             </label>
                                                         </span>
                                                     </div>
                                                   </div>
                                                </div> --}}
                                                <div class="form-group m-form__group row">
                                                   <label for="example-text-input" class="col-4 col-form-label">{{ __('is_account_confirmation_required') }}</label>
                                                   <div class="col-8">
                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                        <input type="hidden" name="is_account_confirmation_required" value="0">
                                                         <span class="switch">
                                                             <label>
                                                                 <input class="form-check-input " type="checkbox" {{ @$settings->valueOf('is_account_confirmation_required') ? 'checked' : ''}} name="is_account_confirmation_required" value="1">
                                                             </label>
                                                         </span>
                                                     </div>
                                                   </div>
                                                </div>
                                             </div>
                                        </div>

                                        <div class="tab-pane  fade " id="tab_social_media" role="tabpanel">
                                            @foreach($socials as $social)
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">{{$social->name}}</label>
                                                    <input
                                                        class="form-control mb-10 d-flex align-items-center justify-content-between m-input"
                                                        type="text" name="{{$social->key}}"
                                                        value="{{$social->getLink()}}" placeholder="{{$social->name}} ">
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade " id="tab_contact" role="tabpanel">
                                            <div class="form-group">
                                                <label for="email">{{__('email')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="email"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('email')}}" required id="email"
                                                       placeholder=""/>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile">{{__('mobile')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="mobile"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('mobile')}}" required id="mobile"
                                                       placeholder=""/>
                                            </div>
                                          
                                            <div class="form-group">
                                                <label for="mobile">{{__('address')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="address"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('address')}}" required id="address"
                                                       placeholder=""/>
                                            </div>
                                            <div class="form-group">
                                                <label for="map">{{__('map')}}</label>
                                                <input type="text" name="map"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('map')}}" id="map"
                                                       placeholder=""/>
                                            </div>
                                        </div>

                                        <div class="tab-pane  fade" id="tab_points" role="tabpanel">
                                            <div class="form-group">
                                                <label
                                                    for="minimum_withdrawal_points">{{__('minimum_withdrawal_points')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="minimum_withdrawal_points"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('minimum_withdrawal_points')}}"
                                                       required id="minimum_withdrawal_points" placeholder=""/>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="tab_user_balance" role="tabpanel">
                                            <div class="form-group">
                                                <label for="system_commission">{{__('system_commission')}} (%)
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="system_commission"
                                                       class="form-control mb-2 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('system_commission')}}"
                                                       required id="system_commission" placeholder=""/>
                                                <span class="d-block mb-10 " role="alert">
                                                    <strong>
                                                        {{__('system_commission_text')}}
                                                    </strong>
                                                </span>
                                            </div>

                                            <div class="form-group">
                                                <label for="earnings_suspension_period">
                                                    {{__('earnings_suspension_period')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="earnings_suspension_period"
                                                       class="form-control mb-2 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('earnings_suspension_period')}}"
                                                       required id="earnings_suspension_period" placeholder=""/>
                                                <span class="d-block  mb-10" role="alert">
                                                    <strong>
                                                            {{__('earnings_suspension_period_text')}}
                                                    </strong>
                                                </span>
                                            </div>


                                            <div class="form-group">
                                                <label
                                                    for="minimum_withdrawal_balances">{{__('minimum_withdrawal_balances')}}
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" name="minimum_withdrawal_balances"
                                                       class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                       value="{{@$settings->valueOf('minimum_withdrawal_balances')}}"
                                                       required id="minimum_withdrawal_balances" placeholder=""/>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade " id="auth_images" role="tabpanel">
                                            <div class="row">
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="">{{__('login_image')}}</label>
                                                        <div class="form-group row align-items-start    ">
                                                            <div class="col-lg-12 col-xl-12 mt-3">
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                                     style="background-image: url({{imageUrl(@$settings->valueOf('login_image'))}})">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                         style="background-image: url({{imageUrl(@$settings->valueOf('login_image'))}})"></div>
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
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="">{{__('student_reg_img')}}</label>
                                                        <div class="form-group row align-items-start    ">
                                                            <div class="col-lg-12 col-xl-12 mt-3">
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                                     style="background-image: url({{imageUrl(@$settings->valueOf('student_reg_img'))}})">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                         style="background-image: url({{imageUrl(@$settings->valueOf('student_reg_img'))}})"></div>
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
                                                                        <input type="file" class="file_upload_5"
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
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="">{{__('lecturer_reg_img')}}</label>
                                                        <div class="form-group row align-items-start    ">
                                                            <div class="col-lg-12 col-xl-12 mt-3">
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                                     style="background-image: url({{imageUrl(@$settings->valueOf('lecturer_reg_img'))}})">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                         style="background-image: url({{imageUrl(@$settings->valueOf('lecturer_reg_img'))}})"></div>
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
                                                                        <input type="file" class="file_upload_6"
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
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="">{{__('marketer_reg_img')}}</label>
                                                        <div class="form-group row align-items-start    ">
                                                            <div class="col-lg-12 col-xl-12 mt-3">
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                                     style="background-image: url({{imageUrl(@$settings->valueOf('marketer_reg_img'))}})">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                         style="background-image: url({{imageUrl(@$settings->valueOf('marketer_reg_img'))}})"></div>
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
                                                                        <input type="file" class="file_upload_7"
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
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="">{{__('verification_img')}}</label>
                                                        <div class="form-group row align-items-start    ">
                                                            <div class="col-lg-12 col-xl-12 mt-3">
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                                     style="background-image: url({{imageUrl(@$settings->valueOf('verification_img'))}})">
                                                                    <!--begin::Image preview wrapper-->
                                                                    <div class="image-input-wrapper w-125px h-125px"
                                                                         style="background-image: url({{imageUrl(@$settings->valueOf('verification_img'))}})"></div>
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
                                                                        <input type="file" class="file_upload_8"
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
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="tab_notification_times" role="tabpanel">

                                            <div class="form-group">
                                                <label for="can_postpone_hours_before">{{__('can_postpone_hours_before')}}</label>
                                                <input type="number" min="0" name="can_postpone_hours_before"
                                                    class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                    value="{{@$settings->valueOf('can_postpone_hours_before')}}"
                                                    id="can_postpone_hours_before" placeholder="" min="1"
                                                />
                                            </div>

                                          
                                        </div>
                                        <div class="tab-pane fade" id="tab_application_settings" role="tabpanel">

                                            <div class="form-group">
                                                <label for="android_release">{{__('android_release')}}</label>
                                                <input type="text" name="android_release"
                                                    class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                    value="{{@$settings->valueOf('android_release')}}"
                                                    id="android_release" 
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="android_update_status">{{__('android_update_status')}}</label>
                                                <select type="text" name="android_update_status"
                                                    class="form-control mb-10 d-flex align-items-center justify-content-between"
                                              
                                                    id="android_update_status" 
                                                >
                                                <option>{{__('choose_pls')}}</option>
                                                <option value="0" @if(@$settings->valueOf('android_update_status') == 0) selected @endif>{{__('optional')}}</option>
                                                <option value="1" @if(@$settings->valueOf('android_update_status') == 1) selected @endif>{{__('mandatory')}}</option>
                                            </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="ios_release">{{__('ios_release')}}</label>
                                                <input type="text" name="ios_release"
                                                    class="form-control mb-10 d-flex align-items-center justify-content-between"
                                                    value="{{@$settings->valueOf('ios_release')}}"
                                                    id="ios_release"
                                                />
                                            </div>

                                            <div class="form-group">
                                                <label for="ios_update_status">{{__('ios_update_status')}}</label>
                                                <select type="text" name="ios_update_status"
                                                    class="form-control mb-10 d-flex align-items-center justify-content-between"
                                              
                                                    id="ios_update_status" 
                                                >
                                                <option>{{__('choose_pls')}}</option>
                                                <option value="0" @if(@$settings->valueOf('ios_update_status') == 0) selected @endif>{{__('optional')}}</option>
                                                <option value="1" @if(@$settings->valueOf('ios_update_status') == 1) selected @endif>{{__('mandatory')}}</option>
                                            </select>
                                            </div>

                                          
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
                                    <h3 class="card-title"> {{__('action')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body d-flex align-items-center   ">
                                    @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                                    <a href="{{route('panel.home')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{__('logo')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$settings->valueOf('logo'))}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$settings->valueOf('logo'))}})"></div>
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
                                    <h3 class="card-title">{{__('logo_white')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">

                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline bg-black " data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl($settings->valueOf('white_logo'))}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$settings->valueOf('white_logo'))}})"></div>
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
                                    <h3 class="card-title">{{__('image_how_its_work')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">


                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$settings->valueOf('image_how_its_work'))}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$settings->valueOf('image_how_its_work'))}})"></div>
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
                                                    <input type="file" class="file_another_upload_3"
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
                            <!--end::Card-->
                             <!--begin::Card-->
                             <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{__('image_why_register')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">


                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$settings->valueOf('image_why_register'))}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$settings->valueOf('image_why_register'))}})"></div>
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
                                                    <input type="file" class="file_upload_10"
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
                                            <!--end::Image input placeholder-->
                                            <!--begin::Image input-->
                                            <!--end::Image input-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{__('show_result_img')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">


                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$settings->valueOf('show_result_img'))}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$settings->valueOf('show_result_img'))}})"></div>
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
                                                    <input type="file" class="file_upload_9"
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
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @push('panel_js')
            <script src="{{asset('assets/panel/js/post.js')}}?v={{getVersionAssets()}}"></script>
            <!--begin::Page Scripts(used by this page)-->
            <script src="{{asset('assets/panel/js/image-input.js')}}?v={{getVersionAssets()}}"></script>
            <script
                src="{{asset('assets/panel/js/pages/crud/forms/widgets/tagify.js')}}?v={{getVersionAssets()}}"></script>
            <script>
                handleImageUpload('.file_upload_5', '#image_5', '#widthImage', '#heightImage');
                handleImageUpload('.file_upload_6', '#image_6', '#widthImage', '#heightImage');
                handleImageUpload('.file_upload_7', '#image_7', '#widthImage', '#heightImage');
                handleImageUpload('.file_upload_8', '#image_8', '#widthImage', '#heightImage');
                handleImageUpload('.file_upload_9', '#image_9', '#widthImage', '#heightImage');
                handleImageUpload('.file_upload_10', '#image_10', '#widthImage', '#heightImage');

            </script>
    @endpush
@stop
