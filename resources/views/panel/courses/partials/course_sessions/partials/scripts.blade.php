<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.CourseSessionRequests.data')}}';
    window.columns = [{
         data: 'DT_RowIndex', name: 'DT_RowIndex', title: '{{ __('Index') }}',orderable: false,searchable:false,visible: false
    },

        {
            data: 'status',
            title: '{{__('status')}}'
        },
        {
            data: 'user',
            title: '{{__('user')}}'
        },
        {
            data: 'course_title',
            title: '{{__('course')}}'
        },
        {
            data: 'type',
            title: '{{__('type')}}'
        },
        {
            title: '{{__('files')}}',
            data: 'files',
            orderable: false
        },
        {
            data: 'admin_response',
            title: '{{__('admin_response')}}',
        }, {
            data: 'suggested_dates',
            title: '{{__('suggested_dates')}}',
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




