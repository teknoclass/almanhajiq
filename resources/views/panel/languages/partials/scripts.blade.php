


<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.languages.all.data')}}';
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },

        {
            data: 'title',
            title: '{{__('title')}}',
        },
        {
            title: '{{__('words')}}',
            sortable: false,
            width: 125,
            overflow: 'visible',
            autoHide: false,
            data: function(data) {
                var path = '{{url('admin/translation')}}' + '/'+ data.lang +'/all';

                return '<a class="details_orders" href="'+path+'" data-id="'+data.id+'"><i class="fas fa-sitemap"></i></a>';

            },

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



