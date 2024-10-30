<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>
    window.data_url = '{{route('panel.loginActivity.all.data')}}';
    window.columns = [
        {
            data: 'DT_RowIndex', name: 'DT_RowIndex'
        },
        {
            data: 'user_name', // Use the alias provided in backend
            title: '{{__('user')}}',
        },
        {
            data: 'role', // Use the alias provided in backend
            title: '{{__('user_role')}}',
        },
        {
            data: 'type',
            title: '{{__('type')}}',
        },
        {
            data: 'user_agent',
            title: '{{__('agent')}}',
        },
        {
            data: 'ip_address',
            title: '{{__('ip')}}',
        },
        {
            data: 'date',
            title: '{{__('date')}}',
        },
    ];
    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength="{{__('pageLength')}}";
    $('#category').change(function () {
        var selectedValue = $(this).val();

        // Only perform the search if a valid role is selected
        if (selectedValue) {
            datatable.column(2).search(selectedValue).draw();
        } else {
            // Clear the filter if the placeholder is selected
            datatable.column(2).search('').draw();
        }
    });
</script>
