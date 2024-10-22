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
                                {{__('join_as_a_trainer')}}
                                </h2>
                                <form class="join-as-teacher-form" action="{{ route('joinAsTeacherRequest') }}" to="close_model" data-close_model="#modal_join_trainer" method="POST"
                                id="form_5"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="name" value="{{ @$user->name }}" />
                                <input type="hidden" name="mobile" value="{{ @$user->mobile }}" />
                                <input type="hidden" name="email" value="{{ @$user->email }}" />

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ @$user->name }}" disabled class="form-control" placeholder="{{__('full_name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group " >
                                            <input type="text" value="{{ @$user->mobile }}" disabled class="form-control " required id="mobile" placeholder="{{__('mobile')}}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text" value="{{ @$user->email }}" disabled class="form-control" required id="email" placeholder="{{__('email')}}" />
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
                                            <textarea type="text" name="about" class="form-control" rows="4" required id="about" placeholder="{{__('about')}}" ></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="selectpicker" name="certificate_id" title="{{__('certificate')}}" required>
                                                @foreach($joining_certificates as $joining_certificate)
                                                    <option value="{{@$joining_certificate->value}}">
                                                        {{@$joining_certificate->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="selectpicker" name="material_id" title="{{__('materials')}}" required>
                                                @foreach($joining_courses as $joining_course)
                                                    <option value="{{@$joining_course->value}}">
                                                        {{@$joining_course->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="selectpicker" name="specialization_id" title="{{__('section')}}" required>
                                                @foreach($joining_sections as $joining_section)
                                                    <option value="{{@$joining_section->value}}">
                                                        {{@$joining_section->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="input-image-preview d-block px-3 pointer" for="id_image">
                                        <input class="input-file-image-1" type="file" name="id_image" id="id_image"  accept="image/png, image/jpeg, image/jpg,application/pdf">
                                        <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                                        <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                            <div class="flipthis-wrapper">
                                            <span class="">{{__('id_image')}} </span>
                                            </div>
                                            <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="input-image-preview d-block px-3 pointer" for="job_proof_image">
                                        <input class="input-file-image-1" type="file" name="job_proof_image" id="job_proof_image" accept="image/png, image/jpeg, image/jpg,application/pdf">
                                        <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                                        <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                            <div class="flipthis-wrapper">
                                            <span class="">{{__('job_proof_image')}} </span>
                                            </div>
                                            <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="input-image-preview d-block px-3 pointer" for="cv_file">
                                        <input class="input-file-image-1" type="file" name="cv_file" id="cv_file" accept="image/png, image/jpeg, image/jpg,application/pdf">
                                        <span  class="img-show h-100 d-flex align-items-center py-1" ></span>
                                        <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                            <div class="flipthis-wrapper">
                                            <span class="">{{__('cv_file')}} </span>
                                            </div>
                                            <span class="d-flex align-items-center"><i class="fa-light fa-paperclip fa-lg"></i></span>
                                        </span>
                                    </label>
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
    @endpush


@endsection
