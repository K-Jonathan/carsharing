document.addEventListener("DOMContentLoaded", function () {
    const markers = document.querySelectorAll(".map-marker"); // Get all map markers

    /**
     * 🔹 Add click event listener to each marker
     */
    markers.forEach(marker => {
        marker.addEventListener("click", function () {
            const city = this.getAttribute("data-city"); // Get the city name from the marker's data attribute

            // 🔹 Define the base URL for the car selection page
            const baseUrl = "http://localhost/carsharing/car_selection.php";

            // 🔹 Construct search parameters with the selected city
            const searchParams = new URLSearchParams({
                "search-location": city,  // Set city as the search location
                "pickup": "",             // Keep pickup date empty
                "pickup-time": "",        // Keep pickup time empty
                "return": "",             // Keep return date empty
                "return-time": ""         // Keep return time empty
            });

            // 🔹 Redirect to car selection page with search parameters
            window.location.href = `${baseUrl}?${searchParams.toString()}`;
        });
    });
});