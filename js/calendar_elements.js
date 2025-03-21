/**
 * This script ensures that search input values are copied into hidden fields
 * before submitting the form that redirects to `car_selection.php`.
 * 
 * - On form submission, values from visible input fields (location, dates, times)
 *   are transferred to corresponding hidden inputs.
 * - This is useful for persisting user search data during redirection or processing,
 *   especially if the visible fields are outside the actual form being submitted.
 */
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector("form[action='car_selection.php']");
    
    if (searchForm) {
        searchForm.addEventListener("submit", function () {
            document.getElementById("hidden-search-location").value = document.getElementById("search-location").value;
            document.getElementById("hidden-pickup").value = document.getElementById("pickup").value;
            document.getElementById("hidden-pickup-time").value = document.getElementById("pickup-time").value;
            document.getElementById("hidden-return").value = document.getElementById("return").value;
            document.getElementById("hidden-return-time").value = document.getElementById("return-time").value;
        });
    }
});