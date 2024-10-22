<div class="tab-pane fade show {{ @$is_active ? 'active' : '' }}" id="{{ @$key }}">
    <div class="row">

        <div class="col-lg-12 mx-auto">
            <form id="form" action="{{route('user.lecturer.settings.update')}}" to="{{ url()->current() }}" method="post">
               @csrf
                <input type="hidden" name="tab" value="timetable">

                <div class="row">
                    <div class="table-responsive scrollbar" id="style-3">
                        @foreach(\Carbon\Carbon::getDays() as $index => $day)
                            <caption>
                                <b>{{ $day }}</b>
                            </caption>
                            <div class="form-check form-switch form-check-custom form-check-solid" style="float: right">
                                <span class="switch">
                                    <label>
                                        <input type="checkbox" class="change-operation test form-check-input available" @checked(isset($timetable) && in_array($index, $timetable->timeTable->pluck('day_no')->toArray())) data-type="validation" style="width: 40px !important;" data-table-name="{{ strtolower($day) }}-table">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                            <table class="table table-condensed force-overflow" id="{{ strtolower($day) }}-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('from') }}</th>
                                        <th>{{ __('to') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="{{ $day }}">
                                @if(isset($timetable) && in_array($index, $timetable->timeTable->pluck('day_no')->toArray()))
                                    @foreach($timetable->timeTable as $key => $time)
                                        @if($index === $time->day_no)
                                            <tr id="row{{$index}}">
                                                <td>
                                                    @php($hours = ['00:30','01:00','01:30','02:00',
                                                        '02:30','03:00','03:30','04:00','04:30','05:00','05:30',
                                                        '06:00','06:30','07:00','07:30','08:00','08:30','09:00'
                                                        ,'09:30','10:00','10:30','11:00','11:30','12:00','12:30',
                                                        '13:00','13:30','14:00',
                                                        '14:30','15:00','15:30','16:00','16:30','17:00','17:30',
                                                        '18:00','18:30','19:00','19:30','20:00','20:30','21:00'
                                                        ,'21:30','22:00','22:30','23:00','23:30',
                                                    ])
                                                    <select name="days[{{$index}}][{{ $key }}][from]" class="form-control from_date from_{{$index}}_{{ $key }}" data-indx="{{$index . '_' . $key }}" >
                                                        <option value="00:00" @selected( $time->from == '00:00' )>00:00</option>
                                                        @foreach ($hours as $hr)
                                                            <option value="{{ $hr }}" @selected( $time->from == $hr ) >{{ $hr }}</option>
                                                        @endforeach
                                                    </select>
                                                    {{-- <input name='days[{{$index}}][{{ $key }}][from]' value="{{ $time->from }}"  type='time' class='form-control'/> --}}
                                                </td>
                                                <td>
                                                    <select name="days[{{$index}}][{{ $key }}][to]" class="form-control to_date to_{{$index . '_' . $key }}" data-indx="{{$index . '_' . $key }}" >
                                                        @foreach ($hours as $hr)
                                                            <option value="{{ $hr }}" @selected( $time->to == $hr )>{{ $hr }}</option>
                                                        @endforeach
                                                        <option value="24:00" @selected( $time->to == '24:00' )>24:00</option>
                                                    </select>
                                                    {{-- <input name='days[{{$index}}][{{ $key }}][to]' value="{{ $time->to }}"  type='time' class='form-control'/> --}}
                                                </td>
                                                <td>
                                                    <input class="delete-row btn btn-sm btn-danger" type="button" value="Delete" />
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr id="row{{$index}}">
                                        <td>
                                            @php($hours = ['00:30','01:00','01:30','02:00',
                                                '02:30','03:00','03:30','04:00','04:30','05:00','05:30',
                                                '06:00','06:30','07:00','07:30','08:00','08:30','09:00'
                                                ,'09:30','10:00','10:30','11:00','11:30','12:00','12:30',
                                                '13:00','13:30','14:00',
                                                '14:30','15:00','15:30','16:00','16:30','17:00','17:30',
                                                '18:00','18:30','19:00','19:30','20:00','20:30','21:00'
                                                ,'21:30','22:00','22:30','23:00','23:30',
                                            ])
                                            <select name="days[{{$index}}][0][from]" class="form-control from_date from_{{$index}}_0" data-indx="{{$index . '_0' }}" disabled >
                                                <option value="00:00">00:00</option>
                                                @foreach ($hours as $hr)
                                                    <option value="{{ $hr }}" >{{ $hr }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="days[{{$index}}][0][to]" class="form-control to_date to_{{$index . '_0' }}" data-indx="{{$index . '_0' }}" disabled >
                                                @foreach ($hours as $hr)
                                                    <option value="{{ $hr }}">{{ $hr }}</option>
                                                @endforeach
                                                <option value="24:00">24:00</option>
                                            </select>
                                            {{-- <input name='days[{{$index}}][{{ $key }}][to]' value="{{ $time->to }}"  type='time' class='form-control'/> --}}
                                        </td>
                                        <td>
                                            <input class="delete-row btn btn-sm btn-danger" type="button" value="Delete" />
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <input class='btn btn-sm btn-primary add-row {{strtolower($day)}}-table-add-btn' data-day-number="{{ $index }}" data-day="{{ $day }}" type='button' value='Add' style="margin-bottom: 25px;" {{ isset($timetable) && !in_array($index, $timetable->timeTable->pluck('day_no')->toArray()) ? 'disabled' : '' }}/>
                            <br>
                        @endforeach
                    </div>
                </div>


                @include('front.user.lecturer.courses.new_course.components.save_button')
            </form>
        </div>
    </div>
</div>
@push('front_js')
    <script src="{{ asset('assets/front/js/post.js') }}"></script>
    <script>
        var hrs_options = '@foreach ($hours as $hr) <option value="{{ $hr }}">{{ $hr }}</option> @endforeach';
        $(document).on("click", ".add-row", function () {
            var dayName = $(this).attr('data-day');
            var dayNumber = $(this).attr('data-day-number');
            var row=$("#"+dayName+" tr").length + 1;

            var from_date = '<select name="days['+dayNumber+']['+row+'][from]" class="form-control from_date from_'+dayNumber+'_'+row+'" data-indx="'+dayNumber+'_'+row+'" ><option value="00:00">00:00</option>' + hrs_options + '</select>';
            var to_date = '<select name="days['+dayNumber+']['+row+'][to]" class="form-control to_date to_'+dayNumber+'_'+row+'" data-indx="'+dayNumber+'_'+row+'" >'+hrs_options+'<option value="24:00">24:00</option></select>';
            // var newRow = '<tr id="row' + row + '"><td><input name="days['+dayNumber+']['+row+'][from]" type="time" class="form-control"/></td><td><input name="days['+dayNumber+']['+row+'][to]" type="time" class="form-control"/></td><td><input class="delete-row btn btn-sm btn-danger" type="button" value="Delete" /></td></tr>';
            var newRow = '<tr id="row' + row + '"><td>' + from_date + '</td><td>' + to_date + '</td><td><input class="delete-row btn btn-sm btn-danger" type="button" value="Delete" /></td></tr>';
           $('#'+dayName).append(newRow);
            row++;
            return false;
        });

        $(document).on("change", ".to_date , .from_date", function () {
            var indx = $(this).attr('data-indx');
            if($('.from_'+indx).val() >= $('.to_'+indx).val() ){
                $('.to_'+indx).val($('.from_'+indx).val());
                $(this).addClass('border-danger');
            }else{
                $('.from_date').removeClass('border-danger');
                $('.to_date').removeClass('border-danger');
            }
        });

        // Remove criterion
        $(document).on("click", ".delete-row", function () {
            $(this).closest('tr').remove();
            return false;
        });
        // Disabled not available day
        $(document).on("click", ".available", function () {
            var tableName = $(this).attr('data-table-name');
            if(!this.checked) {
                $("#"+tableName).find('input').prop("disabled",true);
                $("#"+tableName).find('select').prop("disabled",true);
                $("."+tableName+"-add-btn").prop("disabled",true);
            } else {
                $("#"+tableName).find('input').prop("disabled",false);
                $("#"+tableName).find('select').prop("disabled",false);
                $("."+tableName+"-add-btn").prop("disabled",false);
            }
        });
    </script>
@endpush
