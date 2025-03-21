/**
 * This script enables quick location-based car searches by clicking on map markers.
 * 
 * Features:
 * 
 * 🗺️ Interactive Map Markers:
 * - Listens for clicks on `.map-marker` elements.
 * - Extracts the city name from the `data-city` attribute of the clicked marker.
 * 
 * 🔄 Dynamic URL Construction:
 * - Constructs a query string with the selected city as `search-location`.
 * - Initializes empty placeholders for pickup and return dates/times.
 * 
 * 🚀 Redirection:
 * - Redirects the user to `car_selection.php` with the selected city prefilled in the search.
 * - Ensures a smooth, intuitive way for users to start their car rental search directly from the map.
 */
document.addEventListener("DOMContentLoaded", function () {
    const markers = document.querySelectorAll(".map-marker");

    markers.forEach(marker => {
        marker.addEventListener("click", function () {
            const city = this.getAttribute("data-city"); // Gets the city name from the attribute
            const baseUrl = "http://localhost/carsharing/car_selection.php";
            const searchParams = new URLSearchParams({
                "search-location": city,
                "pickup": "",
                "pickup-time": "",
                "return": "",
                "return-time": ""
            });

            // Redirect with city in the URL
            window.location.href = `${baseUrl}?${searchParams.toString()}`;
        });
    });
});