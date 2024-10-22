document.querySelectorAll('.update-text').forEach(function(textarea) {
    textarea.addEventListener('change', function() {
        let key = this.getAttribute('data-key');  // Get the 'key' of the textarea
        let value = this.value;  // Get the new value of the textarea// You can dynamically get the language if needed

        // Send AJAX request to update the record
        let url = $("#btn_submit").data('url');
        let csrf = $("#btn_submit").data('csrf');
        console.log(url);
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf // Include CSRF token
            },
            body: JSON.stringify({
                key: key,
                value: value,
                csrf: csrf,
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    console.log('Record updated successfully');
                } else {
                    console.error('Update failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
