<div class="single-page-hero-section">
    <div class="container">
        @include('front.courses.partials.single_course_page_sections.breadcrumb')
        <div class="row">
            <div class="col-12 col-lg-8 mb-4">
                <div class="position-relative d-inline-block w-100">
                    <img class="img-video" src="{{ imageUrl(@$course->video_image ?? @$course->image) }}"
                        alt="{{ @$course->title }}" />
                    @if (@$course->video)
                        <a class="btn-play-video" href="{{ @$course->video }}" data-fancybox="">
                            <svg width="113" height="112" viewBox="0 0 113 112" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="56.5" cy="56" r="50" fill="#FEFEFE" fill-opacity="0.6" />
                                <circle cx="56.5" cy="56" r="55.5" stroke="#E7E7E7" />
                                <path d="M80.4238 81.9229C94.7605 67.5862 94.7605 44.3762 80.4238 30.0762"
                                    stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M28.5767 30.0762C14.2401 44.4128 14.2401 67.6229 28.5767 81.9229"
                                    stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M42.4004 90.5029C46.3237 91.8596 50.3937 92.5198 54.5003 92.5198C58.607 92.4831 62.677 91.8596 66.6003 90.5029"
                                    stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M42.4004 21.4963C46.3237 20.1397 50.3937 19.4795 54.5003 19.4795C58.607 19.4795 62.677 20.1397 66.6003 21.4963"
                                    stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M42.5469 55.9999V49.8766C42.5469 42.2499 47.9369 39.1332 54.5369 42.9465L59.8535 46.0266L65.1703 49.1065C71.7703 52.9198 71.7703 59.1533 65.1703 62.9666L59.8535 66.0465L54.5369 69.1266C47.9369 72.9399 42.5469 69.8232 42.5469 62.1965V55.9999Z"
                                    fill="#013B3D" />
                            </svg>
                        </a>
                    @endif
                    @if (@$course->video_type && @$course->video)
                        @if (@$course->video_type == 'file')
                            <a class="btn-play-video" href="{{ videoUrl(@$course->video) }}" data-fancybox="">
                                <svg width="113" height="112" viewBox="0 0 113 112" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="56.5" cy="56" r="50" fill="#FEFEFE" fill-opacity="0.6" />
                                    <circle cx="56.5" cy="56" r="55.5" stroke="#E7E7E7" />
                                    <path d="M80.4238 81.9229C94.7605 67.5862 94.7605 44.3762 80.4238 30.0762"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M28.5767 30.0762C14.2401 44.4128 14.2401 67.6229 28.5767 81.9229"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.4004 90.5029C46.3237 91.8596 50.3937 92.5198 54.5003 92.5198C58.607 92.4831 62.677 91.8596 66.6003 90.5029"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.4004 21.4963C46.3237 20.1397 50.3937 19.4795 54.5003 19.4795C58.607 19.4795 62.677 20.1397 66.6003 21.4963"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.5469 55.9999V49.8766C42.5469 42.2499 47.9369 39.1332 54.5369 42.9465L59.8535 46.0266L65.1703 49.1065C71.7703 52.9198 71.7703 59.1533 65.1703 62.9666L59.8535 66.0465L54.5369 69.1266C47.9369 72.9399 42.5469 69.8232 42.5469 62.1965V55.9999Z"
                                        fill="#013B3D" />
                                </svg>
                            </a>
                        @elseif (@$course->video_type == 'link')
                            <a class="btn-play-video" href="{{ @$course->video }}" data-fancybox="">
                                <svg width="113" height="112" viewBox="0 0 113 112" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="56.5" cy="56" r="50" fill="#FEFEFE" fill-opacity="0.6" />
                                    <circle cx="56.5" cy="56" r="55.5" stroke="#E7E7E7" />
                                    <path d="M80.4238 81.9229C94.7605 67.5862 94.7605 44.3762 80.4238 30.0762"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M28.5767 30.0762C14.2401 44.4128 14.2401 67.6229 28.5767 81.9229"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.4004 90.5029C46.3237 91.8596 50.3937 92.5198 54.5003 92.5198C58.607 92.4831 62.677 91.8596 66.6003 90.5029"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.4004 21.4963C46.3237 20.1397 50.3937 19.4795 54.5003 19.4795C58.607 19.4795 62.677 20.1397 66.6003 21.4963"
                                        stroke="#01585B" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M42.5469 55.9999V49.8766C42.5469 42.2499 47.9369 39.1332 54.5369 42.9465L59.8535 46.0266L65.1703 49.1065C71.7703 52.9198 71.7703 59.1533 65.1703 62.9666L59.8535 66.0465L54.5369 69.1266C47.9369 72.9399 42.5469 69.8232 42.5469 62.1965V55.9999Z"
                                        fill="#013B3D" />
                                </svg>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-4">
                <div class="content course-info">
                    <div class="category">
                        <div class="icon">
                            <svg width="121" height="32" viewBox="0 0 121 32" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1.22609 1.78087C0.487949 1.19036 0.905503 0 1.85078 0H121V32H1.85079C0.905509 32 0.487948 30.8096 1.22609 30.2191L17.0478 17.5617C18.0486 16.7611 18.0486 15.2389 17.0478 14.4383L1.22609 1.78087Z"
                                    fill="#6F2B90"></path>
                            </svg>
                        </div>
                        <span class="cate-title">{{ @$course->category->name }}</span>
                    </div>
                    <h4 class="text-color-secondary">
                        {{ @$course->title }}
                    </h4>
                    <div class="text-desc">
                        @php
                            $description =   Illuminate\Support\Str::limit(strip_tags($course->description), $limit = 250, $end = '...') ;
                        @endphp
                        {!! $description !!}
                    </div>
                    <div>
                        <div class="info my-2 d-flex gap-2 flex-wrap">
                            <span>
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.5413 8.16675C26.5413 8.39881 26.4492 8.62137 26.2851 8.78547C26.121 8.94956 25.8984 9.04175 25.6663 9.04175H2.33301C2.10094 9.04175 1.87838 8.94956 1.71429 8.78547C1.5502 8.62137 1.45801 8.39881 1.45801 8.16675C1.45801 7.93468 1.5502 7.71212 1.71429 7.54803C1.87838 7.38394 2.10094 7.29175 2.33301 7.29175H25.6663C25.8984 7.29175 26.121 7.38394 26.2851 7.54803C26.4492 7.71212 26.5413 7.93468 26.5413 8.16675ZM23.0413 14.0001C23.0413 14.2321 22.9492 14.4547 22.7851 14.6188C22.621 14.7829 22.3984 14.8751 22.1663 14.8751H5.83301C5.60094 14.8751 5.37838 14.7829 5.21429 14.6188C5.05019 14.4547 4.95801 14.2321 4.95801 14.0001C4.95801 13.768 5.05019 13.5455 5.21429 13.3814C5.37838 13.2173 5.60094 13.1251 5.83301 13.1251H22.1663C22.3984 13.1251 22.621 13.2173 22.7851 13.3814C22.9492 13.5455 23.0413 13.768 23.0413 14.0001ZM19.5413 19.8334C19.5413 20.0655 19.4492 20.288 19.2851 20.4521C19.121 20.6162 18.8984 20.7084 18.6663 20.7084H9.33301C9.10094 20.7084 8.87838 20.6162 8.71429 20.4521C8.55019 20.288 8.45801 20.0655 8.45801 19.8334C8.45801 19.6014 8.55019 19.3788 8.71429 19.2147C8.87838 19.0506 9.10094 18.9584 9.33301 18.9584H18.6663C18.8984 18.9584 19.121 19.0506 19.2851 19.2147C19.4492 19.3788 19.5413 19.6014 19.5413 19.8334Z"
                                        fill="#D89E53" />
                                </svg>
                            </span>
                            <div class="text">
                                {{__('type')}} : {{__(@$course->type) }}
                            </div>
                        </div>
                        <div class="info my-2 d-flex gap-2 flex-wrap">
                            <span>
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.9998 8.35326C20.9298 8.34159 20.8481 8.34159 20.7781 8.35326C19.1681 8.29492 17.8848 6.97659 17.8848 5.34325C17.8848 3.67492 19.2264 2.33325 20.8948 2.33325C22.5631 2.33325 23.9048 3.68659 23.9048 5.34325C23.8931 6.97659 22.6098 8.29492 20.9998 8.35326Z"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M19.7987 16.8465C21.397 17.1149 23.1587 16.8349 24.3953 16.0065C26.0403 14.9099 26.0403 13.1132 24.3953 12.0165C23.147 11.1882 21.362 10.9082 19.7637 11.1882"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M6.96457 8.35326C7.03457 8.34159 7.11624 8.34159 7.18624 8.35326C8.79624 8.29492 10.0796 6.97659 10.0796 5.34325C10.0796 3.67492 8.73791 2.33325 7.06957 2.33325C5.40124 2.33325 4.05957 3.68659 4.05957 5.34325C4.07124 6.97659 5.35457 8.29492 6.96457 8.35326Z"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M8.16635 16.8465C6.56802 17.1149 4.80635 16.8349 3.56969 16.0065C1.92469 14.9099 1.92469 13.1132 3.56969 12.0165C4.81802 11.1882 6.60302 10.9082 8.20135 11.1882"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M13.9998 17.0683C13.9298 17.0567 13.8481 17.0567 13.7781 17.0683C12.1681 17.01 10.8848 15.6917 10.8848 14.0583C10.8848 12.39 12.2264 11.0483 13.8948 11.0483C15.5631 11.0483 16.9048 12.4017 16.9048 14.0583C16.8931 15.6917 15.6098 17.0217 13.9998 17.0683Z"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M10.6048 20.7434C8.95984 21.8401 8.95984 23.6367 10.6048 24.7334C12.4715 25.9817 15.5282 25.9817 17.3948 24.7334C19.0398 23.6367 19.0398 21.8401 17.3948 20.7434C15.5398 19.5068 12.4715 19.5068 10.6048 20.7434Z"
                                        stroke="#D89E53" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>

                            <div class="text">
                               {{@$course->graduates()->count()}} {{__('student_finished_this_course')}}
                            </div>

                        </div>
                    </div>
                    @if (!$course->isSubscriber())
                        <div class="pt-2 d-flex align-items-center">
                            <div class="text-color-secondary flex-fill font-bold">{!! @$course->getPriceDisc() !!}</div>
                            <a href="#course-registration" class="primary-btn py-2 px-5 text-center font-bold">
                                {{ __('register_now') }}
                            </a>
                        </div>
                    @else
                        <div class="pt-2">
                            <a href="{{url('/user/courses/curriculum/item/'.$course->id)}}"
                                class="primary-btn py-2 d-block w-100 text-center font-bold">
                                {{__('continue_course')}}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
