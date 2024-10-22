<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>
    window.data_url = '{{route('panel.roles.all.data')}}';
    window.columns =  [
        {
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },

        {
            data: 'name',
            title: '{{__('name')}}',
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
