/**
 * This script handles the redirection to the car details page when a "Book" button is clicked.
 * 
 * Features:
 * 
 * 🚗 Car Selection:
 * - Listens for clicks on `.book-button` elements.
 * - Extracts the `car_id` from the `data-car-id` attribute of the clicked button.
 * 
 * 🔄 URL Parameter Handling:
 * - Retrieves the current URL search parameters.
 * - Appends or updates the `car_id` parameter with the selected car's ID.
 * 
 * 🔗 Redirection:
 * - Constructs a new URL with the updated search parameters.
 * - Redirects the user to `car_details.php`, ensuring a smooth transition with preserved search filters.
 * 
 * This script streamlines the car selection process by dynamically forwarding users to the details page.
 */
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".book-button").forEach(button => {
        button.addEventListener("click", function () {
            const carId = this.getAttribute("data-car-id");
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set("car_id", carId);

            // Redirect to car_details.php with the selected ID
            window.location.href = "car_details.php?" + urlParams.toString();
        });
    });
});