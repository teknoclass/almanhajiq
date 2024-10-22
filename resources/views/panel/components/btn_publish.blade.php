@if(!$item->published)
    <a href="javascript:void(0);"
       id="publish-button"
       data-id="{{ $item->id }}"
       data-url="{{ route('panel.courses.create.publish', $item->id) }}"
       data-translations='{"form_submit_error": "{{ __('form_submit_error') }}", "add_session_error": "{{ __('add_session_error') }}"}'
       class="btn btn-success mx-3">
        {{ __('save_and_publish') }}
    </a>
@else
    <a href="javascript:void(0);"
       id="unpublish-button"
       data-id="{{ $item->id }}"
       data-url="{{ route('panel.courses.create.publish', $item->id) }}"
       data-translations='{"form_submit_error": "{{ __('form_submit_error') }}", "add_session_error": "{{ __('add_session_error') }}"}'
       class="btn btn-danger mx-3">
        {{ __('un-publish') }}
    </a>
@endif
