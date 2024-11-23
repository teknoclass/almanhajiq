
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.addCourseRequests.all.data')}}';
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex',searchable: false
    },
        {
            title: '{{__('course')}}',
            name: 'course.translations.title',
             data: 'course_title',
            searchable: true
        },
        {
            title: '{{__('the_trainer')}}',
            data: 'lecturer_name',
            name: 'course.lecturer.name',
            searchable: true
        },
        {
            data: 'date',
            title: "{{__('request_data')}}",
            type: 'date',
            format: 'MM/DD/YYYY',
            searchable: false
        },
        {
          //  data: 'status',
            title: '{{__('status')}}',
            // callback function support for column rendering
            searchable: true,
            data:'statusColumn',
            name:'status',
            orderable:false
          
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

    
    $('#status-filter').change(function () {
        var selectedValue3 = $(this).val();

        if (selectedValue3) {
            datatable.column(4).search(selectedValue3).draw();
        } else {
            datatable.column(4).search('').draw();
        }
    });

</script>
