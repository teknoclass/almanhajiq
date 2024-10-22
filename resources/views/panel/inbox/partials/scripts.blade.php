
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.inbox.all.data')}}';
    window.columns =  [    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

        { data: 'name', title: '{{__('sender')}}' },
        {
            data: 'subject',
            title: '{{__('title')}}',
        },
        {
            data: 'text',
            title: '{{__('message')}}',
        },
        {
            data: 'date',
            title: '{{__('date')}}',

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

</script>
