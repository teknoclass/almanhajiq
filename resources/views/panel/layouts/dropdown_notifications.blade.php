
@if (count(@$notifications) > 0)
	@foreach (@$notifications as $notification)

		<div class="d-flex flex-stack py-4 cursor-pointer" onclick="read_notification({{ @$notification->id }})" >
			<!--begin::Section-->
			<div class="d-flex align-items-center">
				<!--begin::Symbol-->
				<div class="symbol symbol-35px me-4">
					<span class="symbol-label bg-light-primary">
						<!--begin::Svg Icon | path: icons/duotone/Clothes/Crown.svg-->
						<span class="svg-icon svg-icon-2 svg-icon-primary">
							<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<path
									d="M11.2600599,5.81393408 L2,16 L22,16 L12.7399401,5.81393408 C12.3684331,5.40527646 11.7359848,5.37515988 11.3273272,5.7466668 C11.3038503,5.7680094 11.2814025,5.79045722 11.2600599,5.81393408 Z"
									fill="#000000" opacity="0.3" />
								<path
									d="M12.0056789,15.7116802 L20.2805786,6.85290308 C20.6575758,6.44930487 21.2903735,6.42774054 21.6939717,6.8047378 C21.8964274,6.9938498 22.0113578,7.25847607 22.0113578,7.535517 L22.0113578,20 L16.0113578,20 L2,20 L2,7.535517 C2,7.25847607 2.11493033,6.9938498 2.31738608,6.8047378 C2.72098429,6.42774054 3.35378194,6.44930487 3.7307792,6.85290308 L12.0056789,15.7116802 Z"
									fill="#000000" />
							</svg>
						</span>
						<!--end::Svg Icon-->
					</span>
				</div>
				<!--end::Symbol-->
				<!--begin::Title-->
				<div class="mb-0 me-2">
					<b href="{{ @$notification->getAction() }}" class="fs-6 text-gray-800 text-hover-primary fw-bolder">
						{{ @$notification->title }}
					</b>
                    <span class="badge badge-light fs-8 notification-span"> {{ diffForHumans(@$notification->created_at) }}</span>
					<div class="text-gray-400 fs-7"> {{ @$notification->text }}</div>
				</div>

				<!--end::Title-->
			</div>
			<!--end::Section-->
			<!--begin::Label-->

			<!--end::Label-->
		</div>
	@endforeach
@else
	<div class="d-flex flex-stack py-4">
		<!--begin::Section-->
		<div class="d-flex align-items-center">
			<!--begin::Symbol-->
			<div class="symbol symbol-35px me-4">
				<div class="notification-text text-center p-3"><b>{{ __('no_notifications') }}</b></div>
			</div>
		</div>
	</div>

@endif
