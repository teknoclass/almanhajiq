
<div data-repeater-item="item" class="rounded-3 mb-4 bg-light-green p-3 widget_item-course-content d-flex position-relative">
    <a href="javascript:;" data-repeater-delete=""  class="widget_item-remove"><i class="fa-solid fa-trash"></i></a>
    <div class="ms-1 col">
        @foreach (locales() as $locale => $value)
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('faq') }}
                        ({{ __($value) }})
                        <span class="text-danger">*</span></label>
                    <input type="text" name="title_{{ $locale }}" class="form-control mb-2  rounded-pill "
                        value="{{ isset($faq) ? @$faq->translate($locale)->title : '' }}" required />
                </div>
                <div class="form-group">
                    <label>{{ __('ans') }}
                        ({{ __($value) }} )
                        <span class="text-danger">*</span></label>
                    <textarea type="text" name="text_{{ $locale }}" id="text_{{ $locale }}{{ @$faq->id }}"
                    class="form-control" required rows="3">{{ isset($faq) ? @$faq->translate($locale)->text : '' }}</textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- <div data-repeater-item="item" class="form-group row align-items-center">
	<div class="col-md-10">
		<div class="row">
			@foreach (locales() as $locale => $value)
				<div class="col-md-12">
					<div class="form-group">
						<label>{{ __('faq') }}
							({{ __($value) }})
							<span class="text-danger">*</span></label>
						<input type="text" name="title_{{ $locale }}" class="form-control mb-5  rounded-pill "
							value="{{ isset($faq) ? @$faq->translate($locale)->title : '' }}" required />
					</div>
					<div class="form-group">
						<label>{{ __('ans') }}
							({{ __($value) }} )
							<span class="text-danger">*</span></label>
						<textarea type="text" name="text_{{ $locale }}" id="text_{{ $locale }}{{ @$faq->id }}"
						 class="form-control tinymce-" required rows="5">{{ isset($faq) ? @$faq->translate($locale)->text : '' }}</textarea>
					</div>
				</div>
			@endforeach
		</div>
	</div>
	<div class="col-md-2">
		<a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
			<i class="la la-trash-o"></i>{{ __('delete') }}</a>
	</div>
	<div class="col-12">
		<div class="separator separator-dashed  separator-dashed-dark my-8"></div>
	</div>
</div> --}}
