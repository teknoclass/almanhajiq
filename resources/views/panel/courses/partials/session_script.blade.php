<script>
$(document).ready(function(){
    $(document).on('change','.sessionPrice',function(){
        var price = $(this).val();
        var id = $(this).attr("alt");
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
    });
});

</script>