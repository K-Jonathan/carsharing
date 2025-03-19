document.addEventListener("DOMContentLoaded", function () {
    const markers = document.querySelectorAll(".map-marker");

    markers.forEach(marker => {
        marker.addEventListener("click", function () {
            const city = this.getAttribute("data-city"); // Holt den Städtenamen aus dem Attribut
            const baseUrl = "http://localhost/carsharing/car_selection.php";
            const searchParams = new URLSearchParams({
                "search-location": city,
                "pickup": "",
                "pickup-time": "",
                "return": "",
                "return-time": ""
            });

            // Weiterleitung mit Stadt in der URL
            window.location.href = `${baseUrl}?${searchParams.toString()}`;
        });
    });
});