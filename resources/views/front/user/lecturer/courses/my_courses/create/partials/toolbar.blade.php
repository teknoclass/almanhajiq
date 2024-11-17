@if (isset($item))
    @php
        $toolbar = [
            [
                'title' => __('course_information'),
                'icon' => 'fas fa-cog me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'base-information'),
                'href' => route('user.lecturer.my_courses.edit.baseInformation.index', ['id' => @$item->id]),
            ],
            [
                'title' => __('course_details'),
                'icon' => 'fas fa-cog me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'welcome-text-for-registration'),
                'href' => route('user.lecturer.my_courses.edit.welcomeTextForRegistration.index', ['id' => @$item->id]),
            ],
           /* [
                'title' => __('price'),
                'icon' => 'fas fa-tag',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'price-details'),
                'href' => route('user.lecturer.my_courses.edit.priceDetails.index', ['id' => @$item->id]),
            ],*/
            // [
            //     'title' => __('suggested_dates'),
            //     'icon' => 'fa fa-calendar me-3 me-3',
            //     'is_show' => $item->type == 'recorded' ? false : true,
            //     'is_active' => str_contains(url()->current(), 'suggested-dates'),
            //     'href' => route('user.lecturer.my_courses.edit.suggestedDates.index', ['id' => @$item->id]),
            // ],
            // [
            //     'title' => __('content'),
            //     'icon' => 'fas fa-info-circle me-3 me-3',
            //     'is_show' => $item->type == 'recorded' ? false : true,
            //     'is_active' => str_contains(url()->current(), 'content-details'),
            //     'href' => route('user.lecturer.my_courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'content']),
            // ],
            [
                'title' => __('for_whom_this_course'),
                'icon' => 'fas fa-info-circle me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'for_whom_this_course'),
                'href' => route('user.lecturer.my_courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'for_whom_this_course']),
            ],
            [
                'title' => __('what_will_you_learn'),
                'icon' => 'fas fa-info-circle me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'what_will_you_learn'),
                'href' => route('user.lecturer.my_courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'what_will_you_learn']),
            ],
            [
                'title' => __('faqs'),
                'icon' => 'fas fa-question me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'course-faqs'),
                'href' => route('user.lecturer.my_courses.edit.courseFaqs.index', ['id' => @$item->id]),
            ],
            // [
            //     'title' => __('course_request'),
            //     'icon' => 'fas fa-info-circle me-3 me-3',
            //     'is_show' => true,
            //     'is_active' => str_contains(url()->current(), 'requirements'),
            //     'href' => route('user.lecturer.my_courses.edit.requirements.index', ['id' => @$item->id]),
            // ],

        ];

               if ($item->type == 'live'){
                 $toolbar[]=     [
                       'title' => __('pick a date'),
                       'icon' => 'fas fa-calendar me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'course_schedule'),
                       'href' => route('user.lecturer.my_courses.edit.courseSchedule.index', ['id' => @$item->id]),
                   ];

               }

                     $toolbar[]=     [
                       'title' => __('educational_content'),
                         'icon' => 'fas fa-info-circle me-3 me-3',
                          'is_show' => true,
                'is_active' => str_contains(url()->current(), 'curriculum'),
                'href' => route('user.lecturer.my_courses.create_curriculum' , @$item->id),
                   ];

    @endphp

    <div class="mb-5">
        <div class="col-12">
            <ul class=" nav nav-pills mb-3 nav-pills-circulum">
                @foreach ($toolbar as $toolbar_course)
                    @if ($toolbar_course['is_show'])
                        <li class="nav-item">
                            <a href="{{ @$toolbar_course['href'] }}"
                               class="nav-link {{ $toolbar_course['is_active'] ? 'active' : '' }} ">
								<span class="nav-text">
									{{ $toolbar_course['title'] }}
								</span>
                            </a>
                        </li>
                    @endif
                @endforeach

            </ul>
        </div>
    </div>
@endif
