<div data-repeater-item="item" class="form-group row align-items-center widget_item-course-content">
	<div class="col-md-12">
		<div class="row">
			<input type="hidden" class="content_id" name="id" value="{{ isset($details) ? $details->id : 0 }}" />
			<div class="form-group">
				<label>{{ __('course') }}<span class="text-danger">*</span></label>
				<div class="form-group ">
					<select class="selectpicker" multiple aria-label="Default select example" data-live-search="true"
						name="course_requirement_id[]" id="course_requirement_id">
						@foreach ($courses as $course)
							<option value="{{ @$course->id }}"
								{{ in_array($course->id, $content_details->pluck('course_requirement_id')->toArray()) ? 'selected' : '' }}>
								{{ $course->translate()->title }}
							</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
