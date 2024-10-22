<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script>
    window.data_url = '{{route('panel.homePageSections.all.data')}}';
    window.columns =  [{
        data: 'DT_RowIndex', name: 'DT_RowIndex'
    },

        {
            data: 'title',
            title: '{{__('section_name')}}',
        },
        {
            title: '{{__('user_status')}}',
            data: function (data) {
                var check = '';
                var hidden = '';
                if (data.is_active == 1) {
                    check = "checked";
                    hidden = 'hidden';
                }
                return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                    '<label>'+
                    '<input class="form-check-input" type="checkbox" '+check+' name="select" id="is_active" />'+
                    '<span></span></label>'+
                    '<input value=' + data.id + ' type="hidden" class="item_id">' ;
            }
        }
        ];
    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength="{{__('pageLength')}}";

</script>



   <script>
            $(document).on('click', '#is_active', function () {

                var item_id = $(this).parents('.switch').find('.item_id').val();
                var operation="active";
                $.ajax({
                    url: "{{route('panel.homePageSections.operation')}}?id="+item_id,
                    method: "post",
                    data: {id: item_id,operation:operation},
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


