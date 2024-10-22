<div data-repeater-item="item" class="form-group row align-items-center widget_item-course-content">
   <div class="col-md-10">
      <div class="row">
         <input type="hidden" class="content_id" name="id" value="{{isset($details)?$details->id:0}}" />
          <input type="hidden" class="type" name="type" value="{{$type}}" />
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
            <div class="form-group">
               <label>{{__('description')}}
               ({{ __($value) }} )
               <span class="text-danger">*</span></label>
               <textarea type="text" name="description_{{$locale}}"
               id="description_{{$locale}}{{@$details->id}}"
               class="form-control mb-5   tinymce-" required rows="5">{{isset($details)?@$details->translate($locale)->description:''}}</textarea>
            </div>
         </div>
         @endforeach
          @if($type=='content')
         <div class="col-md-12">
         <div class="form-group">
               <label>{{__('icon')}}
               <span class="text-danger">*</span></label>
               <input type="file" name="icon"
                  class="form-control mb-5 content-icon"
                  accept="image/*"
                  @if(!isset($details))
                  required
                  @endif
                   />

                   <label class="text-center mt-3">
                       {{__('image_size')}}
                       ({{__('image_hight')}}:100 {{__('image_size_px')}})
                       ({{__('image_width')}}:100 {{__('image_size_px')}})
                  </label>


            </div>
            @if(isset($details))
              @if($details->image!='')
              <a href="{{fileUrl($details->image)}}" class="view-icon preview-content-course-icon" target="_blank">
                 <img src="{{fileUrl($details->image)}}" class="w-140px"/>
              </a>
              @endif
            @endif
         </div>
           @endif


      </div>
   </div>
   <div class="col-md-2">
      <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
      <i class="la la-trash-o"></i>{{__('delete')}}</a>
   </div>
   <div class="col-12">
      <div class="separator separator-dashed  separator-dashed-dark my-8"></div>
   </div>
</div>
