
function customSweetAlert(type ,title , html , func) {
    var then_function = func || function () {
    };
    swal({
        title: '<span class="'+type+'">'+title+'</span>',
        type: type ,
        html : html ,
        confirmButtonText: 'موافق',
        confirmButtonColor: '#56ace0',
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"

    }).then(then_function);
}

function errorCustomSweet() {
    customSweetAlert(
        'error',
        'حدث خطأ غير متوقع .. الرجاء المحاولة لاحقاً'
    );
}
function successCustomSweet(text) {
    customSweetAlert(
        'success',
        text
    );
}
