"use strict";
// Class definition
var datatable;
var KTDatatableRemoteAjaxDemo = function () {
    // Private functions

    // basic demo
    var demo = function () {
        datatable = $('.data-table').DataTable({
            "language": {
                "search": window.search,
            },
            lengthMenu: [
                [10, 25, 50, 'all'],
                ['10', '25', '50', window.all]
            ],
            processing: true,
            serverSide: true,
            paging: true,
            ordering: false, 
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: window.excel,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],
            responsive: true,
            ajax: {
                url: window.data_url,
                data: function (d) {
                    // Add additional data to the request
                    $.extend(d, window.additionalData);
                }
            },
            columns: window.columns,
            order: [[1, 'asc']], // Default sorting column and direction
        });
    };

    return {
        // public functions
        init: function () {
            demo();
        },
    };
}();

jQuery(document).ready(function () {
    KTDatatableRemoteAjaxDemo.init();
});
