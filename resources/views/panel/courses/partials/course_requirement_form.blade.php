<div data-repeater-item="item" class="form-group row align-items-center widget_item-course-content">
   <div class="col-md-10">
      <div class="row">
         <input type="hidden" class="content_id" name="id" value="{{isset($details)?$details->id:0}}" />
          <div class="form-group">
              <label>{{__('course')}}
                  <span class="text-danger">*</span></label>
              <select id="course_requirement_id" name="course_requirement_id"
                      class="form-control mb-5"
                      required>
                  <option value="" selected disabled>{{__('select_course')}}</option>
                  @foreach($courses as $course)
                      <option
                          value="{{@$course->id}}"
                          {{@$details->course_requirement_id==$course->id ?'selected' :''}}>
                          {{$course->translate()->title}} </option>
                  @endforeach
              </select>
          </div>
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
