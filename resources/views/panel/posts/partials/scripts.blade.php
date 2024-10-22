<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>

    window.data_url = '{{route('panel.posts.all.data')}}';
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
            title: '{{__('author')}}',
            data: function(data) {
                if(data.user==null){
                    return '';
                }else{
                    return data.user.name;
                }
            },
        },
        {
            data: 'num_views',
            title: '{{__('num_views')}}',
        },
        {
            data: 'date_publication',
            title: '{{__('post_date')}}',
        },
        {
         //   data: 'is_published',
            title: '{{__('is_published')}}',
            selector: false,
            data: function (data) {
                var check = '';
                var hidden = '';
                if (data.is_published == 1) {
                    check = "checked";
                    hidden = 'hidden';
                }
                return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                    '<label>'+
                    '<input class="form-check-input" type="checkbox" '+check+' name="select" id="is_published" />'+
                    '<span></span></label>'+
                    '<input value=' + data.id + ' type="hidden" class="item_id">' ;
            },
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


<script>
    $(document).on('click', '#is_published', function () {

        var item_id = $(this).parents('.switch').find('.item_id').val();
        $.ajax({
            url: "{{route('panel.posts.operation')}}?id=" + item_id,
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


