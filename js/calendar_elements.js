document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Select the search form that submits booking details
    const searchForm = document.querySelector("form[action='car_selection.php']");

    // 🔹 Ensure the form exists before adding event listeners
    if (searchForm) {
        searchForm.addEventListener("submit", function () {
            // 🔹 Before submitting, copy user inputs into hidden fields

            // Store selected search location
            document.getElementById("hidden-search-location").value = document.getElementById("search-location").value;

            // Store pickup date
            document.getElementById("hidden-pickup").value = document.getElementById("pickup").value;

            // Store pickup time
            document.getElementById("hidden-pickup-time").value = document.getElementById("pickup-time").value;

            // Store return date
            document.getElementById("hidden-return").value = document.getElementById("return").value;

            // Store return time
            document.getElementById("hidden-return-time").value = document.getElementById("return-time").value;
        });
    }
});