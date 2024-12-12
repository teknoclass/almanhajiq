
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.transactios.all.lecturers_profits_datatable')}}';
    window.columns = [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('lecturer')}}',
            data: function(data) {
                if(data.lecturer==null){
                    return '';
                }else{
                    return data.lecturer;
                }
            },
        },
        {
            title: '{{__('balance')}}',
            data: function(data) {
                if(data.balance==null){
                    return '';
                }else{
                    return data.balance;
                }
            },
        },
        {
            data: 'action',
            title: '{{__('details')}}',
            orderable: false
        }
    ];
    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength = "{{__('pageLength')}}";
    window.translations = @json(json_decode(file_get_contents(resource_path('lang/' . app()->getLocale() . '.json')), true));
    
    $(document).on('click', '.show-transactions', function () {
    const lecturerId = $(this).data('id');
    $.ajax({
        url: `/admin/transactios/all/lecturers_profits/${lecturerId}/transactions`,
        method: 'GET',
        success: function (response) {
            const tableBody = $('#transactionsTable tbody');
            tableBody.empty();
            response.forEach(transaction => {
                tableBody.append(`
                    <tr>
                        <td>${transaction.description}</td>
                        <td>${transaction.amount}</td>
                        <td>${window.translations[transaction.type+'_desc'] || transaction.type}</td>
                        <td>${transaction.created_at}</td>
                    </tr>
                `);
            });
            $('#lecturerTransactionsModal').modal('show');
        }
    });
});

</script>

