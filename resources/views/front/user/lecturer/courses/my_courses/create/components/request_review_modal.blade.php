<div class="modal fade" id="requestReviewModal" tabindex="-1" aria-labelledby="requestReviewModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-2">
                  <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <h2 class="font-medium text-center my-2 modals-title">
                    انشر الدورة!
                </h2>

                <form method="POST" action="{{ route('user.lecturer.my_courses.edit.requestReview.update', ['id' => @$item->id]) }}" to="{{ url()->current() }}" class="w-100 p-3">
                    @csrf
                        <input type="hidden" value="{{ url()->current() }}" name="redirect_url">
                    <div class="col-12 d-flex flex-column align-items-center text-center">
                        <img class="pt-2" src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy">
                        <h3 class="pt-3"> سيقوم فريقنا الإداري بتقييم محتواها بعناية، وبمجرد الموافقة، سيتم إتاحتها للطلاب في أقرب وقت ممكن.</h3>

                        <div class="form-group text-center mt-2">
                            <button type="submit" id="btn_submit" class="submitForm btn btn-primary px-5">{{ __('publish') }}</button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@push('front_js')
<script src="{{ asset('assets/front/js/rating.min.js') }}?v={{ getVersionAssets() }}"></script>

<script>
    $('.kv-rtl-theme-default-star').rating({
        hoverOnClear: false,
        step: 1,
        containerClass: 'is-star'
    });

    $('#add_rate_form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var url = $(this).attr('action');
        var redirectUrl = $(this).attr('to');
        var save_btn = $('#btn_submit');
        var class_btn_add_rate = $('#class_btn_add_rate').val();

        $(save_btn).attr("disabled", true);
        $('#rate_modal').find('#load').show();
        $.ajax({
            url: url,
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function(data) {
                $('#rate_modal').find('#load').hide();
                $(save_btn).attr("disabled", false);

                if (data.status == true) {

                    toastr.success(data.message);
                    $('.' + class_btn_add_rate).hide();
                    $('#rate_modal').modal('hide');
                    if (redirectUrl != '#') {
                        $('#load').show();
                        window.location = redirectUrl;
                    }

                } else {
                    if (data["data_validator"] != null) {

                        toastr.error(data['data_validator']);
                    } else {

                        toastr.error(data.message);

                    }

                }



            },
            error: function(data) {
                $('#rate_modal').find('#load').hide();
                $(save_btn).attr("disabled", false);

                var dt = '<ul>';
                $.each(data.responseJSON.errors, function(key, value) {
                    dt = dt + '<li>' + value + '</li>';
                });
                var dt = dt + '</ul>';

                toastr.error(dt);
            }
        });


    });
</script>
@endpush

