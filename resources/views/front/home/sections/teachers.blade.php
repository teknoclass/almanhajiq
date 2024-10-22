@if (@$lecturers && @$lecturers->isNotEmpty())
    <!-- Team Member's Start -->
    <section class="section-padding homepageLecturer">
        <div id="team-members" class="section-padding">
            <h2 class="text-white position-relative font-medium fs-2 mb-5 text-center">{{ __('our_popular_lecturers') }}
            </h2>
            <div class="teachers-active">
                <div class="container position-relative">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($lecturers as $lecturer)
                                <div class="swiper-slide">
                                    <div class="teacher-box mx-5 prim-border">
                                        <div class="teachers-image">
                                            <img class="w-100" src="{{ imageUrl(@$lecturer->image) }}"
                                                alt="{{ @$lecturer->name }}" loading="lazy" />
                                            {{-- Activate this section when the frontend belong to platfrom tag is finished --}}
                                            {{-- @if (@$lecturer->belongs_to_awael)
                                            <img src="{{ asset('assets/front/images/verified.png') }}" style="width: 30px">
                                        @endif --}}
                                        </div>
                                        <div class="teacher-info bg-white">
                                            <a class="view-profile" href="{{ @$lecturer_url }}">
                                                <svg width="28" height="23" viewBox="0 0 28 23" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M10.4164 22.3234C10.1605 22.5366 9.83036 22.6394 9.49864 22.6092C9.16691 22.5791 8.86073 22.4184 8.64742 22.1626L0.272187 12.1113C0.0683149 11.8544 -0.0269948 11.5279 0.00661876 11.2016C0.0402323 10.8754 0.200104 10.5752 0.452079 10.3652C0.704055 10.1552 1.02815 10.0521 1.35514 10.0779C1.68212 10.1036 1.98607 10.2563 2.20203 10.5031L10.5773 20.5544C10.7904 20.8104 10.8932 21.1405 10.8631 21.4722C10.8329 21.8039 10.6723 22.1101 10.4164 22.3234Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M10.4164 0.290981C10.6723 0.504297 10.8329 0.810472 10.8631 1.1422C10.8932 1.47393 10.7904 1.80405 10.5773 2.06001L2.20203 12.1113C1.98607 12.3582 1.68212 12.5108 1.35514 12.5365C1.02815 12.5623 0.704055 12.4592 0.452079 12.2492C0.200104 12.0392 0.0402323 11.739 0.00661876 11.4128C-0.0269948 11.0865 0.0683149 10.76 0.272187 10.5031L8.64742 0.451801C8.86073 0.195971 9.16691 0.0353204 9.49864 0.00516333C9.83036 -0.0249937 10.1605 0.0778123 10.4164 0.290981Z"
                                                        fill="white" />
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M1.23678 11.3072C1.23678 10.974 1.36915 10.6544 1.60477 10.4188C1.8404 10.1832 2.15997 10.0508 2.49319 10.0508H26.365C26.6982 10.0508 27.0178 10.1832 27.2534 10.4188C27.489 10.6544 27.6214 10.974 27.6214 11.3072C27.6214 11.6404 27.489 11.96 27.2534 12.1956C27.0178 12.4312 26.6982 12.5636 26.365 12.5636H2.49319C2.15997 12.5636 1.8404 12.4312 1.60477 12.1956C1.36915 11.96 1.23678 11.6404 1.23678 11.3072Z"
                                                        fill="white" />
                                                </svg>
                                            </a>
                                            <h4 class="teacher-name">
                                                {{ @$lecturer->name }}
                                                @if (@$lecturer->belongs_to_awael)
                                                    <img src="{{ asset('assets/front/images/verified.png') }}"
                                                        style="width: 20px">
                                                @endif
                                            </h4>
                                            <div class="top-info d-flex flex-column flex-md-row align-items-center">
                                                @if (@$lecturer->country->name)
                                                    <h5 class="text-color-muted-02 flex-fill">
                                                        {{ @$lecturer->country->name }}
                                                    </h5>
                                                @endif
                                                <div>
                                                    <span class="text-color-muted-02 fw-bold">
                                                        {{ @$lecturer->getRating() }}
                                                    </span>
                                                    <span>
                                                        <svg width="20" height="20" viewBox="0 0 20 20"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M6.58692 5.76911L0.779551 6.61109L0.676693 6.63202C0.520986 6.67336 0.379038 6.75528 0.265346 6.86942C0.151654 6.98355 0.0702908 7.12582 0.0295652 7.28169C-0.0111605 7.43756 -0.00978922 7.60144 0.0335388 7.75661C0.0768668 7.91177 0.160599 8.05266 0.276185 8.16488L4.48334 12.2601L3.49117 18.0447L3.47934 18.1448C3.46981 18.3059 3.50325 18.4665 3.57624 18.6104C3.64922 18.7543 3.75914 18.8762 3.89472 18.9636C4.0303 19.051 4.18668 19.1008 4.34785 19.108C4.50902 19.1151 4.66918 19.0792 4.81194 19.0041L10.0058 16.2733L15.1878 19.0041L15.2789 19.046C15.4291 19.1051 15.5924 19.1233 15.752 19.0985C15.9115 19.0738 16.0617 19.007 16.1869 18.9051C16.3122 18.8032 16.4081 18.6698 16.4648 18.5186C16.5214 18.3674 16.5369 18.2038 16.5095 18.0447L15.5164 12.2601L19.7254 8.16397L19.7964 8.0866C19.8978 7.96168 19.9643 7.81211 19.9891 7.65313C20.0139 7.49415 19.9961 7.33144 19.9376 7.18157C19.879 7.0317 19.7818 6.90003 19.6558 6.79998C19.5297 6.69992 19.3795 6.63506 19.2202 6.612L13.4129 5.76911L10.8168 0.507889C10.7417 0.355455 10.6254 0.227092 10.4811 0.137332C10.3368 0.0475725 10.1703 0 10.0003 0C9.8304 0 9.66386 0.0475725 9.51956 0.137332C9.37526 0.227092 9.25897 0.355455 9.18385 0.507889L6.58692 5.76911Z"
                                                                fill="url(#paint0_linear_30_842)" />
                                                            <defs>
                                                                <linearGradient id="paint0_linear_30_842" x1="10"
                                                                    y1="0" x2="10" y2="19.1093"
                                                                    gradientUnits="userSpaceOnUse">
                                                                    <stop offset="0.025" stop-color="#D89E53"
                                                                        stop-opacity="0.55" />
                                                                    <stop offset="0.265" stop-color="#D89E53"
                                                                        stop-opacity="0.65" />
                                                                    <stop offset="1" stop-color="#D89E53"
                                                                        stop-opacity="0.85" />
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-action-teacher d-flex align-items-center justify-content-between">
                            <div
                                class="swiper-prev d-inline-flex align-items-center justify-content-center rounded-circle">
                                <i
                                    class="fa-regular fa-chevron-{{ app()->getlocale() == 'ar' ? 'right' : 'left' }}"></i>
                            </div>
                            <div
                                class="swiper-next d-inline-flex align-items-center justify-content-center rounded-circle">
                                <i
                                    class="fa-regular fa-chevron-{{ app()->getlocale() == 'ar' ? 'left' : 'right' }}"></i>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mt-5">
                        <div class="col-12 text-center">
                            <a href="{{ route('lecturers.index') }}" class="btn btn-primary px-5">
                                {{ __('All_Lecturers') }}
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>


        </div>
    </section>
    <!-- Team Member's End -->

@endif
