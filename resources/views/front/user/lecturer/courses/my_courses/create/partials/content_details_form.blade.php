
<div data-repeater-item="item" class="rounded-3 mb-4 bg-light-green p-3 widget_item-course-content d-flex position-relative">
    <a href="javascript:;" data-repeater-delete=""  class="widget_item-remove"><i class="fa-solid fa-trash"></i></a>
    <div class="ms-1 col">
        <input type="hidden" class="content_id" name="id" value="{{ isset($details) ? $details->id : 0 }}" />
        <input type="hidden" class="type" name="type" value="{{ $type }}" />
        @foreach (locales() as $locale => $value)
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('title') }} ({{ __($value) }}) <span class="text-danger">*</span></label>
                    <input type="text" name="title_{{ $locale }}" class="form-control mb-2 rounded-pill "
                        value="{{ isset($details) ? @$details->translate($locale)->title : '' }}" required />
                </div>
                <div class="form-group">
                    <label>{{ __('description') }} ({{ __($value) }}) <span class="text-danger">*</span></label>
                    <textarea type="text" name="description_{{ $locale }}" id="description_{{ $locale }}{{ @$details->id }}"
                        class="form-control mb-0" required rows="3">{{ isset($details) ? @$details->translate($locale)->description : '' }}</textarea>
                </div>
            </div>
        @endforeach

        @if ($type == 'content')
            <div class="col-md-12">
                <div class="form-group">
                    <label>{{ __('icon') }}
                        <span class="text-danger">*</span></label>
                    <input type="file" name="icon"
                        class="form-control mb-5  rounded-pill mb-5  rounded-pill content-icon" accept="image/*"
                        @if (!isset($details)) required @endif />

                    <label class="text-center mt-3">
                        {{ __('image_size') }}
                        ({{ __('image_hight') }}:100 {{ __('image_size_px') }})
                        ({{ __('image_width') }}:100 {{ __('image_size_px') }})
                    </label>


                </div>
                @if (isset($details))
                    @if ($details->image != '')
                        <a href="{{ fileUrl($details->image) }}" class="view-icon preview-content-course-icon"
                            target="_blank">
                            <img src="{{ fileUrl($details->image) }}" class="w-140px" loading="lazy"/>
                        </a>
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>
