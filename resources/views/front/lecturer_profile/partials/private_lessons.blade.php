<div class="row mb-3" id="show_appoinments_btn-div">
    <div class="col-12 text-center">
        <button class="btn btn-primary" id="appointments-btn" data-from-text="{{ __('From') }}" data-to-text="{{ __('To') }}" onclick="show_appoinments();">{{ __('Show_appointments') }}</button>
    </div>
</div>
<div class="row" id="appoinments-div" style="display:none">
    <div class="col-12">
        <div class="card-course">
            <div class="card-header">
                <h3 class="font-medium text-center">{{ __('appointments_available') }}</h3>
            </div>
            <div class="card-body p-md-4 p-lg-12">
                <div class="message-body">
                    <div class="col-12 mb-4">
                        @if($lecturer->can_add_half_hour)
                            <div class="row text-center w-100">
                                <button class="col-md-6 btn mins_btn Mins_60 active " data-mins="60">{{ __('60 Mins') }}</button>
                                <button class="col-md-6 btn mins_btn Mins_30" data-mins="30">{{ __('30 Mins') }}</button>
                            </div>
                        @endif
                        <div class="row">
                            <div id="calendar">

                            </div>
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
    input.checkbox {
        width: 20px;
        height: 20px;
        position: absolute;
    }
    .mins_btn{
        background-color: #ffffffed;
        margin-bottom: 10px;
        border: 1px solid #c0c0c096;
    }
    .mins_btn.active , .mins_btn:hover{
        background: #d0ebf2;
        font-weight: bold;
    }
    .message-body{
        max-height: 500px;
        overflow: hidden;
        overflow-y: auto;
    }
</style>
@endpush
@push('front_js')
    <script>
        function show_appoinments(){

            $("#appoinments-div").show('slow');
            $("#show_appoinments_btn-div").hide('slow');
        }
        function show_appoinments_tab(){
            show_appoinments();
            $('html, body').animate({
                scrollTop: $('#appoinments-div').offset().top-300
            }, 500);
        }
        @if(request()->tab == 'reserve')
            show_appoinments_tab();
        @endif
    </script>
    <script src="https://cdn.jsdelivr.net/npm/arrobefr-jquery-calendar@1.0.11/dist/js/jquery-calendar.min.js"></script>
    <script>
        let times        =  @json($lecturer->timeTable);
        let single_times =  @json($single_times);

        // console.log('single_times : ' , single_times);
        function check_reserved2(newDate , start)
        {
            // console.log('newDate : ' + newDate);
            // console.log('getDateString(newDate) : ' + getDateString(newDate));
            // start = setTimeHString(start);
            var response = false;
            single_times.forEach(function(item){
                // if(getDateString(newDate) == '2024-08-18'){
                //     //console.log(item.meeting_date , getDateString(newDate), 'strt-'+start , item.time_form , item.meeting_date == getDateString(newDate) && (start == item.time_form || start + ':00' == item.time_form || start.replace(':00' , ':30') == item.time_form) , start.replace(':00' , ':30:00') , item.time_form);
                // }
                if(item.meeting_date == getDateString(newDate) && (start == item.time_form || start + ':00' == item.time_form || (!is_half && start.replace(':00' , ':30:00') == item.time_form))){
                    response = true;
                }
            });
            return response;
        }

        var calendar;
        $(function (e) {
            calendar = $("#calendar").calendarGC({
                dayBegin: 0,
                prevIcon: '&#x3c;',
                nextIcon: '&#x3e;',
                events: setAvailableTimes(),
            });
        });

        var is_half = false;
        function setAvailableTimes() {
            var d = new Date();
            var totalDay = new Date(d.getFullYear(), d.getMonth(), 0).getDate();
            var events = [];

            var today = new Date("{{ date('Y-m-d H:i:s') }}");

            for(var j = 0; j < times.length; j++) {
                var timeStart = new Date("01/01/2007 " + times[j].from).getHours();
                var timeEnd = new Date("01/01/2007 " + times[j].to).getHours();

                // console.log(times[j].from , timeStart);
                // console.log(times[j].to , timeEnd);
                // console.log('---------');
                var hourDiff = timeEnd - timeStart;
                for (var i = 0; i < 365; i++) { // loop days
                    var newDate = new Date(d.getFullYear(), d.getMonth(), i);

                    if (newDate.getDay() == times[j].day_no) {
                        for(var k = 0; k < hourDiff; k++) // draw hours in day
                        {
                            var start_origin = timeStart+k;
                            var end          = start_origin+1;

                            start = handle_time(start_origin , false);
                            end   = handle_time(end , false );

                            var strt_30 = false;
                            var half_end = end;
                            // check half
                            if(is_half){
                                if(!k && times[j].from > start){
                                    start = handle_time(times[j].from , false);
                                    strt_30 = true;
                                }
                                if(!strt_30){
                                    half_end = start.replace(':00' , ':30');
                                }
                            }

                            var starts = [start];
                            var ends   = [half_end];

                            if(is_half && !strt_30){
                                starts.push(start.replace(':00' , ':30'));
                                ends.push(end);

                                if(k == hourDiff -1 && times[j].to > end){
                                    starts.push(end);
                                    ends.push(times[j].to);
                                }
                            }

                            // console.log(starts , ends);
                            // console.log('---------');

                            for (let indx = 0; indx < starts.length; indx++)
                            {
                                var day_hour = new Date(d.getFullYear(), d.getMonth(), i , start_origin);
                                var disabled = ' ';

                                var check_reserved = check_reserved2( day_hour , starts[indx]);
                                if(day_hour < today || check_reserved == true){
                                    disabled = 'disabled';
                                }
                                $appointmentsBtn = $('#appointments-btn');
                                events.push({
                                    date: newDate,
                                    eventName: $appointmentsBtn.data('from-text')+ ": " + starts[indx] +" - "+$appointmentsBtn.data('to-text')+": " + ends[indx],
                                    className: "badge bg-primary " + disabled + "appoinments day_" + handle_time(starts[indx]) + "_"+getDateString(newDate),
                                    dateColor: "green",
                                    dayNumber: times[j].day_no,
                                    from: starts[indx],
                                    to: ends[indx],
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
            }

            return events;
        }

        // setAvailableTimes();

        setTimeout(() => {
            appoinments_click_action();
        }, 2000);

        function appoinments_click_action(){
            $(".appoinments").on('click' , function(element){
                if($(this).hasClass('selected')){
                    $(this).removeClass('selected');
                }else{
                    $(this).addClass('selected');
                }
            });
        }


        $(document).on("click",".gc-calendar-header>button.prev , .gc-calendar-header>button.next",function() {
            appoinments_click_action();
            selected_items.forEach(function(item , i){
                $(".day_" + handle_time(item.from) + "_" + item.date).addClass('selected');
            });
        });

        //let lessons = {!!$single_times->values()->toJson()!!};
        let lecturer = {!!$lecturer!!};
        let user_remain_hours = {!! $user_remain_hours ?? 0 !!};
        var selected_before = false;
        var selected_items = [];

        $(document).on("click",".mins_btn",function() {
            $(".mins_btn").removeClass('active');
            $(this).addClass('active');
            if($(this).data('mins') == 30){
                is_half = true;
                $('.hour_price').html((lecturer.hour_price / 2) +  " {{ __('tr') }}");
                $('#time_type' ).val('half_hour');
                $('#time_type2').val('half_hour');
            }else{
                is_half = false;
                $('.hour_price').html(lecturer.hour_price +  " {{ __('tr') }}");
                $('#time_type' ).val('hour');
                $('#time_type2').val('hour');
            }
            selected_items = [];
            calendar = $("#calendar").calendarGC({
                dayBegin: 0,
                prevIcon: '&#x3c;',
                nextIcon: '&#x3e;',
                events: setAvailableTimes(),
            });
            fill_form();
            appoinments_click_action();
            $('#book_form').css('display', 'none');
            $('.gc-calendar-header>button.prev').click();
        });


        function setSelectedDayInfo(key, from, to , date)
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
            // console.log('selected_items : ' , selected_items);
            // let newDate = getDateString(fullDate);
            let newDate = date;

            if(selected_items.length){
                $('#book_form').css('display', 'block');
                fill_form();
                if(!selected_before){
                    $('html, body').animate({
                        scrollTop: $('#book_form').offset().top-150
                    }, 500);
                }
            }else{
                $('#book_form').css('display', 'none');
            }
            selected_before = true;

        }

        function handle_time(timme , replc = true ){
            timme = timme + "" ;
            if (timme.length == 1) {
                timme = "0" + timme;
            }
            if(timme.length <= 2){
                timme = timme + ':00';
            }
            if(timme.length == 4){
                timme = "0" + timme;
            }
            if(replc){
                timme = timme.replace(':', '_').replace('-', '_');
            }
            return timme;
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
            return time + ":00";
        }
        function formatTime(dateString) {
            const [hours, minutes, seconds] = dateString.split(':').map(Number);

            // Format the hours, minutes, and seconds
            const formattedHours = hours > 0 ? hours : null; // Omit hours if zero
            const formattedMinutes = minutes > 0 ? minutes : '00'; // Always show minutes
            const formattedSeconds = seconds > 0 ? seconds : null; // Omit seconds if zero

            // Build the formatted time string
            const formattedTime = [
                formattedHours,
                formattedMinutes,
                formattedSeconds
            ].filter(part => part !== null).join(':');

            return formattedTime || '00'; // Return '00' if all parts are zero
        }

        draw_form();
        function draw_form(date = '' , newDate = '' , from = '' , to = '' )
        {


            // $('#book_form').css('display', 'block');

            let html = `<div class="tab-content" id="pills-tabContent">`;
            let checkIfAcceptGroupHtml = `
                <div class="checkIfAcceptGroup">
                    <ul class="nav nav-pills mb-3 nav-pills-login" id="pills-tab">
                        <li class="nav-item">
                            <button class="nav-link group-single active" data-bs-toggle="pill" data-bs-target="#tab-single" type="button" role="tab">{{ __('single') }}</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link group-single" data-bs-toggle="pill" data-bs-target="#tab-group" type="button" role="tab">{{ __('group') }}</button>
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

            let singleCaseHtml = `
                <div class="tab-pane fade show active" id="tab-single">
                    <div class="row">
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">
                                    <table>
                                        <tr>
                                            <td class='w-25'>{{ __('Lesson_Time') }}</td>
                                            <td class='px-2'> : </td>
                                            <td id="date_spans_single">
                                                <span dir="ltr" class="d-inline-block" >${newDate} ( ${from} - ${to} )</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='w-25'>{{ __('Lesson_price') }}</td>
                                            <td class='px-2'> : </td>
                                            <td><span dir='ltr' class='hour_price' > ${lecturer.hour_price} {{ __('tr') }}</td>
                                        </tr>
                                    </table>
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
                                        <div id="hidden_inputs_single">
                                            <div id="single_row_0">
                                                <input type="hidden" name="lessons[0][date]" value="${date}">
                                                <input type="hidden" name="lessons[0][from]" value="${from}">
                                                <input type="hidden" name="lessons[0][to]" value="${to}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="teacher_id" value="${lecturer.id}">
                                        <input type="hidden" name="time_type" id='time_type' value="hour" />
                                        `;
                                        if(user_remain_hours){
                                            singleCaseHtml += `
                                                <div class="form-group col-12">
                                                    <p>{{__('number_of_available_hours')}} :
                                                        <b class="text-bold">
                                                            ${user_remain_hours} hrs.
                                                        </b>
                                                    </p>
                                                </div>

                                                <div class="form-group col-12">
                                                    <p><label for="singel_use_old_hrs"> {{ __('Use_Package') }}</label>:
                                                        <input type="checkbox" class="checkbox mx-3" name="use_old_hours" value="1" checked id="singel_use_old_hrs" />
                                                    </p>
                                                </div>
                                            `;
                                        }

                                        singleCaseHtml += `
                                        <div class="form-group col-12 text-muted">
                                            <h4>{{ __('to_price') }} <span class="totalPrice">0</span> <span class="currency"></span></h4>
                                        </div>
                                        <button type="button" class="submitForm2 btn btn-primary w-100 rounded-pill">{{ __('reserve') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            let groupOnlinePricing = `
                <br>
                <table>
                    <tr>
                        <td>{{ __('type') }}</td>
                        <td> : </td>
                        <td><strong>{{ __('online') }}</strong></td>
                    </tr>
                    <tr>
                        <td>{{ __('price') }}</td>
                        <td> : </td>
                        <td>${lecturer.hour_price} <span>{{ __("tr") }}</span></td>
                    </tr>
                    <tr>
                        <td>{{ __('minimum_students_count') }}</td>
                        <td> : </td>
                        <td>${lecturer.min_student_no}</td>
                    </tr>
                    <tr>
                        <td>{{ __('maximum_students_count') }}</td>
                        <td> : </td>
                        <td>${lecturer.max_student_no}</td>
                    </tr>
                </table>
            `;


            let groupCaseHtml = `
                <div class="tab-pane fade" id="tab-group">
                    <div class="row">
                        <div class="col-lg">
                            <div class="bg-white rounded-3 p-4 mb-4">
                                <div class="bg-light-green rounded-3 mb-4 p-3">

                                    <table>
                                        <tr>
                                            <td class='w-25'>{{ __('Lesson_Time') }}</td>
                                            <td class='px-2'> : </td>
                                            <td id="date_spans_group">
                                                <span dir="ltr" class="d-inline-block" >${newDate} ( ${from} - ${to} )</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class='w-25'>{{ __('Lesson_price') }}</td>
                                            <td class='px-2'> : </td>
                                            <td class='hour_price'>${lecturer.hour_price} {{ __('tr') }}</td>
                                        </tr>
                                        <tr>
                                            <td class='w-25'>{{ __('minimum_students_count') }}</td>
                                            <td class='px-2'> : </td>
                                            <td>${lecturer.min_student_no}</td>
                                        </tr>
                                        <tr>
                                            <td class='w-25'>{{ __('maximum_students_count') }}</td>
                                            <td class='px-2'> : </td>
                                            <td>${lecturer.max_student_no}</td>
                                        </tr>
                                    </table>
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
                                        <div id="hidden_inputs_group">
                                            <div id="group_row_0">
                                                <input type="hidden" name="lessons[0][date]" value="${date}">
                                                <input type="hidden" name="lessons[0][from]" value="${from}">
                                                <input type="hidden" name="lessons[0][to]" value="${to}">
                                                <input type="hidden" name="time_type" id='time_type2' value="hour" />
                                            </div>
                                        </div>
                                        `;
                                        if(user_remain_hours){
                                            groupCaseHtml += `
                                                <div class="form-group col-12">
                                                    <p>عدد الساعات المتاحة بالباقة :
                                                        <b class="text-bold">
                                                            ${user_remain_hours} hrs.
                                                        </b>
                                                    </p>
                                                </div>
                                                <div class="form-group col-12">
                                                    <p><label for="group_use_old_hrs"> {{ __('Use_Package') }}</label>:
                                                        <input type="checkbox" class="checkbox mx-3" name="use_old_hours" value="1" checked id="group_use_old_hrs" />
                                                    </p>
                                                </div>
                                            `;
                                        }

                                        groupCaseHtml += `<div class="form-group col-12">
                                            <h4>عدد الطلاب</h4>
                                            <input name="student_no" required class="form-control studentNoInput" max="{{ $lecturer->max_student_no }}" min="{{ $lecturer->min_student_no }}" value="{{ $lecturer->min_student_no ?? 1 }}" type="number" placeholder="">
                                                                        </div>
                                        <div class="form-group col-12 text-muted">
                                            <h4>السعر الكلي: <span class="totalPrice2">0</span> <span class="currency2"></span></h4>
                                        </div>
                                        <button type="button" class="submitForm2 btn btn-primary w-100 rounded-pill">حجز</button>
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
        }

        function fill_form()
        {
            // <span dir="ltr" class="d-inline-block" >${newDate} ( ${from} - ${to} )</span>
            // date_spans_group
            var hidden_inputs = "";
            var date_spans    = "";
            selected_items.forEach(function(item , i){
                var date  = item.date;
                var from  = item.from;

                var to    = item.to;
                var formattedFrom = formatTime(from);
                let formattedTo = formatTime(to);
                var key   = item.key;
                hidden_inputs += `
                    <div id="single_row_${i}">
                        <input type="hidden" name="lessons[${i}][day_no]" value="${key}">
                        <input type="hidden" name="lessons[${i}][date]" value="${date}">
                        <input type="hidden" name="lessons[${i}][from]" value="${from}">
                        <input type="hidden" name="lessons[${i}][to]" value="${to}">
                    </div>
                `;

                date_spans += `<span dir="ltr" class="d-inline-block" >${date} ( ${formattedFrom} - ${formattedTo} )</span>`;
            });

            $("#hidden_inputs_single").html(hidden_inputs);
            $("#hidden_inputs_group") .html(hidden_inputs);

            $("#date_spans_single").html(date_spans);
            $("#date_spans_group") .html(date_spans);

            updateTotalPriceV2();

        }
    </script>

    <script>
        // Attach an event listener to the document using a class selector
        document.addEventListener('input', function(event) {
            // Check if the target element has the 'studentNoInput' class
            if (event.target.classList.contains('studentNoInput')) {
                // Call the updateTotalPrice function
                updateTotalPriceV2();
            }
        });

        // Function to update the total price based on the input value
        function updateTotalPriceV2() {
            // Get the online group price and student number
            var lecturer         =  @json($lecturer);

            var onlineGroupPrice = lecturer.hour_price;
            if(is_half){
                onlineGroupPrice = onlineGroupPrice / 2;
            }

            // Get the value of the 'studentNoInput' class, or use a default value of 0
            var studentNumber = parseInt(document.querySelector('.studentNoInput').value);
            if(!studentNumber){studentNumber = 1;}

            // Calculate the total price
            var totalPrice  = onlineGroupPrice * selected_items.length;
            var totalPrice2 = onlineGroupPrice * studentNumber * selected_items.length;

            // Update the total price in the span element
            document.querySelector('.totalPrice').textContent = totalPrice;
            document.querySelector('.totalPrice2').textContent = totalPrice2;
            document.querySelector('.currency').textContent = '{{ __("tr") }}';
            document.querySelector('.currency2').textContent = '{{ __("tr") }}';
        }
    </script>

    <script>
        let sent = 0;
        $(document).on('click', '.submitForm2', function(e)
        {
            e.preventDefault();
            var save_btn2   = $(this).closest('.submitForm2');
            var form        = $(this).closest('form')[0];
            var formData    = new FormData(form);
            var url         = $(form).attr('action');
            var redirectUrl = $(form).attr('to');
            var _method     = $(form).attr('method');
            // $(save_btn).attr("disabled", true);
            $(save_btn2).attr("disabled", true);
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
                    $(save_btn2).attr("disabled", false);
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
                    // $(save_btn).attr("disabled", false);
                    $(save_btn2).attr("disabled", false);
                    setCookie('back_url', window.location.href, 1);
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
