<!--begin::Notifications-->
<div class="dropdown">
    <!--begin::Toggle-->
    <input type="hidden" id="count_new_notifications" value="{{getCountNotificationsNotShow('admin')}}">
    <div class="topbar-item show_notifications" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1 pulse pulse-white show_notifications">
            <span class="svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                <span class="svg-icon  svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo7\dist/../src/media/svg/icons\General\Notifications1.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="#fff">
                            <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#fff"></path>
                            <rect fill="#fff" opacity="1" x="10" y="16" width="4" height="4" rx="2"></rect>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <!--end::Svg Icon-->
            </span>
            <span class="pulse-ring new-notification" style="display:{{getCountNotificationsNotShow('admin')==0?'none':'block'}}"></span>
        </div>
    </div>
    <!--end::Toggle-->
    <!--begin::Dropdown-->
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <form>
            <!--begin::Header-->
            <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(/assets/panel/media/misc/bg-1.jpg)">
                <!--begin::Title-->
                <h4 class="d-flex flex-center rounded-top">
                    <span class="text-white">الاشعارات</span>
                </h4>
                <!--end::Title-->
                <!--begin::Tabs-->
                <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true">الإشعارات</a>
                    </li>
                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="tab-content">
                <div class="tab-pane active show" id="topbar_notifications_notifications" role="tabpanel">
                    <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
                        <div class="all_notifications">
                            {!!getLastNotifications('admin')!!}
                        </div>

                    </div>
                </div>


            </div>

            <!--end::Content-->
        </form>
    </div>
    <!--end::Dropdown-->
</div>
<!--end::Notifications-->