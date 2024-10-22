
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.addCourseRequests.all.data')}}';
    window.additionalData = {
        status: $('#status-filter').val(),
    };
    window.columns =  [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', title: '{{ __('Index') }}',orderable: false,searchable:false},
        { data: 'course', title: '{{ __('Course') }}' },
        { data: 'trainer', title: '{{ __('The Trainer') }}' },
        { data: 'status', title: '{{ __('Status') }}' },
        {
            data: 'date',
            title: "{{__('request_data')}}",
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

    $('#status-filter').change(function () {
        var selectedValue = $(this).val();
        console.log(selectedValue);
        if (selectedValue) {
            datatable.column(3).search(selectedValue).draw();
        } else {
            datatable.column(3).search('').draw();
        }
    });
</script>
