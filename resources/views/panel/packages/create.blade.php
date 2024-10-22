@extends('panel.layouts.index',['sub_title' =>__('packages') ,'is_active'=>request('parent')])
@section('contion')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

   @php
   $item = isset($item) ? $item: null;
   $title_page=__('add');
   if(isset($item)){
   $title_page=__('edit');
   }
   $breadcrumb_links=[
   [
   'title'=>__('home'),
   'link'=>route('panel.home'),
   ],
    [
    'title'=>__('packages'),
    'link'=>'#',
    ],
   [
   'title'=>@$title_page,
   'link'=>'#',
   ],
   ];
   @endphp
    @section('title', $title_page)



   <!--begin::Entry-->

      <!--begin::Container-->

      <!--begin::Form-->
      <form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
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

                        @foreach(locales() as $locale => $value)
                        <div class="form-group">
                            <label>{{__('title')}}
                                ({{ __($value) }} )
                                <span class="text-danger">*</span></label>
                            <input type="text" name="title_{{$locale}}" class="form-control  rounded-pill"
                                   value="{{isset($item)?@$item->translate($locale)->title:''}}"
                                   required
                            />
                        </div>
                        <div class="form-group mt-4">
                            <label>{{__('description')}}
                                ({{ __($value) }} )
                                </label>
                            <textarea type="text"
                                      id="description_{{$locale}}"
                                      name="description_{{$locale}}" class="form-control tinymce  rounded-pill"
                                      required rows="5"
                            >{{isset($item)?@$item->translate($locale)->description:''}}</textarea>
                        </div>


                        <hr>
                        @endforeach

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('price')}}
                                        <span class="text-danger"></span></label>
                                    <br>
                                    <div class="input-group ">
                                        <input type="number"
                                            class="form-control mb-5  rounded-pill directionAlign"
                                            name="price"
                                            value="{{(isset($item) && $item->price!='')?$item->price :'' }}"
                                        />

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('num_hours')}}
                                        <span class="text-danger"></span></label>
                                    <br>
                                    <div class="input-group ">
                                        <input type="number"
                                            class="form-control mb-5  rounded-pill directionAlign"
                                            name="num_hours"
                                            value="{{(isset($item) && $item->num_hours!='')?$item->num_hours :'' }}"
                                        />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        {{__('Package_Type')}}
                                        <span class="text-danger"></span>
                                    </label>
                                    <div class="input-group ">
                                        <select name="type" id="package_type" class="form-control rounded-pillx select2">
                                            <option value="none"        @selected(@$item->package_type == 'none')     >{{__('None')}}</option>
                                            <option value="featured"    @selected(@$item->package_type == 'featured') >{{__('Featured')}}</option>
                                            <option value="best_seller" @selected(@$item->package_type == 'best_seller') >{{__('Best_Seller')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="color-div" style="{{ @$item->package_type == 'featured' ? '' : 'display: none' }}" >
                                <div class="form-group">
                                    <label>{{__('Button_Color')}}
                                        <span class="text-danger"></span>
                                    </label>
                                    <br>
                                    <div class="input-group ">
                                        <input type="color"
                                            class="form-control mb-5  rounded-pill directionAlign"
                                            name="color" value="{{ @$item->color }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{__('Number_of_months')}}
                                        <span class="text-danger"></span>
                                    </label>
                                    <br>
                                    <div class="input-group ">
                                        <input type="number"
                                            class="form-control mb-5  rounded-pill directionAlign"
                                            name="num_months" value="{{ @$item->num_months }}" />
                                    </div>
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

                         <a href="{{route('panel.packages.all.index',['parent'=>request('parent')])}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>


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
    <script src="{{asset('assets/panel/js/post.js')}}"></script>
    <script src="{{asset('assets/panel/plugins/custom/tinymce/tinymce.bundle.js')}}"></script>
    <script src="{{asset('assets/panel/js/pages/crud/forms/editors/tinymce.js')}}?v=1"></script>
    <script>
        $("#package_type").change(function(){
            if($(this).val() == 'featured')
                $("#color-div").show();
            else
                $("#color-div").hide();
        });
    </script>

   @endpush

   @stop
