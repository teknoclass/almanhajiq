@extends('panel.layouts.index',['sub_title' =>__('roles') ,'is_active'=>'roles'])
@section('contion')

    @php
        $item = isset($item) ? $item: null;
        $title_page=__('add_roles');
            if(isset($item)){
                $title_page=__('edit_roles');
            }
        $breadcrumb_links=[
        [
        'title'=>__('home'),
        'link'=>route('panel.home'),
        ],
        [
        'title'=>__('roles'),
        'link'=>route('panel.roles.all.index'),
        ],
        [
        'title'=>$title_page,
        'link'=>'#',
        ]
        ];

        $permissions=[

        [
        'name'=>__('home'),
        'permissions'=>[
        'show_home'=>__('home'),
        'show_inbox'=>__('contact_us_message'),
        ],
        ],
        [
        'name'=>__('course_section'),
        'permissions'=>[
           'show_add_course_requests'=>__('add_course_requests'),
           'show_courses'=>__('course'),
           'show_course_levels'=>__('course_levels'),
           'show_course_languages'=>__('course_languages'),
           'show_course_categories'=>__('course_category'),
           'show_age_categories'=>__('age_categories'),
           'show_private_lessons'=>__('private_lessons'),
           'show_course_students'=>__('students'),
           'show_course_comments'=>__('course_comments'),
           'show_course_ratings'=>__('course_ratings'),
           'show_private_lesson_ratings'=>__('private_lessons_rating'),
           'show_certificate_templates'=>__('certificate_templates')
        ],
        ],
        [
        'name'=>__('home_edit'),
        'permissions'=>[
        'show_home_page_sections'=> __('home_page_sections'),
        'show_sliders'=> __('header_permission'),
        'show_statistics'=>__('statistics'),
        'show_our_partners'=>__('our_partners'),
        'show_our_services'=>__('services'),
        'show_students_opinions'=>__('students_opinions'),
        'show_work_steps'=>__('work_steps'),
        'show_our_messages'=>__('messages'),
        'show_our_teams'=>__('our_teams'),
        ],
        ],
        [
        'name'=>__('web_pages'),
        'permissions'=>[
        'show_pages'=>__('pages'),
        'show_faqs'=>__('faqs'),
        'show_post_category'=>__('post_category'),
        'show_posts'=>__('post'),
        "show_posts_comments"=>__('post_comments')
        ],
        ],
        [
        'name'=>__('join_as_teacher_requests'),
        'permissions'=>[
        'show_join_as_teacher_requests'=>__('join_as_teacher_requests'),
        'show_joining_certificates'=>__('certificates'),
        'show_joining_sections'=>__('sections'),
        'show_joining_course'=>__('materials'),
        ],
        ],
        [
        'name'=>__('users'),
        'permissions'=>[
        'show_admins'=>__('admins'),
        'show_roles'=>__('roles'),
        'show_users'=>__('users'),
        'show_countries'=>__('countries'),
         'show_login_activity'=>__('user_login_activiy'),
        ],
        ],
        [
        'name'=>__('finance'),
        'permissions'=>[
        'show_transactions'=>__('transactions'),
        'show_withdrawal_requests'=>__('withdrawal_requests'),
        'show_banks'=>__('banks')
        ]
        ],

        [
        'name'=>'المسوقين',
        'permissions'=>[
        'show_marketers_joining_requests'=>'طلبات الانضمام كمسوق',
        'show_marketers_templates'=>'قوالب المسوقين',
        'show_coupons'=>'الكوبونات',
        ],
        ],
        [
        'name'=>__('system_setting'),
        'permissions'=>[
        'show_settings'=>__('setting'),
        'show_languages'=>__('languages'),
        'show_notifications'=>__('notifications'),
        ]
        ]
    ];


    @endphp
    @section('title', $title_page)
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">


        <!--begin::Form-->
        <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}"
              class="w-100">
            @csrf

            <div class="container">
                @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
                <div class="row">


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

                                <div class="form-group">
                                    <label for="label_name">{{__('name')}}

                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                           class="form-control mb-10 d-flex align-items-center justify-content-between"
                                           value="{{isset($item)?@$item->name:''}}" required id="label_name"
                                           placeholder=""/>
                                </div>


                                @foreach($permissions as $permission)

                                    <div class="form-group">
                                        <h5>{{@$permission['name']}}</h5>
                                        <fieldset>
                                            <legend>
                                                <label class="checkbox">
                                                    <input type="checkbox" class="checkAll">
                                                    <span class="first"></span>
                                                </label>
                                            </legend>
                                            <div class="row">
                                                @foreach($permission['permissions'] as $key => $value)

                                                    <div class="col-md-6 mb-4">
                                                        @php
                                                            $checked='';
                                                            try{
                                                            if(isset($item)){
                                                            if($item->hasPermissionTo($key)){
                                                            $checked='checked';
                                                            }
                                                            }

                                                            } catch (Exception $e) {

                                                            }


                                                        @endphp


                                                        <label class="checkbox ">
                                                            <input name="permissions[]" {{@$checked}} value="{{@$key}}"
                                                                   type="checkbox">
                                                            <span class="mr-2"></span>
                                                            {{@$value}}
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </fieldset>
                                    </div>

                                @endforeach


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

                                <a href="{{route('panel.roles.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                            </div>

                            <!--end::Form-->
                        </div>
                        <!--end::Card-->


                    </div>


                </div>
            </div>


        </form>


        @push('panel_js')
            <script src="{{asset('assets/panel/js/post.js')}}"></script>
            <script>
                $(".checkAll").click(function () {
                    $(this).closest('.form-group').find('input:checkbox').not(this).prop('checked', this.checked);
                });
            </script>


    @endpush

@stop
