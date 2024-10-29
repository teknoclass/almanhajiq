
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.joinAsTeacherRequests.all.data')}}';
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('full_name')}}',
            data: function(data) {
                if(data.name==null){
                    return '';
                }else{
                    return data.name;
                }
            },
        },
        {
            title: '{{__('country')}}',
            data: function(data) {
                if(data.country==null){
                    return '';
                }else{
                    return data.country.name;
                }
            },
        },
        {
            title: '{{__('certificate')}}',
            data: function(data) {
                if(data.certificate==null){
                    return '';
                }else{
                    return data.certificate.name;
                }
            },
        },
        {
            data: 'date',
            title: "{{__('request_data')}}",
            type: 'date',
            format: 'MM/DD/YYYY',
        },
        {
          //  data: 'status',
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
                        'class': 'badge bg-success badge-custom',
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
