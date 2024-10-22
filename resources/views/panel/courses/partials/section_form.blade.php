<div data-repeater-item="item" class="form-group row align-items-center widget_item-course-content">
   <div class="col-md-10">
      <div class="row">
         <input type="hidden" class="content_id" name="id" value="{{isset($details)?$details->id:0}}" />
         @foreach(locales() as $locale => $value)
         <div class="col-md-12">
            <div class="form-group">
               <label>{{__('title')}}
               ({{ __($value) }} )
               <span class="text-danger">*</span></label>
               <input type="text" name="title_{{$locale}}"
                  class="form-control mb-5"
                  value="{{isset($details)?@$details->translate($locale)->title:''}}"
                  required />
            </div>
         </div>
         @endforeach
          <div class="form-group">
          <div class="form-check form-switch form-check-custom form-check-solid">
              <span class="switch">
                  <label><input class="form-check-input" value="1"
                                type="checkbox" @if ($details->is_active==1)checked=""@endif
                                name="is_active" ><span></span>
                  </label></span></div>
          </div>
      </div>
   </div>
   <div class="col-md-2">
      <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
      <i class="la la-trash-o"></i>{{__('delete')}}</a>
       <div class="card-toolbar">
           <!--begin::Menu-->
           <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" fdprocessedid="rxco5">
               <i class="fas fa-ellipsis-v text-dark"></i>
           </button>

           <!--begin::Menu 1-->
           <div class="menu menu-sub menu-sub-dropdown w-200px text-start p-3" data-kt-menu="true" id="kt_menu_64a6a9e38a473" >
               <a href="#" class="d-block p-2 text-dark">{{__('update')}} </a>
           </div>
           <!--end::Menu 1-->

       </div>
   </div>
   <div class="col-12">
      <div class="separator separator-dashed  separator-dashed-dark my-8"></div>
   </div>
</div>
