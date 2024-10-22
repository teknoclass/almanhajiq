<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.privateLessons.all.data')}}';
    window.columns = [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },
        {
            title: '{{__('title')}}',
            data: function(data) {
                if(data.title==null){
                    return '';
                }else{
                    return data.title;
                }
            },
        },
        {
            title: '{{__('category')}}',
            data: function(data) {
                if(data.category==null){
                    return '';
                }else{
                    return data.category.name;
                }
            },
        },
        {
            title: '{{__('student')}}',
            data: function(data) {
                if(data.student==null){
                    return '';
                }else{
                    return data.student.name;
                }
            },
        },
        {
            title: '{{__('lecturer')}}',
            data: function(data) {
                if(data.teacher==null){
                    return '';
                }else{
                    return data.teacher.name;
                }
            },
        },
        {
            title: '{{__('type')}}',
            data: function (row) {
                var meeting_type = {
                    'online': {
                        'title': '{{__('online')}}',
                    },
                    'offline': {
                        'title': '{{__('offline')}}',
                    },
                    'both': {
                        'title': '{{__('both')}}',
                    },
                };
                return  meeting_type[row.meeting_type].title;
            }
        },
        {
            data: 'meeting_date',
            title: '{{__('start_date')}}',
        },
        {
            data: 'time_form',
            title: '{{__('meeting.time_form')}}',
        },
        {
            data: 'time_to',
            title: '{{__('meeting.time_to')}}',
        },
        /*{
            title: '{{__('status')}}',
            data: function (row) {
                var status = {
                    'pending': {
                        'title': '{{__('pending')}}',
                        'class': 'badge bg-dark',
                    },
                    'acceptable': {
                        'title': '{{__('acceptable')}}',
                        'class': 'badge bg-success',
                    },
                    'unacceptable': {
                        'title': '{{__('unacceptable')}}',
                        'class': 'badge bg-danger',
                    },
                };
                return '<span class="label font-weight-bold label-lg ' + status[row.status].class + ' label-inline">' + status[row.status].title + '</span>';
            }
        },*/

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




