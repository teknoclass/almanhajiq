@extends('panel.layouts.index',['sub_title' =>__('admins') ,'is_active'=>'admins'])
@section('contion')

@php
$item = isset($item) ? $item: null;
@endphp
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
	@php
	$title_page=__('add_admin');
	if(isset($item)){
		$title_page=__('edit_admin');
	}
	$breadcrumb_links=[
	[
	'title'=>__('home'),
	'link'=>route('panel.home'),
	],
	[
	'title'=>__('admins'),
	'link'=>route('panel.admins.all.index'),
	],
	[
	'title'=>$title_page,
	'link'=>'#',
	],
	]
	@endphp
    @section('title', $title_page)
	<!--begin::Form-->
	<form id="form" method="{{isset($item) ? 'POST' : 'POST'}}" to="{{url()->current()}}" url="{{url()->current()}}" class="w-100">
		@csrf






			<div class="container">
                @include('panel.layouts.breadcrumb',['breadcrumb_links'=>$breadcrumb_links,'title_page'=>$title_page,])
				<div class="row">


					<div class="col-md-9">
						<!--begin::Card-->
						<div class="card card-custom gutter-b example example-compact">
							<div class="card-header">
								<h3 class="card-title">

                                    {{$title_page}}
                                </h3>

							</div>
							<!--begin::Form-->
							<div class="card-body">
								<div class="form-group">
									<label for="name">{{__('name')}}
										<span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control mb-10 " value="{{@$item->name}}" required id="name" placeholder="" />
								</div>

								<div class="form-group">
									<label>{{__('email')}}
										<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control mb-10 d-flex align-items-center justify-content-between" name="email" value="{{@$item->email}}" required placeholder="" />
								</div>
								<div class="form-group">
									<label for="password">{{__('password')}}
										<span class="text-danger">
											@if(!isset($item))
											*
											@endif
										</span></label>
									<input type="password" name="password" class="form-control mb-10 d-flex align-items-center j
                                    ustify-content-between " value="" id="password" placeholder="" @if(!isset($item)) required @endif />
									@if(isset($item))
									<span class="d-block " role="alert">
										<strong>
										{{__('password_note')}}
										</strong>
									</span>
									@endif
								</div>

								<div class="form-group">
									<label for="exampleInputPassword1">{{__('roles')}}
										<span class="text-danger">*</span></label>

                                        <select class="form-control mb-10 d-flex align-items-center justify-content-between " name="role_id" required>
										@foreach($roles as $role)
										@php
										$selected='';
										if(isset($item)){
										if(@$item->roles()->orderBy('id','desc')->first()->id==@$role->id){
										$selected='selected';
										}
										}
										@endphp

										<option value="{{@$role->id}}" {{$selected}}>{{@$role->name}}</option>

										@endforeach
									</select>
								</div>



							</div>

							<!--end::Form-->
						</div>
						<!--end::Card-->

					</div>
					<div class="col-md-3">
						<!--begin::Card-->
						<div class="card card-custom gutter-b example example-compact">
							<div class="card-header">
								<h3 class="card-title"> {{__('action')}}</h3>

							</div>
							<!--begin::Form-->
							<div class="card-body d-flex align-items-center   ">

								@include('panel.components.btn_submit',['btn_submit_text'=>__('save')])

								<a href="{{route('panel.admins.all.index')}}" class="btn btn-secondary mx-3">{{__('cancel')}}</a>

							</div>

							<!--end::Form-->
						</div>
						<!--end::Card-->

					</div>


				</div>
			</div>

	</form>
</div>


@push('panel_js')
<script src="{{asset('assets/panel/js/post.js')}}"></script>

@endpush

@stop
