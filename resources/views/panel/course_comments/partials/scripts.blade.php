<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    @if($type==0)
        window.data_url = '{{route('panel.courseComments.all.data')}}';
    @else
        window.data_url = '{{route('panel.courseComments.course.data',$course_id)}}';
    @endif

        window.columns = [
        {data: 'DT_RowIndex', name: 'DT_RowIndex', title: '{{ __('Index') }}', orderable: false},
        {data: 'text', title: '{{ __('comment') }}'},
        {data: 'user', title: '{{ __('user') }}'},
        {data: 'course', title: '{{ __('course') }}'},
        {data: 'is_published', title: '{{ __('is_published') }}'},
        {data: 'action', title: '{{ __('action') }}', orderable: false}];

    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength = "{{__('pageLength')}}";

</script>


<script>
    $(document).on('click', '#is_published', function () {

        var item_id = $(this).parents('.switch').find('.item_id').val();
        $.ajax({
            url: "{{route('panel.courseComments.operation')}}?id=" + item_id,
            method: "post",
            data: {id: item_id},
            success: function (e) {
                if (e.status) {
                    Swal.fire({
                        title: '{{__('message_done')}}',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    })
                }


            }
        });

    });


</script>


