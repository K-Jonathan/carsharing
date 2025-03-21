/**
 * This script manages car selection and redirection to the details page with validated search parameters.
 * 
 * Features:
 * 
 * 🚗 Car Selection:
 * - Attaches a global event listener to all "Book" buttons (`.book-button`).
 * - When clicked, retrieves the `car_id` and calls `redirectToDetails(carId)`.
 * 
 * 🔄 Redirect with Search Parameters:
 * - Extracts search details (location, pickup/return date & time) from the URL.
 * - Validates that all required values are set and not placeholders.
 * - If valid, appends the `car_id` and redirects to `car_details.php`.
 * - If missing values, displays a popup alerting the user.
 * 
 * 📌 Popup Notification:
 * - Shows an alert if the user has not selected all required booking details.
 * - The popup can be closed by clicking the close button.
 * 
 * 🚀 Data Fetching:
 * - Calls `fetchCarIds()` on page load (assumed to retrieve and display car listings).
 */
document.addEventListener("DOMContentLoaded", function () {
    function fetchCarIds() {
        // (The rest of the fetch code remains unchanged)
    }

    function redirectToDetails(carId) {
        // 📌 Get values directly from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const location = urlParams.get("search-location") ? urlParams.get("search-location").trim() : "";
        const pickupDate = urlParams.get("pickup") ? urlParams.get("pickup").trim() : "";
        const pickupTime = urlParams.get("pickup-time") ? urlParams.get("pickup-time").trim() : "";
        const returnDate = urlParams.get("return") ? urlParams.get("return").trim() : "";
        const returnTime = urlParams.get("return-time") ? urlParams.get("return-time").trim() : "";

        // 📌 Check whether values are empty or contain placeholders
        if (!location || location === "Stadt" || 
            !pickupDate || pickupDate === "Datum" || 
            !pickupTime || pickupTime === "--:--" || 
            !returnDate || returnDate === "Datum" || 
            !returnTime || returnTime === "--:--") {
            
            showPopup("Wählen Sie bitte Ihren gewünschten Buchungszeitraum und Standort aus.");
            return;
        }

        // 📌 If everything fits, forward
        urlParams.set("car_id", carId);
        window.location.href = "car_details.php?" + urlParams.toString();
    }

    function showPopup(message) {
        document.getElementById("popupMessage").textContent = message;
        document.getElementById("popupOverlay").style.display = "flex";
    }

    document.getElementById("popupClose").addEventListener("click", function () {
        document.getElementById("popupOverlay").style.display = "none";
    });

    // 📌 Event listener for ALL “Details” buttons
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("book-button")) {
            const carId = event.target.getAttribute("data-car-id");
            redirectToDetails(carId);
        }
    });

    fetchCarIds(); // 🚀 First data query when loading the page
});