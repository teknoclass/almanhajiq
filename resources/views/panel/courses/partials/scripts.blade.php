<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.courses.all.data')}}';
    window.columns = [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },

        {
            data: 'title',
            title: '{{__('title')}}',
        },
        {
            title: '{{__('the_trainer')}}',
            data: function(data) {
                if(data.lecturer==null){
                    return '';
                }else{
                    return data.lecturer.name;
                }
            },
        },
        {
            title: '{{__('material')}}',
            data: function(data) {
                if(data.material==null){
                    return '';
                }else{
                    return data.material.name;
                }
            },
        },
        {
            data: 'students_count',
            title: '{{__('number_of_students')}}',
        },
        {
            data: 'rating',
            title: '{{__('rate')}}',
        },
        {
            data: 'comments',
            title: '{{__('comments')}}',
        },
        {
            data: 'students',
            title: '{{__('students')}}',
        },
        {
            //  data: 'status',
            title: '{{__('status')}}',
            // callback function support for column rendering
            data: function (row) {
                var status = {
                    'being_processed': {
                        'title': '{{__('being_processed')}}',
                        'class': 'badge bg-warning badge-custom',
                    },
                    'ready': {
                        'title': '{{__('ready')}}',
                        'class': 'badge bg-info badge-custom',
                    },
                    'accepted': {
                        'title': '{{__('accepted')}}',
                        'class': 'badge bg-success badge-custom',
                    },
                    'unaccepted': {
                        'title': '{{__('unaccepted')}}',
                        'class': 'badge bg-danger badge-custom',
                    }
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
