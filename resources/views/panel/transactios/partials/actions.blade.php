<meta name="csrf-token" content="{{ csrf_token() }}">
@if(isRefundableTransaction($id))
<button  class="btn btn-sm btn-danger refund-button" 
   data-url="{{ route('panel.transactios.refund', $id) }}" 
   title="{{ __('make_refund') }}">
   <span class="svg-icon svg-icon-md">
       {{ __('make_refund') }}
   </span>
</button>
@endif

<script>
$(document).ready(function () {

    $('.refund-button').click(function () {
        var url = $(this).data('url'); 
        var button = $(this); 

        Swal.fire({
            title: 'ارجاع مبلغ العملية',
            text: "هل أنت متاكد من اتمام العملية؟",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم',
            cancelButtonText: 'الغاء'
        }).then((result) => {
            if (result.value) {
                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري التنفيذ...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire('نجاح',  response.message , response.status).then(() => {
                                location.reload(); 
                            });
                        } else {
                            Swal.fire('فشل', response.message,  response.status);
                            button.prop('disabled', false).html('{{ __("make_refund") }}'); 
                        }
                    },
                    error: function () {
                        Swal.fire('فشل',  response.message ,  response.status);
                        button.prop('disabled', false).html('{{ __("make_refund") }}'); 
                    }
                });
            }
        });
    });

});
</script>

