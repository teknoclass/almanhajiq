<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script>

    window.data_url = '{{route('panel.users.all.data')}}';
    window.columns = [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },

        { title: '{{__('name')}}', data: 'name', name: 'name', orderable: true },
        { title: '{{__('email')}}', data: 'email', name: 'email', orderable: true },
        { title: '{{__('account_type')}}', data: 'role', name: 'role', orderable: true },
        {
            title: '{{__('user_block')}} ',
            data: function(data) {
                var check = '';
                var hidden = '';
                if (data.is_block == 1) {
                    check = "checked";
                    hidden = 'hidden';
                }

                return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                    '<label>' +
                    '<input type="checkbox" class="change-operation form-check-input" ' + check + ' name="select" id="is_block" data-type="block" />' +
                    '<span></span></label>' +
                    '<input value=' + data.id + ' type="hidden" class="item_id">';
            },

        },
        {
            title: '{{__('user_status')}} ',
            data: function(data) {
                var check = '';
                var hidden = '';
                if (data.is_validation == 1) {
                    check = "checked";
                    hidden = 'hidden';
                }

                return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                    '<label>' +
                    '<input type="checkbox" class="change-operation test form-check-input" ' + check + ' name="select" id="is_validation" data-type="validation" />' +
                    '<span></span></label>' +
                    '<input value=' + data.id + ' type="hidden" class="item_id">';
            },
        },
        { data: 'date', title: '{{__('reg_date')}}', name: 'date', orderable: true },

        {
            data: 'action',
            title: '{{__('action')}}',
            orderable: false, searchable: false
        }
    ];

    window.search = "{{__('search')}}";
    window.rows = "{{__('rows')}}";
    window.all = "{{__('view_all')}}";
    window.excel = "{{__('excel')}}";
    window.pageLength="{{__('pageLength')}}";
</script>

<script>

    $(document).on('click', '.change-operation', function () {

         var item_id = $(this).parents('.switch').find('.item_id').val();
         var operation = $(this).data('type');

         $.ajax({
            url: "{{route('panel.users.operation')}}?id=" + item_id,
            method: "post",
            data: {
               id: item_id,
               operation: operation
            },
            success: function(e) {
               if (e.status) {
                  Swal.fire({
                     title: '{{__('message.operation_accomplished_successfully')}}',
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
    $(document).on('click', '.export-excel', function() {

        var search = {
            "role": $('#role').val(),
            "name": $('#name_user').val(),
        }

        var url = "{{route('panel.users.exportExcel')}}?" + $.param(search)

        window.location = url;
    });
    $('#category').change(function () {
        var selectedValue = $(this).val();

        if (selectedValue) {
            datatable.column(3).search(selectedValue).draw();
        } else {
            datatable.column(3).search('').draw();
        }
    });
</script>
