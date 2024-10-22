<div class="hero-lecturer">
    <div class="container">
        <div class="text">
            <h2 class="mb-1">
                المحاضر:
                {{ @$lecturer->name }}
                @if (@$lecturer->belongs_to_awael)
                    <img src="{{ asset('assets/front/images/verified.png') }}" style="width: 20px" loading="lazy" />
                @endif
            </h2>
            @if (@$lecturerSetting->position)
                <div class="pt-1">
                    <h3>{{ @$lecturerSetting->position }}</h3>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="image-box">
        <img src="{{ imageUrl(@$lecturer->image) }}" alt="lecturer-image" loading="lazy" />
    </div>
    <div class="row align-items-center">
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            @if (@$lecturerSetting->abstract)
                <div class="about-trainer mt-2">
                    <h4 class="title mb-3">
                        {{ __('about_trainer') }}
                    </h4>
                    <div class="read-more-container">
                        @php
                            $maxLength = 150;
                            $abstract = @$lecturerSetting->abstract;

                            if (mb_strlen($abstract) > $maxLength) {
                                $truncatedAbstract = mb_substr($abstract, 0, $maxLength);
                                $lastWordPosition = mb_strrpos($truncatedAbstract, ' ');

                                if ($lastWordPosition !== false) {
                                    // If a space is found within the limit, truncate at the last space
                                    $abstract = mb_substr($abstract, 0, $lastWordPosition);
                                }
                            }
                        @endphp

                        <div class="read-more-text" data-max-length="{{ $maxLength }}">
                            {!! $abstract !!}
                            @if (mb_strlen(@$lecturerSetting->abstract) > $maxLength)
                                <span class="read-more-btn"><strong>اقرأ المزيد</strong></span>
                            @endif
                        </div>

                        <div class="more-text" style="display: none;">
                            {!! @$lecturerSetting->abstract !!}
                            <span class="read-less-btn"><strong>إخفاء التفاصيل</strong></span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="statics-box">
                <h5 class="title">
                    الاحصاءيات الخاصة بالمدرس
                </h5>
                <div class="row">
                    <div class="col-6 mb-4 d-flex align-items-center gap-2">
                        <span>
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="44" height="44" rx="8" fill="#FF5A5F" fill-opacity="0.1" />
                                <path
                                    d="M15.5 12C15.5 11.4477 15.0523 11 14.5 11C13.9477 11 13.5 11.4477 13.5 12V13.5H12C11.4477 13.5 11 13.9477 11 14.5C11 15.0523 11.4477 15.5 12 15.5H13.5V17C13.5 17.5523 13.9477 18 14.5 18C15.0523 18 15.5 17.5523 15.5 17V15.5H17C17.5523 15.5 18 15.0523 18 14.5C18 13.9477 17.5523 13.5 17 13.5H15.5V12Z"
                                    fill="#FF5A5F" />
                                <path
                                    d="M15.5 27C15.5 26.4477 15.0523 26 14.5 26C13.9477 26 13.5 26.4477 13.5 27V28.5H12C11.4477 28.5 11 28.9477 11 29.5C11 30.0523 11.4477 30.5 12 30.5H13.5V32C13.5 32.5523 13.9477 33 14.5 33C15.0523 33 15.5 32.5523 15.5 32V30.5H17C17.5523 30.5 18 30.0523 18 29.5C18 28.9477 17.5523 28.5 17 28.5H15.5V27Z"
                                    fill="#FF5A5F" />
                                <path
                                    d="M23.9333 12.641C23.7848 12.2548 23.4138 12 23 12C22.5862 12 22.2152 12.2548 22.0667 12.641L20.3325 17.1499C20.0321 17.9309 19.9377 18.156 19.8085 18.3376C19.679 18.5198 19.5198 18.679 19.3376 18.8085C19.156 18.9377 18.9309 19.0321 18.1499 19.3325L13.641 21.0667C13.2548 21.2152 13 21.5862 13 22C13 22.4138 13.2548 22.7848 13.641 22.9333L18.1499 24.6675C18.9309 24.9679 19.156 25.0623 19.3376 25.1914C19.5198 25.321 19.679 25.4802 19.8085 25.6624C19.9377 25.844 20.0321 26.0691 20.3325 26.8501L22.0667 31.359C22.2152 31.7452 22.5862 32 23 32C23.4138 32 23.7848 31.7452 23.9333 31.359L25.6675 26.8501C25.9679 26.0691 26.0623 25.844 26.1914 25.6624C26.321 25.4802 26.4802 25.321 26.6624 25.1914C26.844 25.0623 27.0691 24.9679 27.8501 24.6675L32.359 22.9333C32.7452 22.7848 33 22.4138 33 22C33 21.5862 32.7452 21.2152 32.359 21.0667L27.8501 19.3325C27.0691 19.0321 26.844 18.9377 26.6624 18.8085C26.4802 18.679 26.321 18.5198 26.1914 18.3376C26.0623 18.156 25.9679 17.9309 25.6675 17.1499L23.9333 12.641Z"
                                    fill="#FF5A5F" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="num">{{ $lecturer->lecturer_courses_count }}</h3>
                            <h6 class="text">دورة يقدمها </h6>
                        </div>
                    </div>
                    <div class="col-6 mb-4 d-flex align-items-center gap-2">
                        <span>
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect width="44" height="44" rx="8" fill="#E6F4F9" />
                                <path
                                    d="M25.2311 12.7176C27.306 11.5765 29.6383 10.9851 32.0062 10.9998C32.5561 11.0032 33 11.4499 33 11.9998C33 14.8101 32.2117 19.7075 27.1477 23.4164C27.2329 23.774 27.3298 24.2446 27.3968 24.7647C27.47 25.3321 27.5111 25.9852 27.4514 26.6279C27.3924 27.2619 27.2288 27.9597 26.8321 28.5547L26.8312 28.556C26.1523 29.5709 24.8718 30.1594 23.9773 30.4838C23.4966 30.6582 23.0525 30.7818 22.7294 30.862C22.4858 30.9224 22.3071 30.9591 22.2261 30.9749C21.9179 31.0335 21.6038 30.9719 21.3592 30.7677C21.1316 30.5777 21 30.2965 21 30V25.414L18.586 23H14C13.7035 23 13.4223 22.8685 13.2323 22.6409C13.0423 22.4133 12.9631 22.1131 13.0161 21.8214C13.0498 21.6365 13.0928 21.453 13.138 21.2707C13.2182 20.9475 13.3418 20.5035 13.5162 20.0228C13.8406 19.1283 14.4291 17.8478 15.444 17.1688L15.4453 17.168C16.0403 16.7713 16.7381 16.6076 17.3721 16.5487C18.0148 16.4889 18.6679 16.5301 19.2353 16.6032C19.7608 16.6709 20.2359 16.7692 20.5948 16.8551C21.8057 15.1461 23.3899 13.7303 25.2311 12.7176Z"
                                    fill="#17C2FF" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.0031 24.9883C15.2199 24.9641 14.4554 25.2299 13.8562 25.7346C13.3294 26.1774 12.9426 26.7872 12.6561 27.3738C12.3639 27.9719 12.1419 28.6175 11.976 29.1973C11.8093 29.7804 11.6933 30.3181 11.6191 30.7092C11.5818 30.9055 11.5547 31.0666 11.5367 31.1801C11.5269 31.2417 11.5178 31.3035 11.5091 31.3653L11.5088 31.3669C11.4675 31.6758 11.5725 31.9866 11.7929 32.2069C12.0132 32.4273 12.3245 32.5322 12.6333 32.4909C12.6955 32.4821 12.7577 32.4729 12.8197 32.4631C12.9332 32.4451 13.0943 32.418 13.2906 32.3807C13.6817 32.3065 14.2194 32.1905 14.8025 32.0238C15.3823 31.8579 16.0279 31.6359 16.626 31.3437C17.2124 31.0573 17.822 30.6707 18.2647 30.1442C19.2857 28.935 19.301 27.0516 18.1126 25.8782L18.1004 25.8664C17.5334 25.3253 16.7865 25.0126 16.0031 24.9883Z"
                                    fill="#17C2FF" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="num">360</h3>
                            <h6 class="text">دقائق تمت </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="progress-box">
                <div class="row">
                    <div class="col-6 mb-2">
                        <div class="d-flex aling-items-center justify-content-center flex-wrap text">
                            <span class="flex-fill">
                                مهارات التواصل
                            </span>
                            <span>
                                98%
                            </span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-color-secondary" style="width: 98%"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="d-flex aling-items-center justify-content-center flex-wrap text">
                            <span class="flex-fill">
                                معرفته بالمادة
                            </span>
                            <span>
                                99%
                            </span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-color-secondary" style="width: 99%"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="d-flex aling-items-center justify-content-center flex-wrap text">
                            <span class="flex-fill">
                                مهارات حل المشكلات
                            </span>
                            <span>
                                78%
                            </span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-color-secondary" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="d-flex aling-items-center justify-content-center flex-wrap text">
                            <span class="flex-fill">
                                قدراته التحفيزية
                            </span>
                            <span>
                                100%
                            </span>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                            aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-color-secondary" style="width: 98%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div class="row gap-3 gap-lg-0">
        <div class="col-lg-3">
            <div class="bg-light-green h-100 rounded-15 d-flex flex-column justify-content-between p-3 text-center">
                <div class="data-rating d-flex align-items-center justify-content-center"><span class="d-flex"
                        data-rating="{{ @$lecturer->getRating() }}"><i class="far fa-star"></i><i
                            class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
                            class="far fa-star"></i></span><span class="pt-1">{{ @$lecturer->getRating() }}</span>
                </div>
                <div class="row row-cols-6 justify-content-center row-cols-md-4 row-cols-lg-3 gx-lg-2">
                    <div class="col-4">
                        <div class="bg-light-green mb-2 text-center rounded-10 py-3">
                            <h3 class="font-medium">{{ $teacherPrivateLessonsCount }}</h3>
                            <h6>مرات الحجز</h6>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="bg-light-green mb-2 text-center rounded-10 py-3">
                            <h3 class="font-medium">{{ $teacherStudentsPrivateLessonsCount }}</h3>
                            <h6>عدد الطلاب</h6>
                        </div>
                    </div>

                </div>
                @if (@$lecturer->id != auth()->id())
<a class="btn btn-outline-secondary py-2 px-2 mt-2" style="width:100%"
                        href="{{ route('user.chat.open.chat', @$lecturer->id) }}">
                        <i class="fa-solid fa-comment-dots me-1"></i>
                        {{ __('start_chat') }}
                    </a>

                    <a class="btn btn-success py-2 px-2 mt-2" href="javascript:void()" onclick="show_appoinments_tab()"
                        style="width:100%">
                        <i class="fa-regular fa-calendar-check"></i>
                        {{ __('Test_Reservation') }}
                    </a>
@endif
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <div class="d-flex flex-column justify-content-between h-100">
                @if (@$lecturerSetting->abstract || @$lecturerMaterials->isNotEmpty() || @$lecturerLanguages->isNotEmpty())
                    <div class="bg-light-green rounded-15 p-3 mb-3">
                        <div class="mb-1">

                             @if (@$lecturerSetting->abstract)
                                <h5 class="font-medium"><i class="fa-solid fa-certificate"></i> {{ @$lecturerSetting->abstract }}</h5>
                            @endif
                            <!--<div class="d-block font-14 text-gray mt-1">
                                <span><i class="fa-solid fa-school"></i> المناهج:</span>
                                <span class="occupation">المنهج المصري, </span><span class="occupation">المنهج السعودي</span>
                            </div>-->

                             @if (@$lecturerLanguages->isNotEmpty())
                                <div class="d-block font-14 text-gray mt-2" style="line-height: 1.8;">
                                    <span><i class="fa-solid fa-language"></i> اللغات: </span>
                                    @foreach ($lecturerLanguages as $language)
                                        <span class="experience">{{ @$language->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                             <div class="d-block font-14 text-gray mt-2" style="line-height: 1.8;">
                                @if (@$lecturerMaterials->isNotEmpty())
                                    <span><i class="fa-solid fa-file-video"></i> المواد: </span>
                                    @foreach ($lecturerMaterials as $material)
                                        <span class="experience">{{ @$material->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                {{-- <div class="row gx-lg-2">
                     @if (@$lecturer->country->name)
                        <div class="col-6 col-lg-3">
                            <div class="bg-light-green mb-3 text-center rounded-10 py-3" style="height: 100px;">
                                <h6><i class="fa-solid fa-flag"></i> الدولة</h6>
                                <h3 class="font-medium mb-2">{{ @$lecturer->country->name }}</h3>
                            </div>
                        </div>
                    @endif
                     @if (@$lecturer->gender)
                        <div class="col-6 col-lg-3">
                            <div class="bg-light-green mb-3 text-center rounded-10 py-3" style="height: 100px;">
                                <h6><i class="fa-solid fa-user"></i> الجنس</h6>
                                <h3 class="font-medium mb-2">{{ __(@$lecturer->gender) }}</h3>
                            </div>
                        </div>
                    @endif

                     @if (@$lecturer->motherLang)
                        <div class="col-6 col-lg-3">
                            <div class="bg-light-green mb-6 text-center rounded-10 py-3" style="height: 100px;">
                                <h6><i class="fa-solid fa-language"></i> {{ __('mother_language') }}</h6>
                                <span class="h5 mb-2">{{ @$lecturer->motherLang->name }}</span>
                            </div>
                        </div>
                    @endif
                </div> --}}
        {{-- @if (@$lecturerSetting->description || @$lecturerSetting->twitter || @$lecturerSetting->facebook || @$lecturerSetting->youtube || @$lecturerSetting->instagram) --}}
        {{-- @if (@$lecturerSetting->description)
                    <div class="bg-light-green rounded-15 p-3 lecturer-description-div">
                         @if (@$lecturerSetting->description)
                            <div class="mb-1">
                                <h5 class="font-medium">
                                    <i class="fa-solid fa-circle-info"></i>
                                    وصف المدرب
                                </h5>
                                <div class="read-more-container">
                                    @php
                                        $maxLength = 235;
                                        $description = @$lecturerSetting->description;

                                        if (mb_strlen($description) > $maxLength) {
                                            $truncateddescription = mb_substr($description, 0, $maxLength);
                                            $lastWordPosition = mb_strrpos($truncateddescription, ' ');

                                            if ($lastWordPosition !== false) {
                                                // If a space is found within the limit, truncate at the last space
                                                $description = mb_substr($description, 0, $lastWordPosition);
                                            }
                                        }
                                    @endphp

                                    <div class="read-more-text" data-max-length="{{ $maxLength }}">
                                        {!! $description !!}
                                        @if (mb_strlen(@$lecturerSetting->description) > $maxLength)
                                            <span class="read-more-btn"><strong>اقرأ المزيد</strong></span>
                                        @endif
                                    </div>

                                    <div class="more-text" style="display: none;">
                                        {!! @$lecturerSetting->description !!}
                                        <span class="read-less-btn"><strong>إخفاء التفاصيل</strong></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                         @if (@$lecturerSetting->twitter || @$lecturerSetting->facebook || @$lecturerSetting->youtube || @$lecturerSetting->instagram)
                    <div class="mb-1 d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column">
                            <h5 class="font-medium"><i class="fa-solid fa-address-book"></i> بيانات التواصل</h5>
                            <ul class="social-media social-dark">
                                @if (@$lecturerSetting->twitter)
                                <li><a class="tw" href="{{@$lecturerSetting->twitter }}"><i class="fa-brands fa-twitter"> </i></a></li>
                                @endif
                                @if (@$lecturerSetting->facebook)
                                <li><a class="fa" href="{{@$lecturerSetting->facebook }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                                @endif
                                @if (@$lecturerSetting->youtube)
                                <li><a class="yo" href="{{@$lecturerSetting->youtube }}"><i class="fa-brands fa-youtube"></i></a></li>
                                @endif
                                @if (@$lecturerSetting->instagram)
                                <li><a class="in" href="{{@$lecturerSetting->instagram }}"><i class="fa-brands fa-instagram"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
                    </div>
                @endif
            </div>
        </div> --}}
        {{-- <div class="col-lg-3">
            <div class="bg-light-green h-100 rounded-15 p-3 mb-3">
                <div class="position-relative image-coach">
                    <img src="{{ imageUrl(@$lecturerSetting->video_thumbnail) }}" alt="{{ @$lecturer->name }}"
                        loading="lazy" />
                    @if (@$lecturerSetting->video_type && @$lecturerSetting->video)
                        @if (@$lecturerSetting->video_type == 'file')
                            <a class="btn-play-video" href="{{ videoUrl(@$lecturerSetting->video) }}" data-fancybox="">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        @elseif (@$lecturerSetting->video_type == 'link')
                            <a class="btn-play-video" href="{{ @$lecturerSetting->video }}" data-fancybox="">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div> --}}
    </div>
-->
</div>

@push('front_js')
    <script>
        document.querySelectorAll('.read-more-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                let container = this.closest('.read-more-container');
                let moreText = container.querySelector('.more-text');
                let textContent = container.querySelector('.read-more-text');

                textContent.style.display = 'none';
                moreText.style.display = 'inline';
            });
        });
        document.querySelectorAll('.read-less-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                let container = this.closest('.read-more-container');
                let moreText = container.querySelector('.more-text');
                let textContent = container.querySelector('.read-more-text');

                textContent.style.display = 'inline';
                moreText.style.display = 'none';
            });
        });
    </script>
@endpush
