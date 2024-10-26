
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.addCourseRequests.all.data')}}';
    window.additionalData = {
        status: $('#status-filter').val(),
    };
    window.columns =  [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '{{ __('Index') }}',orderable: false,searchable:false},
        { data: 'course', title: '{{ __('course') }}' , name: 'course', orderable: true,searchable:true },
        { data: 'trainer', title: '{{ __('lecturer') }}' , name: 'trainer', orderable: true ,searchable:true},
        { data: 'statusColumn', title: '{{ __('status') }}', name: 'status', orderable: true ,searchable:true },
        {
            data: 'date',
            title: "{{__('request_data')}}",
            orderable: true 
            ,searchable:true
        },
        {
            data: 'action',
            title: '{{__('action')}}',
            orderable: true
        }];
    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength="{{__('pageLength')}}";


$('#status-filter').change(function () {
        var selectedValue = $(this).val();

        if (selectedValue) {
            datatable.column(3).search(selectedValue).draw();
        } else {
            datatable.column(3).search('').draw();
        }
    });

    $('#course-filter').change(function () {
        var selectedValue = $(this).val();

        if (selectedValue) {
            datatable.column(1).search(selectedValue).draw();
        } else {
            datatable.column(1).search('').draw();
        }
    });

    $('#lecturer-filter').change(function () {
        var selectedValue = $(this).val();

        if (selectedValue) {
            datatable.column(2).search(selectedValue).draw();
        } else {
            datatable.column(2).search('').draw();
        }
    });
</script>
