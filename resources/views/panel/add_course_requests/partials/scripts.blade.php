
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.addCourseRequests.all.data')}}';
    window.additionalData = {
        status: $('#status-filter').val(),
    };
    window.columns =  [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '{{ __('Index') }}',orderable: false,searchable:false},
        { data: 'course', title: '{{ __('course') }}' , name: 'course', orderable: false,searchable:true },
        { data: 'trainer', title: '{{ __('lecturer') }}' , name: 'trainer', orderable: false ,searchable:true},
        { data: 'statusColumn', title: '{{ __('status') }}', name: 'status', orderable: false ,searchable:true },
        {
            data: 'date',
            title: "{{__('request_data')}}",
            orderable: false 
            ,searchable:true
        },
        {
            data: 'action',
            title: '{{__('action')}}',
            orderable: false
        }];
    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength="{{__('pageLength')}}";

    // $('#course-filter').change(function () {
    //     var selectedValue1 = $(this).val();

    //     if (selectedValue1) {
    //         datatable.column(1).search(selectedValue1).draw();
    //     } else {
    //         datatable.column(1).search('').draw();
    //     }
    // });

    // $('#lecturer-filter').change(function () {
    //     var selectedValue2 = $(this).val();

    //     if (selectedValue2) {
    //         datatable.column(2).search(selectedValue2).draw();
    //     } else {
    //         datatable.column(2).search('').draw();
    //     }
    // });

    $('#status-filter').change(function () {
        var selectedValue3 = $(this).val();

        if (selectedValue3) {
            datatable.column(3).search(selectedValue3).draw();
        } else {
            datatable.column(3).search('').draw();
        }
    });
</script>
