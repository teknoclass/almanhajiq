@extends('panel.layouts.index',['sub_title' =>__('post') ,'is_active'=>'posts'])
@section('contion')
    @php
        $item = isset($item) ? $item: null;
    @endphp

        @php
            $title_page=__('add_post');
            if(isset($item)){
            $title_page=__('edit_post');
                       }
           $breadcrumb_links=[
           [
           'title'=>__('home'),
           'link'=>route('panel.home'),
           ],
            [
           'title'=>__('post'),
           'link'=>route('panel.posts.all.index'),
                    ],
           [
           'title'=>$title_page,
           'link'=>'#',
           ],
           ]
        @endphp
    @section('title', $title_page)
        <!--begin::Entry-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container">
            @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
            <!--begin::Container-->
            <!--begin::Form-->
            <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}"
                  url="{{url()->current()}}" class="w-100">
                @csrf
                <input type="hidden" value="{{@$item->image}}" name="image" id="image"/>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">{{$title_page}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    @foreach(locales() as $locale => $value)
                                        <div class="form-group">
                                            <label>{{__('title')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <input type="text" name="title_{{$locale}}" class="form-control"
                                                   value="{{isset($item)?@$item->translate($locale)->title:''}}"
                                                   required
                                            />
                                        </div>
                                        <div class="form-group mt-4">
                                            <label>{{__('description')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <textarea type="text"
                                                      id="text_{{$locale}}"
                                                      name="text_{{$locale}}" class="form-control tinymce"
                                                      required rows="5"
                                            >{{isset($item)?@$item->translate($locale)->text:''}}</textarea>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="exampleInputPassword1">{{__('post_keys')}}
                                                ({{ __($value) }} )
                                                <span class="text-danger">*</span></label>
                                            <input id="kt_tagify_1_{{$locale}}"
                                                   class="form-control" name='tags_{{$locale}}'
                                                   placeholder=''
                                                   value="{{isset($item)?@$item->translate($locale)->tags:''}}"
                                                   required
                                            />
                                        </div>
                                    @endforeach

                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <div class="col-md-3 postCreatePage">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('action')}}</h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body  d-flex align-items-center">
                                    @include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

                                    <a href="{{route('panel.posts.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('post_date')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <div class="input-group date">
                                                <input type="text" class="form-control" readonly name="date_publication"
                                                       value="{{isset($item)?$item->date_publication :date('m/d/Y') }}"
                                                       id="kt_datepicker_3" required/>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('category')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <select id="category_id" name="category_id" class="form-control"
                                                    required>
                                                <option value="">{{__('category_select')}}</option>
                                                @foreach($blog_categories as $blog_category)
                                                    <option
                                                        value="{{@$blog_category->value}}" {{@$item->category_id==$blog_category->value ?'selected' :''}}>{{@$blog_category->name}}  </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('author')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <select id="search_lecturers"   name="user_id"
                                                    class="form-control" required>

                                                    <option  selected value="{{@$item->user->id}}">
                                                        {{@$item->user->name}}
                                                    </option>

                                            </select>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!--end::Form-->
                            <!--end::Card-->
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title"> {{__('image')}} </h3>
                                </div>
                                <!--begin::Form-->
                                <div class="card-body">
                                    <div class="form-group row align-items-center">
                                        <div class="col-lg-12 col-xl-12 text-center">
                                            <!--begin::Image input-->
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                 style="background-image: url({{imageUrl(@$item->image)}})">
                                                <!--begin::Image preview wrapper-->
                                                <div class="image-input-wrapper w-125px h-125px"
                                                     style="background-image: url({{imageUrl(@$item->image)}})"></div>
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
                                                    <input type="file" class="fileupload"  accept=".png, .jpg, .jpeg"/>
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
<script>
    window.select2_hint = '{{__('select2_search_hint')}}';

</script>
            <script src="{{asset('assets/panel/js/post.js')}}"></script>
            <script src="{{asset('assets/panel/js/image-input.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/tagify.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/bootstrap-datepicker.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/widgets/select2.js')}}"></script>
            <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
            <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @if( app()->isLocale('ar'))
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
            @else
                    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymceEN.js')}}?v=1"></script>
            @endif
    @endpush
@stop
