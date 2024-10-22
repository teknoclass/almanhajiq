@php
    $lecturerSetting = @$lecturer->lecturerSetting;
    $lecturerExpertise = @$lecturer->lecturerExpertise;
    $lecturerMaterials = @$lecturer->materials->map->category;
    $lecturerLanguages = @$lecturer->languages->map->category;
    $rating = @$lecturer->getRating();
    $lecturer_url = route('lecturerProfile.index', [
        'id' => @$lecturer->id,
        'name' => mergeString(@$lecturer->name, ''),
    ]);
@endphp
<div class="col-12 col-lg-6 mb-4">
    <div class="bg-white p-3 third-shadow-hover private-lesson-item prim-border rounded-15">
        <div class="card-course">
            <div class="card-body">
                <div class="">
                    <div class="d-flex gap-2">
                        <div class="teachers-image">
                            <img class="w-100" src="{{ imageUrl(@$lecturer->image) }}" alt="{{ @$lecturer->name }}" loading="lazy"/>
                        </div>
                        <div class="flex-fill d-flex justify-content-between py-3">
                            <div>
                                <h5 class="text-colot-primary fw-bold">{{ @$lecturer->name }}</h5>
                                <h6 class="text-muted">{{ @$lecturer->country->name }}</h6>
                            </div>
                            <div class="data-rating">
                                <span class="text-color-muted fw-bold">{{ @$rating }}</span>
                                <span data-rating="{{ @$rating }}">
                                    <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row">
                            {{-- Specialization --}}
                            <div class="col-6 mb-3">
                                <div class="d-flex gap-2 align-items-center flex-column flex-md-row">
                                    <span>
                                        <svg width="38" height="36" viewBox="0 0 38 36" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.950195 4C0.950195 1.79086 2.74106 0 4.9502 0H33.0498C35.259 0 37.0498 1.79086 37.0498 4V32C37.0498 34.2091 35.259 36 33.0498 36H4.9502C2.74106 36 0.950195 34.2091 0.950195 32V4Z"
                                                fill="#2C7EB3" />
                                            <path
                                                d="M26.5384 20.0488L28.5152 23.4735C28.5965 23.6146 28.6425 23.7732 28.649 23.9358C28.6556 24.0985 28.6226 24.2603 28.5529 24.4074C28.4832 24.5546 28.3789 24.6826 28.2488 24.7805C28.1188 24.8784 27.967 24.9434 27.8063 24.9697L27.6927 24.9808L27.5801 24.9798L24.631 24.7887L23.3208 27.4392C23.2497 27.5827 23.1453 27.7072 23.0164 27.8023C22.8875 27.8974 22.7378 27.9603 22.5796 27.9859C22.4215 28.0114 22.2596 27.9989 22.1073 27.9493C21.955 27.8997 21.8167 27.8144 21.704 27.7006L21.6215 27.6061L21.5491 27.4955L19.5703 24.0698C20.9633 23.9827 22.3172 23.5744 23.5261 22.8768C24.735 22.1792 25.766 21.2113 26.5384 20.0488Z"
                                                stroke="#FEFEFE" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M18.4281 24.0698L16.4513 27.4965C16.3712 27.6354 16.2591 27.753 16.1243 27.8398C15.9895 27.9266 15.836 27.9799 15.6765 27.9953C15.5169 28.0108 15.356 27.9879 15.2071 27.9286C15.0582 27.8693 14.9256 27.7753 14.8204 27.6544L14.7439 27.5538L14.6796 27.4392L13.3684 24.7897L10.4213 24.9808C10.259 24.9912 10.0965 24.9622 9.94789 24.8961C9.79924 24.83 9.66882 24.7289 9.5678 24.6014C9.46678 24.4739 9.39818 24.3238 9.36786 24.1639C9.33754 24.0041 9.34641 23.8393 9.39371 23.6837L9.43393 23.5761L9.4842 23.4756L11.463 20.0478C12.2349 21.2103 13.2653 22.1784 14.4737 22.8763C15.682 23.5742 17.0354 23.982 18.4281 24.0698Z"
                                                stroke="#FEFEFE" stroke-linecap="round" stroke-linejoin="round" />
                                            <path
                                                d="M19.0012 8L19.2425 8.00402C21.0664 8.06659 22.7947 8.83512 24.0628 10.1475C25.3309 11.4599 26.0397 13.2135 26.0397 15.0385L26.0366 15.2325L26.0296 15.4256L26.0115 15.6719L25.9854 15.9152L25.9612 16.0942C25.8951 16.5282 25.7883 16.9551 25.6425 17.3692L25.5258 17.6789L25.372 18.0288C24.8028 19.2414 23.8994 20.2664 22.7679 20.9835C21.6364 21.7005 20.3238 22.0799 18.9842 22.0769C17.6446 22.074 16.3337 21.6888 15.2054 20.9668C14.0771 20.2448 13.1782 19.2158 12.6143 18.0006L12.4836 17.702L12.4313 17.5683L12.3509 17.3501L12.2553 17.0545C12.2212 16.94 12.19 16.8247 12.1618 16.7086L12.1015 16.4361L12.0522 16.1636L12.0321 16.0238L11.9929 15.6991L11.9688 15.3321L11.9627 15.0385C11.9627 13.2135 12.6715 11.4599 13.9396 10.1475C15.2077 8.83512 16.936 8.06659 18.7599 8.00402L19.0012 8Z"
                                                stroke="#FEFEFE" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    @if (count(@$lecturerMaterials) > 0)
                                        <div>
                                            <span class="text-color-primary fw-bold">{{ __('materials') }}:</span>
                                            @foreach ($lecturerMaterials as $material)
                                                <span class="text-muted">{{ @$material->name }}</span>
                                            @endforeach
                                        </div>

                                    @endif
                                </div>
                            </div>
                            {{-- language  --}}
                            <div class="col-6 mb-3">
                                <div class="d-flex gap-2 align-items-center flex-column flex-md-row">
                                    <span>
                                        <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.950195 4C0.950195 1.79086 2.74106 0 4.9502 0H32.9502C35.1593 0 36.9502 1.79086 36.9502 4V32C36.9502 34.2091 35.1593 36 32.9502 36H4.9502C2.74106 36 0.950195 34.2091 0.950195 32V4Z"
                                                fill="#2C7EB3" />
                                            <path
                                                d="M9.61686 14.6667H28.2835M9.61686 21.3333H28.2835M18.3946 8C16.5228 10.9996 15.5304 14.4643 15.5304 18C15.5304 21.5357 16.5228 25.0004 18.3946 28M19.5058 8C21.3776 10.9996 22.37 14.4643 22.37 18C22.37 21.5357 21.3776 25.0004 19.5058 28M8.9502 18C8.9502 19.3132 9.20885 20.6136 9.7114 21.8268C10.2139 23.0401 10.9505 24.1425 11.8791 25.0711C12.8077 25.9997 13.9101 26.7363 15.1234 27.2388C16.3366 27.7413 17.637 28 18.9502 28C20.2634 28 21.5638 27.7413 22.777 27.2388C23.9903 26.7363 25.0927 25.9997 26.0213 25.0711C26.9498 24.1425 27.6864 23.0401 28.189 21.8268C28.6915 20.6136 28.9502 19.3132 28.9502 18C28.9502 15.3478 27.8966 12.8043 26.0213 10.9289C24.1459 9.05357 21.6024 8 18.9502 8C16.298 8 13.7545 9.05357 11.8791 10.9289C10.0038 12.8043 8.9502 15.3478 8.9502 18Z"
                                                stroke="#FEFEFE" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    @if (
                                        @$lecturerSetting->abstract ||
                                            @$lecturerSetting->position ||
                                            @$lecturerMaterials->isNotEmpty() ||
                                            @$lecturerLanguages->isNotEmpty())
                                        @if (count(@$lecturerLanguages) > 0)
                                            <div>
                                                <span class="text-color-primary fw-bold">{{ __('languages') }}:</span>
                                                @foreach ($lecturerLanguages as $language)
                                                    <span class="text-muted">{{ @$language->name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            {{-- Levels --}}
                            {{-- <div class="col-6 mb-3">
                                <div class="d-flex gap-2 align-items-center flex-column flex-md-row">
                                    <span>
                                        <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.0498047 4C0.0498047 1.79086 1.84067 0 4.0498 0H32.0498C34.2589 0 36.0498 1.79086 36.0498 4V32C36.0498 34.2091 34.2589 36 32.0498 36H4.0498C1.84067 36 0.0498047 34.2091 0.0498047 32V4Z"
                                                fill="#2C7EB3" />
                                            <path
                                                d="M21.9387 19.1111C20.9073 19.1111 19.9181 19.5208 19.1888 20.2501C18.4595 20.9794 18.0498 21.9686 18.0498 23M18.0498 23V24.1111M18.0498 23C18.0498 21.9686 17.6401 20.9794 16.9108 20.2501C16.1815 19.5208 15.1923 19.1111 14.1609 19.1111M18.0498 23V11.8889M18.0498 24.1111C18.0498 25.1425 18.4595 26.1317 19.1888 26.861C19.9181 27.5903 20.9073 28 21.9387 28C22.9701 28 23.9592 27.5903 24.6886 26.861C25.4179 26.1317 25.8276 25.1425 25.8276 24.1111V22.1111M18.0498 24.1111C18.0498 25.1425 17.6401 26.1317 16.9108 26.861C16.1815 27.5903 15.1923 28 14.1609 28C13.1295 28 12.1404 27.5903 11.4111 26.861C10.6817 26.1317 10.272 25.1425 10.272 24.1111V22.1111M24.1609 22.4444C25.1923 22.4444 26.1815 22.0347 26.9108 21.3054C27.6401 20.5761 28.0498 19.587 28.0498 18.5556C28.0498 17.5242 27.6401 16.535 26.9108 15.8057C26.1815 15.0764 25.1923 14.6667 24.1609 14.6667H23.6054M25.8276 15V11.8889C25.8276 10.8575 25.4179 9.86834 24.6886 9.13903C23.9592 8.40972 22.9701 8 21.9387 8C20.9073 8 19.9181 8.40972 19.1888 9.13903C18.4595 9.86834 18.0498 10.8575 18.0498 11.8889M18.0498 11.8889C18.0498 10.8575 17.6401 9.86834 16.9108 9.13903C16.1815 8.40972 15.1923 8 14.1609 8C13.1295 8 12.1404 8.40972 11.4111 9.13903C10.6817 9.86834 10.272 10.8575 10.272 11.8889V15M11.9387 22.4444C10.9073 22.4444 9.91814 22.0347 9.18883 21.3054C8.45953 20.5761 8.0498 19.587 8.0498 18.5556C8.0498 17.5242 8.45953 16.535 9.18883 15.8057C9.91814 15.0764 10.9073 14.6667 11.9387 14.6667H12.4942"
                                                stroke="#FEFEFE" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    <div>
                                        <span class="text-color-primary fw-bold">المستوى:</span>
                                        <span class="text-muted">مبتدئ</span>
                                    </div>
                                </div>
                           </div> --}}
                            {{-- Hours Price --}}
                            <div class="col-6 mb-3">
                                <div class="d-flex gap-2 align-items-center flex-column flex-md-row">
                                    <span>
                                        <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.0386963 4C0.0386963 1.79086 1.82956 0 4.0387 0H32.0498C34.2589 0 36.0498 1.79086 36.0498 4V32C36.0498 34.2091 34.2589 36 32.0498 36H4.0387C1.82956 36 0.0386963 34.2091 0.0386963 32V4Z"
                                                fill="#2C7EB3" />
                                            <path
                                                d="M23.2665 13.5556C23.0453 12.928 22.6414 12.3811 22.1068 11.985C21.5721 11.589 20.9312 11.362 20.2665 11.3333H15.822C14.938 11.3333 14.0901 11.6845 13.465 12.3096C12.8399 12.9348 12.4887 13.7826 12.4887 14.6667C12.4887 15.5507 12.8399 16.3986 13.465 17.0237C14.0901 17.6488 14.938 18 15.822 18H20.2665C21.1505 18 21.9984 18.3512 22.6235 18.9763C23.2486 19.6014 23.5998 20.4493 23.5998 21.3333C23.5998 22.2174 23.2486 23.0652 22.6235 23.6904C21.9984 24.3155 21.1505 24.6667 20.2665 24.6667H15.822C15.1573 24.638 14.5164 24.411 13.9817 24.015C13.4471 23.6189 13.0432 23.072 12.822 22.4444M18.0443 8V11.3333M18.0443 24.6667V28"
                                                stroke="#FEFEFE" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                    @if (@$lecturer->hour_price)
                                        <div>
                                            <span class="text-color-priamry fw-bold">{{ __('hour_price') }}: </span>
                                            <span
                                                class="text-color-third fw-bold">{{ __(@$lecturer->hour_price) . __('currency') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 align-items-center text-center justify-content-center">
                    <div class="col-md-6 col-12 mb-3">
                        <a class="primary-btn py-2 px-5" href="{{ @$lecturer_url . '#tab-2' }}">
                            {{ __('book_lesson') }}
                        </a>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <h3>
                            <a class="text-color-primary text-center p-1 text-underline" href="{{ @$lecturer_url }}">
                                {{ __('view_profile') }}
                            </a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
        <div class="col-lg-3 my-1">
            <div class="bg-light-green rounded-15 px-3 py-4 text-center">
                <a href="{{ @$lecturer_url }}">
                    <div class="symbol symbol-70 mb-3"><img class="rounded-circle" src="{{ imageUrl(@$lecturer->image) }}"
                            alt="{{ @$lecturer->name }}" />
                    </div>
                    <h3 class="font-medium mb-2">
                        {{ @$lecturer->name }}
                        @if (@$lecturer->belongs_to_awael)
                            <img src="{{ asset('assets/front/images/verified.png') }}" style="width: 30px">
                        @endif
                    </h3>
                    @if (@$lecturerSetting->position)
                        <h6 class="text-muted">{{@$lecturerSetting->position }}</h6>
                    @endif
                </a>
                <div class="data-rating d-flex align-items-center justify-content-center">
                    <span class="d-flex" data-rating="{{ @$rating }}">
                        <i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i
                            class="far fa-star"></i><i class="far fa-star"></i>
                    </span>
                    <span class="pt-1">{{ @$rating }}</span>
                </div>

                @if (@$lecturer->id != auth()->id())
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-outline-secondary py-2 px-2 mt-2" style="width:100%"
                                href="{{ route('user.chat.open.chat', @$lecturer->id) }}"><i
                                    class="fa-solid fa-comment-dots me-1"></i>{{ __('chat') }}</a>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-success py-2 px-2 mt-2" href="{{ @$lecturer_url . '#tab-2' }}"
                                style="width:100%"><i class="fa-solid fa-calendar-days me-1"></i>{{ __('book_lesson') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row gx-lg-2 my-1">
                @if (@$lecturer->motherLang->name)
                    <div class="col">
                        <div class="bg-light-green mb-3 text-center rounded-10 py-3">
                            <span><i class="fa-solid fa-language"></i> {{ __('mother_language') }}: </span>
                            <span><strong>{{ @$lecturer->motherLang->name }}</strong></span>
                        </div>
                    </div>
                @endif

                @if (@$lecturer->country->name)
                    <div class="col">
                        <div class="bg-light-green mb-3 text-center rounded-10 py-3">
                            <span><i class="fa-solid fa-flag"></i> {{ __('country') }}: </span>
                            <span><strong>{{ @$lecturer->country->name }}</strong></span>
                        </div>
                    </div>
                @endif

                @if (@$lecturer->gender)
                    <div class="col">
                        <div class="bg-light-green mb-3 text-center rounded-10 py-3">
                            <span><i class="fa-solid fa-user"></i> {{ __('gender') }}: </span>
                            <span><strong>{{ __(@$lecturer->gender) }}</strong></span>
                        </div>
                    </div>
                @endif

                @if (@$lecturer->hour_price)
                    <div class="col">
                        <div class="bg-light-green mb-3 text-center rounded-10 py-3">
                            <span><i class="fa-solid fa-clock"></i> {{ __('hour_price') }}: </span>
                            <span><strong>{{ __(@$lecturer->hour_price) . __('currency') }}</strong></span>
                        </div>
                    </div>
                @endif
            </div>
            @if (@$lecturerSetting->abstract || @$lecturerSetting->position || @$lecturerMaterials->isNotEmpty() || @$lecturerLanguages->isNotEmpty())
                <div class="bg-light-green rounded-15 p-3" style="min-height: 187px">
                    <div class="mb-1">
                        @if (count(@$lecturerLanguages) > 0)
                            <div class="d-block font-14 text-gray mt-2" style="line-height: 1.8;">
                                <span><i class="fa-solid fa-language"></i> {{ __('languages') }}: </span>
                                @foreach ($lecturerLanguages as $language)
                                    <span class="experience">{{ @$language->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if (count(@$lecturerMaterials) > 0)
                            <div class="d-block font-14 text-gray mt-2" style="line-height: 1.8;">
                                <span><i class="fa-solid fa-file-video"></i> {{ __('materials') }}: </span>
                                @foreach ($lecturerMaterials as $material)
                                    <span class="experience">{{ @$material->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if (@$lecturerSetting->abstract)
                            <div class="d-block font-14 text-gray mt-2" style="line-height: 1.8;">
                                <h5 class="font-medium"><i class="fa-solid fa-circle-info"></i>
                                    {{ __('about_trainer') }}</h5>
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
                                            <span class="read-more-btn"><strong>{{ __('read_more') }}</strong></span>
                                        @endif
                                    </div>

                                    <div class="more-text" style="display: none;">
                                        {!! @$lecturerSetting->abstract !!}
                                        <span class="read-less-btn"><strong>{{ __('hide_details') }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
        <div class="col-lg-3 my-1">
            <div class="position-relative image-coach">
                <img src="{{ imageUrl(@$lecturerSetting->video_thumbnail) }}" alt="{{ @$lecturer->name }}" />
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
