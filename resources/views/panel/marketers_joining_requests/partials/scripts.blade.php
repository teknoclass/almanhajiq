<script src="{{ asset('assets/panel/js/datatable.js') }}"></script>
<script src="{{ asset('assets/panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    window.data_url = '{{ route('panel.marketersJoiningRequests.all.data') }}';
    window.columns = [{
            data: 'DT_RowIndex', name: 'DT_RowIndex'
        },
        {
            title: '{{__('name')}}',
            data: function(data) {
                if(data.name==null){
                    return '';
                }else{
                    return data.name;
                }
            },
        },
        {
            data: 'email',
            title: '{{__('email')}}',
        },
        {
            data: 'country.name',
            title: '{{__('country')}} ',
        },

        {
            data: 'date',
            title: "{{__('request_data')}}",
            type: 'date',
            format: 'MM/DD/YYYY',
        },
        {
            title: '{{__('status')}}',
            // callback function support for column rendering
            data: function (row) {
                var status = {
                    'pending': {
                        'title': '{{__('underreview')}}',
                        'class': 'badge bg-warning badge-custom',
                    },
                    'acceptable': {
                        'title': '{{__('acceptable')}}',
                        'class': 'badge bg-info badge-custom',
                    },
                    'unacceptable': {
                        'title': '{{__('unacceptable')}}',
                        'class': 'badge bg-danger badge-custom',
                    },
                };
                return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
            }
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
