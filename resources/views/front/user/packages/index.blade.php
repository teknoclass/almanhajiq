@extends('front.layouts.index', ['sub_title' => __('my_packages')])

@push('front_css')
	<link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-datetimepicker.min.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/front/css/fullcalendar.min.css') }}" />
@endpush

@section('content')
	@php
		$is_active = 'my_packages';

		$breadcrumb_links = [
		    [
		        'title' => __('home'),
		        'link' => route('user.home.index'),
		    ],
		];
        $breadcrumb_links[] = [
            'title' => __('my_packages'),
            'link' => '#',
        ];
	@endphp
	<section class="section wow fadeInUp" data-wow-delay="0.1s">
		<div class="container">
			@include('front.user.components.breadcrumb')

			<div class="row mb-3">

				<div class="col-12 bg-white p-4 rounded-4">
                    @if(false)
                    <div class="row mb-4 justify-content-between align-items-center">
                        <div class="col-9">
                            <div class="d-lg-flex align-items-center justify-content-between">
                                    <h2 class="font-medium">{{ __('rest_hours') }}: {{ $user->hours_balance }}</h2>
                                    <a href="#addPackageModal" data-target="#addPackageModal" data-toggle="modal"  class="btn btn-warning" >إضافة باقة</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="all-data">
                                @include('front.user.packages.partials.all')
                            </div>
                        </div>
                    </div>

					<!--  Meeting Rate Modal   -->

				</div>
			</div>
		</div>

	</section>

	<div class="modal fade" id="addPackageModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content border rounded-15">
				<div class="modal-body p-5">
					<div class="text-center">
						<h3 class="mb-4">{{__('packages')}}</h3>
                        <form method="POST" id="packageForm">
                            @csrf
                            <select id="package_id" class="form-control" required>
                                <option value="" selected>{{__('choose_package')}}</option>
                                @foreach ($packages as $package)
                                <option value="{{$package->id}}">{{$package->title}}</option>
                                @endforeach
                            </select>
                            <button type="submit" id="btn_submit" class="btn btn-primary w-100 mt-4" data-bs-dismiss="modal">اشترك</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
    @push('front_js')
    <script src="{{ asset('assets/front/js/ajax_pagination.js') }}"></script>
    <script>
        $(document).on('submit', '#packageForm', function (e) {
            e.preventDefault();
            var save_btn = $('#btn_submit');
            $(save_btn).attr("disabled", true);
            $(save_btn).find('.spinner-border').show();
            $.ajax({
                url:"{{ url('user/packages/book') }}/"+$('#package_id').val(),
                type:'post',
                dataType:'json',
                data:new FormData(this),
                processData:false,
                contentType: false,
                success:function(response){
                    $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    $(save_btn).find('.spinner-border').hide();
                    if (response.status) {
                        $('#addPackageModal').modal('hide');
                        $('#packageForm')[0].reset();

                        if(response.redirect_url){
                            $('#load').show();
                            window.location = response.redirect_url;
                        }else{
                            customSweetAlert(
                                'success',
                                response.message,
                                response.item,
                                function (event) {
                                    $('#load').show();
                                    window.location = '';
                                }
                            );
                        }
                    } else {
                        customSweetAlert(
                            'error',
                            response.message,
                            response.errors_object
                        );
                    }
                }
            });
        });
    </script>
    @endpush
@endsection
