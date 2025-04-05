<script src="{{ asset('assets/panel/js/datatable.js') }}"></script>
<script src="{{ asset('assets/panel/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    window.data_url = '{{ route('panel.coupons.all.data') }}';
    window.columns = [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'title',
            title: '{{__('title')}}',
        },
        {
            data: 'code',
            title: '{{__('code')}}',
        },
        {
            data: 'action',
            title: '{{ __('action') }}',
            orderable: false
        }
    ];

    window.search = "{{ __('search') }}";
    window.rows = "{{ __('rows') }}";
    window.all = "{{ __('view_all') }}";
    window.excel = "{{ __('excel') }}";
    window.pageLength = "{{ __('pageLength') }}";

    $(document).ready(function() {
        $("#donwload-coupons-btn").click(function() {
            $.ajax({
                url: "{{ route('panel.download-coupons') }}",
                method: "GET",
                xhrFields: {
                    responseType: "blob"
                }, // Important for binary response
                success: function(data, status, xhr) {
                    // Extract filename from Content-Disposition header
                    let disposition = xhr.getResponseHeader("Content-Disposition");
                    let filename = "report_" + new Date().toISOString().slice(0, 10) +
                        ".xls"; // Default filename

                    if (disposition) {
                        let matches = disposition.match(/filename="(.+)"/);
                        if (matches.length > 1) filename = matches[1];
                    }

                    // Create Blob and trigger download
                    let blob = new Blob([data], {
                        type: xhr.getResponseHeader("Content-Type")
                    });
                    let url = window.URL.createObjectURL(blob);
                    let a = document.createElement("a");
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr);
                    console.log("Status:", status);
                    console.log("Error:", error);

                    // Log server response if available
                    if (xhr.responseText) {
                        console.log("Server Response:", xhr.responseText);
                    }

                    alert("Error downloading file. Check the console for details.");
                }
            });
        });
    });
</script>
