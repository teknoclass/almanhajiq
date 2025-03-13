<script src="{{ asset('assets/panel/js/datatable.js') }}"></script>
<script src="{{ asset('assets/panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    window.data_url = '{{route('panel.coupons.groups.data')}}';
    window.columns = [{
            data: 'DT_RowIndex', name: 'DT_RowIndex'
        },
        {
            data: 'group_name',
            title: 'اسم المجموعة',
        },
        {
            data: 'total_coupons',
            title: 'عدد الكوبونات',
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
