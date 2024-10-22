
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.transactios.all.data')}}';
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
            data: 'description',
            title: '{{__('transaction')}}',
        },
        {
            title: '{{__('type')}}',
            data: function (row) {
                var type = {
                    'deposit': {
                        'title': '{{__('deposit')}}',
                    },

                    'withdrow': {
                        'title': '{{__('withdrow')}}',
                    },

                };
                return '<span class="label font-weight-bold label-lg ' + type[row.type].class + ' label-inline">' + type[row.type].title + '</span>';
            }
        },

        {
            title: '{{__('payment_method')}}',
            sortable: false,
            overflow: 'visible',
            autoHide: false,
            data: function(data) {
                var brand='';

                if(data.brand=='paypal'){
                    brand='{{__('paypal')}}';
                }else if(data.brand=='visa'){
                    brand='{{__('visa')}}';
                }else if(data.brand=='master'){
                    brand='{{__('master')}}';
                }else if(data.brand=='mada'){
                    brand='{{__('mada')}}';
                }else if(data.brand=='apple_pay'){
                    brand='{{__('apple_pay')}}';
                }else if(data.brand=='bank_transfer'){
                    brand='{{__('apple_pay')}}';
                }



                return brand;


            },
        },
        {
            data: 'amount',
            title: '{{__('amount')}}',
        },
        {
            title: '{{__('amount_before_discount')}}',
            sortable: false,
            overflow: 'visible',
            autoHide: false,
            data: function(data) {


                if(data.amount_before_discount==data.amount){

                    return '{{__('no_discount')}}';
                }else{

                    return data.amount_before_discount;
                }




            },
        },
        {
            title: '{{__('coupon')}}',
            sortable: false,
            overflow: 'visible',
            autoHide: false,
            data: function(data) {


                if(data.coupon=='' || data.coupon==null){

                    return '- ';
                }else{

                    return data.coupon;
                }




            },
        },
        {
            data: 'date',
            title: '{{__('transaction_date')}}',
        },
        {
            title: '{{__('status')}}',
            data: function (row) {
                var status = {
                    'refused': {
                        'title': '{{__('refused')}}',
                        'class': 'badge bg-dark',
                    },
                    'pinding': {
                        'title': '{{__('pinding')}}',
                        'class': 'badge bg-primary transactions-status',
                    },
                    'completed': {
                        'title': '{{__('completed')}}',
                        'class': 'badge bg-success',
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
    window.pageLength = "{{__('pageLength')}}";

</script>
