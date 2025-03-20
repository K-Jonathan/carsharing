document.addEventListener("DOMContentLoaded", function () {
    // 🔹 Function to fetch car IDs (implementation remains unchanged)
    function fetchCarIds() {
        // Fetch logic remains unchanged
    }

    // 🔹 Function to handle redirecting to car details
    function redirectToDetails(carId) {
        // 📌 Extract values directly from the URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const location = urlParams.get("search-location") ? urlParams.get("search-location").trim() : "";
        const pickupDate = urlParams.get("pickup") ? urlParams.get("pickup").trim() : "";
        const pickupTime = urlParams.get("pickup-time") ? urlParams.get("pickup-time").trim() : "";
        const returnDate = urlParams.get("return") ? urlParams.get("return").trim() : "";
        const returnTime = urlParams.get("return-time") ? urlParams.get("return-time").trim() : "";

        // 📌 Validate input values to ensure all required fields are filled
        if (!location || location === "Stadt" || 
            !pickupDate || pickupDate === "Datum" || 
            !pickupTime || pickupTime === "--:--" || 
            !returnDate || returnDate === "Datum" || 
            !returnTime || returnTime === "--:--") {
            
            showPopup("Bitte wählen Sie ihren gewünschten Standort und Zeitraum aus.");
            return;
        }

        // 📌 If all inputs are valid, update the URL and redirect to car details page
        urlParams.set("car_id", carId);
        window.location.href = "car_details.php?" + urlParams.toString();
    }

    // 🔹 Function to display a popup message
    function showPopup(message) {
        document.getElementById("popupMessage").textContent = message;
        document.getElementById("popupOverlay").style.display = "flex";
    }

    // 🔹 Close the popup when clicking the close button
    document.getElementById("popupClose").addEventListener("click", function () {
        document.getElementById("popupOverlay").style.display = "none";
    });

    // 📌 Event listener for all "Book" buttons
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("book-button")) {
            const carId = event.target.getAttribute("data-car-id");
            redirectToDetails(carId);
        }
    });

    fetchCarIds(); // 🚀 Fetch initial car data when the page loads
});