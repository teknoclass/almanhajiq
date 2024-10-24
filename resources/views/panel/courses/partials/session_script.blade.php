<script>
$(document).ready(function(){
    $(document).on('change','.sessionPrice',function(){
        var price = $(this).val();
        var id = $(this).attr("alt");
        if(price != "" && price != 0)
        {
            $.ajax({
                url: "{{url('/admin/update-session-price')}}",
                data:{id:id,price:price},
                method: 'get',
                success: function (response) {
                    customSweetAlert(
                        response.status_msg,
                        response.message,
                    );
                }
            });
        }else{
                customSweetAlert(
                        "error",
                        "{{__('price-not-zero')}}"
                    );
            }
    });
});

</script>