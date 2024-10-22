
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>
    window.data_url = '{{route('panel.studentsOpinions.all.data')}}';
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('student_name')}}',
            data: function(data) {
                if(data.name==null){
                    return '';
                }else{
                    return data.name;
                }
            },
        },
        {
            data: 'text',
            title: '{{__('description')}}',
            render: function(data, type, row, meta) {
                let node = $.parseHTML( '<span>' + data + '</span>' )[0];
                return node.innerText;
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
