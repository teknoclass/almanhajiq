<script src="{{ asset('assets/panel/js/datatable.js') }}"></script>
<script src="{{ asset('assets/panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    window.data_url = '{{route('panel.coupons.all.data')}}';
    window.columns = [{
            data: 'DT_RowIndex', name: 'DT_RowIndex'
        },
        {
            data: 'title',
            title: 'العنوان',
        },
        {
            data: 'code',
            title: 'الكود',
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
