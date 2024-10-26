
<button class="btn btn-primary  font-medium align-items-center
                        justify-content-center" data-url="{{url()->current()}}" data-csrf="{{ csrf_token() }}"
                         type="submit" id="btn_submit">
    <div class="spinner-border  ml-2" style="display:none ;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
    <span class="">
        {{$btn_submit_text}}
    </span>
</button>
