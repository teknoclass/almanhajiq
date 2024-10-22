<div class="tab" id="{{ @$tab }}">
    <div class="card-course shadow rounded p-3">
        <div class="">
            <h5 class="text-colot-primary">
                <span><svg width="22" height="26" viewBox="0 0 22 26" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14.8947 1V6.05263C14.8947 6.38764 15.0278 6.70893 15.2647 6.94582C15.5016 7.18271 15.8229 7.31579 16.1579 7.31579H21.2105M14.8947 1H6.05263C5.38261 1 4.74003 1.26616 4.26626 1.73994C3.79248 2.21372 3.52632 2.8563 3.52632 3.52632V7.31579M14.8947 1L21.2105 7.31579M21.2105 7.31579V21.2105C21.2105 21.8805 20.9444 22.5231 20.4706 22.9969C19.9968 23.4707 19.3542 23.7368 18.6842 23.7368H12.3684M2.89474 18.6842L1 25L4.78947 23.1053L8.57895 25L6.68421 18.6842M1 14.8947C1 15.8998 1.39925 16.8636 2.10991 17.5743C2.82058 18.285 3.78444 18.6842 4.78947 18.6842C5.7945 18.6842 6.75837 18.285 7.46904 17.5743C8.1797 16.8636 8.57895 15.8998 8.57895 14.8947C8.57895 13.8897 8.1797 12.9258 7.46904 12.2152C6.75837 11.5045 5.7945 11.1053 4.78947 11.1053C3.78444 11.1053 2.82058 11.5045 2.10991 12.2152C1.39925 12.9258 1 13.8897 1 14.8947Z"
                            stroke="#051242" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{ __('certificate_desc') }}
            </h5>
        </div>
        <div class="card-body">
            <div class="">
                {{-- <h6 class="font-bold mb-1">{{ __('certificate_text') }}</h6> --}}
                <p>{!! @$course->certificate_text !!}</p>
                {{-- <h6>يمكنك مشاركة الشهادة على</h6>
                                    <ul class="social-media mt-2 social-dark py-2 px-0">
                                        <li><a class="tw" href=""><i class="fa-brands fa-twitter"> </i></a></li>
                                        <li><a class="fa" href=""><i class="fa-brands fa-facebook-f"></i></a></li>
                                        <li><a class="yo" href=""><i class="fa-brands fa-youtube"></i></a></li>
                                        <li><a class="in" href=""><i class="fa-brands fa-instagram"></i></a></li>
                                    </ul> --}}
                <div class="ctf-image">
                    <div>
                        <img class="rounded" src="{{ imageUrl(@$course->certificate_text_image) }}"
                            alt="{{ @$course->title }}" loading="lazy"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
