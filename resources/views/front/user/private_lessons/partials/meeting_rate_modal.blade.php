<!--Start Modals # 3  -->
<link rel="stylesheet" href="{{ asset('assets/front/css/star-rating.min.css') }}" />

<div class="modal fade" id="rate_modal" tabindex="-1" aria-labelledby="RateLessonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <div class="modal-body">

                <h2 class="font-medium text-center my-3">
                    {{ __('add_a_rateing_to') }} {{ @$item->title }}
                </h2>

                <form id="add_rate_form" method="POST" action="{{ route('user.ratings.add') }}" to="{{ url()->current() }}" class="w-100 p-3">
                    @csrf
                    <input type="hidden" name="sourse_type" id="sourse_type"    value="private_lesson" />
                    <input type="hidden" name="action_type" id="action_type"    value="private_lesson_ratings" />

                    <div class="form-group d-flex justify-content-center mb-5">
                        <input id="input-2-rtl-star-sm" name="rate" class="kv-rtl-theme-default-star rating-loading" value="1"
                            dir="rtl" data-size="md">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control bg-transparent" name="comment_text" rows="4" placeholder="{{ __('comment') }}"></textarea>
                    </div>

                    <div class="form-group mt-4">
                        @include('front.components.btn_submit', ['btn_submit_text' => __('send')])
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>
<!--End Modals   #3 -->
<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>

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
