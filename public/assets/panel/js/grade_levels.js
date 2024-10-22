const select1 = document.getElementById("grade_level_id");
const select2 = document.getElementById("sub_level_id");

select1.addEventListener("change", function() {
    const selectedOption = this.options[this.selectedIndex];

    // Get the data-child attribute (which is a JSON string)
    const children = selectedOption.getAttribute('data-child');

    // Parse the JSON string into an array of objects
    let childrenOptions = [];
    if (children) {
        childrenOptions = JSON.parse(children);
    }

    // Clear the second select
    select2.innerHTML = '<option value="">Select a Child</option>';

    // Populate the second select with child options
    childrenOptions.forEach(child => {
        const option = document.createElement("option");
        option.value = child.id; // Assuming each child has an id
        option.textContent = child.name; // Assuming each child has a name
        select2.appendChild(option);
    });
});
