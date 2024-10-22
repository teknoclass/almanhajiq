@if (isset($item))
	@php

               $toolbar = [
                   [
                       'title' => __('course_information'),
                       'icon' => 'fas fa-cog me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'base-information'),
                       'href' => route('panel.courses.edit.baseInformation.index', ['id' => @$item->id]),
                   ],
                   [
                       'title' => __('course_details'),
                       'icon' => 'fas fa-cog me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'welcome-text-for-registration'),
                       'href' => route('panel.courses.edit.welcomeTextForRegistration.index', ['id' => @$item->id]),
                   ],
                   [
                       'title' => __('price'),
                       'icon' => 'fas fa-tag',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'price-details'),
                       'href' => route('panel.courses.edit.priceDetails.index', ['id' => @$item->id]),
                   ],
                   // [
                   //     'title' => __('suggested_dates'),
                   //     'icon' => 'fa fa-calendar me-3 me-3',
                   //     'is_show' => $item->type == 'recorded' ? false : true,
                   //     'is_active' => str_contains(url()->current(), 'suggested-dates'),
                   //     'href' => route('panel.courses.edit.suggestedDates.index', ['id' => @$item->id]),
                   // ],
                   // [
                   //     'title' => __('content'),
                   //     'icon' => 'fas fa-info-circle me-3 me-3',
                   //     'is_show' => true,
                   //     'is_active' => str_contains(url()->current(), 'content-details'),
                   //     'href' => route('panel.courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'content']),
                   // ],
                   [
                       'title' => __('for_whom_this_course'),
                       'icon' => 'fas fa-info-circle me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'for_whom_this_course'),
                       'href' => route('panel.courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'for_whom_this_course']),
                   ],
                   [
                       'title' => __('what_will_you_learn'),
                       'icon' => 'fas fa-info-circle me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'what_will_you_learn'),
                       'href' => route('panel.courses.edit.contentDetails.index', ['id' => @$item->id, 'type' => 'what_will_you_learn']),
                   ],
                   [
                       'title' => __('faqs'),
                       'icon' => 'fas fa-question me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'course-faqs'),
                       'href' => route('panel.courses.edit.courseFaqs.index', ['id' => @$item->id]),
                   ],
                   // [
                   //     'title' => __('course_request'),
                   //     'icon' => 'fas fa-info-circle me-3 me-3',
                   //     'is_show' => true,
                   //     'is_active' => str_contains(url()->current(), 'requirements'),
                   //     'href' => route('panel.courses.edit.requirements.index', ['id' => @$item->id]),
                   // ],

                   // [
                   //     'title' => __('course_sections'),
                   //     'icon' => 'fas fa-info-circle me-3 me-3',
                   //     'is_show' => $item->type == 'recorded' ? true : false,
                   //     'is_active' => str_contains(url()->current(), 'sections'),
                   //     'href' => route('panel.courses.edit.sections.index', ['id' => @$item->id]),
                   // ],
               ];

               if ($item->type == 'live'){
                 $toolbar[]=     [
                       'title' => __('pick a date'),
                       'icon' => 'fas fa-calendar me-3 me-3',
                       'is_show' => true,
                       'is_active' => str_contains(url()->current(), 'course_schedule'),
                       'href' => route('panel.courses.edit.courseSchedule.index', ['id' => @$item->id]),
                   ];

               }

                $toolbar[]=     [
                'title' => __('educational_content'),
                'icon' => 'fas fa-book-open me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'curriculum'),
                'href' => route('panel.courses.edit.curriculum.index', ['id' => @$item->id]),
                ];

            if ($item->type == 'live' && $item->open_installments == 1){
            $toolbar[]=     [
                'title' => __('installments_settings'),
                'icon' => 'fas fa-book-open me-3 me-3',
                'is_show' => true,
                'is_active' => str_contains(url()->current(), 'installments-settings'),
                'href' => route('panel.courses.edit.installments-settings.index', ['course_id' => @$item->id]),
                ];
             }
	@endphp

	<div class="col-md-12">

		<div class="card card-custom gutter-b example example-compact">
			<div class="card-body">
				<ul class="nav nav-tabs nav-line-tabs tabs-courses">
					@foreach ($toolbar as $toolbar_course)
						@if ($toolbar_course['is_show'])
							<li class="nav-item">
								<a href="{{ @$toolbar_course['href'] }}" class="nav-link {{ $toolbar_course['is_active'] ? 'active' : '' }} ">
									<span class="nav-icon">
										<i class=" {{ $toolbar_course['icon'] }}"></i>
                                    </span>
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
	</div>

@endif
