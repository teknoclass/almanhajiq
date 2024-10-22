
<div class="col-lg-3">
    <select class="selectpicker bg-primary rounded-pill" data-style="select-primary rounded-pill" title="" id="selectOption">
      <option value="{{ route('user.home.index') }}"                {{ @$is_active == 'home' ? 'selected' : '' }}>              {{ __('home') }}</option>
      <option value="{{ route('user.courses.myCourses') }}"         {{ @$is_active == 'my_courses' ? 'selected' : '' }}>        {{ __('my_courses') }}</option>
      <option value="{{ route('user.private_lessons.index') }}"     {{ @$is_active == 'my_private_lessons' ? 'selected' : ''}}> {{ __('my_private_lessons') }}</option>
      <option value="{{ route('user.chat.index') }}"                {{ @$is_active == 'my_chats' ? 'selected' : '' }}>          {{ __('my_chats') }}</option>
      {{-- <option value="{{ route('user.my_points.index') }}"           {{ @$is_active == 'my_points' ? 'selected' : '' }}>         {{ __('my_points') }}</option> --}}
      {{-- <option value="{{ route('user.my_purchases.index') }}">مشترياتي</option> --}}
    </select>
</div>

@push('front_js')
<script>
    const selectElement = document.getElementById('selectOption');

    selectElement.addEventListener('change', function() {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedUrl = selectedOption.value;

        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    });
</script>
@endpush
