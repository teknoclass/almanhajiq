

<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>



    @if($type==0)
        window.data_url = '{{route('panel.courseStudents.all.data')}}';
    @else
        window.data_url = '{{route('panel.courseStudents.course.data',$course_id)}}';
    @endif
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('student')}}',
            sortable: false,
            data: function(data) {
                if(data.user==null){
                    return '';
                }else{
                    return data.user.name;
                }
            },
        },
        {
            title: '{{__('course')}}',
            sortable: false,
            data: function(data) {
                if(data.course==null){
                    return '';
                }else{
                    return data.course.title;
                }
            },
        },

        {
          //
            title: '{{__('payment_status')}}',
            data: function (row) {
                var is_complete_payment = {
                    '1': {
                        'title': '{{__('done')}}',
                        'class': 'badge bg-dark',
                    },
                    '0': {
                        'title': '{{__('not_done')}}',
                        'class': 'badge bg-success',
                    },
                };
                return  is_complete_payment[row.is_complete_payment].title;
            }
        },

        {
            data: 'date',
            sortable: false,
            title: '{{__('date')}}',
        },{
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



