<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>

<script>
    window.data_url = '{{route('panel.packages.all.data')}}';
    window.columns = [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },

        {
            data: 'title',
            title: '{{__('title')}}',
        },
        {
            data: 'price',
            title: '{{__('price')}}',
        },
        {
            data: 'num_hours',
            title: '{{__('num_hours')}}',
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
