document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#sessionInputsContainer input,select, textarea').forEach((element) => {
        if (element.id !== 'select_sessions') {  // Replace 'excludeId' with the id of the element to exclude
            element.disabled = true;
        }
    });    document.querySelectorAll('#planContainer input, select, textarea').forEach((element) => {
        if (element.id !== 'select_sessions') {  // Replace 'excludeId' with the id of the element to exclude
            element.disabled = true;
        }
    });

    // Hide buttons
    document.querySelectorAll('#planContainer .btn').forEach((button) => {
        if (element.id !== 'select_sessions') {  // Replace 'excludeId' with the id of the element to exclude
            element.disabled = true;
        }
    });  // Hide buttons
    document.querySelectorAll('#sessionInputsContainer .btn').forEach((button) => {
        if (element.id !== 'select_sessions') {  // Replace 'excludeId' with the id of the element to exclude
            element.disabled = true;
        }
    });
});
