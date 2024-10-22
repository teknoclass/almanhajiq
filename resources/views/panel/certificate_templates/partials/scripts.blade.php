<script src="{{asset('assets/panel/js/datatable.js')}}"></script>
<script src="{{asset('assets/panel/plugins/custom/datatables/datatables.bundle.js')}}"></script>
   <script>
      window.data_url = '{{route('panel.certificateTemplates.all.data')}}';
      window.columns = [
          {
              data: 'DT_RowIndex', name: 'DT_RowIndex'

          },
          {
              data: 'name',
              title: '{{__('name')}}',
          },
          {
              title: '{{__('user_status')}} ',
              data: function(data) {
                  var check = '';
                  var hidden = '';
                  if (data.is_active == 1) {
                      check = "checked";
                      hidden = 'hidden';
                  }

                  return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                      '<label>' +
                      '<input type="checkbox" class="change-operation test form-check-input" ' + check + ' name="select" id="is_active" data-type="active" />' +
                      '<span></span></label>' +
                      '<input value=' + data.id + ' type="hidden" class="item_id">';
              },
          },
          {
              title: '{{__('is_default')}} ',
              data: function(data) {
                  var check = '';
                  var hidden = '';
                  if (data.is_default == 1) {
                      check = "checked";
                      hidden = 'hidden';
                  }

                  return '<div class="form-check form-switch form-check-custom form-check-solid">  <span class="switch"> ' +
                      '<label>' +
                      '<input type="checkbox" class="change-operation form-check-input" ' + check + ' name="select" id="is_default" data-type="default" />' +
                      '<span></span></label>' +
                      '<input value=' + data.id + ' type="hidden" class="item_id">';
              },

          },


          {
              data: 'action',
              title: '{{__('action')}}',
              orderable: false
          }

      ],


 $(document).on('click', '#is_active', function() {

var item_id = $(this).parents('.switch').find('.item_id').val();
var operation = 'active';
$.ajax({
   url: "{{route('panel.certificateTemplates.operation')}}?id=" + item_id,
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

$(document).on('click', '#is_default', function() {

var item_id = $(this).parents('.switch').find('.item_id').val();
var operation = 'default';
$.ajax({
   url: "{{route('panel.certificateTemplates.operation')}}?id=" + item_id,
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

   </script>
