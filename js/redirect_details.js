document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".book-button").forEach(button => {
        button.addEventListener("click", function () {
            const carId = this.getAttribute("data-car-id"); // Get the car's unique ID
            const urlParams = new URLSearchParams(window.location.search); // Extract current URL parameters
            urlParams.set("car_id", carId); // Add car ID as a new parameter

            // 🔹 Redirect to the car details page with the selected car ID
            window.location.href = "car_details.php?" + urlParams.toString();
        });
    });
});