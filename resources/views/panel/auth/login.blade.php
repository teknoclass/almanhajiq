<!DOCTYPE html>

<html lang="en" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<!--begin::Head-->

<head>
	<base href="../../../">
	<meta charset="utf-8" />
	<title>{{getSeting('title_ar')}} </title>
	<meta name="description" content="Login page example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="{{asset('assets/panel/css/pages/login/login-1.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{asset('assets/panel/plugins/global/plugins.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/panel/plugins/custom/prismjs/prismjs.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/panel/css/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/panel/css/custome.css')}}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="{{imageUrl(getSeting('logo'))}}" />
</head>


<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
			<!--begin::Aside-->
			<div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #192947;">
				<!--begin::Aside Top-->
				<div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
					<!--begin::Aside header-->
					<a href="{{ route('panel.home') }}" class="text-center mb-10">
						<img src="{{imageUrl(getSeting('white_logo'))}}" class="max-h-140px shadow-img" alt="" />
					</a>
					<!--end::Aside header-->
					<!--begin::Aside title-->
					<h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #fff;">{{__('hellow')}}
						<br /><br />{{getSeting('title_ar')}}
					</h3>
					<!--end::Aside title-->
				</div>
				<!--end::Aside Top-->

			</div>
			<!--begin::Aside-->
			<!--begin::Content-->
			<div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
				<!--begin::Content body-->
				<div class="d-flex flex-column-fluid flex-center">

					<!--begin::Signin-->
					<div class="login-form login-signin">
						<!--begin::Form-->
						<div class="flash-message">
							@foreach (['danger', 'warning', 'success', 'info'] as $msg)
							@if(Session::has('alert-' . $msg))
							<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							</p>
							@endif
							@endforeach
						</div>
						<form class="kt-form" method="POST" action="{{ route('panel.admin.login') }}">
							@csrf
							<input type="hidden" class="device_token" id="device_token" name="device_token" />
							<!--begin::Title-->
							<div class="pb-13 pt-lg-0 pt-5">
								<h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg"> {{__('login_title')}}</h3>
								<p class="text-muted font-weight-bold font-size-h4">{{__('login_text')}}</p>

							</div>
							<!--begin::Title-->
							<!--begin::Form group-->
							<div class="form-group mb-10">
								<label class="font-size-h6 font-weight-bolder text-dark">{{__('email')}}</label>
								<input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="email" name="email" autocomplete="off" />
								@if ($errors->has('email'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
								@endif
							</div>
							<!--end::Form group-->
							<!--begin::Form group-->
							<div class="form-group mb-10">
								<div class="d-flex justify-content-between mt-n5">
									<label class="font-size-h6 font-weight-bolder text-dark pt-5">{{__('password')}} </label>
								</div>
								<input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
								@if ($errors->has('password'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif

							</div>
							<!--end::Form group-->
							<!--begin::Action-->
							<div class="pb-lg-0 pb-5">
								<button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"> {{__('login')}}</button>

							</div>
							<!--end::Action-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Signin-->




				</div>
				<!--end::Content body-->
				<!--begin::Content footer-->
				<div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
					<div class="text-dark-50 font-size-lg font-weight-bolder mr-10">
						<span class="mr-1">{{date('Y')}}©</span>
						<a href="{{ route('panel.home') }}" class="text-dark-75 text-hover-primary">{{getSeting('title_ar')}}</a>
					</div>

				</div>
				<!--end::Content footer-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->

	<!--end::Global Config-->
	<script>
		var KTAppSettings = {
			"breakpoints": {
				"sm": 576,
				"md": 768,
				"lg": 992,
				"xl": 1200,
				"xxl": 1200
			},
			"colors": {
				"theme": {
					"base": {
						"white": "#ffffff",
						"primary": "#6993FF",
						"secondary": "#E5EAEE",
						"success": "#1BC5BD",
						"info": "#8950FC",
						"warning": "#FFA800",
						"danger": "#F64E60",
						"light": "#F3F6F9",
						"dark": "#212121"
					},
					"light": {
						"white": "#ffffff",
						"primary": "#E1E9FF",
						"secondary": "#ECF0F3",
						"success": "#C9F7F5",
						"info": "#EEE5FF",
						"warning": "#FFF4DE",
						"danger": "#FFE2E5",
						"light": "#F3F6F9",
						"dark": "#D6D6E0"
					},
					"inverse": {
						"white": "#ffffff",
						"primary": "#ffffff",
						"secondary": "#212121",
						"success": "#ffffff",
						"info": "#ffffff",
						"warning": "#ffffff",
						"danger": "#ffffff",
						"light": "#464E5F",
						"dark": "#ffffff"
					}
				},
				"gray": {
					"gray-100": "#F3F6F9",
					"gray-200": "#ECF0F3",
					"gray-300": "#E5EAEE",
					"gray-400": "#D6D6E0",
					"gray-500": "#B5B5C3",
					"gray-600": "#80808F",
					"gray-700": "#464E5F",
					"gray-800": "#1B283F",
					"gray-900": "#212121"
				}
			},
			"font-family": "Poppins"
		};
	</script>
	<!--begin::Global Theme Bundle(used by all pages)-->
	<script src="{{asset('assets/panel/plugins/global/plugins.bundle.js')}}"></script>
	<script src="{{asset('assets/panel/plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
	<script src="{{asset('assets/panel/js/scripts.bundle.js')}}"></script>
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<script src="{{asset('assets/panel/js/pages/custom/login/login-general.js')}}"></script>
	<!--end::Page Scripts-->


	<script src="https://www.gstatic.com/firebasejs/8.1/firebase-app.js" type="text/javascript"></script>
	<script src="https://www.gstatic.com/firebasejs/8.1/firebase-database.js" type="text/javascript"></script>
	<script src="https://www.gstatic.com/firebasejs/8.1/firebase-firestore.js" type="text/javascript"></script>
	<script src="https://www.gstatic.com/firebasejs/8.1/firebase-messaging.js" type="text/javascript"></script>
	<script src="https://www.gstatic.com/firebasejs/8.1/firebase-functions.js" type="text/javascript"></script>

	<script>
		var firebaseConfig = {
			apiKey: "{{env('FIREBASE_API_KEY')}}",
			authDomain: "{{env('FIREBASE_AUTH_DOMAIN')}}",
			databaseURL: "{{env('FIREBASE_DATABASE_URL')}}",
			projectId: "{{env('FIREBASE_PROJECT_ID')}}",
			messagingSenderId: "{{env('FIREBASE_MESSAGIN_SENDER_ID')}}",
			storageBucket: "{{env('FIREBASE_STORAGES_BUCKET')}}",
			appId: "{{env('FIREBASE_APP_ID')}}",
			measurementId: "{{env('FIREBASE_MEASURMENT_ID')}}",
		};
		// Initialize Firebase
		firebase.initializeApp(firebaseConfig);

		const messaging = firebase.messaging();

		function startFCM() {
			$('#load').show();
			messaging
				.requestPermission()
				.then(function() {
					return messaging.getToken()
				})
				.then(function(response) {
					$('#device_token').val(response);
				}).catch(function(error) {});
			$('#load').hide();
		}

		$(document).ready(function() {
			startFCM();
		});
	</script>

</body>

</html>
