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
                                                    <input name='days[{{$index}}][{{ $key }}][from]' value="{{ $time->from }}"  type='time' class='form-control'/>
                                                </td>
                                                <td>
                                                    <input name='days[{{$index}}][{{ $key }}][to]' value="{{ $time->to }}"  type='time' class='form-control'/>
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
                                            <input name='days[{{$index}}][0][from]'  type='time' class='form-control' disabled/>
                                        </td>
                                        <td>
                                            <input name='days[{{$index}}][0][to]'  type='time' class='form-control' disabled/>
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
        $(document).on("click", ".add-row", function () {
            var dayName = $(this).attr('data-day');
            var dayNumber = $(this).attr('data-day-number');
            var row=$("#"+dayName+" tr").length + 1;
            var newRow = '<tr id="row' + row + '"><td><input name="days['+dayNumber+']['+row+'][from]" type="time" class="form-control"/></td><td><input name="days['+dayNumber+']['+row+'][to]" type="time" class="form-control"/></td><td><input class="delete-row btn btn-sm btn-danger" type="button" value="Delete" /></td></tr>';
            $('#'+dayName).append(newRow);
            row++;
            return false;
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
                $("."+tableName+"-add-btn").prop("disabled",true);
            } else {
                $("#"+tableName).find('input').prop("disabled",false);
                $("."+tableName+"-add-btn").prop("disabled",false);
            }
        });
    </script>
@endpush
