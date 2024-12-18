<script>
$(document).ready(function(){
    $(document).on('change','.sessionPrice',function(){
        var price = $(this).val();
        var id = $(this).attr("alt");
        if(price == "")
        {
            price = 0;
        }   
        // if(price != "" && price != 0)
        // {
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
        // }else{
                // customSweetAlert(
                //         "error",
                //         "{{__('price-not-zero')}}"
                //     );
            // }
    });

    $(document).on('change','.changeDate',function(){
        var date = $(this).val();
        var id = $(this).attr("alt");
        
        $.ajax({
            url: "{{url('/admin/update-session-date')}}",
            data:{id:id,date:date},
            method: 'get',
            success: function (response) {
                customSweetAlert(
                    response.status_msg,
                    response.message,
                );
                location.reload();
            }
        });
    });

    $(document).on('change','.changeTime',function(){
        var time = $(this).val();
        var id = $(this).attr("alt");
        
        $.ajax({
            url: "{{url('/admin/update-session-time')}}",
            data:{id:id,time:time},
            method: 'get',
            success: function (response) {
                customSweetAlert(
                    response.status_msg,
                    response.message,
                );

                location.reload();
            }
        });
    });

});

</script>