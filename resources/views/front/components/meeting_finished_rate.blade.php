<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />
	<link rel="icon" type="image/png" href="{{ asset('assets/favicon.ico') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="{{ imageUrl(getSeting('logo')) }}" />


	<link rel="stylesheet" href="{{ asset('assets/front/css/animate.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/fontawesome.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/jquery.fancybox.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-select.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.rtl.min.css') }}" />

	<link rel="stylesheet" href="{{ asset('assets/front/css/swiper.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/front/css/custome.css') }}?v={{ getVersionAssets() }}" />


	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" href="{{ asset('assets/front/css/star-rating.min.css') }}" />

</head>

<body>
    <div class="main-wrapper">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                            <h2 class="font-medium text-center my-3">
                                {{ __('add_a_rateing') }}
                            </h2>

                            <form id="add_rate_form" method="POST" action="{{ route('user.ratings.add') }}" class="w-100 p-3">
                                @csrf
                                <input type="hidden" name="sourse_id"   id="sourse_id"      value="{{ @$sourse_id }}" />
                                <input type="hidden" name="sourse_type" id="sourse_type"    value="{{ @$sourse_type }}" />
                                <input type="hidden" name="action_type" id="action_type"    value="{{ @$action_type }}" />

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
    </div>
	<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/swiper.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/jquery.fancybox.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/function.js') }}"></script>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
		integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
	</script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="{{ asset('assets/front/js/jqueryValidate.min.js') }}"></script>
	<script src="{{ asset('assets/front/js/sweetalert2.min.js') }}"></script>
	@if (app()->isLocale('ar'))
		<script src="{{ asset('assets/front/js/custom.sweet.js') }}"></script>
	@else
		<script src="{{ asset('assets/front/js/custom_en.sweet.js') }}"></script>
	@endif
	<script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
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
			var class_btn_add_rate = $('#class_btn_add_rate').val();

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

					if (data.status == true) {

						toastr.success(data.message);
						$('.' + class_btn_add_rate).hide();
						$('#rate_modal').modal('hide');

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

</body>

</html>
