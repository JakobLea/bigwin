function myFunction(event) {
    var dropdown = document.getElementById("myDropdown");
    if (dropdown.style.display === "block") {
        dropdown.style.display = "none";
    } else {
        dropdown.style.display = "block";
    }
    event.stopPropagation();
}

// Close the dropdown if the user clicks outside of it
document.addEventListener('click', function (event) {
    var dropdown = document.getElementById("myDropdown");
    if (event.target !== dropdown) {
        dropdown.style.display = "none";
    }
});
