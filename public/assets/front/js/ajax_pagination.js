


function getData(urlPage) {
    var url = urlPage;
    window.history.pushState("", "", url);
    $('#load').show();
    $.ajax({
        url: urlPage,
        data: {}
    }).done(function (data) {
        $(".all-data").empty().html(data);
        $('#load').hide();
    });
}

$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    $('li').removeClass('active');
    $(this).parent('li').addClass('active');
    var url = urlFilter($(this).attr('href'));

    url = getUrlWithSearchParm(url, window.filter, true);
    getData(url);
    //to scroll top of page
    window.scrollTo(0, 0);
});

function urlFilter(url) {
    return url;
}

$(document).on('click', '.clear-filter', function (event) {
    $('.filter-input').val('');
    var url = $(this).data('url');
    $('.filter-form-body').find('input:text').val('');
    $('.filter-form-body').find("input:radio").attr("checked", false);
    $('.filter-form-body').find("input:checkbox").attr("checked", false);
    getData(url);
});


function getUrlWithSearchParm(url, filter, is_pagination) {

    var char_parm = "?";
    if (is_pagination) {
        char_parm = "&";
    }
    if (filter) {
        for (var obj in filter) {
            url = url + char_parm + obj + '=' + filter[obj];

            if (!is_pagination) {
                char_parm = "&";
            }
        }
    }

    return url;

}

function checkisNotNull(item){

   if( typeof(item) != "undefined" && item != null && item != 'undefined'){
    return true;
   }
   return false;


}

$(document).on('click', '.view-more-data', function (event) {
    event.preventDefault();

    var url=$(this).data('url');
    var section=$(this).data('section');
    var grids=$(this).data('grids');
    var count=$('.'+grids).length;
    $('#load').show();
    $.ajax({
        url: url,
        data: {count:count}
        ,success: function (response) {
        $("."+section).append(response.item.html);

        $('.view-more-button').show();
        if(!response.item.is_show_button_view_more){
        $('.view-more-button').hide();
        }

        $('#load').hide();
        },
    });


});
