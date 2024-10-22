<div class="row">
    <div class="col-12">
        <div class="card-course">
            <div class="card-header">
                <h3 class="font-medium text-center">المواعيد المتاحة</h3>
            </div>
            <div class="card-body p-md-4 p-lg-12">
                <div class="message-body">
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <hr id="book_form-hr">
                <div id="calendar" style="padding: 1rem;"></div>
                <div id="book_form" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>

@push('front_css')
<style>
    .gc-calendar .gc-event{
        padding: 6px;
        margin-right: 10px;
    }
    .gc-calendar .gc-event.selected{
        background-color: #37b284 !important;
    }
    .bg-primary{
        background-color: #3882a6 !important
    }
    .disabledappoinments{
        background-color: #9dafb8 !important;
    }
</style>
@endpush
@push('front_js')
    <script src="https://cdn.jsdelivr.net/npm/arrobefr-jquery-calendar@1.0.11/dist/js/jquery-calendar.min.js"></script>
    <script>
        let times        =  @json($lecturer->timeTable);
        let single_times =  @json($single_times);

        function check_reserved2(newDate , start)
        {
            start = setTimeHString(start);
            var response = false;
            single_times.forEach(function(item){
                if(item.meeting_date == getDateString(newDate) && start == item.time_form){
                    response = true;
                }
            });
            return response;
        }

        $(function (e) {
            var calendar = $("#calendar").calendarGC({
                dayBegin: 0,
                prevIcon: '&#x3c;',
                nextIcon: '&#x3e;',
                events: setAvailableTimes(),
            });
        });


        function setAvailableTimes() {
            var d = new Date();
            var totalDay = new Date(d.getFullYear(), d.getMonth(), 0).getDate();
            var events = [];

            var today = new Date("{{ date('Y-m-d H:i:s') }}");

            for(var j = 0; j < times.length; j++) {
                var timeStart = new Date("01/01/2007 " + times[j].from).getHours();
                var timeEnd = new Date("01/01/2007 " + times[j].to).getHours();
                var hourDiff = timeEnd - timeStart;
                for (var i = 0; i < 365; i++) { // loop days
                    var newDate = new Date(d.getFullYear(), d.getMonth(), i);

                    if (newDate.getDay() == times[j].day_no) {
                        for(var k = 0; k < hourDiff; k++)
                        {
                            var start = timeStart+k;
                            var end = start+1;

                            var day_hour = new Date(d.getFullYear(), d.getMonth(), i , start);
                            var disabled = ' ';

                            var check_reserved = check_reserved2( day_hour , start);
                            if(day_hour < today || check_reserved == true){
                                disabled = 'disabled';
                            }
                            events.push({
                                date: newDate,
                                eventName: "From: " + start +" - To: "+end,
                                className: "badge bg-primary " + disabled + "appoinments",
                                dateColor: "green",
                                dayNumber: times[j].day_no,
                                from: start,
                                to: end,
                                disabled: disabled,
                                onclick(e, data) {
                                    if(data.disabled == ' '){
                                        // console.log('disabled : ' + disabled);
                                        // var meetingDate = new Date(data.date).toISOString();
                                        var meetingDate = getDateString(data.date);
                                        var from = data.from+":00";
                                        var to = data.to+":00";

                                        setSelectedDayInfo(data.dayNumber, from, to, meetingDate);
                                    }
                                },
                            });
                        }
                    }
                }
            }

            return events;
        }

        setAvailableTimes();

        setTimeout(() => {
            appoinments_click_action();
        }, 2000);

        function appoinments_click_action(){
            $(".appoinments").on('click' , function(){
                $('.appoinments.selected').removeClass('selected');
                $(this).addClass('selected');
            });
        }

        //let lessons = {!!$single_times->values()->toJson()!!};
        let lecturer = {!!$lecturer!!};
        let user_remain_hours = {!! $user_remain_hours ?? 0 !!};
        var selected_items = [];
        function setSelectedDayInfo(key, from, to, date)
        {
            var exists_before = false;
            var current_item = {
                "key" : key,
                "from": from,
                "to"  : to,
                "date": date,
            };
            // check if exists
            selected_items.forEach(function(item , i){
                if( JSON.stringify(item) == JSON.stringify(current_item) ){
                    exists_before = true;
                    selected_items.splice(i,1);
                }
            });
            if(!exists_before){
                selected_items.push(current_item);
            }
            console.log('selected_items : ' , selected_items);
            // let newDate = getDateString(fullDate);
            let newDate = date;

            if(selected_items.length){
                $('#book_form').css('display', 'block');
            }else{
                $('#book_form').css('display', 'none');
            }

            let html = `<div class="tab-content" id="pills-tabContent">`;
            let checkIfAcceptGroupHtml = `
                <div class="checkIfAcceptGroup">
                    <ul class="nav nav-pills mb-3 nav-pills-login" id="pills-tab">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-single" type="button" role="tab">{{ __('single') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-group" type="button" role="tab">{{ __('group') }}</button>
                        </li>
                    </ul>
                </div>
            `;
            let tabContainerStart = `
                <div class="tab-content" id="pills-tabContent">
            `;

            let onlineOrOfflineSelect = `
                <div class="row">
                    <div class="form-group col-12">
                        <div class="d-lg-flex align-items-center justify-content-start">
                            <div class="d-flex align-items-center col-9">
                                <label class="m-radio m-radio-2 mb-0 ms-2 me-2">
                                    <input type="radio" name="meeting_type" id="online" value="online" checked>
                                    <span class="checkmark"></span>
                                </label>
                                <p class="me-3">{{ __('online') }}</p>

                                <label class="m-radio m-radio-2 mb-0 me-2">
                                    <input type="radio" name="meeting_type" id="offline" value="offline">
                                    <span class="checkmark"></span>
                                </label>
                                {{--<p class="me-3">{{ __('offline') }}</p>--}}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            let singleOnlinePricing = `
                <br>
                <p>{{ __('type') }}:  <strong>{{ __('online') }}</strong> </p>
                <p>{{ __('price') }} : ${lecturer.hour_price} <span>tr</span></p>
            `;
            // <p>{{ __('online_discount_amount') }} : ${lessons[key].online_discount} </p>

            {{--let singleOfflinePricing = `--}}
            {{--    <br>--}}
            {{--    <p>{{ __('type') }}:  <strong>{{ __('offline') }}</strong> </p>--}}
            {{--    <p>{{ __('price') }} : ${lessons[key].offline_price} <span>${lessons[key].currency}</span></p>--}}
            {{--`;--}}
            {{--// <p>{{ __('offline_discount_amo                                                                        unt') }} : ${lessons[key].offline_discount} </p>--}}

            let singleCaseHtml = `
                <div class="tab-pane fade show active" id="tab-single">
                    <div class="row">
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">
                                    {{--<h5>{{ __('category') }}:  ${lessons[key].category_name} </i></h5>--}}
                                    <p>{{ __('Lesson_Time') }} :  <span dir='ltr'>${newDate} ( ${from} - ${to} )</span></p>
                                    <p>{{ __('Lesson price') }}: ${lecturer.hour_price} {{ __('tr') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 position-relative">
                            <div class="line-vertical"></div>
                        </div>
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">
                                    <form action="/user/private-lessons/book" to="/user/private-lessons" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="single">
                                        <input type="hidden" name="meeting_type" value="online">
                                        <input type="hidden" name="date" value="${date}">
                                        <input type="hidden" name="from" value="${from}">
                                        <input type="hidden" name="to" value="${to}">
                                        <input type="hidden" name="teacher_id" value="${lecturer.id}">
                                        `;
                                        if(user_remain_hours){
                                            singleCaseHtml += `
                                                <div class="form-group col-12">
                                                    <h4>عدد الساعات</h4>
                                                    <select name="time_type" class="form-control">
                                                        <option value="hour" selected>1 Hour</option>
                                                        @if($lecturer->can_add_half_hour)
                                                        <option value="half_hour">Half Hour</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <p>عدد الساعات المتاحة بالباقة :
                                                        <b class="text-bold">
                                                            ${user_remain_hours} hrs.
                                                        </b>
                                                    </p>
                                                </div>

                                                <div class="form-group col-12">
                                                    <p><label for="singel_use_old_hrs"> إستخدام الساعات</label>:
                                                        <input type="checkbox" class="checkbox mx-3" name="use_old_hours" value="1" id="singel_use_old_hrs" />
                                                    </p>
                                                </div>
                                            `;
                                        }

                                        singleCaseHtml += `
                                        <button type="button" class="submitForm btn btn-primary w-100 rounded-pill">حجز</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            let groupOnlinePricing = `
                <br>
                <p>{{ __('type') }}:  <strong>{{ __('online') }}</strong> </p>
                <p>{{ __('price') }} :  ${lecturer.hour_price} <span>{{ __("tr") }}</span></p>
                <p>{{ __('minimum_students_count') }} :  ${lecturer.min_student_no} </p>
                <p>{{ __('maximum_students_count') }} :  ${lecturer.max_student_no} </p>
            `;


            let groupCaseHtml = `
                <div class="tab-pane fade" id="tab-group">
                    <div class="row">
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">
                                    <p>{{ __('Lesson_Time') }} : <span dir='ltr'>${newDate} ( ${from} - ${to} )</span></p>

                                    <p>{{ __('Lesson price') }} ${lecturer.hour_price} {{ __('tr') }}</p>

                                    <p>{{ __('minimum_students_count') }} :  ${lecturer.min_student_no} </p>
                                    <p>{{ __('maximum_students_count') }} :  ${lecturer.max_student_no} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1 position-relative">
                            <div class="line-vertical"></div>
                        </div>
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">
                                    <form action="/user/private-lessons/book" to="/user/private-lessons" method="POST" data-parsley-validate>
                                        @csrf
                                        <input type="hidden" name="type" value="group">
                                        <input type="hidden" name="meeting_type" value="online">
                                        <input type="hidden" name="teacher_id" value="${lecturer.id}">
                                        <input type="hidden" name="date" value="${date}">
                                        <input type="hidden" name="from" value="${from}">
                                        <input type="hidden" name="to" value="${to}">
                                        `;
                                        if(user_remain_hours){
                                            groupCaseHtml += `
                                                <div class="form-group col-12">
                                                    <h4>عدد الساعات</h4>
                                                    <select name="time_type" class="form-control">
                                                        <option value="hour" selected>1 Hour</option>
                                                        @if($lecturer->can_add_half_hour)
                                                            <option value="half_hour">Half Hour</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="form-group col-12">
                                                    <p>عدد الساعات المتاحة بالباقة :
                                                        <b class="text-bold">
                                                            ${user_remain_hours} hrs.
                                                        </b>
                                                    </p>
                                                </div>
                                                <div class="form-group col-12">
                                                    <p><label for="group_use_old_hrs"> إستخدام الساعات</label>:
                                                        <input type="checkbox" class="checkbox mx-3" name="use_old_hours" value="1" id="group_use_old_hrs" />
                                                    </p>
                                                </div>
                                            `;
                                        }

                                        groupCaseHtml += `<div class="form-group col-12">
                                            <h4>عدد الطلاب</h4>
                                            <input name="student_no" required class="form-control studentNoInput" max="{{ $lecturer->max_student_no }}" min="{{ $lecturer->min_student_no }}" type="number" placeholder="">
                                                                        </div>
                                        <div class="form-group col-12 text-muted">
                                            <h4>السعر الكلي: <span class="totalPrice">0</span> <span class="currency"></span></h4>
                                        </div>
                                        <button type="button" class="submitForm btn btn-primary w-100 rounded-pill">حجز</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            let tabContainerEnd = `
                </div>
            `;
            let lastHtml = `
                </div>
            `;

            BookFormHtml = html + tabContainerStart + checkIfAcceptGroupHtml + singleCaseHtml +
                groupCaseHtml + tabContainerEnd + lastHtml;

            $('#book_form').html(BookFormHtml);
            $('html, body').animate({
                scrollTop: $('#book_form').offset().top-150
            }, 500);

        }


        function getDateString(fullDate){
            let month = fullDate.getMonth() + 1;
            if (month.toString().length == 1) {
                month = "0" + month;
            }
            let day = fullDate.getDate();
            if (day.toString().length == 1) {
                day = "0" + day;
            }
            return fullDate.getFullYear() + "-" + month + "-" + day;
        }

        function setTimeHString(time){
            if (time.toString().length == 1) {
                time = "0" + time;
            }
            return time + ":00:00";
        }
    </script>

    <script>
        // Attach an event listener to the document using a class selector
        document.addEventListener('input', function(event) {
            // Check if the target element has the 'studentNoInput' class
            if (event.target.classList.contains('studentNoInput')) {
                // Call the updateTotalPrice function
                updateTotalPrice();
            }
        });

        // Function to update the total price based on the input value
        function updateTotalPrice() {
            // Get the online group price and student number
            let lecturer =  @json($lecturer);
            let onlineGroupPrice = lecturer.hour_price;

            // Get the value of the 'studentNoInput' class, or use a default value of 0
            let studentNumber = parseInt(document.querySelector('.studentNoInput').value) || 0;

            // Calculate the total price
            let totalPrice = onlineGroupPrice * studentNumber;

            // Update the total price in the span element
            document.querySelector('.totalPrice').textContent = totalPrice;
            document.querySelector('.currency').textContent = '{{ __("tr") }}';
        }
    </script>



    <script>
        $(document).on('click', '.submitForm', function(e) {
            e.preventDefault();

            var save_btn = $(this).closest('.submitForm');
            var form = $(this).closest('form')[0];
            var formData = new FormData(form);
            var url = $(form).attr('action');
            var redirectUrl = $(form).attr('to');
            var _method = $(form).attr('method');
            $(save_btn).attr("disabled", true);
            // $('#load').show();
            $.ajax({
                url: url,
                method: _method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // $('#load').hide();
                    $(save_btn).attr("disabled", false);
                    if (response.status) {
                        // form.reset();

                        toastr.success(response.message);

                        if (response.redirect_url) {
                            $('#load').show();
                            window.location = response.redirect_url;
                        }
                        else if (redirectUrl != '#') {
                            $('#load').show();
                            window.location = redirectUrl;
                        }
                        if(false){
                            customSweetAlert(
                                'success',
                                response.message,
                                response.item,
                                function(event) {
                                    if (redirectUrl != '#') {
                                        $('#load').show();
                                        window.location = redirectUrl;
                                    }
                                    else if (redirectUrl != '#') {
                                        $('#load').show();
                                        window.location = redirectUrl;
                                    }
                                }
                            );
                        }
                    } else {
                        customSweetAlert(
                            'error',
                            response.message,
                            response.errors_object
                        );
                    }
                },
                error: function(jqXhr) {
                    $(save_btn).attr("disabled", false);
                    getErrors(jqXhr, '/login');
                }
            });
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                // Check if the event target is within a form
                const isWithinForm = event.target.closest('form');

                // Prevent form submission if the "Enter" key is pressed within a form
                if (isWithinForm) {
                    event.preventDefault();
                }
            }
        });
    </script>

@endpush
