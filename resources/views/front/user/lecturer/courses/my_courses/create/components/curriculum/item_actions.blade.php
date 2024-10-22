<div class="widget_item-action d-flex align-items-center">
    <div class="widget_item-icon">
        <i class="fa-regular fa-pen-to-square outer_modal_{{ $type }}"
            data-id="{{ $itemId }}"
            data-course_id="{{ $course_id }}"
            data-course_type="{{ $course->type }}"
            data-section_id=""
            data-type="edit">
        </i>
    </div>

    <button type="button" class="p-1 text-muted bg-transparent confirm-category"
        data-url="{{ $deleteUrl }}"
        data-id="{{ $itemId }}"
        data-is_relpad_page="true"
        data-row="lessonn_{{ $itemId }}">
            <div class="widget_item-icon"><i class="fa-solid fa-trash"></i></div>
    </button>

    <a href="{{ $previewUrl }}" target="__blank">
        <div class="widget_item-icon"><i class="fa-solid fa-eye"></i></div>
    </a>

    @php
        switch ($status) {
            case 'active':
                $class = "bg-success"; $icon = "fa-check";
                break;
            case 'inactive':
                $class = "bg-danger"; $icon = "fa-times";
                break;
        }
    @endphp

    <div class="widget_item-icon {{ $class }}"><i class="fa-solid {{ $icon }}"></i></div>
</div>
