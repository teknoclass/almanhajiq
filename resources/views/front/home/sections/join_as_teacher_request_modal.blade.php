<!--Start Modal-->
<div class="modal fade" id="modal_join_trainer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 rounded-10">
            <div class="modal-body px-5 py-4">
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">

                </button>
                <h2 class="font-medium text-center my-3">
                    {{ __('join_as_a_trainer') }}
                </h2>
                <form class="join-as-teacher-form" action="{{ route('user.joinAsTeacherRequest') }}" to="close_model"
                    data-close_model="#modal_join_trainer" method="POST" id="form_5" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('full_name') }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <input type="text" name="mobile" class="form-control " required id="mobile"
                                    placeholder="{{ __('mobile') }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" required id="email"
                                    placeholder="{{ __('email') }}" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="selectpicker" name="country_id" title="{{ __('country') }}" required>
                                    @foreach (@$countries as $country)
                                        <option value="{{ @$country->value }}">
                                            {{ @$country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="city" class="form-control" required id="city"
                                    placeholder="{{ __('city') }}" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="selectpicker" name="gender" title="{{ __('gender') }}" required>
                                    @foreach (config('constants.gender') as $gender)
                                        <option value="{{ $gender }}">
                                            {{ __($gender) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea type="text" name="about" class="form-control" rows="4" required id="about"
                                    placeholder="{{ __('about') }}"></textarea>
                            </div>
                        </div>



                        {{-- <div class="col-lg-6">
                    <div class="form-group">
                        <select class="selectpicker" name="experience_id" title="{{__('experience')}}" required>
                            @foreach ($experiences as $experience)
                                <option value="{{@$experience->value}}">
                                    {{@$experience->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                        <div class="col-lg-6">
                            <div class="form-group">
                                <select class="selectpicker" name="certificate_id" title="{{ __('certificate') }}"
                                    required>
                                    @foreach ($joining_certificates as $joining_certificate)
                                        <option value="{{ @$joining_certificate->value }}">
                                            {{ @$joining_certificate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="input-image-preview d-block px-3 pointer" for="id_image">
                            <input class="input-file-image-1" type="file" name="id_image" id="id_image"
                                accept="image/png, image/jpeg, image/jpg,application/pdf">
                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                            <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                <div class="flipthis-wrapper">
                                    <span class="">{{ __('id_image') }} </span>
                                </div>
                                <span class="d-flex align-items-center"><i
                                        class="fa-light fa-paperclip fa-lg"></i></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="input-image-preview d-block px-3 pointer" for="job_proof_image">
                            <input class="input-file-image-1" type="file" name="job_proof_image" id="job_proof_image"
                                accept="image/png, image/jpeg, image/jpg,application/pdf">
                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                            <span class="input-image-container d-flex align-items-center justify-content-between h-100">
                                <div class="flipthis-wrapper">
                                    <span class="">{{ __('job_proof_image') }} </span>
                                </div>
                                <span class="d-flex align-items-center"><i
                                        class="fa-light fa-paperclip fa-lg"></i></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="input-image-preview d-block px-3 pointer" for="cv_file">
                            <input class="input-file-image-1" type="file" name="cv_file" id="cv_file"
                                accept="image/png, image/jpeg, image/jpg,application/pdf">
                            <span class="img-show h-100 d-flex align-items-center py-1"></span>
                            <span
                                class="input-image-container d-flex align-items-center justify-content-between h-100">
                                <div class="flipthis-wrapper">
                                    <span class="">{{ __('cv_file') }} </span>
                                </div>
                                <span class="d-flex align-items-center"><i
                                        class="fa-light fa-paperclip fa-lg"></i></span>
                            </span>
                        </label>
                    </div>
                    <div class="form-group mt-4">
                        @include('front.components.btn_submit', ['btn_submit_text' => __('send')])
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Modal-->

@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}?v={{ getVersionAssets() }}"></script>
@endpush
