@extends('front.layouts.index', ['sub_title' => __('home')])

@section('content')

	<section class="section wow fadeInUp" data-wow-delay="0.1s"
		style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mx-auto">
					<div class="bg-white rounded-30 p-4 box-shadow">
						<div class="row">
                            @if ($joining_request)
                                @if ($joining_request->status == "pending")
                                    <div class="col-lg-10 mx-auto">
                                        <div class="row gx-lg-3">
                                            <div class="col-12 d-flex flex-column align-items-center text-center">
                                                <img class="pt-2" src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy">
                                                <h2 class="pt-2"><strong>{{ __('thank_you') }}</strong></h2>
                                                <p class="pt-2">{{ __('request_received_successfully') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($joining_request->status == "acceptable")
                                    <div class="col-lg-10 mx-auto">
                                        <div class="row gx-lg-3">
                                            <div class="col-12 d-flex flex-column align-items-center text-center">
                                                <img class="pt-2" src="{{ asset('assets/front/images/success.png') }}" alt="" loading="lazy">
                                                <h2 class="pt-2"><strong>{{ __('your_request_accepted') }}</strong></h2>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-10 mx-auto">
                                        <div class="row gx-lg-3">
                                            <div class="col-12 d-flex flex-column align-items-center text-center">
                                                <img class="pt-2" src="{{ asset('assets/front/images/no_content.png') }}" alt="" loading="lazy">
                                                <h2 class="pt-2"><strong>{{ __('sorry') }}</strong></h2>
                                                <p class="pt-2">{{ __('your_request_rejected') }}</p>
                                                <strong><p class="pt-2">{{ @$joining_request->reason_unacceptable }}</p></strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <h2 class="font-medium text-center my-3">
                                {{__('join_as_a_market')}}
                                </h2>
                                <form class="join-as-teacher-form"
                                action="{{ route('joinAsMarketRequest') }}" to="close_model"
                                data-close_model="#modal_join_market" method="POST"
                                id="form_5"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="{{__('full_name')}}" value="{{ auth()->user()->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <input type="hidden" name="code_country" value="{{ auth()->user()->code_country }}"  class="code_counrty">
                                            <input type="hidden" name="slug_country" value="{{ auth()->user()->slug_country }}"  class="slug_country">
                                            <input
                                            type="number" minlength="10" maxlength="10" name="mobile"
                                            required placeholder="{{__('enter_mobile_number')}}"
                                            class="form-control  mobile-number  h-50px"
                                            id="phone" value="{{ auth()->user()->mobile }}"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" required id="email" placeholder="{{__('email')}}" value="{{ auth()->user()->email }}"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="selectpicker" name="country_id" title="{{__('country')}}" required>
                                            @foreach(@$countries as $country)
                                            <option value="{{@$country->value}}">
                                                {{@$country->name}}
                                            </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="city" class="form-control" required id="city" placeholder="{{__('city')}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="selectpicker" name="gender" title="{{__('gender')}}" required>
                                            @foreach(config('constants.gender') as $gender)
                                            <option value="{{$gender}}">
                                                {{__($gender)}}
                                            </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea type="text" rows="5" name="bio" class="form-control"
                                            required id="bio" placeholder="{{__('about')}}" ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3 class="mb-2">
                                            {{__('bank_account_data_if_any')}}
                                        </h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="selectpicker" name="bank_id"
                                            title="{{__('bank')}}" >
                                            @foreach(@$banks as $bank)
                                            <option value="{{@$bank->value}}">
                                                {{@$bank->name}}
                                            </option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="account_num" class="form-control"
                                                id="account_num" placeholder="{{__('account_num')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="ipan"
                                            minlength="30" maxlength="30"
                                            class="form-control"
                                                id="ipan" placeholder="{{__('ipan')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3 class="mb-2">
                                        {{__('paypal_account_if_any')}}
                                        </h3>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="paypal_email" class="form-control"
                                                id="paypal_email" placeholder="{{__('paypal_email')}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h3 class="mb-2">
                                        {{__('social_media_accounts')}}
                                        </h3>
                                        <button type="button"
                                        class="btn btn-sm btn-primary d-flex justify-content-center
                                        align-items-center  add-social-media-accounts
                                        ">
                                        <i class="fa-solid fa-plus ms-2"></i>
                                            {{__('add')}}
                                        </button>
                                    </div>
                                    <div class="col-md-12 social-media-accounts">

                                    </div>

                                </div>
                                <div class="form-group mt-4">
                                    @include('front.components.btn_submit',['btn_submit_text'=>__('send')])
                                </div>
                                </form>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

    @push('front_js')
    <script src="{{asset('assets/front/js/post.js')}}?v={{getVersionAssets()}}"></script>

    <script>

        $(document).on('click', '.add-social-media-accounts', function() {

        var html=`<div class="row mt-3 d-flex justify-content-center
                            align-items-center d-flex social-media-account"><div class="col-md-4"><div class="form-group">
        <select name="socal_media_id[]" required class="form-select form-control"> `;

        var html=html+"<option value='' disapled selected>{{__('social_media_accounts')}}</option>"

        @foreach($social_media_items as $social_media_item)
        var html=html+"<option value='1'>{{$social_media_item->name}}</option>";

        @endforeach
        var html=html+"</select></div></div>"

        var html=html+`<div class="col-md-3">
        <div class="form-group">
        <input type="text" class="form-control" required name="link[]" placeholder="{{__('account_link')}}"/>
        </div>
        </div>`

        var html=html+`<div class="col-md-3">
        <div class="form-group">
        <input type="text" class="form-control" required name="num_followers[]" placeholder="{{__('number_of_followers')}}"/>
        </div>
        </div>`

        var html=html+`<div class="col-md-2">
        <div class="form-group">
        <button type="button"
                            class="btn btn-sm btn-danger d-flex justify-content-center
                            align-items-center  delete-social-media-account
                            ">
                            <i class="fa-solid fa-trash "></i>
                            </button>
        </div>
        </div>`



        $('.social-media-accounts').append(html);



        });
        $(document).on('click', '.delete-social-media-account', function() {

            $(this).parent().parent().parent().remove();
        });


    </script>
    @endpush


@endsection
