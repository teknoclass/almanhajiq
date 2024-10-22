
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>
    window.data_url = '{{route('panel.withdrawalRequests.all.data')}}';
    window.columns = [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('user')}}',
            data: function(data) {
                if(data.user==null){
                    return '';
                }else{
                    return data.user.name;
                }
            },
        },
        {
            title: '{{__('user_role')}}',
            data: function (row) {
                var user_type = {
                    'lecturer': {
                        'title': '{{__('محاضر')}}',
                    },
                    'marketer': {
                        'title': '{{__('مسوق')}}',
                    },

                };
                return '<span class="label font-weight-bold label-lg ' + user_type[row.user_type].class + ' label-inline">' + user_type[row.user_type].title + '</span>';
            }
        },

        {
            data: 'amount',
            title: '{{__('amount')}}',
        },

        {
            data: 'details',
            title: '{{__('details')}}',
        },

        {
            title: '{{__('status')}}',
            // callback function support for column rendering
            data: function(row) {
                var status = {
                    'pending': {
                        'title': "{{__('withdrawal_requests_status.pending')}}",
                        'class': 'badge bg-warning text-dark',
                    },
                    'underway': {
                        'title': "{{__('withdrawal_request_status.underway')}}",
                        'class': ' badge bg-primary',
                    },
                    'completed': {
                        'title': "{{__('withdrawal_requests_status.completed')}}",
                        'class': 'badge bg-success',
                    },
                    'canceled': {
                        'title': "{{__('withdrawal_request_status.canceled')}}",
                        'class': 'badge bg-dark',
                    },
                    'unacceptable': {
                        'title': "{{__('withdrawal_request_status.unacceptable')}}",
                        'class': 'badge bg-danger',
                    },
                };
                return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' badge2 label-inline">' + status[row.status].title + '</span>';

            },
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
    window.pageLength = "{{__('pageLength')}}";
</script>
